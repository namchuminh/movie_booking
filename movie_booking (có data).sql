-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 07, 2025 lúc 06:37 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `movie_booking`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_history`
--

CREATE TABLE `booking_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `booked_at` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cinemas`
--

CREATE TABLE `cinemas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cinemas`
--

INSERT INTO `cinemas` (`id`, `name`, `type`, `province`, `location`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(3, 'Beta Thái Nguyên', 'Beta Cinema', 'Thái Nguyên', '259 Quang Trung, P. Tân Thịnh', '0999888999', 'storage/uploads/cinemas/zlLwzT9cthEvcSImdaQc1U9aqC7Z0t21t5JLfhz6.png', '2025-08-04 02:52:42', '2025-08-30 07:38:37'),
(4, 'CGV Aeon Long Biên', 'CGV', 'Hà Nội', 'Tầng 4 - TTTM AEON Long Biên, Số 27 Cổ Linh, Q. Long Biên', '0999888999', 'storage/uploads/cinemas/rumgC5GeGB2isqRM43Ou8FRjCn3B3YOxR9sL35Od.jpg', '2025-08-06 04:16:45', '2025-08-30 07:36:59'),
(5, 'CGV Aeon Hà Đông', 'CGV', 'Hà Nội', 'Khu đô thị mới Dương Nội, Hoàng Văn Thụ, Hà Đông', '0999888999', 'storage/uploads/cinemas/LSZAYSSETgWTCsVxeQBElUUtdYowwcuuKnawCDBr.jpg', '2025-08-06 05:06:46', '2025-08-30 07:36:22'),
(6, 'Cinestar Quốc Thanh', 'Cinestar', 'Tp. Hồ Chí Minh', '271 Nguyễn Trãi, P. Nguyễn Cư Trinh, Q.1', '0999888999', 'storage/uploads/cinemas/Rt6G5Mw7htDrU0QQzYYMYNNuGxcPX3d0sfYkotjR.png', '2025-08-06 06:06:00', '2025-08-30 07:35:17'),
(7, 'Cinestar Hai Bà Trưng', 'Cinestar', 'Tp. Hồ Chí Minh', '135 Hai Bà Trưng, P. Bến Nghé, Q.1', '0123456789', 'storage/uploads/cinemas/4uRAd5oveY5qFjwemjNIgzErs1G2QMpKod4L5P4e.png', '2025-08-17 08:05:13', '2025-08-17 08:05:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `trailer_url` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `actors` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` int(11) NOT NULL DEFAULT 16,
  `director` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Thời lượng (phút)',
  `release_date` date DEFAULT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `movies`
--

INSERT INTO `movies` (`id`, `title`, `trailer_url`, `actors`, `age`, `director`, `genre`, `rating`, `description`, `duration`, `release_date`, `language`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Mưa Đỏ', 'https://youtu.be/LGYJ8RnwZTk', 'Đỗ Nhật Hoàng Hoàng Long Hứa Vĩ Văn Nguyễn Hùng Lâm Thanh Nhã', 16, 'Đặng Thái Huyền', 'Chiến tranh', NULL, 'Phim truyện điện ảnh Mưa Đỏ nói về đề tài chiến tranh cách mạng, kịch bản của nhà văn Chu Lai, lấy cảm hứng và hư cấu từ sự kiện 81 ngày đêm chiến đấu anh dũng, kiên cường của nhân dân và cán bộ, chiến sĩ bảo vệ Thành Cổ Quảng Trị năm 1972. Tiểu đội 1 gồm toàn những thanh niên trẻ tuổi và đầy nhiệt huyết là một trong những đơn vị chiến đấu, bám trụ tại trận địa khốc liệt này. Bộ phim là khúc tráng ca bằng hình ảnh, là nén tâm nhang tri ân và tưởng nhớ những người con đã dâng hiến tuổi thanh xuân cho đất nước, mang âm hưởng của tình yêu, tình đồng đội thiêng liêng, là khát vọng hòa bình, hoà hợp dân tộc của nhân dân Việt Nam.', 124, '2025-08-22', 'Tiếng Việt', 'storage/uploads/movies/lAhbQGvFfh3QB1aJy5y50lQ7ukNfYXkmnICbtjnT.jpg', '2025-08-04 02:25:58', '2025-08-30 07:18:02'),
(3, 'Băng Đảng Quái Kiệt 2', 'https://youtu.be/ql1mh0P6shE', 'Sam Rockwell, Marc Maron, Craig Robinson, Anthony Ramos, Awkwafina', 16, 'Pierre Perifel', 'Hài hước', NULL, 'The Bad Guys 2 đánh dấu sự trở lại đáng trông chờ của nhóm “bất hảo” với những cuộc phiêu lưu hoàn toàn mới.', 120, '2025-08-29', 'Phụ đề', 'storage/uploads/movies/uOjwlV7zyZTCkMG7kexBzs8Zy8vSkqKCnOOmaiHW.jpg', '2025-08-08 04:56:20', '2025-08-30 07:18:23'),
(4, 'Dính Lẹo', 'https://youtu.be/IOiUYdzhd6I', 'Dave Franco, Alison Brie, Damon Herriman, Mia Morrissey, Karl Richmond', 16, 'Michael Shanks', 'Kinh dị', NULL, 'Dính Lẹo xoay quanh Tim và Millie, một cặp đôi đã gắn bó được 10 năm và tình cảm đang dần phai nhạt. Cố gắng cứu vãn mối quan hệ trên bờ vực đổ vỡ, Tim và Millie chuyển đến sống tại một vùng quê trong lành. Khi đi dạo ở khu rừng gần nhà, họ vô tình uống phải nước từ một chiếc ao kỳ lạ trong hang động. Kể từ đó, cơ thể họ bắt đầu… dính nhau cả về mặt vật lý lẫn tâm lý, theo cách kỳ quái và ngày càng mất kiểm soát. Trên hành trình chống lại hiện tượng kinh dị này, cặp đôi khám phá ra bí mật rúng động phía sau và buộc phải đối mặt với lựa chọn: tình yêu hay sự huỷ diệt về thể xác?', 102, '2025-08-15', 'Phụ đề', 'storage/uploads/movies/ot6cpQT6sikRyKDm2Hq0goTI3LfFGB4VDw5o98QM.jpg', '2025-08-08 05:00:32', '2025-08-30 07:18:43'),
(5, 'Phá Đám Sinh Nhật Mẹ', 'https://youtu.be/w0_KzVONgp0', 'Tín Nguyễn, Hồng Ánh, Trần Kim Hải, Ái Như, NSƯT Thành Hội', 16, 'Nguyễn Thanh Bình (Bình Bồng Bột)', 'Tình cảm', NULL, 'Bị giang hồ đe doạ, một người con trai đã làm đám ma giả cho mẹ mình để lừa tiền bảo hiểm. Nhưng kế hoạch bất hiếu điên rồ của anh liên tục bị phá đám bởi từ người lạ đến người quen, nhất là khi ngày anh đưa mẹ vào hòm lại tình cờ là ngày sinh nhật 60 tuổi của bà.', 120, '2025-09-05', 'Tiếng Việt', 'storage/uploads/movies/31mtzzRLwqzNMwJvaJHNdD5jKyYRfLA5CgSsKzqj.jpg', '2025-08-15 20:40:28', '2025-08-30 07:17:14'),
(6, 'Thanh Gươm Diệt Quỷ: Vô Hạn Thành', 'https://youtu.be/-cXgmans1tM', 'Hiro Shimono, Natsuki Hanae, Yoshitsugu Matsuoka, Akari Kito', 16, 'Haruo Sotozaki', 'Hành động', NULL, 'Bộ phim đầu tiên trong bộ ba phim Thanh Gươm Diệt Quỷ: Vô Hạn Thành. Đây là phần bắt đầu cho trận chiến cuối cùng giữa Sát Quỷ Đoàn cùng Muzan và bè lũ quỷ tại Vô Hạn Thành. Bộ phim quy tụ gần như toàn bộ Trụ Cột & các nhân vật chính đối đầu nhóm Thượng Huyền mạnh nhất của Muzan; cùng bối cảnh Vô Hạn Thành phức tạp, kiến trúc đảo lộn và di chuyển liên tục hứa hẹn mang đến những trận chiến đấu đầy mãn nhãn.', 155, '2025-08-20', 'Phụ đề', 'storage/uploads/movies/isTHDr36JIcIRVcOxnfX041Eq70SuQNxB8KqoDvQ.jpg', '2025-08-17 08:02:29', '2025-08-30 07:19:13'),
(7, 'Phim Shin Cậu Bé Bút Chì: Nóng Bỏng Tay! Những Vũ Công Kasukabe', 'https://youtu.be/9flABrln_Sg', NULL, 16, NULL, 'Hài hước', NULL, 'Để thiết lập mối quan hệ giữa một thành phố ở Ấn Độ và Kasukabe, Lễ hội Giải trí Thiếu nhi Kasukabe chính thức được tổ chức. Và bất ngờ chưa, ban tổ chức thông báo rằng đội chiến thắng trong cuộc thi nhảy của lễ hội sẽ được mời sang Ấn Độ biểu diễn ngay trên sân khấu bản địa! Nghe vậy, Shin và Đội đặc nhiệm Kasukabe lập tức lên kế hoạch chinh phục giải thưởng và khởi hành sang Ấn Độ để “quẩy banh nóc”! Chuyến du lịch tưởng chừng chỉ có vui chơi ca hát lại rẽ hướng 180 độ khi Shin và Bo tình cờ lạc vào một tiệm tạp hóa bí ẩn giữa lòng Ấn Độ. Tại đây, cả hai bắt gặp một chiếc balo có hình dáng giống... cái mũi và cả hai quyết định mua về. Nhưng không ngờ, chiếc balo lại ẩn chứa một bí mật kỳ lạ. Trong lúc tò mò nghịch ngợm, Bo lỡ tay nhét một mảnh giấy kỳ lạ từ balo lên... mũi mình. Và thế là thảm họa bắt đầu! Một thế lực tà ác trỗi dậy, biến Bo trở thành “Bạo Chúa Bo” – phiên bản siêu tăng động, cực kỳ hung hãn và sở hữu sức mạnh đủ để... làm rung chuyển cả thế giới. Liệu Shin và những người bạn có thể ngăn chặn Bo phiên bản Bạo Chúa trước khi cậu ấy khiến Ấn Độ (và cả thế giới) chìm trong hỗn loạn?', 105, '2025-08-22', 'Lồng tiếng', 'storage/uploads/movies/pZXy66dFCJGAvdBgu0wx8Y0LnJjGVB8I8D0z1los.jpg', '2025-08-30 07:21:06', '2025-08-30 07:21:06'),
(8, 'Kẻ Vô Danh 2', 'https://youtu.be/GsqO-OiZs3w', 'Bob Odenkirk, Connie Nielsen, Christopher Lloyd, RZA, Sharon Stone', 16, 'Timo Tjahjanto', 'Hành động', NULL, 'Kẻ Vô Danh 2 (Nobody 2) đánh dấu sự trở lại của Bob Odenkirk trong vai Hutch Mansell – người cha tưởng chừng bình thường nhưng ẩn chứa quá khứ sát thủ đầy nguy hiểm. Sau những sự kiện trong phần đầu tiên, Hutch cùng gia đình quyết định tận hưởng một kỳ nghỉ yên bình. Tuy nhiên, quá khứ đen tối của anh nhanh chóng quay trở lại, kéo theo những mối đe dọa mới.', 90, '2025-08-15', 'Phụ đề', 'storage/uploads/movies/22JhGOsxhFG9RbRPJNY2C0VZ6EpprYIyUYNO0lka.jpg', '2025-08-30 07:22:44', '2025-08-30 07:22:44'),
(9, 'Conan Movie 28: Dư Ảnh Của Độc Nhãn', 'https://youtu.be/dz5mN-iIC4g', 'Minami Takayama, Wakana Yamazaki, Rikiya Koyama, Show Hayami, Yuji Takada', 16, 'Katsuya Shigehara', 'Hoạt hình', NULL, 'Một người đồng nghiệp cũ của thám tử Mori từ Sở cảnh sát bất ngờ liên lạc lại với ông để cùng điều tra về một vụ tai nạn lở tuyết; nhưng khi ông Mori đến địa điểm gặp mặt, tiếng súng đột ngột vang lên... Trong làn tuyết trắng và ký ức mơ hồ của cảnh sát Yamato Kansuke – người đã mất đi một mắt trong vụ lở tuyết năm đó – đang cất giấu bí mật gì?', 109, '2025-07-25', 'Phụ đề', 'storage/uploads/movies/9YqiBSuWRyBOfXXqfEMlkvFyYlClzShaqUir0XrA.jpg', '2025-08-30 07:24:49', '2025-08-30 07:24:49'),
(10, 'Bebefinn Phim Điện Ảnh: Lạc Vào Xứ Sở Pinkfong Diệu Kỳ', NULL, 'Jo Kyoung-i Brooke Kim Emmerson Lee Hyoun-kyoung Kim Hae-na Gang Eun-ae', 16, 'Byeon Hee-sun, Moon Sun-young, Han Su-jeong', 'Hoạt hình', NULL, 'Nội dung “Bebefinn biến mất rồi!” Finn bất ngờ bị cuốn vào chiếc máy tính bảng vì tình cờ vẫy chiếc đũa sao của Pinkfong khi đang chơi Trốn Tìm Cùng Baby Shark — và lạc vào một thế giới âm nhạc diệu kỳ chưa từng thấy! Tại đây, Finn bắt đầu chuyến phiêu lưu cùng những giai điệu vui nhộn, sinh vật kỳ lạ và những màn vũ đạo khiến ai cũng muốn nhún nhảy. Trong khi đó, hai anh chị Bora và Brody hốt hoảng tìm cách giải cứu em. Với sự giúp sức của Pinkfong, cả nhóm bước vào một hành trình vừa hồi hộp, vừa đáng yêu, vừa tràn ngập sắc màu. Nhưng chiếc máy tính bảng sắp hết pin mất rồi… Liệu các bạn nhỏ có kịp trở về trước khi ba mẹ phát hiện? Một bộ phim hoạt hình dễ thương, đầy màu sắc và âm nhạc – lý tưởng để cả gia đình cùng thưởng thức, đặc biệt là các bé mê Baby Shark và thế giới kỳ ảo của Pinkfong!', 65, '2025-09-05', 'Phụ đề', 'storage/uploads/movies/p3pbCecDFMXPqu8b8GZ8CnvM8mgzklwAWsIgh5iO.jpg', '2025-08-30 07:26:30', '2025-08-30 07:27:48'),
(12, 'Chainsaw Man - The Movie: Chương Reze', NULL, 'Kikunosuke Toya, Reina Ueda, Shiori Izawa, Tomori Kusunoki, Shogo Sakata', 16, 'Tatsuya Yoshihara', 'Hoạt hình', NULL, 'Denji became “Chainsaw Man”, a boy with a devil’s heart, and is now part of Special Division 4’s devil hunters. After a date with Makima, the woman of his dreams, Denji takes shelter from the rain. There he meets Reze, a girl who works in a café.', 120, '2025-09-26', 'Phụ đề', 'storage/uploads/movies/1wOvW8zddqfSM6lo7Ouw4B5ASSPWzf8lfb2w2FSr.jpg', '2025-08-30 07:31:38', '2025-08-30 07:31:38'),
(13, 'Xin Chào Jadoo: Lạc Vào Vương Quốc Phép Thuật', 'https://youtu.be/p_F3s1luA-M', 'Jeong Hye-ok, Yang Jeong-hwa, Choi Joonyeong, Yeo Min-jeong', 16, 'Son Seok-woo', 'Hoạt hình', NULL, 'Một ngày nọ, một cô bé tên Jadoo bất ngờ chui ra từ một tảng đá gần ngôi làng. Jadoo mong được sống cùng dân làng, nhưng lại bị đuổi đi vì bị vu oan. Không còn nơi nào để nương tựa, cô tìm đến một võ đường để xin chỗ ở, bắt đầu tập luyện võ thuật và dần dần kết bạn, bộc lộ những kỹ năng phi thường. Khi phát hiện ngôi làng sắp bị quái vật tấn công, Jadoo ban đầu không muốn quay về nơi từng ruồng bỏ mình. Nhưng rồi cô nhớ đến lũ trẻ năm xưa — những đứa trẻ đã mang khoai lang cho cô khi cô đói khát…Liệu như trong truyền thuyết, Jadoo có thực sự trở thành người nắm giữ cây gậy phép, cứu lấy ngôi làng?', 62, '2025-08-29', 'Phụ đề', 'storage/uploads/movies/ePaSfWsxeZcZHxamNm7FTdyrKxeceWdneWfExkXT.jpg', '2025-08-30 17:25:39', '2025-08-30 17:25:39'),
(14, 'Làm Giàu Với Ma 2: Cuộc Chiến Hột Xoàn', 'https://youtu.be/wSP07UXIejQ', 'Hoài Linh Tuấn Trần Diệp Bảo Ngọc Võ Tấn Phát Ngọc Xuân', 16, 'Nhật Trung (Trung Lùn)', 'Hài hước', NULL, 'Hành trình đầy bi hài của 5 con người với những toan tính khác nhau nhằm đưa thi thể minh tinh Anh Thư (Ngọc Xuân) về quê nhà, đổi lại, hồn ma của cô hứa sẽ trả cho họ chiếc nhẫn kim cương trị giá 9 tỷ. Ai sẽ là người giành được phần thưởng, hay chuyến đi sẽ bộc lộ phần xấu xa nhất bên trong họ?', 133, '2025-08-29', 'Tiếng Việt', 'storage/uploads/movies/0TT4wcbeRsbOq4HhmSpyyaPefKNLgBExK2YSs113.jpg', '2025-08-30 17:28:30', '2025-08-30 17:28:30'),
(15, 'Chị Đại Cuồng Sát', 'https://youtu.be/oImz-jpLOqI', 'Korranid Laosubinprasoet, Veerinsara Tangkitsuvanich, Apichaya Thongkham, Tarisa Preechatangkit, Ramita Rattanapakdee', 16, 'Taweewat Wantha', 'Kinh dị', NULL, 'Chị Đại Cuồng Sát (Attack 13) bắt đầu khi đội trưởng bóng chuyền kiêm kẻ bắt nạt bị phát hiện treo cổ trong nhà thi đấu. Các đồng đội phải ngăn cha cô ả lập tế đàn để hồi sinh linh hồn báo thù của kẻ bắt nạt... Nhưng liệu đó có phải là sự thật? Ai là người đứng sau âm mưu mượn tay oán hồn để tàn sát cả trường?', 102, '2025-08-22', 'Phụ đề', 'storage/uploads/movies/Xr6uimJXjEIPBiRfmGtSIA3oLFCS0RyhdGIS6aAM.jpg', '2025-08-30 17:49:03', '2025-08-30 17:49:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `value`, `description`, `start_date`, `end_date`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Khuyến Mãi ABCDE 1', 10, '11111', '2025-08-05', '2025-08-15', 'storage/uploads/promotions/Ee5qTmvdVkpvDfYxl3yuLD1yq0CSQQzt7mIL0kIQ.jpg', '2025-08-04 23:33:12', '2025-08-04 23:39:20'),
(2, 'Mới', 15, 'ab', '2025-08-06', '2025-09-26', 'storage/uploads/promotions/yUyoK9lqJUuKiDuoROob2FWjfvLQY105E1XvHXDn.jpg', '2025-08-05 05:19:36', '2025-08-17 08:38:18'),
(3, 'Moi', 90, 'Lễ 2/9', '2025-08-13', '2025-10-23', 'storage/uploads/promotions/HH4wbZ1zd9ycd38P5eTm1lBJYfAF4GExuYg6OdXb.png', '2025-08-15 20:43:08', '2025-08-15 20:44:55'),
(4, 'TUAN-MOI', 10, 'Khuyến mãi cho mỗi tuần mới', '2025-08-17', '2025-08-23', 'storage/uploads/promotions/xo8q3fhCGab0zqfRqPQle86D2Z44nGMffvLL93iv.png', '2025-08-17 08:24:39', '2025-08-17 08:24:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `cinema_id`, `name`, `capacity`, `type`, `created_at`, `updated_at`) VALUES
(2, 3, 'Phòng 1', 90, '3D', '2025-08-04 03:24:26', '2025-08-30 07:41:10'),
(3, 5, 'Phòng 1', 120, '3D', '2025-08-07 23:35:19', '2025-08-30 07:40:44'),
(4, 7, 'Phòng 1', 120, '3D', '2025-08-17 08:06:21', '2025-08-30 07:40:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `seat_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seat_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Thường',
  `price` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `seats`
--

INSERT INTO `seats` (`id`, `room_id`, `seat_code`, `seat_type`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 'A2', 'VIP', 0, '2025-08-04 04:04:20', '2025-08-04 20:54:49'),
(3, 2, 'A01', 'Thường', 35000, '2025-08-04 20:54:21', '2025-08-30 07:55:04'),
(4, 2, 'A1', 'Thường', 35000, '2025-08-11 19:33:21', '2025-08-30 07:56:47'),
(5, 2, 'A2', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(6, 2, 'A3', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(7, 2, 'A4', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(8, 2, 'A5', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(9, 2, 'B1', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(10, 2, 'B2', 'Thường', 35000, '2025-08-11 19:33:21', '2025-08-30 07:57:30'),
(11, 2, 'B3', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(12, 2, 'B4', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(13, 2, 'B5', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(14, 2, 'C1', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(15, 2, 'C2', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(16, 2, 'C3', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(17, 2, 'C4', 'Thường', 35000, '2025-08-11 19:33:21', '2025-08-30 07:56:29'),
(18, 2, 'C5', 'Thường', 35000, '2025-08-11 19:33:21', '2025-08-30 07:55:25'),
(19, 2, 'D1', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(20, 2, 'D2', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(21, 2, 'D3', 'Thường', 35000, '2025-08-11 19:33:21', '2025-08-30 07:57:08'),
(22, 2, 'D4', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(23, 2, 'D5', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(24, 2, 'E1', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(25, 2, 'E2', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(26, 2, 'E3', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(27, 2, 'E4', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(28, 2, 'E5', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(29, 3, 'C6', 'Thường', 60000, '2025-08-15 20:42:00', '2025-08-15 20:42:00'),
(30, 4, 'Z1', 'Thường', 0, '2025-08-17 08:08:25', '2025-08-17 08:16:24'),
(31, 4, 'Z2', 'Thường', 0, '2025-08-17 08:09:00', '2025-08-17 08:16:45'),
(32, 4, 'Z3', 'Thường', 0, '2025-08-17 08:09:18', '2025-08-17 08:16:56'),
(33, 4, 'Z4', 'Thường', 0, '2025-08-17 08:09:37', '2025-08-17 08:17:09'),
(34, 4, 'Z5', 'Thường', 0, '2025-08-17 08:09:58', '2025-08-17 08:17:25'),
(35, 4, 'Z6', 'Thường', 0, '2025-08-17 08:10:16', '2025-08-17 08:17:39'),
(36, 4, 'Z7', 'Thường', 10000, '2025-08-17 08:11:25', '2025-08-17 08:19:03'),
(37, 3, 'C09', 'Thường', 35000, '2025-08-26 00:10:09', '2025-08-30 07:51:10'),
(38, 3, 'C10', 'Thường', 35000, '2025-08-30 07:52:32', '2025-08-30 07:52:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `showtimes`
--

CREATE TABLE `showtimes` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `show_time` time DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `showtimes`
--

INSERT INTO `showtimes` (`id`, `movie_id`, `room_id`, `show_date`, `show_time`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 2, '2025-09-06', '19:40:00', 35000, '2025-08-04 03:38:57', '2025-08-30 07:54:06'),
(3, 2, 3, '2025-09-11', '11:46:00', 15000, '2025-08-04 20:45:49', '2025-08-30 07:49:39'),
(4, 2, 2, '2025-08-31', '00:47:00', 35000, '2025-08-07 22:47:31', '2025-08-30 07:54:28'),
(6, 5, 3, '2025-09-30', '10:40:00', 35000, '2025-08-15 20:41:26', '2025-08-30 07:50:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `showtime_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `showtime_id`, `seat_id`, `customer_name`, `customer_email`, `customer_phone`, `created_at`, `updated_at`) VALUES
(2, 4, 3, 2, NULL, NULL, NULL, '2025-08-04 05:03:55', '2025-08-04 21:24:40'),
(3, 3, 2, 2, NULL, NULL, NULL, '2025-08-04 21:08:28', '2025-08-04 21:18:31'),
(4, NULL, 2, 5, NULL, NULL, NULL, '2025-08-12 03:34:15', '2025-08-12 03:34:15'),
(5, NULL, 2, 4, NULL, NULL, NULL, '2025-08-12 03:34:15', '2025-08-12 03:34:15'),
(6, NULL, 2, 6, NULL, NULL, NULL, '2025-08-12 03:36:39', '2025-08-12 03:36:39'),
(7, NULL, 2, 7, NULL, NULL, NULL, '2025-08-12 03:36:39', '2025-08-12 03:36:39'),
(8, NULL, 2, 8, NULL, NULL, NULL, '2025-08-12 03:39:55', '2025-08-12 03:39:55'),
(9, NULL, 2, 13, NULL, NULL, NULL, '2025-08-12 03:39:55', '2025-08-12 03:39:55'),
(10, NULL, 2, 27, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 03:56:40', '2025-08-12 03:56:40'),
(11, NULL, 2, 26, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 03:56:40', '2025-08-12 03:56:40'),
(12, 1, 2, 28, NULL, NULL, NULL, '2025-08-12 04:15:22', '2025-08-12 04:15:22'),
(13, 1, 2, 23, NULL, NULL, NULL, '2025-08-12 04:15:22', '2025-08-12 04:15:22'),
(14, NULL, 2, 18, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(15, NULL, 2, 17, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(16, NULL, 2, 16, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(17, NULL, 2, 14, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(18, NULL, 2, 15, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(19, 6, 2, 9, NULL, NULL, NULL, '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(20, 6, 2, 24, NULL, NULL, NULL, '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(21, 6, 2, 22, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(22, 6, 2, 21, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(23, 6, 2, 20, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(24, 6, 2, 19, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(25, NULL, 2, 12, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888991', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(26, NULL, 2, 11, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888991', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(27, NULL, 2, 10, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888991', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(28, 6, 4, 4, NULL, NULL, '0888555999', '2025-08-14 09:42:56', '2025-08-14 09:42:56'),
(29, 6, 4, 5, NULL, NULL, '0888555999', '2025-08-14 09:42:56', '2025-08-14 09:42:56'),
(30, 9, 4, 6, 'nguyenvana', 'laivannam@gmail.com', '0888555999', '2025-08-15 20:13:29', '2025-08-15 20:18:25'),
(31, 1, 4, 7, NULL, NULL, '0888555999', '2025-08-15 20:21:21', '2025-08-15 20:21:21'),
(32, NULL, 6, 29, 'minhto', 'dang@gmail.com', '0888555999', '2025-08-15 20:51:21', '2025-08-15 20:51:21'),
(33, 9, 6, 37, NULL, NULL, '0888555999', '2025-08-26 00:18:27', '2025-08-26 00:18:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_codes`
--

CREATE TABLE `ticket_codes` (
  `ticket_id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_codes`
--

INSERT INTO `ticket_codes` (`ticket_id`, `code`, `created_at`, `updated_at`) VALUES
(2, 'TKT6890A1AB3E70A', '2025-08-04 05:03:55', '2025-08-04 05:03:55'),
(3, 'TKT689183BCA6E52', '2025-08-04 21:08:28', '2025-08-04 21:08:28'),
(14, 'TKT689B240C8BF1F', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(15, 'TKT689B240C9B6A7', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(16, 'TKT689B240C9D426', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(17, 'TKT689B4D9CE00A4', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(18, 'TKT689B4D9CE1BB8', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(19, 'TKT689C796B41F57', '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(20, 'TKT689C796B49E63', '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(21, 'TKT689C7A32BF600', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(22, 'TKT689C7A32C0BF2', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(23, 'TKT689C7A32C1CD5', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(24, 'TKT689C7A32C3D29', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(25, 'TKT689C7AC2D703E', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(26, 'TKT689C7AC2D8A72', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(27, 'TKT689C7AC2DA1AF', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(28, 'TKT689E12103C2C0', '2025-08-14 09:42:56', '2025-08-14 09:42:56'),
(29, 'TKT689E121058D3C', '2025-08-14 09:42:56', '2025-08-14 09:42:56'),
(30, 'TKT689FF759DAD32', '2025-08-15 20:13:29', '2025-08-15 20:13:29'),
(31, 'TKT689FF93209F4F', '2025-08-15 20:21:22', '2025-08-15 20:21:22'),
(32, 'TKT68A00039DCC5E', '2025-08-15 20:51:21', '2025-08-15 20:51:21'),
(33, 'TKT68AD5FC34EB07', '2025-08-26 00:18:27', '2025-08-26 00:18:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_promotions`
--

CREATE TABLE `ticket_promotions` (
  `movie_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_promotions`
--

INSERT INTO `ticket_promotions` (`movie_id`, `promo_id`, `created_at`, `updated_at`) VALUES
(6, 2, '2025-08-17 08:38:46', '2025-08-17 08:38:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` enum('customer','staff','admin') COLLATE utf8_unicode_ci DEFAULT 'customer',
  `avatar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'admin@example.com', 'admin', 'storage/uploads/avatars/95vIGv5Pu1cLaPz5rvU4GWXhdZ5wZY3BMmIPK60k.jpg', '2025-08-04 11:43:16', '2025-08-05 04:16:31'),
(2, 'staff01', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'staff01@example.com', 'staff', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(3, 'john_doe', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'john.doe@gmail.com', 'customer', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(4, 'jane_smith', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'jane.smith@yahoo.com', 'customer', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(5, 'tester', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'tester@gmail.com', 'customer', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(6, 'nguyenvana', '$2y$10$Ez.bAEzHKDjeCv93M1IEseisc55nl6i1uI96rxHM/ASRIthYFjpZi', 'laivannam@gmail.com', 'customer', '/storage/avatars/aRsEcOTH98vMmR2BfxjuYiCF0WCsyAtnqNj6A10I.jpg', '2025-08-04 23:51:25', '2025-08-13 03:56:55'),
(7, 'laivannam2', '$2y$10$fJyOs08qDrMkxZ51ao45W.fj3aswrkKi3zk5y3MP2MI59ilxnSqnG', 'laivannam2@gmail.com', 'customer', NULL, '2025-08-13 04:25:29', '2025-08-13 04:25:29'),
(8, 'laivannam3', '$2y$10$3NOxjw0c9v8EW9/ZCulO5upl4U1eGQEFNwvpMKhcgGp0mbTzQ02Oq', 'laivannam3@gmail.com', 'customer', 'storage/avatars/no-avatar.png', '2025-08-13 04:28:20', '2025-08-13 04:28:20'),
(9, 'kyanh0', '$2y$10$xR9qHrNN1MZ5H8RD2bdAyeecuDIIp8ui7MSMHjLTTCQ8cLrWTrMu2', 'kyanh@gmail.com', 'customer', 'storage/avatars/no-avatar.png', '2025-08-15 17:51:40', '2025-08-15 17:51:40'),
(10, 'dang123456', '$2y$10$18tSJpMxi/K78079pbmEUeyzgmbpcYpLmFka6HAbtIJNSFD1ZonmW', 'dang@gmail.com', 'customer', 'storage/avatars/no-avatar.png', '2025-08-15 19:49:28', '2025-08-15 19:49:28'),
(11, 'kyanh1', '$2y$10$k6DVR8Lc45RPFFxq5uF7tePMIayiZRZiHjQnNh3Uw7Rb1BxNZY906', 'admin@gmail.com', 'customer', 'storage/avatars/no-avatar.png', '2025-08-29 04:50:59', '2025-08-29 04:50:59'),
(12, 'anhbanh', '$2y$10$mCxRCldXFmAKTLRoesf0FeElSGJu1wjyy5eGKsL6jKRdqfdM/YQOC', 'anhbanh@gmail.com', 'staff', NULL, '2025-08-30 06:07:26', '2025-08-30 06:07:26');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `booking_history`
--
ALTER TABLE `booking_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Chỉ mục cho bảng `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cinema_id` (`cinema_id`);

--
-- Chỉ mục cho bảng `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `showtime_id` (`showtime_id`),
  ADD KEY `seat_id` (`seat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `ticket_codes`
--
ALTER TABLE `ticket_codes`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `ticket_promotions`
--
ALTER TABLE `ticket_promotions`
  ADD PRIMARY KEY (`movie_id`,`promo_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `booking_history`
--
ALTER TABLE `booking_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_history_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`id`);

--
-- Các ràng buộc cho bảng `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  ADD CONSTRAINT `showtimes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `showtimes_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`),
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `ticket_codes`
--
ALTER TABLE `ticket_codes`
  ADD CONSTRAINT `ticket_codes_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Các ràng buộc cho bảng `ticket_promotions`
--
ALTER TABLE `ticket_promotions`
  ADD CONSTRAINT `ticket_promotions_ibfk_2` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`id`),
  ADD CONSTRAINT `ticket_promotions_ibfk_3` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
