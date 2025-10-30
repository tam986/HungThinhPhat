-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th5 01, 2025 lúc 04:08 PM
-- Phiên bản máy phục vụ: 10.5.28-MariaDB
-- Phiên bản PHP: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `op6cjaieob0f_cms_admin`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baiviets`
--

CREATE TABLE `baiviets` (
  `id` int(11) NOT NULL COMMENT 'ID bài viết',
  `tieude` varchar(255) NOT NULL COMMENT 'Tiêu đề bài viết',
  `noidung` text NOT NULL COMMENT 'Nội dung bài viết',
  `anhdaidien` varchar(100) NOT NULL COMMENT 'Ảnh đại diện bài viết',
  `motangan` varchar(1000) DEFAULT NULL COMMENT 'Mô tả ngắn bài viết',
  `seotieude` varchar(255) NOT NULL COMMENT 'SEO tiêu đề bài viết',
  `slug` varchar(255) DEFAULT NULL,
  `luotxem` tinyint(4) NOT NULL DEFAULT 0,
  `id_danhmuc` int(11) NOT NULL COMMENT 'ID danh mục bài viết',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'Thời điểm tạo bài viết',
  `updated_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'thời điểm cập nhật',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `anhien` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Ẩn hoặc hiển bài viết',
  `id_user` int(11) NOT NULL COMMENT 'ID người viết'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `baiviets`
--

INSERT INTO `baiviets` (`id`, `tieude`, `noidung`, `anhdaidien`, `motangan`, `seotieude`, `slug`, `luotxem`, `id_danhmuc`, `created_at`, `updated_at`, `deleted_at`, `anhien`, `id_user`) VALUES
(1, 'Miền Tây đẩy mạnh phát triển du lịch sinh thái sau đại dịch', '<h4><strong>Giới thiệu chung:</strong></h4><blockquote><p><br>Miền Tây Việt Nam với đặc trưng sông nước, các con kênh rạch đan xen và hệ sinh thái phong phú, đang trở thành tâm điểm phát triển du lịch sinh thái của Việt Nam hậu đại dịch. Sau những tác động nặng nề của COVID-19, nhiều địa phương như Cần Thơ, Bến Tre, Đồng Tháp đang tích cực đầu tư để hồi phục ngành du lịch theo hướng bền vững. Những khu vực từng bị ảnh hưởng nặng nề nay đã bắt đầu phục hồi, đón khách trở lại và mở rộng các mô hình du lịch mới, gắn liền với thiên nhiên và đời sống cộng đồng bản địa.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:940/600;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/image2_1744640807.png\" alt=\"hoạt động sông nước\" width=\"940\" height=\"600\"><figcaption>Hình 1. Hoạt động sông nước</figcaption></figure><h4><strong>Chiến lược phát triển:</strong></h4><blockquote><p><br>Chính quyền địa phương đang triển khai nhiều chương trình khuyến khích doanh nghiệp đầu tư vào du lịch sinh thái, nhất là các loại hình du lịch miền vườn, homestay, và tham quan cánh đồng lúc thu hoạch. Các tour du lịch ngắn ngày, trải nghiệm nửa ngày trở nên phổ biến hơn bao giờ hết. Nhiều địa phương còn kết hợp du lịch sinh thái với du lịch nông nghiệp, để du khách có thể vừa khám phá thiên nhiên vừa trải nghiệm cuộc sống của người dân địa phương: đi bắt cá, trồng rau, hái trái cây theo mùa.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/481;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/image3_1744640834.png\" alt=\"Chợ nổi\" width=\"800\" height=\"481\"><figcaption>Hình 2. Chợ nội</figcaption></figure><h4><strong>Hiệu quả ban đầu:</strong></h4><blockquote><p><br>Theo thống kê từ Sở VHTTDL Cần Thơ, trong 6 tháng đầu năm 2025, thành phố đã đón hơn 2 triệu lượt khách, tăng 25% so với cùng kỳ năm ngoái. Nhiều homestay, resort sinh thái quanh vùng ven sông, cánh đồng đã full phòng trong mùa du lịch cao điểm. Các tour du lịch học đường, trải nghiệm cho học sinh – sinh viên cũng được tổ chức thường xuyên, giúp lan tỏa giá trị của du lịch sinh thái trong thế hệ trẻ.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:1920/1279;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/image1_1744640860.png\" alt=\"Cần Thơ\" width=\"1920\" height=\"1279\"><figcaption>Hình 3. Đô thị ở Cần Thơ</figcaption></figure><h4><strong>Định hướng tương lai:</strong></h4><blockquote><p><br>Để đảm bảo sự phát triển lâu dài, nhiều tỉnh đang xây dựng quy hoạch vùng du lịch gắn với bảo tồn hệ sinh thái. Các chính sách ưu đãi về thuế, vay vốn, đào tạo nguồn nhân lực cũng được chú trọng nhằm nâng cao chất lượng dịch vụ. Ngoài ra, việc ứng dụng công nghệ vào du lịch – như bản đồ số, app hướng dẫn tham quan, hệ thống đặt tour trực tuyến – cũng đang được đầu tư mạnh mẽ.</p></blockquote><h4><strong>Kết luận:</strong></h4><blockquote><p><br>Du lịch sinh thái không chỉ giúp người dân tăng thu nhập, mà còn đóng vai trò quan trọng trong việc bảo vệ hệ sinh thái và giá trị văn hóa bản địa của vùng đất châu thổ Việt Nam. Đây là hướng đi cần thiết và mang tính bền vững trong bối cảnh ngành du lịch toàn cầu đang chuyển mình theo xu hướng xanh, gần gũi thiên nhiên và thân thiện với môi trường.</p></blockquote><p>&nbsp;</p><p>&nbsp;</p>', 'uploads/posts/image1.png', 'Các tỉnh miền Tây đang tập trung phát triển du lịch sinh thái với nhiều chính sách mới nhằm thu hút khách trong và ngoài nước.', 'du-lich-sinh-thai-mien-tay', 'du-lich-sinh-thai-mien-tay', 7, 6, '2025-04-14 14:25:19', '2025-04-30 09:10:28', NULL, 1, 16),
(2, 'Đồng bằng sông Cửu Long đối mặt tình trạng sụt lún và xâm nhập mặn nghiêm trọng', '<blockquote><h4><strong>Tổng quan tình hình:</strong></h4><p><br>Biến đổi khí hậu và tác động từ con người đang khiến vùng đồng bằng sông Cửu Long (ĐBSCL) phải đối mặt với nhiều rủi ro nghiêm trọng. Trong đó, hai vấn đề nổi cộm nhất hiện nay là tình trạng sụt lún đất ngày càng gia tăng và tình trạng xâm nhập mặn diễn ra sớm hơn, kéo dài hơn mỗi năm.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:540/360;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/capture_1744648079.png\" width=\"540\" height=\"360\"><figcaption>Hình 1. Nhiễm mặn</figcaption></figure><blockquote><h4><strong>Nguyên nhân và hậu quả:</strong></h4><p><br>Nguyên nhân chính đến từ việc khai thác nước ngầm quá mức, kết hợp với đắp đập thủy điện ở thượng nguồn sông Mekong khiến lượng phù sa về vùng hạ lưu giảm mạnh. Điều này khiến nền đất yếu của miền Tây không được bồi đắp và ngày càng lún sâu. Đồng thời, hiện tượng xâm nhập mặn khiến hàng chục nghìn hecta lúa và cây ăn trái bị thiệt hại, ảnh hưởng nghiêm trọng đến đời sống nông dân.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/533;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/sut-lun1_1744648101.jpg\" width=\"800\" height=\"533\"><figcaption>Hình 2. Sụt lún</figcaption></figure><blockquote><h4><strong>Giải pháp được đề xuất:</strong></h4><p><br>Chính phủ đã triển khai nhiều chương trình như xây dựng hệ thống cống đập kiểm soát mặn, trồng rừng ngập mặn bảo vệ đê biển và chuyển đổi cơ cấu cây trồng phù hợp với điều kiện khí hậu mới. Ngoài ra, các tỉnh cũng đang khuyến khích người dân hạn chế khai thác nước ngầm, sử dụng nước mưa, nước mặt thay thế.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:820/461;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/4_1744648133.jpg\" width=\"820\" height=\"461\"><figcaption>Hình 3. Lỡ đất</figcaption></figure><blockquote><h4><strong>Vai trò cộng đồng:</strong></h4><p><br>Ý thức của người dân trong việc bảo vệ tài nguyên thiên nhiên đang ngày càng được nâng cao thông qua các chiến dịch truyền thông và giáo dục cộng đồng. Một số mô hình như \"thu hoạch nước mưa trong nhà\" hay \"chuyển đổi sang nuôi trồng thủy sản chịu mặn\" đang mang lại hiệu quả bước đầu.</p></blockquote><p>&nbsp;</p><blockquote><h4><strong>Kết luận:</strong></h4><p><br>Đồng bằng sông Cửu Long – vựa lúa lớn nhất cả nước – đang cần sự chung tay từ cả chính quyền, nhà khoa học và cộng đồng để thích ứng với những biến đổi khí hậu nghiêm trọng này. Việc đưa ra các giải pháp tổng thể và đồng bộ không chỉ giúp bảo vệ vùng đất này mà còn giữ gìn an ninh lương thực cho cả nước.</p></blockquote>', 'uploads/posts/sut-lun1.jpg', 'Miền Tây đang đối mặt với những thách thức lớn về biến đổi khí hậu như sụt lún đất và xâm nhập mặn, đòi hỏi giải pháp đồng bộ và lâu dài.', 'sut-lun-mien-tay-xam-nhap-man-dong-bang-song-cuu-long', 'sut-lun-mien-tay-xam-nhap-man-dong-bang-song-cuu-long', 5, 6, '2025-04-14 16:29:13', '2025-04-26 20:34:50', NULL, 1, 16),
(3, 'Cồn Sơn – Viên ngọc xanh giữa lòng Cần Thơ', '<blockquote><h4><strong>Giới thiệu chung:</strong></h4><p><br>Cách trung tâm thành phố Cần Thơ khoảng 6 km, <strong>Cồn Sơn</strong> nằm tách biệt giữa sông Hậu, thuộc phường Bùi Hữu Nghĩa, quận Bình Thủy. Không ồn ào, không khói bụi, nơi đây được ví như “lá phổi xanh” của thành phố – nơi mà bạn có thể tìm thấy sự yên bình, mộc mạc đúng chất miền Tây Nam Bộ.</p><p>Cồn Sơn không lớn – chỉ khoảng 70 ha – nhưng lại ẩn chứa trong đó cả một kho tàng văn hóa, sinh thái, và lòng mến khách của người dân địa phương. Đây là nơi lý tưởng để \"đổi gió\", rời xa phố thị và sống chậm lại cùng thiên nhiên.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/532;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/du-lich-con-son-can-tho-23_1624378187_1744648614.jpg\" width=\"800\" height=\"532\"></figure><blockquote><h4><strong>Đến Cồn Sơn bằng cách nào?</strong></h4><p><br>Di chuyển đến Cồn Sơn vô cùng thú vị. Từ trung tâm thành phố Cần Thơ, bạn có thể đi xe máy hoặc ô tô đến bến đò Cô Bắc, sau đó <strong>đi ghe hoặc tàu nhỏ khoảng 5-10 phút</strong> là đã đặt chân lên cồn.</p><p>Cảm giác được ngồi xuồng băng qua dòng sông Hậu lộng gió, ngắm nhìn đôi bờ xanh mát và nghe tiếng sóng vỗ mạn thuyền là một trải nghiệm khó quên</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:600/750;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/du-lich-con-son-can-tho-1_1744648607.jpg\" width=\"600\" height=\"750\"></figure><blockquote><h4><strong>Trải nghiệm độc đáo tại Cồn Sơn</strong></h4><p><br>🐟 <strong>Xem cá lóc bay – màn trình diễn \"xiếc cá\" nổi tiếng</strong></p><p>Cá lóc bay là một trong những “đặc sản tinh thần” khi đến Cồn Sơn. Du khách sẽ được tận mắt chứng kiến <strong>những chú cá lóc vượt khỏi mặt nước để đớp mồi trên không</strong>, tạo nên những cú “bay” ngoạn mục và cực kỳ thú vị.</p><p>Màn biểu diễn này là kết quả của quá trình huấn luyện đầy kiên nhẫn của các hộ dân nơi đây – minh chứng cho sự sáng tạo trong làm du lịch cộng đồng.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:1000/577;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/review-cuc-co-tam-kinh-nghiem-di-con-son-can-tho-1649603179_1744648598.jpg\" width=\"1000\" height=\"577\"></figure><blockquote><h4><strong>Tại sao nên chọn Cồn Sơn cho kỳ nghỉ cuối tuần?</strong></h4><p>&nbsp;</p><p><strong>Gần thành phố, dễ đi lại</strong> nhưng không gian lại rất yên bình, trong lành.</p><p><strong>Trải nghiệm đa dạng</strong>, từ sinh thái, ẩm thực đến văn hóa, giáo dục.</p><p><strong>Phù hợp mọi lứa tuổi</strong>: nhóm bạn trẻ, gia đình có trẻ nhỏ, người lớn tuổi đều có hoạt động phù hợp.</p><p><strong>Chi phí rẻ</strong>: phần lớn dịch vụ tại đây do người dân tổ chức, giá cả thân thiện, lại có tính cộng đồng cao.</p><h3><strong>Lưu ý khi du lịch Cồn Sơn</strong></h3><p>&nbsp;</p><p>Nên mang giày dép dễ tháo, dễ đi (vì một số đoạn đi bộ trong vườn hoặc trên bè cá).</p><p>Nếu đi theo nhóm, nên liên hệ trước để đặt dịch vụ ăn uống, trải nghiệm.</p><p>Mang theo nón, kem chống nắng, và nước uống nếu đi vào mùa nắng.</p><p>Tôn trọng không gian sinh hoạt của người dân, không xả rác.</p></blockquote><blockquote><h4><strong>Kết luận:</strong></h4><p><br>Không cần đi đâu xa, ngay trong lòng Cần Thơ, <strong>Cồn Sơn</strong> vẫn đủ sức níu chân du khách bằng chính sự giản dị và chân thật của mình. Đến đây, bạn không chỉ du lịch – bạn sống cùng người dân, ăn món quê, làm nghề truyền thống và hòa mình vào thiên nhiên mát lành.</p><p>Nếu bạn đang tìm một điểm đến để “reset” lại tâm hồn, tạm rời phố thị và quay về với giá trị nguyên bản – thì <strong>Cồn Sơn chính là lựa chọn hoàn hảo</strong>.</p></blockquote>', 'uploads/posts/review-cuc-co-tam-kinh-nghiem-di-con-son-can-tho-1649603179.jpg', 'Cồn Sơn đang nổi lên như một điểm đến lý tưởng với trải nghiệm du lịch cộng đồng, thân thiện và gần gũi thiên nhiên.', 'du-lich-con-son-can-tho', 'du-lich-con-son-can-tho', 0, 5, '2025-04-14 16:37:14', '2025-04-14 16:44:32', NULL, 1, 16),
(4, 'Phú Quốc – Thiên đường đảo ngọc của Việt Nam', '<h3><strong>Giới thiệu về Phú Quốc</strong></h3><blockquote><p>Nằm trong vịnh Thái Lan, <strong>Phú Quốc</strong> là hòn đảo lớn nhất của Việt Nam và cũng là điểm đến mơ ước của hàng triệu du khách trong và ngoài nước. Với chiều dài khoảng 50km từ Bắc xuống Nam, nơi đây được mệnh danh là “<strong>đảo ngọc</strong>” bởi vẻ đẹp thiên nhiên quyến rũ, khí hậu ôn hòa quanh năm và hệ sinh thái biển phong phú.</p><p>Không chỉ nổi bật với <strong>những bãi biển hoang sơ, làn nước trong vắt và bãi cát trắng mịn</strong>, Phú Quốc còn gây ấn tượng bởi <strong>sự kết hợp hài hòa giữa nghỉ dưỡng hiện đại và nét văn hóa bản địa mộc mạc</strong>.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/400;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/phuquoc_1744649586.jpg\" width=\"800\" height=\"400\"></figure><h3><strong>Những trải nghiệm không thể bỏ lỡ ở Phú Quốc</strong></h3><h4>&nbsp;<strong>Tắm biển và thư giãn tại các bãi biển nổi tiếng</strong></h4><blockquote><p><strong>Bãi Sao</strong> – nơi có bãi cát trắng mịn như kem và làn nước trong xanh như ngọc. Đây là bãi biển được nhiều du khách bình chọn là đẹp nhất Phú Quốc.</p><p><strong>Bãi Dài</strong> – kéo dài hơn 15km, thích hợp để ngắm hoàng hôn và nghỉ dưỡng tại các resort sang trọng.</p><p><strong>Bãi Trường</strong> – gần thị trấn Dương Đông, sôi động với các hoạt động vui chơi và hàng quán ven biển.</p></blockquote><p>&nbsp;</p><h4>&nbsp;<strong>Khám phá làng chài và trải nghiệm đời sống ngư dân</strong></h4><p>Hãy ghé thăm <strong>làng chài Hàm Ninh</strong>, nơi bạn có thể thưởng thức hải sản tươi sống với giá cực kỳ phải chăng, ngắm bình minh lên từ cầu tàu và cảm nhận nhịp sống yên bình của cư dân vùng biển.</p><h3><strong>Ẩm thực Phú Quốc – Đậm đà hương vị biển khơi</strong></h3><p>Ẩm thực nơi đây nổi tiếng với <strong>nước mắm truyền thống</strong> – đặc sản nổi tiếng cả nước, cùng những món ăn không thể bỏ qua:</p><blockquote><p><strong>Ghẹ Hàm Ninh</strong> – nhỏ nhưng chắc thịt, ngọt thanh tự nhiên.</p><p><strong>Nhum biển nướng mỡ hành</strong> – béo ngậy, đậm đà.</p><p><strong>Gỏi cá trích</strong> – món ăn đặc trưng không thể thiếu khi đến đảo.</p><p><strong>Còi biên mai nướng</strong> – giòn sần sật, ngon không tưởng!</p></blockquote><h3><strong>Khám phá thiên nhiên hoang sơ</strong></h3><blockquote><p><strong>Vườn quốc gia Phú Quốc</strong> – nơi lý tưởng để trekking, khám phá hệ sinh thái rừng nguyên sinh và suối đá đẹp như tranh vẽ.</p><p><strong>Suối Tranh, suối Đá Bàn</strong> – mát lành giữa rừng sâu, thích hợp dã ngoại và tắm suối.</p><p><strong>Hòn Thơm, Hòn Móng Tay, Hòn Gầm Ghì</strong> – thiên đường snorkeling, lặn ngắm san hô.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:1200/673;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/du-lich-phu-quoc-1013_1744649594.jpg\" width=\"1200\" height=\"673\"></figure><h3><strong>Nghỉ dưỡng và vui chơi đẳng cấp</strong></h3><blockquote><p><strong>Sun World Hon Thom Nature Park</strong> – cáp treo vượt biển dài nhất thế giới, kết nối bạn đến Hòn Thơm với công viên nước và bãi biển cực đẹp.</p><p><strong>VinWonders &amp; Safari Phú Quốc</strong> – khu vui chơi giải trí và vườn thú bán hoang dã quy mô nhất Đông Nam Á.</p><p><strong>Grand World Phú Quốc</strong> – thành phố không ngủ, với hàng loạt hoạt động văn hóa – giải trí – ẩm thực suốt ngày đêm.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/450;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/doi-net-ve-dia-diem-du-lich-phu-quoc_1744649636.jpg\" width=\"800\" height=\"450\"></figure><h3><strong>Kết luận</strong></h3><blockquote><p><strong>Du lịch Phú Quốc</strong> là hành trình đưa bạn rời xa khói bụi phố thị để đắm mình vào thiên nhiên, tận hưởng sự thư giãn đúng nghĩa, đồng thời khám phá văn hóa và ẩm thực độc đáo của người dân đảo ngọc. Dù bạn yêu biển, thích khám phá hay chỉ đơn giản là tìm chốn bình yên, Phú Quốc luôn có cách khiến bạn phải nhớ mãi không quên.</p></blockquote>', 'uploads/posts/phuquoc.jpg', 'Phú Quốc – hòn đảo lớn nhất Việt Nam, nổi tiếng với biển xanh cát trắng, ẩm thực phong phú và những trải nghiệm nghỉ dưỡng đẳng cấp giữa thiên nhiên hoang sơ.', 'du-lich-phu-quoc', 'du-lich-phu-quoc', 1, 5, '2025-04-14 16:54:09', '2025-04-23 02:37:47', NULL, 1, 16),
(5, 'Cá lóc nướng trui – Hương vị dân dã của miền sông nước', '<h4><strong>Cá lóc nướng trui – Món ăn của người nông dân</strong></h4><blockquote><p>Cá lóc (hay còn gọi là cá quả) là loài cá nước ngọt phổ biến ở các ao hồ, kênh rạch miền Tây. Cá lóc nướng trui có cách chế biến vô cùng mộc mạc. Người ta chọn cá lóc tươi sống, không đánh vảy, cũng không mổ bụng. Cá được rửa sạch, xiên một cây tre dài từ miệng đến đuôi, rồi cắm nghiêng vào đất, đốt rơm xung quanh cho đến khi lớp vảy cháy xém, da cá căng nứt, thịt bên trong chín mềm, tỏa mùi thơm phức.</p><p>Chính cách nướng trui độc đáo này giữ nguyên được vị ngọt tự nhiên của cá, không cần nêm nếm cầu kỳ. Lớp da cháy sém bên ngoài được lột bỏ, để lộ phần thịt trắng ngà, thơm lừng bên trong. Đó là lý do tại sao cá lóc nướng trui trở thành món “đặc sản” trong các bữa tiệc đồng quê, được nhiều du khách ưa thích khi đến miền Tây.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:490/327;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/ca-loc-nuong-chui-02_1744650147.jpg\" width=\"490\" height=\"327\"></figure><h4><strong>Hương vị quê nhà trong từng miếng cá</strong></h4><blockquote><p>Cá lóc nướng trui thường được ăn kèm với rau sống – những loại rau dân dã như rau thơm, xà lách, diếp cá, tía tô, lá cách, chuối chát, khế chua... cùng bánh tráng và chén mắm me pha chua ngọt. Mỗi người có thể tự cuốn bánh tráng, bỏ thêm rau, bún tươi và miếng cá lóc thơm lừng, chấm với nước mắm me là đủ để cảm nhận được sự hài hòa giữa các tầng hương vị – ngọt của cá, chua của khế, chát của chuối, thơm của rau sống và đậm đà của mắm me.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:1960/1303;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/Phat-Them-Voi-Ca-Loc_1744650160.jpg\" width=\"1960\" height=\"1303\"></figure><h4><strong>Không chỉ là món ăn, mà còn là một phần ký ức</strong></h4><blockquote><p>Đối với nhiều người miền Tây, cá lóc nướng trui không chỉ là món ăn mà còn là ký ức tuổi thơ. Những buổi chiều cùng cha ra đồng, bắt cá rồi nhóm lửa nướng bên bờ ruộng, khói rơm cay cay mắt, nhưng mùi cá nướng thì làm ấm lòng. Ngày nay, món cá lóc nướng trui vẫn giữ được cái hồn dân dã ấy, dù đã xuất hiện trong nhiều nhà hàng, quán ăn.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:1200/676;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/caloc_1744650199.jpg\" width=\"1200\" height=\"676\"></figure>', 'uploads/posts/caloc.jpg', 'Ẩm thực miền Tây Nam Bộ là sự kết tinh của thiên nhiên trù phú, con người chân chất và những giá trị văn hóa truyền thống lâu đời. Trong vô vàn món ngon nơi đây, cá lóc nướng trui là một trong những món ăn dân dã nhưng lại mang đậm hương vị miền quê, gợi nhớ đến những buổi chiều bên bếp lửa hồng, mùi khói thoảng quyện trong tiếng cười rôm rả của gia đình sum vầy.', 'ca-loc-nuong-trui', 'ca-loc-nuong-trui', 3, 7, '2025-04-14 17:04:31', '2025-04-26 05:24:46', NULL, 1, 16),
(6, 'Bánh xèo miền Tây – Giòn rụm, đậm đà hương vị đồng quê', '<h4><strong>Bánh xèo – Nét riêng của từng vùng</strong></h4><p>&nbsp;</p><blockquote><p>Khác với bánh xèo miền Trung có kích thước nhỏ và nhân đơn giản, bánh xèo miền Tây thường to bằng cái chảo lớn, vàng ươm, giòn tan với phần nhân phong phú gồm tôm, thịt, giá, đậu xanh, đôi khi có thêm nấm rơm hay củ sắn tùy theo vùng.</p><p>Để làm ra chiếc bánh xèo chuẩn vị miền Tây, người ta pha bột gạo với nước cốt dừa, chút nghệ để tạo màu vàng hấp dẫn. Chảo được làm nóng, phết một lớp dầu mỏng, đổ một vá bột tráng đều rồi nhanh tay rải nhân lên trên. Chỉ trong vài phút, lớp vỏ bánh giòn rụm, các nguyên liệu chín tới, tỏa ra mùi thơm quyến rũ.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/570;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banhxeo1_1744650393.jpg\" width=\"800\" height=\"570\"></figure><h4><strong>Ăn bánh xèo là cả một “nghi thức”</strong></h4><p>&nbsp;</p><blockquote><p>Bánh xèo miền Tây không ăn một mình mà phải ăn kèm rau sống và nước mắm chua ngọt. Điều đặc biệt ở đây là rau ăn kèm không chỉ là rau xà lách hay rau thơm mà còn có lá lụa, lá lốt, cải trời, đọt bằng lăng non, đọt xoài, lá cách, rau diếp cá, rau quế... Mỗi loại rau góp một mùi vị riêng, tạo nên tổng thể hài hòa độc đáo.</p><p>Thưởng thức bánh xèo đúng cách là lấy một miếng bánh, đặt lên lá rau, cuốn lại và chấm vào chén nước mắm. Cái giòn tan của vỏ bánh, vị ngọt đậm của nhân, sự tươi mát của rau và chút chua ngọt của nước chấm hòa quyện lại khiến ai ăn một lần cũng khó quên.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:800/450;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banhxeo2_1744650398.jpg\" width=\"800\" height=\"450\"></figure><h4><strong>Món bánh gắn liền với ký ức gia đình</strong></h4><p>&nbsp;</p><blockquote><p>Bánh xèo là món ăn thường thấy trong những dịp sum họp, lễ hội hay đơn giản là bữa chiều cuối tuần. Nhiều gia đình miền Tây chọn cách đổ bánh xèo tại chỗ, cả nhà quây quần bên bếp, người nướng, người cuốn, người chấm – tất cả tạo nên không khí ấm cúng, gần gũi vô cùng.</p><p>Ngày nay, bánh xèo miền Tây đã trở thành món ăn nổi tiếng không chỉ trong nước mà còn với du khách quốc tế. Dù xuất hiện ở nhiều nơi, nhưng chỉ có về miền Tây, ngồi trong một quán nhỏ ven sông, thưởng thức chiếc bánh xèo nóng hổi, thơm giòn mới thật sự cảm nhận được trọn vẹn cái hồn của món ăn này.</p></blockquote><figure class=\"image\"><img style=\"aspect-ratio:2000/1333;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banhxeo3_1744650403.jpg\" width=\"2000\" height=\"1333\"></figure>', 'uploads/posts/banhxeo1.jpg', 'Miền Tây không chỉ nổi tiếng với cảnh sắc thiên nhiên hữu tình mà còn là nơi lưu giữ nhiều món ăn đặc sản dân dã, mang đậm bản sắc địa phương. Một trong số đó không thể không nhắc đến bánh xèo miền Tây – món bánh mang trong mình cái hồn của ruộng đồng, sông nước, cùng tình cảm ấm áp của người dân quê hiếu khách.', 'banh-xeo-mien-tay', 'banh-xeo-mien-tay', 1, 7, '2025-04-14 17:06:57', '2025-04-26 05:05:09', NULL, 1, 16),
(7, 'Ẩm Thực Cà Mau Hấp Dẫn', '<p><strong>Khi nhắc đến du lịch Cà Mau, bên cạnh vẻ đẹp thiên nhiên kỳ thú, \"ẩm thực Cà Mau hấp dẫn\" là một trong những điểm nhấn khiến du khách lưu luyến mãi không quên. Những món ăn nơi đây mang đậm hương vị miền sông nước, vừa giản dị vừa đặc sắc, làm say lòng người thưởng thức.</strong></p><h3>Cua cà mau</h3><p>Một trong những món nổi tiếng nhất của ẩm thực Cà Mau hấp dẫn chính là <strong>cua Cà Mau</strong>. Những con cua thịt chắc, gạch son vàng ươm được chế biến thành nhiều món như cua hấp, cua rang me, cua nướng mọi… Dù chế biến thế nào, hương vị vẫn giữ được sự ngọt thanh, béo ngậy đặc trưng.</p><figure class=\"image\"><img style=\"aspect-ratio:1200/676;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/cach-phan-biet-cua-duc-cua-cai-cua-ca-mau-that-gia-don-gian-avt-1200x676-1_1745890708.jpg\" width=\"1200\" height=\"676\"><figcaption><i>&nbsp;Cua cà mau - Ẩm thực Cà Mau hấp dẫn.</i></figcaption></figure><h3>Ba khía</h3><p>Bên cạnh cua, <strong>ba khía Rạch Gốc</strong> cũng là món ăn đậm bản sắc của vùng đất này. Ba khía được muối vừa miệng, khi ăn kèm với cơm trắng hoặc cuốn bánh tráng rau sống đều rất tuyệt vời. Món ăn này góp phần làm cho ẩm thực Cà Mau hấp dẫn trong lòng du khách phương xa.</p><figure class=\"image\"><img style=\"aspect-ratio:1200/1200;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/goi-du-du-ba-khia-bep-nha_1745892445.jpg\" width=\"1200\" height=\"1200\"><figcaption><i>Ba khía - Ẩm thực Cà Mau hấp dẫn</i></figcaption></figure><h3>Lẩu mắm</h3><p>Không thể bỏ qua <strong>lẩu mắm U Minh</strong> – một tuyệt phẩm ẩm thực từ rừng tràm. Nồi lẩu kết hợp nước mắm cá linh thơm đậm cùng hàng chục loại rau rừng như bồn bồn, rau nhút, bông súng… tạo nên một hương vị hài hòa, đậm đà mà chỉ riêng Cà Mau mới có.</p><figure class=\"image\"><img style=\"aspect-ratio:1280/720;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/lau-mam_1745892525.jpg\" width=\"1280\" height=\"720\"><figcaption><i>Lẩu mắm - U minh</i></figcaption></figure><p>Ngoài ra, những món ăn dân dã như <strong>chuột đồng nướng muối ớt</strong>, <strong>cá thòi lòi nướng trui</strong> hay <strong>bánh tầm gà cay</strong> cũng góp phần làm phong phú thêm bức tranh ẩm thực nơi đây. Chính sự đa dạng, độc đáo này đã khiến ẩm thực Cà Mau hấp dẫn đối với mọi thực khách.</p><p>Điều đặc biệt trong hành trình khám phá ẩm thực Cà Mau hấp dẫn không chỉ nằm ở món ăn mà còn ở cách người dân bản xứ chế biến, phục vụ với tất cả sự chân thành và mến khách. Từng món ăn là câu chuyện về cuộc sống, thiên nhiên, và văn hóa con người vùng đất mũi.</p><p>Nếu bạn đang tìm kiếm một trải nghiệm ẩm thực đặc sắc, đầy hương vị và cảm xúc, đừng ngần ngại lên kế hoạch để một lần thưởng thức ẩm thực Cà Mau hấp dẫn – nơi tinh hoa ẩm thực miền Tây hội tụ.</p>', 'uploads/posts/du-lich-ca-mau-1-1430.jpg', 'Ẩm thực Cà Mau hấp dẫn du khách bởi sự đa dạng, tươi ngon và đậm đà bản sắc miền Tây. Khám phá ngay những món ngon khó cưỡng khi đến với vùng đất tận cùng Tổ quốc!', 'am-thuc-ca-mau-hap-dan', 'am-thuc-ca-mau-hap-dan', 0, 7, '2025-04-29 02:10:15', '2025-04-29 02:10:15', NULL, 1, 7),
(8, 'Ẩm Thực Cần Thơ Giản dị', '<p><strong>Cần Thơ – trái tim miền Tây sông nước – không chỉ nổi tiếng bởi vẻ đẹp dịu dàng của bến Ninh Kiều hay nét thơ mộng của những chợ nổi, mà còn ghi dấu trong lòng du khách bởi ẩm thực Cần Thơ đậm đà, giản dị nhưng sâu sắc như chính con người nơi đây.</strong></p><h3><strong>Bánh xèo</strong></h3><p>Khi đặt chân đến vùng đất này, du khách khó lòng bỏ qua món <strong>bánh xèo Cần Thơ</strong>. Chiếc bánh vàng ruộm, giòn rụm, ôm trọn nhân tôm, thịt, giá và rau xanh tươi mát. Ăn một miếng bánh xèo, chấm ngập nước mắm chua ngọt, ta như cảm nhận trọn vẹn cái hồn của <strong>ẩm thực Cần Thơ đậm đà</strong>.</p><figure class=\"image\"><img style=\"aspect-ratio:1281/804;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banh-xeo-Can-Tho-Bay-Toi (1)_1745895367.jpg\" width=\"1281\" height=\"804\"><figcaption><i>Bánh xèo Cần Thơ giản dị</i></figcaption></figure><h3>Lẩu mắm</h3><p>Tiếp nối hành trình khám phá, <strong>lẩu mắm Cần Thơ</strong> là món ăn mà ai yêu thích ẩm thực miền Tây cũng mong một lần thưởng thức. Nồi lẩu đậm đà vị mắm, hòa quyện với nhiều loại cá, tôm, rau đồng, mang lại một hương vị nồng nàn, mộc mạc nhưng cũng rất quyến rũ. Một lần nếm thử, bạn sẽ hiểu vì sao <strong>ẩm thực Cần Thơ đậm đà</strong> luôn có sức hút đặc biệt.</p><figure class=\"image\"><img style=\"aspect-ratio:1000/1000;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/lau-mam-can-tho_1745895412.jpeg\" width=\"1000\" height=\"1000\"><figcaption><i>Lẩu mắm Cần Thơ</i></figcaption></figure><h3>Bún nước lèo</h3><p>Không thể không nhắc đến <strong>bún nước lèo</strong>, món ăn nhẹ nhàng nhưng đầy tinh tế. Sợi bún mềm, nước lèo trong veo, thoang thoảng mùi mắm, điểm xuyết những lát thịt heo quay vàng ruộm và chút rau sống xanh mát. Món ăn này như một lời thì thầm dịu dàng của <strong>ẩm thực Cần Thơ đậm đà</strong> gửi đến những ai yêu sự mộc mạc.</p><figure class=\"image\"><img style=\"aspect-ratio:576/330;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/bun-nuoc-leo-can-tho_1745895466.jpg\" width=\"576\" height=\"330\"><figcaption><i>Bún nước lèo Cần Thơ</i></figcaption></figure><p>Ngoài ra, một buổi sáng tại Cần Thơ sẽ thêm phần trọn vẹn nếu bạn thưởng thức một tô <strong>hủ tiếu Sa Đéc</strong> hay lang thang các khu chợ, thưởng thức <strong>bánh tét lá cẩm</strong> – món bánh đặc sản được làm từ nếp dẻo, nhuộm tím tự nhiên từ lá cẩm, vừa thơm vừa béo.</p><p>Cái hay của <strong>ẩm thực Cần Thơ đậm đà</strong> không chỉ nằm ở món ăn ngon, mà còn ở cái cách người dân gửi gắm tình yêu quê hương vào từng mẻ bánh, từng nồi lẩu, từng tô bún. Mỗi món ăn là một câu chuyện, một niềm tự hào, một lời mời gọi thân thương dành cho những ai ghé thăm.</p><p>Nếu bạn cần một hành trình nhẹ nhàng, ấm áp và đầy ắp hương vị, đừng quên để lòng mình phiêu du cùng <strong>ẩm thực Cần Thơ đậm đà</strong> – nơi những điều bình dị trở nên đáng nhớ hơn bao giờ hết.</p>', 'uploads/posts/am-thuc-can-tho-gian-di.jpg', 'Ẩm thực Cần Thơ đậm đà mang trong mình sự hào sảng, ngọt ngào của miền Tây, níu chân du khách bằng những món ăn bình dị mà khó quên.', 'am-thuc-can-tho-gian-di', 'am-thuc-can-tho-gian-di', 0, 7, '2025-04-29 02:58:21', '2025-04-29 02:58:21', NULL, 1, 7),
(9, 'Ẩm Thực An Giang Huyền Bí', '<p><strong>Vùng đất Thất Sơn – Bảy Núi của An Giang không chỉ gắn liền với những câu chuyện huyền thoại mà còn nổi tiếng với nền ẩm thực An Giang huyền bí, vừa mộc mạc, vừa đậm đà nét văn hóa bản địa.</strong></p><h3><strong>Bò leo núi</strong></h3><p>Nhắc đến <strong>ẩm thực An Giang huyền bí</strong>, không thể bỏ qua món <strong>bò leo núi</strong> ở vùng Tịnh Biên. Thịt bò tươi được ướp gia vị đặc biệt, nướng trên chảo đá hồng, tỏa mùi thơm lừng, ăn kèm rau rừng xanh mướt và nước chấm chua ngọt. Hương vị vừa hoang dã vừa đậm chất núi rừng khiến thực khách không thể nào quên.</p><figure class=\"image\"><img style=\"aspect-ratio:1024/768;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/bo-leo-nui_1745900260.jpg\" width=\"1024\" height=\"768\"><figcaption><i>Bò leo núi</i></figcaption></figure><h3>Gà đốt lá trúc</h3><p>Một món ăn độc đáo khác của <strong>ẩm thực An Giang huyền bí</strong> là <strong>gà đốt lá trúc</strong> – đặc sản vùng Tri Tôn. Những chú gà thả vườn chắc thịt được ướp cùng lá trúc thơm ngát, đốt lên thành món ăn vàng ruộm, thơm lừng, vị chua nhẹ tự nhiên thấm đẫm từng thớ thịt, đậm đà mà tinh tế.</p><figure class=\"image\"><img style=\"aspect-ratio:760/442;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/ga-dot-la-chuc_1745900370.jpg\" width=\"760\" height=\"442\"><figcaption><i>Gà đốt lá chúc</i></figcaption></figure><h3>Mắm Châu Đốc</h3><p>Nếu yêu thích hương vị dân dã, <strong>mắm Châu Đốc</strong> là đại diện tiêu biểu của <strong>ẩm thực An Giang huyền bí</strong>. Từ mắm cá lóc, mắm sặc đến mắm thái, mỗi loại mắm đều mang hương vị riêng biệt, ăn kèm rau sống, thịt luộc hay cơm trắng đều tròn vị, đậm đà bản sắc miền Tây.</p><figure class=\"image\"><img style=\"aspect-ratio:1280/894;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/mam-chau-doc_1745900436.jpeg\" width=\"1280\" height=\"894\"><figcaption><i>Mắm Châu Đốc</i></figcaption></figure><h3>Bánh xèo rau rừng và bún cá An Giang</h3><p>Lang thang chợ vùng Thất Sơn, bạn còn bắt gặp những món ăn dân gian như <strong>bánh xèo rau rừng</strong>, <strong>bún cá An Giang</strong>, hay thậm chí những món ăn độc lạ như <strong>chuột núi nướng mọi</strong>. Chính sự phong phú và tự nhiên ấy đã làm nên vẻ đẹp rất riêng cho <strong>ẩm thực An Giang huyền bí</strong>.</p><figure class=\"image\"><img style=\"aspect-ratio:600/400;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banh-xeo-an-giang_1745900781.jpg\" width=\"600\" height=\"400\"><figcaption><i>Bánh xèo An Giang</i></figcaption></figure><figure class=\"image\"><img style=\"aspect-ratio:1024/768;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/bun-ca-an-giang_1745900923.jpg\" width=\"1024\" height=\"768\"><figcaption>Bún cá An Giang</figcaption></figure><p>Ẩm thực nơi đây không chỉ đơn thuần là món ăn, mà còn là linh hồn của đất trời, của những truyền thuyết và niềm tin huyền bí bao đời. Mỗi món ăn chứa đựng sự giao hòa giữa thiên nhiên hoang dã và bàn tay khéo léo của người dân miền sơn cước.</p><p>Một lần lạc bước giữa những cung đường đá núi, thưởng thức trọn vẹn những món ăn mộc mạc nhưng đậm chất vùng cao, bạn sẽ cảm nhận được cái tình, cái hồn của <strong>ẩm thực An Giang huyền bí</strong> – nơi mà mỗi hương vị đều kể một câu chuyện xưa cũ nhưng đầy sức sống</p>', 'uploads/posts/an-giang-am-thuc-huyen-bi.jpg', 'Ẩm thực An Giang huyền bí mang trong mình nét độc đáo của vùng Thất Sơn Bảy Núi, hòa quyện giữa tinh hoa dân tộc và hương vị thiên nhiên hoang sơ.', 'am-thuc-an-giang-huyen-bi', 'am-thuc-an-giang-huyen-bi', 1, 7, '2025-04-29 04:29:02', '2025-04-29 00:36:14', NULL, 1, 7),
(10, 'Ẩm thực Bến Tre ngọt lạnh', '<p>Nhắc đến Bến Tre, người ta thường nhớ ngay đến những rặng dừa bạt ngàn soi bóng nước, cùng với đó là nền <strong>ẩm thực Bến Tre ngọt lành</strong>, mang trong mình trọn vẹn sự tươi mát và bình dị của xứ dừa.</p><h3>Cơm dừa</h3><p>Một trong những món đặc trưng không thể bỏ qua của <strong>ẩm thực Bến Tre ngọt lạnh</strong> là <strong>cơm dừa</strong>. Hạt gạo dẻo thơm được nấu chín trong trái dừa tươi, thấm đẫm vị ngọt béo tự nhiên, ăn kèm tôm rang dừa hoặc cá kho tộ thì càng thêm tròn vị. Mỗi hạt cơm như mang theo dư vị của những ngày nắng chan hòa nơi miền quê thanh bình.</p><figure class=\"image\"><img style=\"aspect-ratio:900/525;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/thuong-thuc-com-dua-ben-tre_1745902903.jpg\" width=\"900\" height=\"525\"><figcaption><i>Cơm dừa Bến Tre</i></figcaption></figure><h3>Gỏi củ hủ dừa</h3><p>Tiếp theo, <strong>gỏi củ hủ dừa</strong> cũng là món ăn nổi tiếng trong <strong>ẩm thực Bến Tre ngọt lạnh</strong>. Củ hũ dừa – phần non nhất của cây dừa – được trộn cùng tôm, thịt và rau thơm, tạo nên món gỏi giòn ngọt, thanh mát, vừa đẹp mắt vừa đậm đà hương vị quê hương.</p><figure class=\"image\"><img style=\"aspect-ratio:540/360;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/goi-cu-hu-dua-bao-tu_1745902920.jpg\" width=\"540\" height=\"360\"><figcaption><i>Gỏi củ hủ dừa</i></figcaption></figure><h3>Bánh xèo nhân hến</h3><p>Khi dạo quanh các chợ quê Bến Tre, du khách không thể không thưởng thức <strong>bánh xèo nhân hến</strong> hay <strong>chuối đập nướng</strong> – những món ăn dân dã gắn liền với tuổi thơ nhiều người. Chính sự mộc mạc, chân phương này đã làm nên nét duyên riêng cho <strong>ẩm thực Bến Tre ngọt lạnh</strong>.</p><figure class=\"image\"><img style=\"aspect-ratio:1200/676;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banh-xeo-henn_1745902937.jpg\" width=\"1200\" height=\"676\"><figcaption><i>Bánh xèo nhân hến</i></figcaption></figure><h3>Kẹo dừa Bến Tre</h3><p>Cuối cùng Không thể không nhắc đến đặc sản nơi đây đó là các món ngọt như <strong>kẹo dừa Bến Tre</strong> – món quà quê nổi tiếng. Kẹo dừa dẻo dai, thơm lừng vị béo của nước cốt dừa, thoảng chút ngọt thanh tinh tế, như mang theo cả hồn quê mộc mạc gửi gắm vào từng viên kẹo nhỏ bé.</p><figure class=\"image\"><img style=\"aspect-ratio:1484/880;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/keo-dua-ben-tre_1745902955.jpg\" width=\"1484\" height=\"880\"><figcaption><i>Kẹo dừa Bến Tre</i></figcaption></figure><p>Điều làm nên sức hấp dẫn của <strong>ẩm thực Bến Tre ngọt lạnh</strong> không chỉ nằm ở nguyên liệu tươi ngon mà còn ở sự khéo léo, chăm chút trong từng công đoạn chế biến. Mỗi món ăn đều mang theo tấm lòng hiếu khách, sự chân thành của người dân vùng đất này.</p><p>Nếu bạn mong muốn tìm về một nơi với những bữa ăn mộc mạc nhưng đong đầy tình quê, hãy để lòng mình trôi theo những con rạch, qua những vườn dừa, để cảm nhận hết nét duyên thầm của <strong>ẩm thực Bến Tre ngọt lạnh</strong> – nơi ngọt ngào từ hương vị đến tâm hồn.</p>', 'uploads/posts/am-thuc-ben-tre-ngot-lanh.jpg', 'Ẩm thực Bến Tre ngọt lạnh mang hương vị của những vườn dừa xanh mát, gói trọn sự giản dị, chân chất của miền quê sông nước.', 'am-thuc-ben-tre-ngot-lanh', 'am-thuc-ben-tre-ngot-lanh', 0, 7, '2025-04-29 05:01:20', '2025-04-29 05:03:48', NULL, 1, 7),
(11, 'Ăn gì ở Tây Ninh?', '<p>Nằm giữa miền Đông Nam Bộ, Tây Ninh không chỉ nổi tiếng với núi Bà Đen linh thiêng mà còn ghi dấu trong lòng du khách bởi <strong>ẩm thực Tây Ninh đậm đà</strong>, chân chất và đầy cuốn hút.</p><h3>Bánh tráng phơi sương</h3><p>Đầu tiên phải kể đến <strong>bánh tráng phơi sương Trảng Bàng</strong> – món đặc sản trứ danh làm nên thương hiệu <strong>ẩm thực Tây Ninh đậm đà</strong>. Bánh tráng mỏng, dẻo nhẹ, được phơi sương vào ban đêm để giữ được độ mềm mại tự nhiên. Ăn kèm thịt luộc, rau rừng và chấm mắm nêm, mỗi cuốn bánh là một sự tổng hòa của vị ngọt, chua, mặn, cay – giản dị mà tròn đầy.</p><figure class=\"image\"><img style=\"aspect-ratio:1398/830;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/banh-trang-phoi-suong-Tay-Ninh_1745907429.jpg\" width=\"1398\" height=\"830\"><figcaption><i>Bánh tráng phơi sương Tây Ninh</i></figcaption></figure><h3>Muối tôm Tây Ninh</h3><p>Nhắc đến Tây Ninh mà không nói đến <strong>muối tôm Tây Ninh</strong> thì quả thật là thiếu sót. Món chấm độc đáo này có mặt hầu như ở mọi nhà, được dùng để ăn trái cây, chấm rau hoặc pha chế nước chấm. Hương vị đậm đà, cay nhẹ và thơm nồng khiến <strong>ẩm thực Tây Ninh đậm đà</strong> luôn mang lại cảm giác “ăn là ghiền”.</p><figure class=\"image\"><img style=\"aspect-ratio:1920/1280;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/muoi-tom-tay-ninh_1745907502.jpg\" width=\"1920\" height=\"1280\"><figcaption><i>Muối tôm Tây Ninh</i></figcaption></figure><h3>Bò tơ Tây Ninh</h3><p>Bên cạnh đó, <strong>bò tơ Tây Ninh</strong> cũng góp phần làm phong phú thêm bản đồ ẩm thực địa phương. Thịt bò non được chế biến thành nhiều món như nướng, hấp, tái chanh… nhưng dù là món nào thì cũng giữ được vị ngọt mềm đặc trưng, đặc biệt hấp dẫn khi ăn kèm bánh tráng và rau rừng – một điểm nhấn đặc trưng của <strong>ẩm thực Tây Ninh đậm đà</strong>.</p><figure class=\"image\"><img style=\"aspect-ratio:1000/667;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/bo-to-tay-ninh_1745907557.jpg\" width=\"1000\" height=\"667\"><figcaption><i>Bò tơ Tây Ninh</i></figcaption></figure><p>Ngoài những món chính, Tây Ninh còn níu chân thực khách bằng các món ăn vặt bình dân như <strong>bánh canh Trảng Bàng</strong>, <strong>chè đậu ván</strong>, hay những loại trái cây dầm muối tôm đầy cuốn hút. Mỗi món ăn mang một nét riêng, vừa dân dã vừa gần gũi như chính con người nơi đây.</p><p>Điều khiến <strong>ẩm thực Tây Ninh đậm đà</strong> trở nên đặc biệt không chỉ ở nguyên liệu mà còn ở sự kết hợp giữa văn hóa ẩm thực miền núi, miền quê và chút ảnh hưởng từ Campuchia – quốc gia có chung đường biên giới. Nhờ đó, món ăn nơi đây mang hương vị riêng biệt, đầy bản sắc.</p>', 'uploads/posts/an-gi-o-tay-ninh.jpg', 'Ẩm thực Tây Ninh đậm đà là sự hòa quyện giữa hương vị miền núi và văn hóa ẩm thực dân gian, mang đến trải nghiệm ẩm thực khó quên cho du khách phương xa.', 'am-thuc-tay-ninh-dam-da', 'am-thuc-tay-ninh-dam-da', 2, 7, '2025-04-29 06:19:37', '2025-04-29 00:34:28', NULL, 1, 7),
(12, 'Ẩm thực miền tây có gì nhỉ?', '<h3><strong>Các món lẩu</strong></h3><h4><strong>Lẩu cá linh</strong></h4><p>Cá linh ngon nhất khi vào mùa nước nổi, tầm tháng cuối tháng 7 âm lịch hằng năm. Lẩu cá linh thường được ăn với bông điên điển với một số món ăn kèm khác, tất cả đã hòa quyện thành một món ăn mang hương vị ngọt thanh, chua chua giản dị mà lại thoang thoảng dư âm của thiên nhiên miền sông nước. Món lẩu này có thể linh hoạt ăn kèm với cơm hoặc bún tươi. Lẩu cá linh rất dễ ăn, phù hợp với nhiều lứa tuổi và chắc chắn rằng chỉ khi đến miền Tây bạn mới có thể thưởng thức đúng mùi vị của món ăn này.</p><figure class=\"image\"><img style=\"aspect-ratio:1200/676;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/lau-ca-linh_1745907992.jpg\" width=\"1200\" height=\"676\"><figcaption><i>Lâu cá linh</i></figcaption></figure><h4><strong>Lẩu cá kèo</strong></h4><p>Trải nghiệm ẩm thực miền Tây về món lẩu sẽ đầy đủ hơn khi bạn được nếm thử món lẩu cá kèo trứ danh miền sông nước. Vị béo ngậy, ngọt dai của cá kết hợp vị chua thanh của nước lẩu và độ tươi ngon của các loại rau ăn kèm sẽ mang lại cho vị giác bạn 1 cảm giác hoàn toàn hài lòng. Thật không gì tuyệt vời bằng việc sau chuyến tham quan, bạn có thể vào bất cứ một nhà hàng lẩu mắm để thưởng thức sự thơm ngon của món ăn này.</p><figure class=\"image\"><img style=\"aspect-ratio:1112/1112;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/Lau-ca-keo_1745908091.jpg\" width=\"1112\" height=\"1112\"><figcaption><i>Lẩu cá kèo</i></figcaption></figure><h3>Món ăn đặc trưng với tên gọi độc đáo</h3><h4><strong>“Vũ nữ chân dài” khô nhái (khô cá nhái, khô nhái cơm, khô nhái đồng)</strong></h4><p>Nghe có vẻ rất lạ nhưng đây là món ăn đặc sản vô cùng độc đáo và ấn tượng tại vùng Tây Nam Bộ. “Vũ nữ chân dài” là một cách gọi vui món khô nhái của người dân địa phương miền Tây nhưng nguồn gốc của nó lại đến từ Campuchia. Có rất nhiều cách biến tấu món ăn này, cách nào cũng sẽ khiến bạn đi từ bất ngờ này đến bất ngờ khác vì mùi vị vô cùng hấp dẫn của khô nhái “vũ nữ”. Các món khô nhái bạn có thể tham khảo: khô nhái nướng, khô nhái chiên giòn, khô nhái chiên bơ tỏi, khô nhái chiên mắm,...&nbsp;</p><figure class=\"image\"><img style=\"aspect-ratio:1200/700;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/vu-nu-chan-dai_1745908244.jpg\" width=\"1200\" height=\"700\"><figcaption><i>Vũ nữ chân dài miền tây</i></figcaption></figure><h4>Chuột đồng</h4><p>Chỉ cần nghe thấy tên món ăn, chắc bạn có thể cảm nhận được sự dân dã nhưng lại rất đặc biệt của nó. Chuột được người dân nuôi ở đồng, chúng ăn thóc và gạo nên thịt sẽ rất béo có thể hơi giống thịt gà một chút. Chuột đồng cũng được chế biến theo nhiều cách thức khác nhau, món nào cũng mang sự thơm ngon của riêng chúng: chuột đồng nướng, chuột đồng chiên sả ớt, chuột đồng khìa nước dừa, chuột quay lu,...</p><figure class=\"image\"><img style=\"aspect-ratio:2044/1534;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/chuot-dong-nuong_1745908328.jpg\" width=\"2044\" height=\"1534\"><figcaption><i>Chuột đồng nướng</i></figcaption></figure><p>Vừa rồi là 1001 những món ăn đặc trưng của ẩm thực miền Tây mà bạn không thể bỏ lỡ. Bạn đã chấm lại món nào cho chuyến du lịch của mình chưa ? Hãy cố gắng thử hết và cảm nhận nó theo cách riêng của bản thân. Hãy tham quan những món bánh đặc sản miền tây tại <a href=\"https://xn--hngthnhspecialfood-cze8310m.vn/sanpham\">đây nhé</a>!</p>', 'uploads/posts/am-thuc-mien-tay.jpg', 'Ẩm thực miền Tây luôn nổi tiếng với cảm giác lạ miệng nhưng lại đủ “sát thương” để gây thương nhớ vô cùng đối với một 1 vị khách khi đặt chân đến vùng đất này. Đây cũng chính là điều thôi thúc những vị khách phương xa ước 1 lần có thể tận mắt đến với non nước tại khu vực Đồng bằng sông Cửu Long. Hãy theo chân Hưng Thịnh Food tổng hợp những món ăn bạn không thể bỏ lỡ của ẩm thực miền Tây', 'am-thuc-mien-tay', 'am-thuc-mien-tay', 4, 7, '2025-04-29 07:33:18', '2025-04-29 02:21:41', NULL, 1, 7),
(13, 'Top 5 điểm du lịch hè mát lạnh gần Hà Nội cho cuối tuần', '<h4><strong>1. Tam Đảo (Vĩnh Phúc)</strong></h4><p><br>Chỉ cách Hà Nội khoảng 80km, Tam Đảo nổi bật với không khí mát mẻ quanh năm và cảnh sắc thiên nhiên thơ mộng. Đến đây, bạn có thể khám phá Thác Bạc, Nhà thờ đá, Cầu mây và thưởng thức đặc sản su su.</p><figure class=\"image\"><img style=\"aspect-ratio:2048/1152;\" src=\"https://static-images.vnncdn.net/files/publish/2023/8/27/w-thach-thao-44-1-812.jpg\" alt=\"Tam Đảo, điểm du lịch trên mây đang bị \'bức tử\'\" width=\"2048\" height=\"1152\"><figcaption>Tam đảo - Vĩnh&nbsp;</figcaption></figure><h4><strong>2. Mai Châu (Hòa Bình)</strong></h4><p><br>Với những thung lũng xanh mướt, không khí trong lành và văn hóa người Thái đặc sắc, Mai Châu là điểm đến lý tưởng cho gia đình hoặc nhóm bạn bè muốn nghỉ dưỡng, hòa mình vào thiên nhiên.</p><figure class=\"image\"><img style=\"aspect-ratio:2048/1365;\" src=\"https://thefittraveller.com/wp-content/uploads/2017/10/mai-chau-cover-.jpeg\" alt=\"mai châu\" width=\"2048\" height=\"1365\"><figcaption>Mai Châu - Hòa Bình</figcaption></figure><h4><strong>3. Ba Vì (Hà Nội)</strong></h4><p><br>Không cần đi quá xa, Ba Vì là lựa chọn cực kỳ tiện lợi cho chuyến đi trong ngày hoặc cuối tuần. Vườn quốc gia Ba Vì, nhà thờ cổ Pháp và khu du lịch Ao Vua đều là những điểm check-in hút khách.</p><figure class=\"image\"><img style=\"aspect-ratio:1024/620;\" src=\"https://motogo.vn/wp-content/uploads/2019/01/ba-vi-14.jpg\" alt=\"Ba Vì\\\" width=\"1024\" height=\"620\"><figcaption>Ba Vì - Hà Nội</figcaption></figure><h4><strong>4. Hồ Núi Cốc (Thái Nguyên)</strong></h4><p><br>Nổi tiếng với vẻ đẹp bình yên và mặt hồ xanh trong, Hồ Núi Cốc là nơi thích hợp để thư giãn, đi du thuyền, tham quan động huyền thoại, hoặc vui chơi tại khu giải trí ven hồ.</p><figure class=\"image\"><img style=\"aspect-ratio:800/533;\" src=\"https://khamphadisan.com.vn/wp-content/uploads/2016/05/ho-nui-coc-4.jpg\" alt=\"Hồ Núi Cốc\" width=\"800\" height=\"533\"><figcaption>Hồ Núi Cốc - Thái Nguyên</figcaption></figure><h4><strong>5. Mộc Châu (Sơn La)</strong></h4><p><br>Tuy cách Hà Nội khoảng 180km nhưng Mộc Châu vẫn là “thiên đường tránh nóng” được yêu thích. Với khí hậu dễ chịu, cao nguyên xanh ngát, đồi chè, rừng thông bản Áng, đây là nơi lý tưởng cho du lịch ngắn ngày.</p><figure class=\"image\"><img style=\"aspect-ratio:660/394;\" src=\"https://kenh14cdn.com/thumb_w/660/203336854389633024/2022/10/4/photo-8-1664885986580870082280.jpeg\" alt=\"Mộc Châu\" width=\"660\" height=\"394\"><figcaption>Mộc Châu - Sơn La</figcaption></figure><h4><strong>Kết luận</strong></h4><p>Không cần đi xa hay tốn quá nhiều chi phí, bạn vẫn có thể tận hưởng một kỳ nghỉ hè mát mẻ ngay gần Hà Nội. Lên kế hoạch sớm, đặt phòng trước và đừng quên mang theo máy ảnh để lưu lại những khoảnh khắc đẹp nhé!</p>', 'uploads/posts/bg du  lich m b.jpg', 'Khi Hà Nội bắt đầu bước vào mùa hè oi ả, việc tìm kiếm một nơi nghỉ ngơi mát mẻ, không quá xa thành phố là nhu cầu của nhiều người. Dưới đây là 5 điểm đến lý tưởng gần Hà Nội giúp bạn “trốn nóng” cuối tuần', 'du-lich-gan-ha-noi-diem-den-mat-me-mua-he', 'du-lich-gan-ha-noi-diem-den-mat-me-mua-he', 0, 5, '2025-04-29 07:45:30', '2025-04-29 07:45:30', NULL, 1, 16),
(14, 'Bỏ túi kinh nghiệm đi Đà Lạt tự túc từ A-Z', '<p><strong>1. Thời điểm lý tưởng để đi Đà Lạt</strong><br>Thành phố này đẹp quanh năm, nhưng nếu bạn muốn ngắm hoa dã quỳ, hãy đi vào tháng 10–11. Mùa xuân (tháng 1–3) thì có mai anh đào nở rực rỡ khắp phố. Thời tiết mát mẻ dễ chịu, rất thích hợp để đi dạo, chụp hình và tận hưởng.</p><figure class=\"image\"><img style=\"aspect-ratio:1239/733;\" src=\"https://2.bp.blogspot.com/-36Knjcu5hpM/WOMc7KiV6YI/AAAAAAAAFQU/FSlkocx2nvYgkHK-e7bOUAr22vo4E83swCLcB/s1600/17434929_1830452067278367_1887572470325016227_o.jpg\" alt=\"Đà Lạt\" width=\"1239\" height=\"733\"><figcaption>Trung tâm Đà Lạt</figcaption></figure><p><strong>2. Di chuyển như thế nào?</strong><br>Từ Hà Nội hoặc TP.HCM, bạn có thể bay thẳng đến sân bay Liên Khương. Từ đây, di chuyển vào trung tâm thành phố khoảng 30km bằng taxi hoặc xe buýt. Trong nội thành, xe máy là lựa chọn linh hoạt, giá thuê khoảng 120.000–150.000đ/ngày.</p><p><strong>3. Ở đâu khi đến Đà Lạt?</strong><br>Tùy ngân sách, bạn có thể chọn homestay xinh xắn (từ 300.000đ/đêm) hoặc khách sạn gần chợ Đà Lạt để tiện đi lại. Một số gợi ý: Dalat Note, Là Nhà Homestay, hoặc các khách sạn trên đường Bùi Thị Xuân.</p><p><strong>4. Ăn gì ở Đà Lạt?</strong><br>Đừng bỏ lỡ bánh tráng nướng, lẩu gà lá é, bún bò Huế, kem bơ, và sữa đậu nành nóng. Các khu chợ đêm hoặc hàng quán vỉa hè đều có món ngon và giá hợp lý.</p><figure class=\"image\"><img style=\"aspect-ratio:800/600;\" src=\"https://agotourist.com/wp-content/uploads/2016/08/an-vat-da-lat.jpg\" alt=\"Top 15 đồ ăn vặt đà lạt\" width=\"800\" height=\"600\"><figcaption>Đồ ăn Đà Lạt</figcaption></figure><p><strong>5. Những địa điểm không thể bỏ qua</strong></p><ul><li><strong>Đồi chè Cầu Đất</strong></li><li><strong>Thung lũng Tình Yêu</strong></li><li><strong>Nhà thờ Domaine de Marie</strong></li><li><strong>Vườn ánh sáng Lumiere</strong></li><li><strong>Check-in cà phê Mê Linh hoặc Horizon</strong></li></ul><h3><strong>Lưu ý nhỏ nhưng quan trọng</strong></h3><ul><li>Mang theo áo ấm vì ban đêm khá lạnh</li><li>Đặt phòng sớm nếu đi vào dịp lễ</li><li>Luôn kiểm tra thời tiết và lịch trình điểm đến</li></ul>', 'uploads/posts/du-lich-da-lat(1).jpg', 'Đà Lạt luôn là điểm đến lý tưởng cho những ai yêu thiên nhiên, không khí se lạnh và khung cảnh nên thơ. Nếu bạn đang lên kế hoạch đi Đà Lạt tự túc, bài viết này sẽ giúp bạn chuẩn bị kỹ càng để có chuyến đi trọn vẹn và tiết kiệm.', 'kinh-nghiem-du-lich-da-lat-di-da-lat-tu-tuc', 'kinh-nghiem-du-lich-da-lat-di-da-lat-tu-tuc', 0, 5, '2025-04-29 07:54:26', '2025-04-29 07:54:26', NULL, 1, 16);
INSERT INTO `baiviets` (`id`, `tieude`, `noidung`, `anhdaidien`, `motangan`, `seotieude`, `slug`, `luotxem`, `id_danhmuc`, `created_at`, `updated_at`, `deleted_at`, `anhien`, `id_user`) VALUES
(15, 'Du lịch Côn Đảo – Thiên đường biển và lịch sử', '<p><strong>1. Di chuyển đến Côn Đảo</strong><br>Hiện tại có hai cách chính để đến Côn Đảo:</p><ul><li><strong>Máy bay</strong>: Từ TP.HCM, Cần Thơ, Hà Nội có chuyến bay thẳng đến sân bay Cỏ Ống.</li><li><strong>Tàu cao tốc</strong>: Đi từ Vũng Tàu hoặc Sóc Trăng, thời gian từ 2,5 đến 4 giờ, giá vé khoảng 300.000–600.000đ/lượt.</li></ul><p><strong>2. Côn Đảo có gì chơi?</strong></p><ul><li><strong>Bãi Đầm Trầu</strong>: Được ví như “thiên đường Maldives của Việt Nam” với nước biển xanh ngọc và bãi cát trắng mịn.</li><li><strong>Lặn ngắm san hô</strong>: Trải nghiệm dưới lòng biển đầy sắc màu tại Hòn Bảy Cạnh hoặc Hòn Cau.</li><li><strong>Thăm di tích lịch sử</strong>: Nhà tù Côn Đảo, chuồng cọp, nghĩa trang Hàng Dương – nơi yên nghỉ của hàng ngàn anh hùng, trong đó có nữ liệt sĩ Võ Thị Sáu.</li><li><strong>Chùa Núi Một</strong>: Tọa lạc trên đồi cao, ngắm toàn cảnh thị trấn và vịnh Côn Sơn.</li></ul><p>&nbsp;</p><figure class=\"image\"><img style=\"aspect-ratio:800/541;\" src=\"https://th.bing.com/th/id/R.0b1bffbb7bd0e4b015f684ac9256afb1?rik=ACELK%2fgITIJvkg&amp;riu=http%3a%2f%2fmedia.baobinhphuoc.com.vn%2fContent%2fUploadFiles%2fEditorFiles%2fimages%2f2016%2fQuy4%2f2222.jpg&amp;ehk=LcDvCOVCDB17KF44%2fspfavs9fno0vTgBWYtz4asvIUM%3d&amp;risl=&amp;pid=ImgRaw&amp;r=0\" alt=\"Côn Đảo\" width=\"800\" height=\"541\"><figcaption>Côn Đảo</figcaption></figure><figure class=\"image\"><img style=\"aspect-ratio:1000/800;\" src=\"https://focusasiatravel.vn/wp-content/uploads/2020/10/chua-nui-mot.png\" alt=\"Côn Đảo\" width=\"1000\" height=\"800\"><figcaption>Chùa trên Côn&nbsp;</figcaption></figure><p><strong>3. Ăn gì ở Côn Đảo?</strong><br>Hải sản tươi ngon là “đặc sản” tại đây. Nên thử mắm nhum, cua mặt trăng, ốc vú nàng, cháo hàu. Quán Tri Kỷ và quán Thu Ba là hai địa chỉ được nhiều du khách yêu thích.</p><figure class=\"image\"><img style=\"aspect-ratio:2048/1536;\" src=\"https://bloganchoi.com/wp-content/uploads/2022/10/quan-an-ngon-o-con-dao-15.jpg\" alt=\"Côn Đảo\" width=\"2048\" height=\"1536\"><figcaption>Ẩm thực Côn Đảo</figcaption></figure><p><strong>4. Lưu ý khi đến Côn Đảo</strong></p><ul><li>Hạn chế sử dụng đồ nhựa, bảo vệ môi trường biển</li><li>Mang theo tiền mặt vì máy ATM còn ít</li><li>Đặt vé tàu/khách sạn trước nếu đi vào mùa cao điểm (tháng 4–9)</li></ul>', 'uploads/posts/cdao.jpg', 'Côn Đảo – cái tên từng gắn liền với lịch sử đau thương, ngày nay lại trở thành điểm đến du lịch biển hoang sơ, yên bình và đầy cuốn hút. Nếu bạn đang tìm một nơi để “sạc lại năng lượng” mà vẫn muốn chạm đến chiều sâu lịch sử, Côn Đảo là lựa chọn không thể bỏ qua.', 'du-lich-con-dao-bien-dep-viet-nam', 'du-lich-con-dao-bien-dep-viet-nam', 0, 5, '2025-04-29 08:04:26', '2025-04-29 08:04:26', NULL, 1, 16),
(16, 'Phú Yên có gì chơi? Gợi ý lịch trình 3 ngày 2 đêm cực chill', '<p><strong>Ngày 1: Đến Tuy Hòa – khám phá thành phố biển</strong></p><ul><li><strong>Sáng:</strong> Bay đến sân bay Tuy Hòa, nhận phòng khách sạn.</li><li><strong>Chiều:</strong> Tham quan <strong>Tháp Nhạn</strong> – biểu tượng văn hóa Chăm Pa, ngắm toàn cảnh thành phố từ trên cao.</li><li><strong>Tối:</strong> Dạo biển Tuy Hòa, ăn tối với các món ngon như: bò một nắng chấm muối kiến vàng, chả dông, sò huyết đầm Ô Loan.</li></ul><figure class=\"image\"><img style=\"aspect-ratio:1600/1067;\" src=\"https://3.bp.blogspot.com/-ItoDODOOFRw/V48XEjE8cmI/AAAAAAAAANs/Ht67x3L2zRQSJsazUg3D9S5oOVu6ME1PwCLcB/s1600/phu-yen.jpg\" alt=\"Phú Yên\" width=\"1600\" height=\"1067\"><figcaption>Phú Yên</figcaption></figure><p><strong>Ngày 2: Cung đường ven biển và Gành Đá Dĩa</strong></p><ul><li><strong>Sáng:</strong> Khởi hành đi <strong>Gành Đá Dĩa</strong> – kỳ quan thiên nhiên hiếm có với hàng nghìn khối đá xếp lớp như tổ ong.</li><li>Tham quan thêm <strong>Nhà thờ Mằng Lăng</strong>, <strong>Đầm Ô Loan</strong>, <strong>Bãi Xép</strong> – nơi quay phim <i>Tôi thấy hoa vàng trên cỏ xanh</i>.</li><li><strong>Chiều:</strong> Check-in <strong>Hòn Yến</strong> và <strong>Bãi Tuy Hòa</strong>, chụp ảnh siêu đẹp vào lúc hoàng hôn.</li><li><strong>Tối:</strong> Về lại trung tâm nghỉ ngơi, thưởng thức các món hải sản tươi sống tại quán bình dân ven biển.</li></ul><figure class=\"image\"><img style=\"aspect-ratio:1920/1080;\" src=\"https://static.vinwonders.com/production/dia-diem-du-lich-phu-yen-banner.jpg\" alt=\"Phú Yên\" width=\"1920\" height=\"1080\"><figcaption>Phú Yên</figcaption></figure><p><strong>Ngày 3: Ghé Vũng Rô và tạm biệt Phú Yên</strong></p><ul><li><strong>Sáng:</strong> Di chuyển đến <strong>Vịnh Vũng Rô</strong> – nơi từng là căn cứ tàu không số huyền thoại.</li><li>Tắm biển, ngắm <strong>hải đăng Mũi Điện</strong> – điểm đón bình minh đầu tiên trên đất liền Việt Nam.</li><li><strong>Trưa:</strong> Ăn nhẹ và di chuyển ra sân bay, kết thúc hành trình.</li></ul><h3><strong>Một vài lưu ý nhỏ</strong></h3><ul><li>Nên thuê xe máy hoặc ô tô riêng để tiện đi lại vì các điểm du lịch cách xa nhau.</li><li>Đặt phòng gần biển Tuy Hòa để thuận tiện ăn uống và nghỉ ngơi.</li><li>Mùa đẹp nhất: Tháng 3 đến tháng 9 – nắng đẹp, biển xanh, ít mưa.</li></ul>', 'uploads/posts/phuqye.jpg', 'Phú Yên – mảnh đất “hoa vàng trên cỏ xanh” khiến bao người say mê bởi vẻ đẹp bình dị, hoang sơ và cực kỳ thơ mộng. Nếu bạn có 3 ngày 2 đêm, đây là lịch trình gợi ý giúp bạn khám phá trọn vẹn vùng đất yên bình này.', 'du-lich-phu-yen-phu-yen-co-gi-dep', 'du-lich-phu-yen-phu-yen-co-gi-dep', 1, 5, '2025-04-29 08:36:31', '2025-05-01 02:05:30', NULL, 1, 16),
(17, 'Chinh phục Tà Xùa – Săn mây và sống ảo cực chất', '<h3><strong>Tà Xùa ở đâu, đi như thế nào?</strong></h3><p>Tà Xùa là một xã thuộc huyện Bắc Yên, tỉnh Sơn La, cách Hà Nội khoảng 200km. Bạn có thể chọn:</p><ul><li><strong>Xe máy/phượt</strong>: Xuất phát từ Hà Nội theo hướng quốc lộ 32 đến Nghĩa Lộ, rồi lên Bắc Yên. Đường đèo uốn lượn, nhiều khúc cua nhưng cảnh rất đẹp.</li><li><strong>Ô tô</strong>: Có thể đi xe khách đến Bắc Yên, sau đó thuê xe máy chạy thêm khoảng 15km để lên Tà Xùa.</li></ul><h3><strong>Thời điểm lý tưởng để săn mây</strong></h3><p>Muốn săn được biển mây đẹp nhất, bạn nên đến Tà Xùa vào khoảng tháng 11 đến tháng 3 năm sau. Khoảng 5h–7h sáng là thời gian \"vàng\" để ngắm mây cuồn cuộn dâng lên từ thung lũng, phủ kín núi đồi như bông gòn.</p><figure class=\"image\"><img style=\"aspect-ratio:1999/1333;\" src=\"https://chuyentactical.com/wp-content/uploads/2023/09/kinh-nghiem-du-lich-ta-xua-4-chuyentactical.com_.jpg\" alt=\"Tà Xùa\" width=\"1999\" height=\"1333\"><figcaption>Săn mây ở Tà Xùa</figcaption></figure><h3><strong>Các điểm check-in không thể bỏ qua</strong></h3><ul><li><strong>Sống lưng khủng long Háng Đồng</strong>: Con đường mòn nhô ra giữa hai thung lũng, rất phù hợp cho những bức ảnh để đời.</li><li><strong>Cây táo cô đơn</strong>: Giữa bạt ngàn núi rừng, một cây táo trơ trọi giữa trời, là background cực chill được giới trẻ săn đón.</li><li><strong>Mỏm đá đầu rùa</strong>: Nằm chênh vênh giữa biển mây, nơi đây tạo nên cảm giác như bạn đang đứng giữa trời.</li><li><strong>Xóm Mống Vàng</strong>: Bản làng yên bình, nơi bạn có thể cảm nhận rõ văn hóa người Mông.</li></ul><figure class=\"image\"><img style=\"aspect-ratio:1536/1024;\" src=\"https://dulichtaxua.com.vn/wp-content/uploads/2022/11/le-huynh-1-16640686508761668459475-1536x1024.jpeg\" alt=\"Tà Xùa\" width=\"1536\" height=\"1024\"><figcaption>Tà Xùa</figcaption></figure><h3><strong>Ở đâu khi đến Tà Xùa?</strong></h3><p>Có nhiều homestay đẹp, giá cả phải chăng, thiết kế mộc mạc hòa cùng thiên nhiên:</p><ul><li><strong>Tà Xùa Hills Homestay</strong></li><li><strong>Trà Mây Hostel</strong></li><li><strong>Sống Lưng Khủng Long Homestay</strong><br>Giá phòng từ 250.000–500.000đ/đêm, có phòng tập thể lẫn phòng riêng.</li></ul><h3><strong>Ăn gì ở Tà Xùa?</strong></h3><p>Ẩm thực vùng cao đậm chất bản địa: thịt trâu gác bếp, lợn bản, cơm lam, rau rừng xào tỏi, và đặc biệt là <strong>chè Shan tuyết cổ thụ</strong> – đặc sản nổi tiếng của vùng này.</p><figure class=\"image\"><img style=\"aspect-ratio:1024/708;\" src=\"https://taxua.vn/wp-content/uploads/2023/02/Thuc-don-nha-hang-a-phu-1024x708.jpg\" alt=\"Ẩm thực Tà Xùa\" width=\"1024\" height=\"708\"><figcaption>Ẩm thực Tà&nbsp;</figcaption></figure><h3><strong>Lưu ý khi đi Tà Xùa</strong></h3><ul><li>Mang theo áo ấm, đặc biệt là sáng sớm và tối vì trời lạnh.</li><li>Đường đèo dốc nên xe cộ phải kiểm tra kỹ lưỡng.</li><li>Nên đi theo nhóm để hỗ trợ nhau khi cần.</li><li>Luôn giữ ý thức bảo vệ môi trường và tôn trọng bản sắc người địa phương.</li></ul>', 'uploads/posts/taxua.jpg', 'Nếu bạn đang tìm kiếm một nơi để “trốn phố” vào cuối tuần, vừa gần gũi thiên nhiên, vừa mang lại cảm giác phiêu lưu thì Tà Xùa (Sơn La) chính là điểm đến lý tưởng. Với biển mây bồng bềnh, khung cảnh hùng vĩ và không khí trong lành, Tà Xùa đang là \"thánh địa sống ảo\" của giới trẻ mê phượt.', 'ta-xua-san-may-phuot-ta-xua', 'ta-xua-san-may-phuot-ta-xua', 1, 5, '2025-04-29 08:58:53', '2025-04-29 02:17:53', NULL, 1, 16),
(18, 'Miền Tây mùa nước nổi – Trải nghiệm không thể bỏ lỡ', '<h3><strong>Mùa nước nổi là gì?</strong></h3><p>Mùa nước nổi diễn ra khi nước từ thượng nguồn sông Mekong đổ về, làm mực nước các sông, kênh rạch dâng cao. Cánh đồng khô cằn bỗng biến thành mặt nước mênh mông, cây cối xanh mướt, cá tôm sinh sôi nảy nở. Đây chính là “mùa làm ăn” của người dân miền Tây, cũng là mùa du lịch hút khách nhất trong năm.</p><h3><strong>Du lịch miền Tây mùa nước nổi nên đi đâu?</strong></h3><p><strong>1. Đồng Tháp – Tràm Chim mùa sen nở</strong><br>Vườn quốc gia Tràm Chim là điểm đến nổi bật. Ngồi xuồng len lỏi giữa rừng tràm, ngắm chim trời, sen nở và thử giăng lưới bắt cá, bạn sẽ hiểu vì sao nơi đây được gọi là “miền Tây thu nhỏ”.</p><figure class=\"image\"><img style=\"aspect-ratio:800/481;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/image3_1745917247.png\" width=\"800\" height=\"481\" alt=\"Chợ nổi\"><figcaption>Chợ nổi ở Miền Tây</figcaption></figure><p><strong>2. An Giang – Châu Đốc và rừng tràm Trà Sư</strong><br>Rừng tràm Trà Sư mang vẻ đẹp mê hoặc khi nước tràn đầy mặt sông. Màu xanh của bèo, cây tràm và những đàn chim bay lượn khiến nơi đây trở thành điểm check-in không thể thiếu. Đừng quên ghé <strong>Châu Đốc</strong>, thưởng thức bún cá và mắm đặc sản trứ danh.</p><p><strong>3. Long An – Làng nổi Tân Lập</strong><br>Một địa điểm gần Sài Gòn, thích hợp cho chuyến đi ngắn ngày. Đi bộ trên con đường xuyên rừng tràm, ngắm mặt nước phẳng lặng và tận hưởng không gian yên bình, rất hợp để “xả stress”.</p><figure class=\"image\"><img style=\"aspect-ratio:940/600;\" src=\"https://admin.xn--hngthnhspecialfood-cze8310m.vn/storage/uploads/posts/image2_1745917271.png\" width=\"940\" height=\"600\" alt=\"Hoạt động trên sông nước\"><figcaption>Hoạt động trên sông nước của người miền Tây</figcaption></figure><h3><strong>Trải nghiệm mùa nước nổi có gì đặc biệt?</strong></h3><ul><li><strong>Đi xuồng giữa cánh đồng ngập nước</strong></li><li><strong>Ăn lẩu cá linh bông điên điển – món ngon mùa lũ</strong></li><li><strong>Thử cảm giác giăng lưới, bắt cá, kéo vó tôm như dân địa phương</strong></li><li><strong>Chụp ảnh cực chill với rừng tràm và ruộng nước bát ngát</strong></li></ul><h3><strong>Lưu ý khi đi mùa nước nổi</strong></h3><ul><li>Mặc đồ gọn nhẹ, chống muỗi, mang theo thuốc chống côn trùng</li><li>Ưu tiên đi theo nhóm, có người bản địa hướng dẫn</li><li>Chuẩn bị sẵn máy ảnh hoặc điện thoại đầy pin vì cảnh rất đẹp</li><li>Không xả rác xuống sông, bảo vệ môi trường sinh thái</li></ul><p>Miền Tây mùa nước nổi là bức tranh sống động về thiên nhiên và văn hóa bản địa. Không cần đi xa, chỉ cần vài ngày để bạn thấy mình “lạc” vào một thế giới mộc mạc, yên bình nhưng đầy cuốn hút.</p>', 'uploads/posts/du-lich-con-son-can-tho-1.jpg', 'Mỗi năm, từ khoảng tháng 9 đến tháng 11, các tỉnh miền Tây Nam Bộ bước vào mùa nước nổi – một trong những khoảng thời gian đặc biệt nhất của vùng sông nước. Đây không chỉ là thời điểm lý tưởng để khám phá vẻ đẹp thiên nhiên, mà còn là dịp để trải nghiệm lối sống dân dã, độc đáo của người miền Tây.', 'du-lich-mien-tay-mua-nuoc-noi-mien-tay', 'du-lich-mien-tay-mua-nuoc-noi-mien-tay', 4, 5, '2025-04-29 09:02:30', '2025-04-29 02:18:21', NULL, 1, 16);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bienthe`
--

CREATE TABLE `bienthe` (
  `id` int(11) NOT NULL,
  `id_sp` int(11) NOT NULL,
  `id_khoiluong` int(11) DEFAULT NULL,
  `id_nhanbanh` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `hinh` varchar(100) DEFAULT NULL,
  `soluong` int(11) NOT NULL,
  `gia` decimal(15,2) DEFAULT NULL,
  `giakm` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bienthe`
--

INSERT INTO `bienthe` (`id`, `id_sp`, `id_khoiluong`, `id_nhanbanh`, `slug`, `hinh`, `soluong`, `gia`, `giakm`, `created_at`, `updated_at`) VALUES
(3, 1, 11, 1, 'banh-pia-dau-xanh-550g', 'uploads/img-sp/WSmdVWfO1B6SvrgFkOP7GhFTzwrNNHyuFIDVpyqC.png', 5, 100000.00, NULL, '2025-04-14 20:58:01', '2025-04-14 20:58:01'),
(4, 1, 12, 1, 'banh-pia-danh-xanh-600-g', 'uploads/img-sp/xOIMSHHvJMmft7blNitnW5lh4DQvyN1oBM4Hg62Z.png', 5, 120000.00, NULL, '2025-04-14 20:58:01', '2025-04-14 20:58:01'),
(5, 2, 11, 5, 'banh-pia-sau-rieng-me-den-550-g', 'uploads/img-sp/yUgHtRgrZ5MRz7jwJ9FZ5DID52scmbMivzYzccGK.png', 10, 100000.00, NULL, '2025-04-14 21:02:34', '2025-04-14 21:02:34'),
(6, 3, 11, 4, 'banh-pia-sau-rieng-dau-do-550-g', 'uploads/img-sp/aQSEs0qLauUqPj9IzfozahGw4vBnNhKC7wFvoLCd.png', 20, 100000.00, NULL, '2025-04-14 21:08:00', '2025-04-14 21:08:00'),
(7, 4, 8, 1, 'banh-pia-2-sao-400-g', 'uploads/img-sp/Vp7VCzqwg3Bq57SpnavlGlDrAxQvrZaUpjALsTYX.png', 20, 80000.00, NULL, '2025-04-14 21:13:04', '2025-04-14 21:13:04'),
(8, 5, 8, 2, 'banh-pia-sau-rieng-2-sao-400g', 'uploads/img-sp/QJvvnweTjBA6IEojlE4tBuJR8d40D0c0SHfUbEmD.png', 10, 80000.00, NULL, '2025-04-14 21:17:24', '2025-04-14 21:17:24'),
(9, 6, 8, 3, 'banh-pia-la-dua-2-sao-400g', 'uploads/img-sp/9BO94PzFPbluOhBTKSJ8saz5eQ9vPLosg4oQ5p0O.jpg', 20, 80000.00, NULL, '2025-04-29 05:05:05', '2025-04-29 05:05:05'),
(10, 6, 7, 3, 'banh-pia-la-dua-2-sao-350g', 'uploads/img-sp/m9Vke7qhfl5UTzOyf599lxw4RKnhzfOwNrwfkSzb.png', 40, 70000.00, NULL, '2025-04-29 05:26:53', '2025-04-29 05:26:53'),
(11, 7, 6, 1, 'banh-pia-dau-xanh-1-sao-300g', 'uploads/img-sp/nZ5aV8XVSHSezyV1h4eb8XOeUEQ9cWVRdg2srlKt.jpg', 30, 60000.00, NULL, '2025-04-29 05:52:53', '2025-04-29 05:52:53'),
(12, 8, 9, 2, 'banh-pia-kim-sa-khoai-mon-450g', 'uploads/img-sp/UFz3FIZQosr6h4Ky4QIffWoDkHCoezFYJ7SZ5lAR.png', 15, 85000.00, NULL, '2025-04-29 07:44:19', '2025-04-29 07:45:23'),
(13, 8, 12, 2, 'banh-pia-kim-sa-khoai-mon-600g', 'uploads/img-sp/5isahjkYELDaqwcA2G5OZZ0KmKzqEqyc1waLGtCG.png', 10, 120000.00, NULL, '2025-04-29 07:45:23', '2025-04-29 07:45:23'),
(14, 9, 10, 4, 'banh-pia-kim-sa-dau-do-500g', 'uploads/img-sp/lc9s8ppNpMZUBtXYdmECTkT0Y5kITFZ5lUNsGtdE.png', 15, 90000.00, NULL, '2025-04-29 07:48:10', '2025-04-29 07:48:10'),
(15, 10, 10, 1, 'banh-pia-kim-sa-tra-xanh-500g', 'uploads/img-sp/mAUisr9AGJfddLMPa0zZ33D2E73HACZJw1HRsT67.png', 25, 90000.00, NULL, '2025-04-29 07:54:15', '2025-04-29 07:54:15'),
(16, 11, 11, 1, 'banh-pia-kim-sa-dau-xanh-550g', 'uploads/img-sp/Qera4Hp5kAdwcBsshdreDpiXsv89YB0ByyFcoodQ.png', 10, 110000.00, NULL, '2025-04-29 08:00:33', '2025-04-29 08:00:33'),
(17, 11, 7, 1, 'banh-pia-kim-sa-dau-xanh-350g', 'uploads/img-sp/Xop2FWLkRI96EiA8RvPc81rgNWLTEWrCwOzNzXJE.png', 30, 70000.00, NULL, '2025-04-29 08:01:52', '2025-04-29 08:01:52'),
(18, 12, 8, 3, 'banh-pia-kim-sa-la-dua-400g', 'uploads/img-sp/ffX3N2KYpUiEjEMkvWmaW85bonwbYqeVE4Y8nGmg.png', 35, 80000.00, NULL, '2025-04-29 08:25:42', '2025-04-29 08:25:42'),
(19, 12, 4, 3, 'banh-pia-kim-sa-la-dua-200g', 'uploads/img-sp/FfszR16X78GuUW7vA5zXFBnTo0yFAXykXfbadKxO.png', 50, 50000.00, NULL, '2025-04-29 08:27:53', '2025-04-29 08:27:53'),
(20, 13, 9, 5, 'banh-pia-chay-dau-den-450g', 'uploads/img-sp/AgrBQfwFW8yQ0YuDr8pFlDf6RdO747E4cjOJAi36.png', 30, 85000.00, NULL, '2025-04-30 06:14:02', '2025-04-30 06:14:02'),
(21, 14, 4, 1, 'banh-pia-chay-mini-dau-xanh-200g', 'uploads/img-sp/XJBMg6MpRZbxB6FNhoVHzyq0ACIUuZijHgfh8zY8.png', 50, 50000.00, NULL, '2025-04-30 06:23:54', '2025-04-30 06:23:54'),
(22, 14, 7, 1, 'banh-pia-chay-mini-dau-xanh-350g', 'uploads/img-sp/mOensMuSK8fmHzR9VFLKkZg894CGATv5aDaf1rMK.png', 40, 70000.00, NULL, '2025-04-30 06:23:54', '2025-04-30 06:23:54'),
(23, 15, 8, 1, 'banh-pia-chay-dau-xanh-400g', 'uploads/img-sp/3qmQsMcNOBNCQR8njYU4yT8W3PoVFL3uw7yWUif8.png', 50, 80000.00, NULL, '2025-04-30 06:28:25', '2025-04-30 06:28:25'),
(24, 15, 10, 1, 'banh-pia-chay-dau-xanh-500g', 'uploads/img-sp/yYECPu9X3BCjm92PdGI0gPojCDxBhyN6oZMuHSNV.png', 55, 90000.00, NULL, '2025-04-30 06:28:25', '2025-04-30 06:28:25'),
(25, 16, 8, 2, 'banh-pia-chay-khoai-mon-400g', 'uploads/img-sp/0MpdhziCLV08OZxx7Fghf559tFq2Sfo9wcw62CZH.png', 55, 80000.00, NULL, '2025-04-30 06:31:05', '2025-04-30 06:31:05'),
(26, 17, 6, 3, 'banh-pia-chay-la-dua-300g', 'uploads/img-sp/grrh7SOvoxpsiDmTBcWZTLKdagAMNTiwu14Wmh9p.png', 60, 65000.00, NULL, '2025-04-30 06:32:54', '2025-04-30 06:32:54'),
(27, 18, 10, 4, 'banh-pia-chay-bi-do-500g', 'uploads/img-sp/EcHnDcRyM1FffyEsYn3UpuKbwj29pbCkdEjbcZiV.png', 45, 90000.00, NULL, '2025-04-30 06:37:17', '2025-04-30 06:37:17'),
(28, 18, 4, 4, 'banh-pia-chay-bi-do-200g', 'uploads/img-sp/WA54z9f1QvTDK71ZKj7XpPRf1PejEc5wQlYcrav1.png', 69, 50000.00, NULL, '2025-04-30 06:37:17', '2025-04-30 06:57:55'),
(29, 19, 11, 3, 'banh-pia-chay-kim-sa-bap-550g', 'uploads/img-sp/3ZWvqYuaCjN5oJkuSvxlipykMygiMcQXuNrqacgJ.png', 55, 110000.00, NULL, '2025-04-30 06:39:54', '2025-04-30 06:39:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluans`
--

CREATE TABLE `binhluans` (
  `id` int(11) NOT NULL COMMENT 'ID bình luận',
  `noidung` text NOT NULL COMMENT 'Nội dung bình luận',
  `id_user` int(11) NOT NULL COMMENT 'ID theo người dùng',
  `id_bienthe` int(11) NOT NULL COMMENT 'ID theo biến thể',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'Thời gian bình luận',
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `anhien` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Ẩn hoặc hiển bình luận',
  `trangthai` enum('chờ duyệt','đã duyệt','từ chối') NOT NULL DEFAULT 'chờ duyệt' COMMENT 'Trạng thái bình luận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucs`
--

CREATE TABLE `danhmucs` (
  `id` int(11) NOT NULL,
  `tendanhmuc` varchar(100) NOT NULL,
  `mota` text DEFAULT NULL,
  `thutu` int(11) NOT NULL DEFAULT 1,
  `anhien` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmucs`
--

INSERT INTO `danhmucs` (`id`, `tendanhmuc`, `mota`, `thutu`, `anhien`, `created_at`, `updated_at`) VALUES
(1, 'Bánh Pía Sầu Riêng Trứng Muối', 'Bánh pía là sản phẩm độc đáo của Sóc Trăng. Thưởng thức vài chiếc bánh  cùng với ngụm trà gừng, buôn đôi ba câu chuyện lại thêm ấm lòng du khách. ', 1, 0, '2025-02-12 09:37:53', '2025-04-30 22:18:36'),
(2, 'Bánh Pía Kim Sa', 'Bánh Pía Kim Sa Đậu Xanh - Lá Dứa Trứng Chảy Thiên Sa là sự kết hợp của 2 loại nhân kim sa với đậu xanh và lá dứa', 2, 0, '2025-02-12 10:13:33', '2025-04-30 22:18:36'),
(3, 'Bánh In', 'Bánh in món bánh đặc sản nổi tiếng của miền Tây được dùng trong nhiều dịp lễ truyền thống của người dân nơi đây, bánh in được dùng để dâng lên Phật hay cúng trên bàn thờ tổ tiên', 4, 0, '2025-02-12 13:46:30', '2025-04-30 23:22:13'),
(4, 'Lạp xưởng', 'Lạp xưởng heo là món ăn quen thuộc và gần như không thể nào thiếu ở trong bếp của bất kì gia đình miền Tây nào.', 5, 0, '2025-02-12 13:48:27', '2025-04-30 23:20:56'),
(5, 'Bánh Pía Sầu Riêng Chay', 'Bánh Pía chay được làm từ bột mỳ với dầu thực vật tạo thành nhiều lớp vỏ mỏng, tan như hàng ngàn lớp lụa được xếp chồng lên nhau. Bên trong là nhân đậu xanh bọc sầu riêng tươi mềm mịn, ngọt bùi, thơm nức, cùng chút mứt bị sần sật tạo nên hương vị độc đáo, khó quên.', 3, 0, '2025-02-12 13:55:29', '2025-04-30 23:20:56'),
(6, 'Kẹo Đậu Phộng', 'Kẹo Đậu Phộng hay còn được gọi là Thèo Lèo trong dân gian. Là loại kẹo hầu hết các gia đình Việt yêu thích từ xưa đến nay. Với thành phần chính là làm từ mạch nha và đường trắng hòa cùng với hạt đậu phộng béo béo đã tạo nên hương vị kẹo đậu phộng thơm ngon, giòn tan.', 8, 0, '2025-02-12 13:57:53', '2025-04-30 23:20:56'),
(8, 'Kẹo Dừa', 'Bánh In Nhân Đậu Xanh Sầu Riêng được biến tấu từ loại bánh in truyền thống nhằm giúp cho người tiêu dùng có nhiều sự lựa chọn. Với hai lớp bánh in kẹp nhân đậu xanh ở giữa cùng hương thơm của sầu riêng,', 6, 0, '2025-02-16 11:02:50', '2025-04-30 23:20:56'),
(9, 'Kẹo Gạo Lức', 'Bánh in nếp than có nhân đậu xanh dứa thơm ngon cuốn hút nhằm mang đến cho khách hàng nhiều sự lựa chọn khi mua sản phẩm bánh in tại cửa hàng', 7, 0, '2025-02-16 11:02:50', '2025-04-30 23:23:03'),
(10, 'Bánh Cacao', 'Bánh in có thêm nhiều hương vị mới, tạo thêm sự lựa chọn cho quý khách. Nếu Quý khách trót mê bánh in và muốn tìm kiếm hương vị mới lạ cho món khoái khẩu của mình thì loại ca cao nhận đậu dứa sẽ là sự lựa chọn số một cho các bạn.', 9, 0, '2025-02-16 11:02:50', '2025-04-30 23:23:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc_bai_viet`
--

CREATE TABLE `danh_muc_bai_viet` (
  `id` int(11) NOT NULL COMMENT 'ID danh mục bài viết',
  `tendm` varchar(30) NOT NULL COMMENT 'Tên danh mục',
  `thutu` int(11) DEFAULT 0 COMMENT 'Thứ tự danh mục',
  `anhien` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Ẩn hoặc hiển danh mục',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc_bai_viet`
--

INSERT INTO `danh_muc_bai_viet` (`id`, `tendm`, `thutu`, `anhien`, `created_at`, `updated_at`) VALUES
(5, 'Du lịch', 1, 1, '2025-04-14 08:40:55', '2025-04-14 08:40:55'),
(6, 'Tin tức', 2, 1, '2025-04-14 08:41:08', '2025-04-14 08:41:08'),
(7, 'Ẩm thực', 3, 1, '2025-04-14 08:41:15', '2025-04-14 08:41:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhangchitiet`
--

CREATE TABLE `donhangchitiet` (
  `id` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `id_bienthe` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `gia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhangchitiet`
--

INSERT INTO `donhangchitiet` (`id`, `id_donhang`, `id_bienthe`, `soluong`, `gia`, `created_at`, `updated_at`) VALUES
(2, 3, 28, 1, 50000, '2025-04-30 06:57:55', '2025-04-30 06:57:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhangs`
--

CREATE TABLE `donhangs` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `tennguoinhan` varchar(100) NOT NULL,
  `tongtien` decimal(15,2) NOT NULL,
  `sotiengiam` decimal(15,2) DEFAULT 0.00,
  `thanhtien` decimal(15,2) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `diachi` varchar(100) NOT NULL,
  `tienvc` decimal(15,2) NOT NULL,
  `trangthai` enum('chờ xác nhận','đã xác nhận','đang giao','hoàn thành','hủy') NOT NULL DEFAULT 'chờ xác nhận',
  `id_giamgia` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `ghichu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhangs`
--

INSERT INTO `donhangs` (`id`, `id_user`, `phone`, `tennguoinhan`, `tongtien`, `sotiengiam`, `thanhtien`, `email`, `diachi`, `tienvc`, `trangthai`, `id_giamgia`, `created_at`, `updated_at`, `ghichu`) VALUES
(3, 21, 1234567890, 'bruh', 50000.00, 0.00, 65000.00, 'enix061099@gmail.com', 'Abc qTB', 15000.00, 'chờ xác nhận', NULL, '2025-04-30 06:57:55', '2025-04-30 06:57:55', 'zzz');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"6850efee-8caa-48b6-bf92-8059822ab1f7\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:36:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":7:{s:7:\\\"id_user\\\";i:14;s:10:\\\"id_bienthe\\\";s:3:\\\"109\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 109\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/109\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744368662, 1744368662),
(2, 'default', '{\"uuid\":\"835493c5-15d0-410b-9162-d2144064e031\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:35:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":7:{s:7:\\\"id_user\\\";i:14;s:10:\\\"id_bienthe\\\";s:3:\\\"109\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 109\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/109\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744368662, 1744368662),
(3, 'default', '{\"uuid\":\"15be85c7-cf8e-426e-8b55-036167f0524b\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:36:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":6:{s:10:\\\"id_bienthe\\\";s:3:\\\"108\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 108\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/108\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744368716, 1744368716),
(4, 'default', '{\"uuid\":\"5d89cb34-0d04-4d57-9f2d-b94a099feced\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:35:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":6:{s:10:\\\"id_bienthe\\\";s:3:\\\"108\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 108\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/108\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744368716, 1744368716),
(5, 'default', '{\"uuid\":\"ec9dd199-fc67-46da-8f4e-736ec3dd5800\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:36:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":6:{s:10:\\\"id_bienthe\\\";s:3:\\\"107\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 107\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/107\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744368722, 1744368722),
(6, 'default', '{\"uuid\":\"6b5fffe9-eded-45a9-819d-76ba817041e7\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:35:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":6:{s:10:\\\"id_bienthe\\\";s:3:\\\"107\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 107\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/107\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744368722, 1744368722),
(7, 'default', '{\"uuid\":\"383c71fd-3061-4488-b418-f6c028e39fba\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:36:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToDatabase\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":6:{s:10:\\\"id_bienthe\\\";s:3:\\\"100\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 100\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/100\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744369026, 1744369026),
(8, 'default', '{\"uuid\":\"2287c56e-eed3-4a92-8e6d-d8a806748f82\",\"displayName\":\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":20:{s:5:\\\"class\\\";s:35:\\\"App\\\\Listeners\\\\YeuThich\\\\AddToSession\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:32:\\\"App\\\\Events\\\\YeuThich\\\\ProductAdded\\\":6:{s:10:\\\"id_bienthe\\\";s:3:\\\"100\\\";s:5:\\\"tensp\\\";s:21:\\\"Tên sản phẩm 100\\\";s:4:\\\"hinh\\\";s:31:\\\"https:\\/\\/via.placeholder.com\\/150\\\";s:3:\\\"gia\\\";d:100;s:5:\\\"giakm\\\";d:80;s:3:\\\"url\\\";s:12:\\\"\\/product\\/100\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1744369026, 1744369026);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoiluongs`
--

CREATE TABLE `khoiluongs` (
  `id` int(11) NOT NULL,
  `khoiluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khoiluongs`
--

INSERT INTO `khoiluongs` (`id`, `khoiluong`) VALUES
(1, 50),
(2, 100),
(3, 150),
(4, 200),
(5, 250),
(6, 300),
(7, 350),
(8, 400),
(9, 450),
(10, 500),
(11, 550),
(12, 600);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_02_05_033132_create_cache_table', 1),
(2, '2025_02_05_033309_create_sessions_table', 2),
(3, '2025_02_05_035130_create_personal_access_tokens_table', 3),
(4, '0001_01_01_000002_create_jobs_table', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcaps`
--

CREATE TABLE `nhacungcaps` (
  `id` int(11) NOT NULL,
  `tennhacungcap` varchar(100) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `anhien` tinyint(4) NOT NULL DEFAULT 0,
  `thutu` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcaps`
--

INSERT INTO `nhacungcaps` (`id`, `tennhacungcap`, `img`, `anhien`, `thutu`, `created_at`, `updated_at`) VALUES
(1, 'Công Lập Thành', NULL, 1, 1, '2025-02-12 09:34:14', '2025-03-26 22:59:25'),
(2, 'Tân Huê Viên', NULL, 1, 2, '2025-02-12 09:36:18', '2025-03-26 22:57:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanbanhs`
--

CREATE TABLE `nhanbanhs` (
  `id` int(11) NOT NULL,
  `tenNhanBanh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanbanhs`
--

INSERT INTO `nhanbanhs` (`id`, `tenNhanBanh`) VALUES
(1, 'Đậu xanh'),
(2, 'Khoai môn'),
(3, 'Lá dứa'),
(4, 'Đậu đỏ'),
(5, 'Mè đen');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `otps`
--

CREATE TABLE `otps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `otp_code` int(11) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(5, 'App\\Models\\User', 1, 'auth_token', 'a4b88ce9fb2a634cdd112be4e2ccc62ad5d4753dc0abded9dfa5f97f90c707ab', '[\"*\"]', NULL, NULL, '2025-02-23 01:51:22', '2025-02-23 01:51:22'),
(13, 'App\\Models\\User', 1, 'auth_token', 'ae5ff82900af449fe765024c169a7abd8495fb1f734d480ffe97c13356444932', '[\"*\"]', NULL, NULL, '2025-02-26 00:28:05', '2025-02-26 00:28:05'),
(14, 'App\\Models\\User', 1, 'auth_token', 'fe818b9dfc65d40d1006cb39e64e91737f25d898f60e1645a0c4604110870387', '[\"*\"]', NULL, NULL, '2025-02-26 00:28:29', '2025-02-26 00:28:29'),
(15, 'App\\Models\\User', 1, 'auth_token', '3688b6d238aff19ef2d3b45314ac236099dca08707dc26016e07cd2063ee6cc1', '[\"*\"]', NULL, NULL, '2025-02-26 00:43:31', '2025-02-26 00:43:31'),
(16, 'App\\Models\\User', 1, 'auth_token', '9e27bcf2b35b03abee5eea36b1a3589c74d69b84c224e3bb3757f62dc67a1ba7', '[\"*\"]', '2025-02-26 01:36:37', NULL, '2025-02-26 00:45:39', '2025-02-26 01:36:37'),
(17, 'App\\Models\\User', 1, 'auth_token', '4ef084d222079553132665ae2f8c9ea88dc1bc45f49e9f9c168da2625143509e', '[\"*\"]', '2025-02-26 02:40:09', NULL, '2025-02-26 01:55:58', '2025-02-26 02:40:09'),
(18, 'App\\Models\\User', 2, 'auth_token', '255dc28de0eb5454c54222a374fedcbdd8ca73ae00c99b273878676c7d012699', '[\"*\"]', NULL, NULL, '2025-02-27 09:40:01', '2025-02-27 09:40:01'),
(19, 'App\\Models\\User', 3, 'auth_token', '214b5f4c89705f2c42c652e2b99123b87118b40696dfe6535d86bd68250d04e2', '[\"*\"]', NULL, NULL, '2025-02-27 21:08:01', '2025-02-27 21:08:01'),
(20, 'App\\Models\\User', 3, 'auth_token', 'a2742c47bf006b7bc33af3b357b875680054e1d1877e9db5ece0951aa4bef90a', '[\"*\"]', NULL, NULL, '2025-02-27 21:08:54', '2025-02-27 21:08:54'),
(21, 'App\\Models\\User', 4, 'auth_token', '5b356370ba90d2c659edafb1796ab2623684765d8a3dcf24ea90580ecad238c5', '[\"*\"]', NULL, NULL, '2025-02-27 22:11:07', '2025-02-27 22:11:07'),
(22, 'App\\Models\\User', 4, 'auth_token', '99069c30d873fd53e3ef30ce1957d9624fd870329087871e36204bf1b1bed8b0', '[\"*\"]', NULL, NULL, '2025-02-27 22:11:50', '2025-02-27 22:11:50'),
(23, 'App\\Models\\User', 5, 'auth_token', 'b487a5bc391ab0715c87d1cdf987d821d480eca740fb7d3929937eb664a06ae1', '[\"*\"]', NULL, NULL, '2025-03-02 02:38:45', '2025-03-02 02:38:45'),
(25, 'App\\Models\\User', 6, 'auth_token', '66ec0b8e1922cc9e253502d17df45587b451a419184a7e66575eb830548fba65', '[\"*\"]', NULL, NULL, '2025-03-09 20:05:21', '2025-03-09 20:05:21'),
(37, 'App\\Models\\User', 7, 'auth_token', '108db6df0df7e04f3b6eac922dba82304376eeb6d832e53de5ff7d8f90df00d9', '[\"*\"]', NULL, NULL, '2025-03-14 23:10:22', '2025-03-14 23:10:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieugiamgia`
--

CREATE TABLE `phieugiamgia` (
  `id` int(11) NOT NULL,
  `magiamgia` varchar(50) NOT NULL,
  `thoidiembatdau` datetime NOT NULL DEFAULT current_timestamp(),
  `thoidiemketthuc` datetime NOT NULL DEFAULT current_timestamp(),
  `hesogiamgia` decimal(15,2) NOT NULL,
  `sotientoithieu` decimal(15,2) NOT NULL,
  `trangthai` tinyint(4) NOT NULL DEFAULT 0,
  `mota` text DEFAULT NULL,
  `soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieugiamgia`
--

INSERT INTO `phieugiamgia` (`id`, `magiamgia`, `thoidiembatdau`, `thoidiemketthuc`, `hesogiamgia`, `sotientoithieu`, `trangthai`, `mota`, `soluong`) VALUES
(3, '30T420PT', '2025-04-14 16:32:00', '2025-05-26 00:00:00', 20.00, 500000.00, 0, NULL, 3),
(4, '30T410PT', '2025-04-14 16:32:00', '2025-05-14 00:00:00', 10.00, 100000.00, 0, NULL, 3),
(5, '30T430PT', '2025-04-14 16:35:00', '2025-05-14 00:00:00', 30.00, 500000.00, 0, NULL, 4),
(6, '30T415PT', '2025-04-14 15:39:00', '2025-05-19 00:00:00', 15.00, 80000.00, 0, NULL, 4),
(7, '30T425PT', '2025-04-15 00:00:00', '2025-05-14 00:00:00', 25.00, 400000.00, 0, NULL, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanphams`
--

CREATE TABLE `sanphams` (
  `id` int(11) NOT NULL,
  `id_danhmuc` int(11) NOT NULL,
  `id_nhacungcap` int(11) NOT NULL,
  `tensp` varchar(150) NOT NULL,
  `mota` text DEFAULT NULL,
  `luotxem` bigint(20) DEFAULT 0,
  `anhien` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Xóa mềm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanphams`
--

INSERT INTO `sanphams` (`id`, `id_danhmuc`, `id_nhacungcap`, `tensp`, `mota`, `luotxem`, `anhien`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'Bánh Pía Sầu Riêng Trứng Muối Nhân Đậu Xanh 4 sao', 'Bánh pía 2 trứng đậu xanh sầu riêng Tân Huê Viên với thành phần chính đậu xanh sầu riêng và 2 trứng vịt muối kết hợp cùng nhau tạo nên hương vị bánh truyền thống đậm đà của Sóc Trăng', 0, 1, '2025-04-14 13:47:05', '2025-04-14 20:58:01', NULL),
(2, 1, 1, 'Bánh Pía Sầu Riêng Trứng Muối Mè Đen', 'Hạt mè đen có chứa khoảng 50- 60% dầu, 25% chất đạm, ngoài ra còn có đồng, canxi oxalat, axit béo omega3 và 6 rất có lợi cho tim mạch và sức khoẻ.\r\nVới mong muốn mang đến những loại bánh ngon những hương vị độc đáo và mới lạ giúp quý khách hàng có nhiều chọn lựa hơn khi thưởng thức bánh Tân Huê Viên đã nghiên cứu và cho ra đời món Bánh pía mè đen trứng muối\r\nBánh pía mè đen trứng muối với thành phần chính là : đậu đen, bột mì, dầu olein, sầu riêng , mứt bí, mạch nha và lòng đỏ trứng vịt muối', 0, 1, '2025-04-14 21:02:34', '2025-04-29 08:02:25', NULL),
(3, 1, 1, 'Bánh pía sầu riêng trứng đậu đỏ', 'Với mong muốn mang đến những loại bánh ngon những hương vị độc đáo và mới lạ giúp quý khách hàng có nhiều chọn lựa hơn khi thưởng thức bánh Tân Huê Viên đã nghiên cứu và cho ra đời món Bánh pía đậu đỏ trứng muối\r\nBánh pía đậu đỏ trứng muối với thành phần chính là : đậu đỏ, bột mì, dầu olein, sầu riêng , mứt bí, mạch nha và lòng đỏ trứng vịt muối', 0, 1, '2025-04-14 21:08:00', '2025-04-29 08:02:36', NULL),
(4, 1, 2, 'Bánh pía sầu riêng đậu xanh 2 sao', 'Đặc sản Sóc Trăng “Bánh pía đậu sầu riêng 2 sao Tân Huê Viên” với bao vì sang trọng đựng trong từng gói bánh riêng biệt là món quà biếu đậm chất Nam bộ dành tặng người thân, bạn bè và gia đình.\r\n\r\nBánh với thành phần được làm từ đậu xanh nguyên chất kết hợp trứng muối và sầu riêng tạo nên một hương vị độc đáo nhất mà không loại bánh nào có được.\r\n\r\nBánh Pía Tân Huê Viên 2 Sao có 2 loại: Bánh pía đậu xanh sầu riêng và bánh pía khoai môn sầu riêng\r\n\r\nHạn dùng: 75 ngày đối với bánh đậu xanh và 30 ngày đối với bánh môn', 0, 1, '2025-04-14 21:13:04', '2025-04-14 21:13:04', NULL),
(5, 1, 2, 'Bánh pía sầu riêng môn 2 sao', 'Đặc sản Sóc Trăng “Bánh pía môn sầu riêng 2 sao” với bao vì sang trọng đựng trong từng gói bánh riêng biệt là món quà biếu đậm chất Nam bộ dành tặng người thân, bạn bè và gia đình.\r\nBánh với thành phần được làm từ khoai môn nguyên chất kết hợp trứng muối và sầu riêng tạo nên một hương vị độc đáo nhất mà không loại bánh nào có được.\r\nBánh pía môn sầu riêng 2 sao có hạn sử dụng 30 ngày, ngắn hơn so với bánh pía đậu xanh sầu riêng.\r\nBánh Pía Tân Huê Viên 2 Sao có 2 loại : Bánh pía đậu xanh sầu riêng và bánh pía khoai môn sầu riêng.', 0, 1, '2025-04-14 21:17:24', '2025-04-14 21:17:24', NULL),
(6, 1, 2, 'Bánh Pía Sầu Riêng Lá Dứa 2 sao', 'Bánh pía lá dứa trứng muối với thành phần chính là : đậu xanh, lá dứa, bột mì, dầu oliu, sầu riêng , mứt bí, mạch nha và lòng đỏ trứng vịt muối', 0, 1, '2025-04-29 05:05:05', '2025-04-29 05:05:05', NULL),
(7, 1, 2, 'Bánh Pía Sầu Riêng Đậu Xanh 1 sao', 'Bánh với thành phần được làm từ đậu xanh nguyên chất kết hợp trứng muối và sầu riêng tạo nên một hương vị độc đáo nhất', 0, 1, '2025-04-29 05:52:53', '2025-04-29 05:52:53', NULL),
(8, 2, 2, 'Bánh pía kim sa khoai môn trứng', 'Bánh Pía Kim Sa Môn Trứng Tan Chảy là sản phẩm đặc biệt của thương hiệu Tân Huê Viên, nổi bật với nhân môn thơm béo và lớp kim sa trứng muối tan chảy đầy lôi cuốn. Đây không chỉ là món bánh ngon mà còn là lựa chọn tuyệt vời cho những ai yêu thích ẩm thực Sóc Trăng với sự kết hợp hiện đại và truyền thống.', 0, 1, '2025-04-29 07:44:19', '2025-04-29 07:44:19', NULL),
(9, 2, 2, 'Bánh pía kim sa đậu đỏ mini', 'Bánh pía kim sa đậu đỏ là một trong những dòng sản phẩm Bánh Kim Sa tan chảy với thành phần bánh chủ yếu được làm từ đậu đỏ tươi kết hợp cùng trứng muối và sữa mang đến hương vị mới lạ cho người dùng.', 0, 1, '2025-04-29 07:48:10', '2025-04-29 07:48:10', NULL),
(10, 2, 2, 'Bánh pía kim sa trà xanh', 'Bánh pía kim sa trà xanh được làm từ trà xanh matcha tạo nên hương vị thanh mát và giúp tăng cường hệ miễn dịch, chống lão hóa da, thanh lọc và giải độc cơ thể rất tốt nhận thất những tác dụng quá tuyệt vời từ trà xanh mang đến. Tân Huê Viên đã không ngừng nghiên cứu phát triển và đưa trà xanh vào trong sản xuất bánh pía', 0, 1, '2025-04-29 07:54:15', '2025-04-29 07:54:15', NULL),
(11, 2, 1, 'Bánh pía kim sa đậu xanh Mini', 'Bánh Pía Kim Sa là đặc sản bánh pía nổi tiếng với thành phần chính của bánh được làm từ đậu xanh, bột mì, lòng đỏ trứng, sữa, đường tinh luyện , có thêm mè đen hoặc lá dứa, khiến cho việc cảm nhận nhân bánh như tan chảy ra như “Cát Vàng” nên bánh có tên gọi là Bánh Pía Kim Sa.', 0, 1, '2025-04-29 08:00:33', '2025-04-29 08:00:33', NULL),
(12, 2, 1, 'Bánh pía kim sa lá dứa', 'Bánh vẫn giữ nguyên vỏ bánh truyền thống kết hợp với nhân đậu xanh pha với hương thơm thanh mát từ lá dứa cộng thêm phần nhân kim sa làm từ trứng muối tan chảy.', 0, 1, '2025-04-29 08:25:42', '2025-04-29 08:25:42', NULL),
(13, 5, 2, 'Bánh pía chay Đậu đen Sầu Riêng', 'Để tăng thêm sự lựa chọn cho khách hàng Tân Huê Viên cho ra mắt thêm bánh Pía chay đậu đen loại bánh nhỏ, với vị bùi bùi của đậu đen, vị ngọt đến từ sầu riêng tươi được chọn lựa kỹ lưỡng, vẫn là sự mềm thơm đặc trưng khi cầm chiếc bánh trên tay.', 0, 1, '2025-04-30 06:14:02', '2025-04-30 06:14:02', NULL),
(14, 5, 2, 'Bánh pía chay Đậu Xanh Mini', 'Bánh Pía chay sầu riêng mini là đặc sản bánh pía nổi tiếng của Sóc Trăng với thành phần chính của bánh được làm từ đậu xanh, sầu riêng, bột mì, sữa, đường tinh luyện .', 0, 1, '2025-04-30 06:23:54', '2025-04-30 06:23:54', NULL),
(15, 5, 2, 'Bánh pía chay Đậu Xanh Sầu Riêng', 'Bánh pía chay đậu xanh sầu riêng là dòng sản phẩm bánh pía không trứng lớn nhất của Tân Huê Viên, thích hợp ăn chay túi gồm 4 bánh với bao bì riêng biệt từng bánh.', 0, 1, '2025-04-30 06:28:25', '2025-04-30 06:28:25', NULL),
(16, 5, 2, 'Bánh pía chay Khoai Môn Sầu Riêng', 'Bánh pía chay môn sầu riêng không trứng muối bao gồm 4 bánh với bao bì riêng biệt từng bánh, Bánh Pía Môn sầu riêng vẫn mang nét đặc trưng của Bánh Pía Tân Huê Viên từ vỏ da đến nhân bánh, nhưng nguyên liệu sử dụng và phương pháp chế biến để bánh có thể ăn chay được và không phá đi nét đặc trưng của bánh Pía.', 0, 1, '2025-04-30 06:31:05', '2025-04-30 06:31:05', NULL),
(17, 5, 2, 'Bánh pía chay Dứa Sầu Riêng', 'Đặc sản Sóc Trăng “Bánh pía chay dứa sầu riêng” với bao vì sang trọng đựng trong từng gói bánh riêng biệt là món quà biếu đậm chất nam bộ dành tặng người thân, bạn bè và gia đình', 0, 1, '2025-04-30 06:32:54', '2025-04-30 06:32:54', NULL),
(18, 5, 1, 'Bánh pía chay Kim Sa Bí Đỏ', 'Bánh Pía Kim Sa bí đỏ tan chảy là một trong những sản phẩm bánh kim sa mới nhất với nhân bánh tan chảy được làm hoàn toàn bằng bí đỏ (không phải trứng muối) nên rất thích hợp làm quà biếu tặng khi mua qua các nước (Mỹ, Úc, Canada)', 0, 1, '2025-04-30 06:37:17', '2025-04-30 06:37:17', NULL),
(19, 5, 1, 'Bánh pía chay Kim Sa Bắp', 'Bánh pía kim sa bắp túi 500g là một trong những dòng sản phẩm Bánh Kim Sa tan chảy với thành phần bánh chủ yếu được làm từ  đậu xanh, bắp ngô mang đến hương vị mới lạ cho người dùng bánh.', 0, 1, '2025-04-30 06:39:54', '2025-04-30 06:39:54', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('03xrtzbP7iZekwIBO9MTLNZJ0Eu7XOdoP44jpb4A', NULL, '172.178.141.132', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicFh1bDdjaDBqYWRMQjNCUjRzMjE4WlBPNGtsOXZ4TmNIWVd1V0RZcSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1746084026),
('4mo9ipO3clYCP0eoYjjJZDLh1Z9niXMFc6UousnY', NULL, '172.178.141.134', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVpzQlhZZFpFR1BBOThDZUJjaWJXMmZwZjRFTHN0Ykx5bUpYN3M4dSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2NzoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3NhbnBoYW0/ZGFuaG11YyU1QjAlNUQ9OSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746084026),
('AKYSbuFSfIX4iXyORRHhTSenGjTNvP5E94Ma88wv', NULL, '172.178.141.136', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia1dYQk5aclN3a09xNDBLckJDWkNmSHFFSFF6Z2NSQTVvdTF2aWh1SyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MToiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3JlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1746084026),
('brcoMBfA3oN990YJo3CSTo8vHoP0uc1XOslV1nr7', NULL, '172.178.141.136', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjI2TFJtcEFqUHRIc010RkZsVndFRWswenFTQ3FocE1hZXRYb2x6aSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1746084027),
('F8SImtXRmFQP8SxqN489jpAoutjvYQZmdaxw7YSd', NULL, '172.178.141.136', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRW5NYzBGMk83dWtYV0NxdDFmdE5GNVRUeTRPUXpCZHNMYnZhWDRjRiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MjoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3NhbnBoYW0vOSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746084026),
('k3OQ3UAmrDSkvF4qUkHGodls9wfufysieymrgDqc', NULL, '103.199.56.163', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_4_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/135.0.7049.83 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiclJUMTgzdzFJVnpEV0NiWFRxVnU2VklTQVk4ZlpHc1lFaUtYam1GVSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2NzoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3NhbnBoYW0vMTI/aWRfYmllbnRoZT0xOCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746080365),
('mUdkzhJG11SNoVmpCVTbbviRWPcORJgxRMwAHy0p', NULL, '66.249.73.128', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.7049.95 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXh4am5jSzdzRThXVU1zRno3bWR0dG85QlJmcHhoUVB1bjlxRVBLbyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MzoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3NhbnBoYW0vMTYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1746085238),
('oZaMeKpB8wIEmRlQqJqe194phl94iEG6Y7Ciu5o0', NULL, '207.46.13.111', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ2t0aVFnblZCaHpudXlXTzBJNU5tR0UzVFNZWGZHYjdtTVRBbHlmRSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1OToiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3Byb2ZpbGVGYXZvcml0ZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1746081073),
('PfAbrnOvazLBF9EZQf2WFjMA74Ef7k7ITqgF71BU', NULL, '171.226.215.247', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidGZXTnk4VjlDOGJTTlJUVUFJMDg3bkw4UlJST05mNG9QOXMwTXZsaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NDoiaHR0cHM6Ly9hZG1pbi54bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL2xvZ2luIjt9fQ==', 1746083977),
('pN5MEWSz50Q175BQeVIzglrkgVg1hbLMCeZ9mMah', NULL, '172.178.141.132', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTNaSXpNZnk1OWdFYlpqWEhydENRVWxDeFU3VTNoZFpPY2R1enJQSCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2NjoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3NhbnBoYW0vOD9pZF9iaWVudGhlPTEyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1746084026),
('qZdiZPVxAnv5jYURTyabESQFzL49UqtF1jG9fKio', NULL, '14.241.250.132', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUdaMEdnblpnZkcyS0gzSDlCMUFKU3JsdTlQUVM3bms3bDlBbjFHcyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MDoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuL3NhbnBoYW0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1746090341),
('tzIoYKJqLHaJsQZUM7FrYsTtNJbzX3xTgB8hBJ7u', NULL, '172.178.141.135', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2g3ZnUwTkx2VkJGUHdHc0hFOVZiMG03Q25TUDUyUmUxSTQ2dUxLSCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cHM6Ly94bi0taG5ndGhuaHNwZWNpYWxmb29kLWN6ZTgzMTBtLnZuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1746084026);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `id` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `phuongthucthanhtoan` enum('chuyenkhoan_nganhang','paypal','cod') NOT NULL,
  `magiaodich` varchar(100) NOT NULL,
  `sotienthanhtoan` decimal(15,2) NOT NULL,
  `trangthai` enum('chưa thanh toán','đã thanh toán') NOT NULL DEFAULT 'chưa thanh toán',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `sodienthoai` int(11) DEFAULT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `hoten` varchar(255) DEFAULT NULL,
  `quyen` tinyint(4) NOT NULL DEFAULT 0,
  `hinh` varchar(100) DEFAULT NULL,
  `gioitinh` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_logout` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `google_id`, `email`, `sodienthoai`, `diachi`, `password`, `hoten`, `quyen`, `hinh`, `gioitinh`, `created_at`, `updated_at`, `email_verified_at`, `deleted_at`, `last_login`, `last_logout`) VALUES
(7, NULL, 'admin@gmail.com', NULL, '113/12 quận gò vấp', '$2y$12$HtgqNoy1EBawvA0Wd8nC8ufhxVoP9r3FQ6f1FYBhYEAFDvQhVKNAy', 'nguyễn đỗ thanh tâm', 1, '1743133563_z4603134298901_5c955d94b90092b9cdec1c3a4287c63e.jpg', 1, '2025-03-10 03:41:21', '2025-04-30 12:33:00', NULL, NULL, '2025-04-30 12:33:00', '2025-04-29 09:18:25'),
(16, NULL, 'tokhoi1312@gmail.com', 325568596, 'FPT quận 12', '$2y$12$ukKztjhYhIzjHAxxX89GvuzKUQ/5zcTtyNL7WtInXG5Z/9zqBkyiS', 'Khôi', 1, NULL, 0, '2025-04-14 05:49:01', '2025-04-29 07:26:22', NULL, NULL, '2025-04-29 07:26:22', '2025-04-15 04:34:03'),
(17, NULL, 'adminnp@gmail.com', 123456789, 'Abc qTB', '$2y$12$gDVGcfMWOBPadmoMIL2LU.GGUdnFf7f7JlQbPmUU2.V4O5qQvSsHW', 'NP', 1, NULL, 0, '2025-04-14 13:13:06', '2025-04-30 15:07:44', NULL, NULL, '2025-04-30 15:07:44', '2025-04-14 18:32:54'),
(18, NULL, 'test@gmail.com', 123456789, 'Abc qTB', '$2y$12$JkqbA1gsN841DtdHnwcK0.PAFLkd20lzMg1IVYHvJOIyp.YGQj1JC', 'test', 1, 'uploads/img-user/XoZQj60G3ll8JepmrEmAom6h4zNVmjaTuRIDvlSb.jpg', 0, '2025-04-14 14:10:45', '2025-04-14 14:13:48', NULL, NULL, '2025-04-14 14:11:01', NULL),
(19, NULL, 'tominhkhoi1312@gmail.com', NULL, NULL, '$2y$12$y1jS/rS/iHaVIuEUmWBz/OJNYmJNDpTa8zPQlX9Hi/stPAmRASaBK', 'Tô Khôi', 0, NULL, 0, '2025-04-23 09:30:48', '2025-04-23 09:30:48', NULL, NULL, NULL, NULL),
(20, NULL, 'thanhtamdevbe@gmail.com', 325568596, '113/12 đường 59 quận gò vấp', '$2y$12$0n4LCCkVJ1nVnApW.C1MNegauYqYnzve3B8cJWTZNPLT7/lSFHiC2', 'Tâm', 0, NULL, 1, '2025-04-23 09:38:44', '2025-04-25 08:31:28', NULL, NULL, '2025-04-25 08:31:28', NULL),
(21, NULL, 'enix061099@gmail.com', NULL, NULL, '$2y$12$TF.79QAc.E1WCDg9KldRR.aJMK78pIPTvjIi8DQIgHyyWEhef7vAi', 'bruh', 0, NULL, 0, '2025-04-27 01:41:59', '2025-04-27 01:41:59', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeu_thich`
--

CREATE TABLE `yeu_thich` (
  `id` int(11) NOT NULL COMMENT 'ID yêu thích',
  `id_bienthe` int(11) NOT NULL COMMENT 'ID theo biến thể',
  `id_user` int(11) NOT NULL COMMENT 'ID theo người dùng',
  `thutu` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'Thời gian yêu thích',
  `updated_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `yeu_thich`
--

INSERT INTO `yeu_thich` (`id`, `id_bienthe`, `id_user`, `thutu`, `created_at`, `updated_at`) VALUES
(8, 8, 19, 1, '2025-04-24 03:24:19', '2025-04-24 03:24:19');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baiviets`
--
ALTER TABLE `baiviets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `baiviet_slug` (`slug`),
  ADD KEY `fk_baiviet_danhmuc` (`id_danhmuc`),
  ADD KEY `fk_baiviet_user` (`id_user`);

--
-- Chỉ mục cho bảng `bienthe`
--
ALTER TABLE `bienthe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bt_slug` (`slug`),
  ADD KEY `id_sp` (`id_sp`),
  ADD KEY `fk_khoiluong` (`id_khoiluong`),
  ADD KEY `fk_nhanbanh` (`id_nhanbanh`);

--
-- Chỉ mục cho bảng `binhluans`
--
ALTER TABLE `binhluans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_binhluan_user` (`id_user`),
  ADD KEY `fk_binhluan_bienthe` (`id_bienthe`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `danhmucs`
--
ALTER TABLE `danhmucs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danh_muc_bai_viet`
--
ALTER TABLE `danh_muc_bai_viet`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `donhangchitiet`
--
ALTER TABLE `donhangchitiet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_donhang` (`id_donhang`),
  ADD KEY `id_bienthe` (`id_bienthe`);

--
-- Chỉ mục cho bảng `donhangs`
--
ALTER TABLE `donhangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_giamgia` (`id_giamgia`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khoiluongs`
--
ALTER TABLE `khoiluongs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nhacungcaps`
--
ALTER TABLE `nhacungcaps`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nhanbanhs`
--
ALTER TABLE `nhanbanhs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `phieugiamgia`
--
ALTER TABLE `phieugiamgia`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sanphams`
--
ALTER TABLE `sanphams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nhacungcap` (`id_nhacungcap`),
  ADD KEY `fk_sanphams_danhmucs` (`id_danhmuc`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_donhang` (`id_donhang`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `yeu_thich`
--
ALTER TABLE `yeu_thich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_yeu_thich_user` (`id_user`),
  ADD KEY `fk_yeu_thich_bienthe` (`id_bienthe`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baiviets`
--
ALTER TABLE `baiviets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID bài viết', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `bienthe`
--
ALTER TABLE `bienthe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `binhluans`
--
ALTER TABLE `binhluans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID bình luận';

--
-- AUTO_INCREMENT cho bảng `danhmucs`
--
ALTER TABLE `danhmucs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `danh_muc_bai_viet`
--
ALTER TABLE `danh_muc_bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID danh mục bài viết', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `donhangchitiet`
--
ALTER TABLE `donhangchitiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `donhangs`
--
ALTER TABLE `donhangs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `khoiluongs`
--
ALTER TABLE `khoiluongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nhacungcaps`
--
ALTER TABLE `nhacungcaps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nhanbanhs`
--
ALTER TABLE `nhanbanhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `phieugiamgia`
--
ALTER TABLE `phieugiamgia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `sanphams`
--
ALTER TABLE `sanphams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `yeu_thich`
--
ALTER TABLE `yeu_thich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID yêu thích', AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baiviets`
--
ALTER TABLE `baiviets`
  ADD CONSTRAINT `fk_baiviet_danhmuc` FOREIGN KEY (`id_danhmuc`) REFERENCES `danh_muc_bai_viet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_baiviet_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `bienthe`
--
ALTER TABLE `bienthe`
  ADD CONSTRAINT `fk_khoiluong` FOREIGN KEY (`id_khoiluong`) REFERENCES `khoiluongs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_nhanbanh` FOREIGN KEY (`id_nhanbanh`) REFERENCES `nhanbanhs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `id_sp` FOREIGN KEY (`id_sp`) REFERENCES `sanphams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `binhluans`
--
ALTER TABLE `binhluans`
  ADD CONSTRAINT `fk_binhluan_bienthe` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_binhluan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhangchitiet`
--
ALTER TABLE `donhangchitiet`
  ADD CONSTRAINT `id_bienthe` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_donhang` FOREIGN KEY (`id_donhang`) REFERENCES `donhangs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhangs`
--
ALTER TABLE `donhangs`
  ADD CONSTRAINT `id_giamgia` FOREIGN KEY (`id_giamgia`) REFERENCES `phieugiamgia` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanphams`
--
ALTER TABLE `sanphams`
  ADD CONSTRAINT `fk_sanphams_danhmucs` FOREIGN KEY (`id_danhmuc`) REFERENCES `danhmucs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_nhacungcap` FOREIGN KEY (`id_nhacungcap`) REFERENCES `nhacungcaps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `fk_donhang` FOREIGN KEY (`id_donhang`) REFERENCES `donhangs` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `yeu_thich`
--
ALTER TABLE `yeu_thich`
  ADD CONSTRAINT `fk_yeu_thich_bienthe` FOREIGN KEY (`id_bienthe`) REFERENCES `bienthe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yeu_thich_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
