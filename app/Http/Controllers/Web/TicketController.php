<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket; // Assuming you have a Ticket model
use App\Models\Showtime; // Assuming you have a Showtime model
use Illuminate\Support\Str;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function show($id)
    {
        $showtime = Showtime::with([
            'movie:id,title',
            'room:id,cinema_id,name',
            'room.cinema:id,name',
            'room.seats:id,room_id,seat_code,seat_type,price'
        ])->findOrFail($id);

        // Ghế đã bán/đang giữ chỗ trong suất này
        $soldSeatIds = Ticket::query()
            ->where('showtime_id', $showtime->id)
            ->pluck('seat_id')
            ->all();

        // Chuẩn hoá seats -> tách row/col từ seat_code (ví dụ A10, B3...)
        $rows = [];
        $maxCols = 0;

        foreach ($showtime->room->seats as $seat) {
            // Parse "A10" -> row=A, col=10
            if (preg_match('/^([A-Za-z]+)\s*0*([0-9]+)$/', $seat->seat_code, $m)) {
                $row = strtoupper($m[1]);
                $col = (int) $m[2];
            } else {
                // fallback: mọi thứ vào hàng "Z"
                $row = 'Z';
                $col = (int) filter_var($seat->seat_code, FILTER_SANITIZE_NUMBER_INT) ?: 0;
            }

            $status = in_array($seat->id, $soldSeatIds, true) ? 'sold' : 'available';
            if (in_array($seat->seat_type, ['blocked', 'broken'], true)) {
                $status = 'blocked';
            }

            $price = $seat->price ?: $showtime->price;

            $rows[$row][$col] = [
                'id' => $seat->id,
                'code' => $seat->seat_code,
                'type' => $seat->seat_type ?: 'standard',
                'price' => (int) $price,
                'status' => $status,
            ];
            $maxCols = max($maxCols, $col);
        }

        // Sắp xếp hàng theo alphabet, cột tăng dần
        ksort($rows);
        foreach ($rows as $r => $cols) {
            ksort($rows[$r]);
        }
        // ẩn footer
        $hiddenFooter = true;

        return view('web.tickets.show', compact('showtime', 'rows', 'maxCols', 'hiddenFooter'));
    }

    public function checkout(Request $request, $id)
    {
        // 1) Lấy showtime + movie/room/cinema
        $showtime = Showtime::with(['movie:id,title', 'room:id,cinema_id,name', 'room.cinema:id,name'])
            ->findOrFail($id);

        // 2) Parse seat_ids
        $seatIds = collect(explode(',', (string) $request->input('seat_ids', '')))
            ->filter()
            ->unique()
            ->values();

        if ($seatIds->isEmpty()) {
            return back()->withErrors('Bạn chưa chọn ghế.');
        }

        // 3) Lấy seats thuộc đúng phòng của suất chiếu
        $seats = Seat::whereIn('id', $seatIds)
            ->where('room_id', $showtime->room_id)
            ->get()
            ->keyBy('id');

        if ($seats->count() !== $seatIds->count()) {
            return back()->withErrors('Có ghế không hợp lệ hoặc không thuộc phòng chiếu này.');
        }

        // 4) Check ghế đã bán/đang giữ chỗ
        $lockedIds = Ticket::where('showtime_id', $showtime->id)
            ->pluck('seat_id')
            ->all();

        $conflict = $seatIds->intersect($lockedIds);
        if ($conflict->isNotEmpty()) {
            return back()->withErrors('Một số ghế đã bán/đang giữ chỗ. Vui lòng chọn ghế khác.');
        }

        $selected = [];
        $total = 0;

        foreach ($seatIds as $sid) {
            $s = $seats[$sid];
            $type = $s->seat_type ?: 'Thường';
            $price = ($s->price ?: 0) + ($showtime->price ?: 0);

            $selected[] = [
                'id' => $s->id,
                'code' => $s->seat_code,
                'type' => $type,
                'price' => $price,
            ];
            $total += $price;
        }

        // Gắn tổng tiền ở session
        session(['total_amount' => $total]);

        // Gắn session thông tin ghế đã chọn
        session(['selected_seats' => $selected]);

        // Session mã showtime
        session(['showtime_id' => $showtime->id]);

        $hiddenFooter = true;
        
        // 6) Render trang thanh toán
        return view('web.tickets.checkout', [
            'showtime' => $showtime,
            'selected' => $selected, // mảng ghế đã chọn
            'total' => $total,
            'seatIds' => $seatIds->implode(','),
            'hiddenFooter' => $hiddenFooter,
        ]);
    }

    public function payment(Request $request)
    {
        // Kiểm tra nếu đăng nhập rồi thì ko cần
        if (!auth()->check()) {
            // Validate and process payment here
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
            ], [
                'customer_name.required' => 'Họ và tên là bắt buộc.',
                'customer_email.required' => 'Email là bắt buộc.',
                'customer_email.email' => 'Email không hợp lệ.',
                'customer_phone.required' => 'Số điện thoại là bắt buộc.',
            ]);
        }

        $customerName = $request->input('customer_name');
        $customerEmail = $request->input('customer_email');
        $customerPhone = $request->input('customer_phone');

        // Lấy các session ra
        $amount = session('total_amount', 0);
        $selectedSeats = session('selected_seats', []);
        $showtimeId = session('showtime_id');

        $this->bankVnpay($amount, $customerName, $customerEmail, $customerPhone);
    }


    private function bankVnpay($amount, $customerName, $customerEmail, $customerPhone)
	{
		$bank_code = "";

		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$vnp_TmnCode = "UKSNYWZS"; //Website ID in VNPAY System
		$vnp_HashSecret = "9RYAAKDJNOQB8PWV0HVOY2BBN1O5HUFQ"; //Secret key
		$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
		$vnp_Returnurl = route('tickets.check_payment', ['customer_name' => $customerName, 'customer_email' => $customerEmail, 'customer_phone' => $customerPhone]); // URL trả về sau khi thanh toán thành công
		$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";

		$startTime = date("YmdHis");
		$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
		$vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
		$vnp_OrderInfo = "thanh toan vnpay";
		$vnp_OrderType = "order";
		$vnp_Amount = $amount * 100;
		$vnp_Locale = 'vn';
		$vnp_BankCode = $bank_code;

		$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

		$inputData = array(
			"vnp_Version" => "2.1.0",
			"vnp_TmnCode" => $vnp_TmnCode,
			"vnp_Amount" => $vnp_Amount,
			"vnp_Command" => "pay",
			"vnp_CreateDate" => date('YmdHis'),
			"vnp_CurrCode" => "VND",
			"vnp_IpAddr" => $vnp_IpAddr,
			"vnp_Locale" => $vnp_Locale,
			"vnp_OrderInfo" => $vnp_OrderInfo,
			"vnp_OrderType" => $vnp_OrderType,
			"vnp_ReturnUrl" => $vnp_Returnurl,
			"vnp_TxnRef" => $vnp_TxnRef,
		);

		if (isset($vnp_BankCode) && $vnp_BankCode != "") {
			$inputData['vnp_BankCode'] = $vnp_BankCode;
		}
		if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
			$inputData['vnp_Bill_State'] = $vnp_Bill_State;
		}
		ksort($inputData);
		$query = "";
		$i = 0;
		$hashdata = "";
		foreach ($inputData as $key => $value) {
			if ($i == 1) {
				$hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
			} else {
				$hashdata .= urlencode($key) . "=" . urlencode($value);
				$i = 1;
			}
			$query .= urlencode($key) . "=" . urlencode($value) . '&';
		}
		$vnp_Url = $vnp_Url . "?" . $query;
		$vnpSecureHash = "";
		if (isset($vnp_HashSecret)) {
			$vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
			$vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
		}
		$returnData = array(
			'code' => '00'
			,
			'message' => 'success'
			,
			'data' => $vnp_Url
		);
		header('Location: ' . $vnp_Url);
		die();
	}

    public function checkPayment(Request $request)
    {
        // Kiểm tra vnp_ResponseCode == 00
        if($request->input('vnp_ResponseCode') == '00'){
            $selectedSeats = session('selected_seats', []);

            // Lặp và lưu vé
            foreach ($selectedSeats as &$seat) {
                $ticket = new Ticket();

                if (auth()->check()) {
                    $ticket->user_id     = auth()->id();
                    $ticket->customer_phone = $request->input('customer_phone');
                } else {
                    $ticket->customer_name  = $request->input('customer_name');
                    $ticket->customer_email = $request->input('customer_email');
                    $ticket->customer_phone = $request->input('customer_phone');
                }

                $ticket->showtime_id = session('showtime_id');
                $ticket->seat_id     = is_array($seat) ? $seat['id'] : $seat;
                $ticket->save();

                // Tạo mã vé
                $ticket->ticketCode()->create([
                    'code' => strtoupper(uniqid('TKT')),
                ]);

                DB::commit();

                // Gắn ticket_id vào seat hiện tại
                if (is_array($seat)) {
                    $seat['ticket_id'] = $ticket->id;
                } else {
                    // Nếu seat ban đầu chỉ là ID, chuyển sang dạng mảng
                    $seat = [
                        'id'        => $seat,
                        'ticket_id' => $ticket->id
                    ];
                }
            }

            // Lưu lại session đã cập nhật
            session(['selected_seats' => $selectedSeats]);

            return redirect()->route('tickets.info');
        }else{
            //Xóa session
            session()->forget('selected_seats');
            session()->forget('showtime_id');
            session()->forget('customer_name');
            session()->forget('customer_email');
            session()->forget('customer_phone');
            return redirect()->route('tickets.show', session('showtime_id'))
                ->withErrors('Thanh toán không thành công. Vui lòng thử lại sau.');
        }
    }

    public function info()
    {
        // Lấy thông tin suất chiếu từ session
        $showtime = Showtime::find(session('showtime_id'));

        if (!$showtime) {
            return redirect()->route('tickets.show', session('showtime_id'))
                ->withErrors('Suất chiếu không tồn tại.');
        }

        $hiddenFooter = true;
        
        // Hiển thị thông tin vé đã mua
        return view('web.tickets.info', [
            'showtime' => $showtime,
            'selected' => session('selected_seats', []),
            'hiddenFooter' => $hiddenFooter,
        ]);
    }

    public function print($id)
    {
        $ticket = Ticket::with(['showtime.movie', 'seat.room.cinema', 'user'])->findOrFail($id);

        // Logic to generate the printable view
        return view('web.tickets.print', compact('ticket'));
    }
}