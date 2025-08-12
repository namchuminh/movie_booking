@extends('web.layouts.app')
@section('title', 'Mua vé - ' . $showtime->movie->title)

@section('content')
  {{-- Steps --}}
<style>
.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #94a3b8; /* Màu xám nhạt */
    font-size: 12px;
    background-color: white !important;
}

.step i {
    font-size: 20px;
}

.step.active {
    color: #dc2626 !important; /* Màu đỏ */
}

.step.active i {
    color: #dc2626 !important;
}


</style>

<div class="d-flex justify-content-center align-items-center mb-3 bg-white small" style="border-bottom: 1px solid #e3ebf6 !important; gap: 6rem !important;">
    <div class="step active">
        <i class="bi bi-grid-fill"></i>
        Chọn ghế
    </div>
    <i class="bi bi-chevron-right text-muted"></i>
    <div class="step">
        <i class="bi bi-credit-card-fill"></i>
        Thanh toán
    </div>
    <i class="bi bi-chevron-right text-muted"></i>
    <div class="step">
        <i class="bi bi-ticket-perforated-fill"></i>
        Thông tin vé
    </div>
</div>

<div class="container py-3">
  <div class="row g-4">
    {{-- LEFT: Seat map --}}
    <div class="col-lg-8">

      <div class="d-flex align-items-center gap-3 mb-2">
        <span class="legend legend-selected"></span> <span class="me-3 small">Ghế bạn chọn</span>
        <span class="legend legend-blocked"></span> <span class="me-3 small">Không thể chọn</span>
        <span class="legend legend-sold"></span> <span class="small">Đã bán</span>
      </div>

      <div class="fw-semibold text-center py-1 mb-3 pt-2" style="background-color: #dfdfdf;">
        MÀN HÌNH
      </div>

      <div class="seatmap-wrapper">
        {{-- Row labels --}}
        <div class="row-labels">
          @foreach($rows as $rowLabel => $cols)
            <div class="row-label">{{ $rowLabel }}</div>
          @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid" style="margin: 0 auto; gap: 12px;">
          @foreach($rows as $rowLabel => $cols)
            <div class="grid-row">
              @for($c=1; $c <= $maxCols; $c++)
                @php $seat = $cols[$c] ?? null; @endphp

                @if(!$seat)
                  <div class="seat gap"></div>
                @else
                  @php
                    $classes = 'seat ';
                    $classes .= $seat['status'] === 'sold' ? 'sold' : ($seat['status']==='blocked' ? 'blocked' : 'available');
                    if ($seat['type'] !== 'standard') $classes .= ' type-'.$seat['type'];
                  @endphp
                  <button type="button"
                          class="{{ $classes }}"
                          @if($seat['status'] === 'available')
                            data-seat-id="{{ $seat['id'] }}"
                            data-price="{{ $seat['price'] }}"
                            data-code="{{ $seat['code'] }}"
                          @else
                            disabled
                          @endif
                  ></button>
                @endif
              @endfor
            </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- RIGHT: Summary --}}
    <div class="col-lg-4">
      <div class="card mb-3 shadow-sm border-0">
        <div class="card-body">
          <div class="fw-semibold">{{ $showtime->movie->title }}</div>
          <div><a class="link-dark text-decoration-none" href="#">{{ optional(optional($showtime->room)->cinema)->name }}</a></div>
          <div class="small text-muted">
            Suất {{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}
            {{ \Carbon\Carbon::parse($showtime->show_date)->format('d/m/Y') }}<br>
            Phòng chiếu {{ optional($showtime->room)->name }} – Ghế <span id="chosenCodes">—</span>
          </div>
        </div>
      </div>

      <div class="card mb-3 shadow-sm border-0">
        <div class="card-body">
          <div class="text-muted small mb-1">TỔNG ĐƠN HÀNG</div>
          <div class="h4 mb-0"><span id="orderTotal">0</span> ₫</div>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary flex-fill">←</a>
        <form id="seatForm" method="post" action="{{ route('tickets.checkout', $showtime->id) }}" class="flex-fill">
          @csrf
          <input type="hidden" name="seat_ids" id="seatIdsInput">
          <button type="submit" id="continueBtn" class="btn btn-danger w-100" disabled>Tiếp tục</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Styles --}}
<style>
.step{ padding:6px 10px; border-radius:6px; background:#f6f7fb }
.step.active{ background:#e9f1ff; color:#3b82f6; font-weight:600 }

.seatmap-wrapper{ display:flex; gap:10px }
.row-labels{ display:flex; flex-direction:column; gap:6px; padding-top:2px }
.row-label{ width:28px; height:28px; background:#6b7280; color:#fff; border-radius:4px; display:flex; align-items:center; justify-content:center; font-size:12px }

.grid{ display:flex; flex-direction:column; gap:6px }
.grid-row{ display:flex; gap:6px }

/* Seat */
.seat{ width:24px; height:24px; border-radius:4px; border:0; background:#e5e7eb }
.seat.available{ background:#e5e7eb; cursor:pointer }
.seat.sold{ background:#cbd5e1; cursor:not-allowed }
.seat.blocked{ background:#eeeeee; cursor:not-allowed; opacity:.7 }
.seat.gap{ visibility:hidden }

.seat.selected{ box-shadow:0 0 0 3px #22c55e inset; background:#22c55e33 }

/* Legend */
.legend{ display:inline-block; width:18px; height:18px; border-radius:4px; margin-right:6px; vertical-align:middle }
.legend-selected{ box-shadow:0 0 0 3px #22c55e inset; background:#22c55e33 }
.legend-blocked{ background:#d1d5db }
.legend-sold{ background:#cbd5e1 }
.legend-type{ width:14px; height:14px; background:#e5e7eb; border:1px solid #d1d5db; border-radius:3px }
</style>

{{-- JS chọn ghế --}}
<script>
(function(){
  const seats = Array.from(document.querySelectorAll('.seat.available'));
  const chosenCodes = document.getElementById('chosenCodes');
  const orderTotal = document.getElementById('orderTotal');
  const seatIdsInput = document.getElementById('seatIdsInput');
  const continueBtn = document.getElementById('continueBtn');
  const showtimePrice = {{ $showtime->price }};

  const state = { ids: [], codes: [], total: 0 };

  function money(n){ return (n||0).toLocaleString('vi-VN'); }
  function render(){
    chosenCodes.textContent = state.codes.length ? state.codes.join(', ') : '—';
    orderTotal.textContent  = money(state.total);
    seatIdsInput.value      = state.ids.join(',');
    continueBtn.disabled    = state.ids.length === 0;
  }

  seats.forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const id = btn.dataset.seatId;
      const code = btn.dataset.code;
      const price = parseInt(btn.dataset.price || '0',10);
      const idx = state.ids.indexOf(id);

      if (idx === -1){
        state.ids.push(id); state.codes.push(code); 
        state.total += price; 
        state.total += showtimePrice;
        btn.classList.add('selected');
      } else {
        state.ids.splice(idx,1);
        const ci = state.codes.indexOf(code); if (ci>-1) state.codes.splice(ci,1);
        state.total -= price; 
        state.total -= showtimePrice;
        btn.classList.remove('selected');
      }
      render();
    });
  });

  render();
})();
</script>
@endsection
