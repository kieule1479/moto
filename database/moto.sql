-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 02, 2021 at 11:30 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Moto`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `motos` text NOT NULL,
  `prices` text NOT NULL,
  `quantities` text NOT NULL,
  `names` text NOT NULL,
  `pictures` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `motos`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`) VALUES
('1DN5Z74', 'kieule1', '[\"57\"]', '[\"330000000\"]', '[\"1\"]', '[\"Yamaha 2018 XSR700\"]', '[\"w86ar4yx.jpg\"]', 1, '2021-03-01 09:03:53'),
('4iXsYcQ', 'kieule1', '[\"57\",\"58\"]', '[\"330000000\",\"500000000\"]', '[\"1\",\"1\"]', '[\"Yamaha 2018 XSR700\",\"Yamaha 2018 MT-10\"]', '[\"w86ar4yx.jpg\",\"zt3ni76w.jpg\"]', 0, '2021-03-01 10:11:09'),
('ZnlafCU', 'kieule1', '[\"55\"]', '[\"336600000\"]', '[\"1\"]', '[\"Yamaha MT-09 2018\"]', '[\"mritzanj.jpg\"]', 0, '2021-03-01 10:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` text DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `ordering` int(11) DEFAULT 10,
  `special` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `special`) VALUES
(1, 'Hyper Naked ', 'o0a85b1c.jpg', '2021-01-28 13:57:16', 'kieule1', '2021-02-27 17:53:35', 'kieule1', '1', 4, 0),
(2, 'Supersport', 'u1x48qot.jpg', '2021-01-28 14:01:25', 'kieule1', '2021-02-27 17:53:08', 'kieule1', '1', 1, 1),
(3, 'Sport Heritage', '6rgsoe9x.jpg', '2021-01-28 14:08:17', 'kieule1', '2021-02-27 17:52:52', 'kieule1', '1', 2, 1),
(4, 'Touring', 'ax78ikwn.jpg', '2021-01-28 14:10:11', 'kieule1', '2021-02-27 17:52:40', 'kieule1', '1', 3, 1),
(5, 'Yamaha YFZ', 'bnwaie50.jpg', '2021-01-28 14:11:59', 'kieule1', '2021-02-28 10:30:02', 'kieule1', '1', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_acp` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `ordering` int(11) DEFAULT 10,
  `privilege_id` text DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `privilege_id`, `picture`) VALUES
(1, 'Founder', 1, '2020-12-30 14:46:11', 'kieule', '2021-01-25 15:43:33', 'kieule1', '1\r\n', 3, NULL, NULL),
(2, 'Manager', 1, '2020-12-30 14:46:11', 'kieule1', '2021-01-27 02:34:39', 'kieule1', '1', 2, NULL, NULL),
(3, 'Admin', 1, '2020-12-30 14:46:11', 'kieul2', '2021-01-29 23:10:44', 'kieule1', '1', 1, NULL, NULL),
(4, 'Member 1', 0, '2020-12-30 17:45:10', 'member', '2021-02-05 00:58:15', 'kieule1', '0', 6, NULL, NULL),
(118, 'Member 2', 0, '2021-01-27 02:35:40', 'kieule1', '2021-02-05 00:31:15', 'kieule1', '1', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `moto`
--

CREATE TABLE `moto` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `special` tinyint(1) DEFAULT 0,
  `sale_off` int(3) DEFAULT 0,
  `picture` text DEFAULT NULL,
  `gallery` text DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT '0',
  `ordering` int(11) DEFAULT 10,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moto`
--

INSERT INTO `moto` (`id`, `name`, `description`, `short_description`, `price`, `special`, `sale_off`, `picture`, `gallery`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `category_id`) VALUES
(55, 'Yamaha MT-09 2018', 'Chiếc xe đạp theo phong cách cầu kỳ khỏa thân\r\nVới vẻ bề ngoài của nó, thân xe tinh xảo và đặc điểm kỹ thuật cao hơn, dĩa phía trước có thể điều chỉnh được cũng như hệ thống Quick Shift (QSS) và bộ phận hỗ trợ và dép (A & S) có nghĩa là bạn có thể chạy nhanh hơn và nhanh hơn Hệ thống điều khiển lực kéo (TCS) có thể chuyển đổi cho bạn khả năng đưa Hyper Naked 3 xi-lanh này lên một cấp độ khác.', 'Chiếc xe máy đã thay đổi mọi thứ đã phát triển thành một Hyper Naked thậm chí còn sắc nét hơn và công nghệ cao hơn', '340000000', 1, 1, 'mritzanj.jpg', '', '2021-01-28 14:59:06', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 1),
(56, 'Yamaha V-Ixion', 'Yamaha V-Ixion 2017 được trang bị động cơ xy-lanh đơn, làm mát bằng dung dịch, dung tích 150 cc. Kết hợp với hộp số 6 cấp, động cơ tạo ra công suất tối đa 16,3 mã lực tại vòng tua máy 8.5000 vòng/phút và mô-men xoắn cực đại 14,5 Nm tại vòng tua máy 7.500 vòng/phút.\r\n\r\nYamaha V-Ixion 2017 còn được trang bị bộ khung Deltabox, bình xăng 12 lít, phuộc ống lồng phía trước và gắp đơn đằng sau. Vành của Yamaha V-Ixion 2017 có đường kính 17 inch, đi kèm lốp không săm với kích thước 90/80-17M trước và 120/70-17M sau. Lực hãm của xe bắt nguồn từ phanh đĩa trên cả 2 bánh.\r\n\r\nYamaha V-Ixion 2017 có chiều dài tổng thể 1.955 mm, rộng 720 mm, cao 1.025 mm, chiều dài cơ sở 1.295 mm và chiều cao gầm 165 mm. Yên của Yamaha V-Ixion 2017 cao 795 mm. Trọng lượng tổng cộng của xe là 132 kg.', 'Yamaha V-Ixion 2017 được trang bị động cơ xy-lanh đơn, làm mát bằng dung dịch, dung tích 150 cc.', '60000000', 1, 0, 'eqh561s2.jpg', '', '2021-01-28 15:58:35', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 1),
(57, 'Yamaha 2018 XSR700', 'Yamaha XSR700  có kiểu dáng độc đáo kết hợp công nghệ đẳng cấp thế giới của Yamaha với phong cách vượt thời gian, tạo ra một loại máy mới cho người đi xe máy tìm kiếm một chiếc xe máy đích thực và trung thực mà không hy sinh hiệu năng. Vẽ ảnh hưởng từ dòng xe máy XS cổ điển của Yamaha, lớp XSR oozes, với chi tiết bằng nhôm lộ liễu, kiểu dáng xe hơi bị ảnh hưởng bởi retro, ghế ngồi và đèn chiếu sáng tùy chỉnh.\r\n\r\nĐộng cơ 2 xy-lanh cao cấp Crossplane cung cấp một nhân vật năng lượng duy nhất, với mô-men xoắn và phản ứng cánh quạt, kết hợp với sức kéo mạnh mẽ. Nó cũng có tính năng \"Crossplane Concept\" của Yamaha 270 độ cung cấp mô-men xoắn tuyến tính để đáp ứng với đầu vào cần điều khiển của người lái.', 'Yamaha XSR700  có kiểu dáng độc đáo kết hợp công nghệ đẳng cấp thế giới của Yamaha với phong cách vượt thời gian', '330000000', 1, 0, 'w86ar4yx.jpg', '', '2021-01-28 16:00:27', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 1),
(58, 'Yamaha 2018 MT-10', 'Động cơ 4 xy-lanh có công suất 998cc có công nghệ Crossplane Crankshaft tương tự được phát triển bởi siêu xe YZF-R1  superbike nổi tiếng của Yamaha. Được thiết kế đặc biệt cho MT-10 , động cơ này phát triển mô men xoắn cực ngắn và trung vị với công suất đầu cuối kéo căng cánh tay.\r\n\r\nCác MT-10 tính năng YCC-T-một hệ thống ga-đi-by-wire cung cấp điều khiển động cơ đặc biệt và D-Mode, cho phép người lái lựa chọn một động cơ ưa thích đáp ứng tại flick của một chuyển đổi. MT-10 cũng bao gồm kiểm soát hành trình để nâng cao tiện nghi bay đường cao tốc.\r\n\r\nHệ thống điều khiển traction điều chỉnh Hệ thống điều khiển traction tiên tiến giúp người lái kiểm soát lực kéo trên các điều kiện đường bằng cách điều chỉnh nhanh tốc độ mở ga, thời gian đánh lửa, lượng nhiên liệu và các thông số khác.', 'Yamaha 2018 MT-10 với thiết kế đầy sức sống và các yếu tố độc đáo - bao gồm mặt nạ mặt trước gọn gàng và thùng nhiên liệu tự động, MT-10 nổi bật lên như là vua của dòng MT.', '500000000', 1, 0, 'zt3ni76w.jpg', '', '2021-01-28 16:02:07', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 1),
(59, 'Yamaha 2018 MT-07', 'Yamaha MT-07 được trang bị một xi lanh thẳng hàng gọn nhẹ 689cc, động cơ DOHC nhẹ, mỏng và ly kỳ. Động cơ concept trục khuỷu 270 độ này cung cấp một nhân vật năng lượng duy nhất, kết hợp mô-men xoắn cực ngắn và tầm xa với sức kéo mạnh mẽ ở tốc độ cao.\r\n\r\nCác MT-07 có phong cách tinh tế mới để phù hợp với phần còn lại của gia đình MT, trong đó có một đèn pha mới góc cạnh, muỗng lượng tích cực hơn, một nắp bình xăng kiểu dáng đẹp, và một thiết kế đuôi lớp mới gồm có một đèn LED nhỏ gọn hơn đèn sau xe.', 'Yamaha MT-07 được trang bị một xi lanh thẳng hàng gọn nhẹ 689cc, động cơ DOHC nhẹ, mỏng và ly kỳ', '300000000', 0, 0, '3t6oki2h.jpg', '', '2021-01-28 16:03:29', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 1),
(60, 'Yamaha-R15-V3-2018', 'Ngoài ra, R15 được trang bị bộ ly hợp Assist & Slipper Clutch, một trong những dặc điểm vốn chỉ được sử dụng cho những dòng xe phân khối lớn. Bộ ly hợp A & S (hỗ trợ và trượt) được sử dụng để giảm trọng lượng kéo ly hợp và giảm chuyển đổi áp suất thấp trong quá trình giảm tốc độ. Trọng lượng kéo ly hợp giảm 18% so với YZF-R15 hiện tại, giúp giảm sự mỏi mệt cho người lái. Điều này cũng ngăn cản quá trình giảm tốc động cơ, do đó làm giảm tác động của lực trên khung xe. Bộ ly hợp A & S tạo ra sự thay đổi mượt mà, dễ chịu cho người lái.', 'Yamaha R15 sở hữu động cơ làm mát bằng dung dịch 155cc SOHC, 4 thì, truyền động 6 số, công suất 19,3 mã lực. Không những phù hợp chinh phục đường trường, R15 còn dễ dàng di chuyển trên đường đô thị đông đúc.', '82000000', 0, 1, 'yg1tu49p.jpg', '', '2021-01-28 22:35:09', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(61, 'Yamaha R15 v3 2018', 'Ngoài những đặc điểm nổi trội kể trên, R15 còn được trang bị van biến thiên VVA (Variable Valve Actuation) với mục tiêu tăng công suất động cơ, giúp xe luôn chạy mượt mà ở mọi dải tốc độ. Nguyên lý hoạt động của nó như sau :  Trục cam trên xe R15 được thiết kế với 03 vấu cam , 02 vấu cam nạp và 01 vấu cam xả .Trong hai vấu cam nạp thì có một vấu cam thấp và một vấu cam cao. Khi tốc độ động cơ thấp dưới 7400 vòng / phút VVA chưa hoạt động, xupap nạp đóng mở theo sự điều khiển của vấu cam thấp. Khi tốc độ động cơ đạt từ 7400 vòng /phút do sự điều khiển của ECU, van biến thiên VVA sẽ đóng lại lúc này hai cò nạp được liên kết lại với nhau bằng chốt định vị và như vậy xupap nạp được điều khiển đóng mở theo gối cam cao dẫn tới khoảng mở của xupap nạp lớn hơn tăng thêm hiệu quả nạp nhiên liệu vào động cơ thích hợp khi chúng ta chạy ở khoảng tốc độ cao .', 'Yamaha R15 sở hữu động cơ làm mát bằng dung dịch 155cc SOHC, 4 thì, truyền động 6 số, công suất 19,3 mã lực. Không những phù hợp chinh phục đường trường', '82000000', 0, 0, '8g20vq13.jpg', '', '2021-01-28 22:36:59', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(62, 'Yamaha 2018 YZF-R1', 'Động cơ Cross -Edge cắt cạnh\r\nĐộng cơ crankshaft có kích thước 4 xy lanh 998cc nội tuyến, có các thanh kết nối gãy xương bằng titan, đây là ngành công nghiệp đầu tiên cho một chiếc xe máy sản xuất. Các hợp kim titan được sử dụng để sản xuất các thanh kết nối là khoảng 60% nhẹ hơn thép, và giảm trọng lượng này mang lại cho động cơ R1 một nhân vật đáp ứng và mạnh tại rpm cao. Động cơ tuyệt đẹp này mang lại công suất cực kỳ cao và một mô men xoắn tuyến tính mạnh.', 'YZF-R1 rất giống với người anh em theo dõi YZR-M1. Với dòng máu MotoGP thuần túy, động cơ crossplane, khung gầm cơ sở ngắn và các thiết bị điện tử công nghệ cao, YZF-R1 đã sẵn sàng đưa trải nghiệm cưỡi của bạn lên một tầm cao mới.', '520000000', 0, 2, '5ezd0m76.jpg', '', '2021-01-28 22:38:56', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(63, 'Yamaha R25 ABS', 'Yamaha R25 ABS không có gì thay đổi so với phiên bản thường. Xe tiếp tục sử dụng động cơ 2 xi-lanh, 4 kỳ, DOHC, làm mát bằng chất lỏng, phun nhiên liệu điện tử, dung tích 250 cc, sản sinh công suất 36 mã lực tại 12.000 vòng/phút và mô-men xoắn cực đại 22,1 Nm tại 10.000 vòng/phút. Sức mạnh được truyền tới bánh thông qua hộp số 6 cấp.\r\n\r\nSo với phiên bản thường, Yamaha R25 ABS 2016 nặng hơn 2 kg. Ngoài ra, Yamaha R25 ABS 2016 cũng đắt hơn đáng kể so với phiên bản thường.', 'Yamaha R25 ABS không có gì thay đổi so với phiên bản thường. Xe tiếp tục sử dụng động cơ 2 xi-lanh, 4 kỳ, DOHC, làm mát bằng chất lỏng, phun nhiên liệu điện tử, dung tích 250 cc, sản sinh công suất 36 mã lực tại 12.000 vòng/phút và mô-men xoắn cực đại 22,1 Nm tại 10.000 vòng/phút. Sức mạnh được truyền tới bánh thông qua hộp số 6 cấp.', '128000000', 0, 0, '8fi1xzp5.jpg', '', '2021-01-28 22:40:24', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(64, 'Yamaha R25', 'Ở phiên bản mới, xe Yamaha R25 có trọng lượng 166 kg với chiều cao yên ở mức 780 mm và bình xăng dung tích 14,3 lít. Ngoài ra, xe được trang bị bộ mâm kích kiểu dáng thể thao kích thước 17 inch với 2 màu đen và xanh. Cả hai bánh trước/sau đều được trang bị hệ thống phanh đĩa. Yamaha R25 vẫn sở hữu khối động cơ giống như phiên bản trước đó với dung tích 249 phân khối, 2 xy-lanh song song, làm mát bằng dung dịch, sản sinh công suất 35,5 mã lực tại 12.000 v/p và mô-men xoắn cực đại 22,6 Nm ở mức 10.000 v/p, kết hợp với hộp số 6 cấp. Yamaha R25 được trang bị hệ thống an toàn với phanh đĩa đơn, ngàm phanh piston đôi cho bánh trước trong khi bánh sau piston đơn. Yamaha R25 sẽ cạnh tranh với hai đối thủ nặng ký là Kawasaki Ninja 250 và KTM RC 250.', 'Yamaha R25 vẫn có thiết kế tương tự nhiên các phiên bản tiền nhiệm trước đó với kiểu dáng thể thao, với nhiều đường nét góc và được thiết kế theo cảm hứng từ phiên bản YZR-M1. Xe có kích thước dài 2.090 mm, rộng 720 mm, cao 1.135 mm, cùng chiều dài cơ sở 1.380 mm và khoảng sáng gầm 160 mm.', '132000000', 0, 1, 'inmbjga8.jpg', '', '2021-01-28 22:41:42', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(65, 'Yamaha R25 Movistar', 'Ngoài bộ tem lấy cảm hứng từ mẫu xe đua M1 2015, bản đặc biệt của chiếc sport bike vẫn giữ nguyên các tính năng và động cơ như phiên bản tiêu chuẩn. Xe có kích thước tổng thể 2.090 x 720 x 1.135 mm, trục cơ sở 1.380 mm, khoảng sáng gầm xe 160 mm và chiều cao yên xe 780 mm.\r\n\r\nTrái tim của R25 là khối động cơ 4 thì, 250 phân khối, xi-lanh đôi, DOHC, làm mát bằng dung dịch, sản sinh công suất 36 mã lực tại 12.000 vòng/phút và mô-men xoắn cực đại 22,1 Nm tại 10.000 vòng/phút.', 'Yamaha R25 Movistar phiên bản đặc biệt có thân xe và cặp vành màu xanh dương, chữ M cách điệu màu xanh lá cùng loạt tem đấu khác.', '135000000', 0, 2, 'gfkybmdv.jpg', '', '2021-01-28 22:42:50', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(66, 'Yamaha 2018 YZF-R1M', 'Bộ khuếch đại điện tử hàng đầu YZF-R1M có tính năng tiên tiến nhất được cung cấp trên một máy siêu âm, với một bộ đầy đủ các công nghệ liên quan đến nhau cho phép rider để tận hưởng đầy đủ nhất của hiệu suất với sự thoải mái hơn, kiểm soát và dễ dàng hoạt động hơn bao giờ hết.\r\n\r\nYamaha YZF-R1M  có tính năng một Öhlins  điện tử Đình chỉ Racing (ERS), thân xe sợi cacbon và một đơn vị truyền thông kiểm soát (CCU) với GPS cho phép người lái xe để nắm bắt dữ liệu đi xe và sau đó tải nó qua WiFi cho điện thoại thông minh và ứng dụng máy tính bảng Yamaha Y-TRAC. Khi dữ liệu được tải xuống, người lái có thể phân tích trực tiếp qua bản đồ theo dõi GPS. Thiết lập các thay đổi sau đó có thể được thực hiện thông qua ứng dụng Cài đặt YRC và tải lại cho R1M.', '\r\nYamaha YZF-R1M có trục khuỷu chéo ngang nhẹ và nhỏ gọn, động cơ có công suất lên đến 998cc, động cơ 4 xi lanh nội tuyến thẳng hàng. Với các thanh kết nối chia tách gãy titan, khối xilanh bù đắp và vỏ magiê, động cơ mang lại công suất cực đại cao và mô men xoắn cực mạnh cho hiệu suất vượt trội, tất cả được bao bọc trong thân xe MotoGP khí động học', '890000000', 0, 0, 'wu9oebyh.jpg', '', '2021-01-28 22:44:00', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(67, 'Yamaha 2018 YZF-R1S', 'Bộ khuếch đại điện tử hàng đầu YZF-R1S có một gói thiết bị điện tử lấy cảm hứng từ MotoGP tiên tiến: một bộ các công nghệ liên quan đến nhau, được trang bị bộ cảm biến quán tính sáu trục của Yamaha, cho phép người lái có thể tận hưởng tối đa hiệu suất với sự thoải mái, kiểm soát và dễ dàng hoạt động.\r\n\r\nHệ thống Thông tin: IMU bao gồm một cảm biến con quay hồi chuyển đo độ cao, cuộn và ngắt, cũng như một máy gia tốc, hoặc cảm biến G, giúp tăng tốc ở phía trước, phía trên, và bên trái phải ... tất cả tại tỷ lệ 125 phép tính trên giây. Bằng cách tính toán từng tín hiệu, IMU tìm thấy vị trí chính xác và chuyển động của xe, và truyền cho ECU, cho phép nó điều khiển các hệ thống của xe.', 'Yamaha YZF-R1S với động cơ phản lực MotoGP tiên tiến được trang bị trục khuỷu ngang và trục phản lực nhỏ gọn, động cơ 4 xi lanh thẳng hàng, công suất 998cc, tạo ra sức mạnh tuyệt vời và mô men xoắn cực mạnh cho hiệu suất tuyệt vời.', '530000000', 0, 1, 'q7mkd2ei.jpg', '', '2021-01-28 22:44:55', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(68, 'Yamaha 2018 YZF-R6', 'Yamaha YZF-R6 được trang bị động cơ 4 xi lanh nhỏ gọn và nhẹ 5HCC DOHC làm mát bằng chất lỏng với công nghệ sản xuất mới nhất. Mười lăm van titan, tỷ lệ nén cao 13,1: 1 và lưỡi côn tay nhẹ cho phép cho sức mạnh mượt. Động cơ Magnesium giảm thiểu trọng lượng của động cơ. Với động cơ bốn xi lanh cao cấp, hệ thống kiểm soát lực kéo và chế độ D cho phép người lái có thể thu được nhiều hiệu quả hơn từ động cơ mạnh mẽ.\r\n\r\nYZF-R6 sử dụng các bộ phận tương tự được tìm thấy trên R1, bao gồm các rôto phía trước 320mm, được cọ xát bằng bốn-pít-tông gắn trên và được kích hoạt bởi một ống xylanh bơm Nissin. Kết quả là sức mạnh tuyệt vời với sự kiểm soát chính xác. Hệ thống phanh phía sau hỗ trợ hệ thống phanh phía trước, và ABS là tiêu chuẩn cho việc tăng cường phanh trên các mặt đường không hoàn hảo.', 'Yamaha YZF-R6 là một trong những máy siêu xe tiên tiến nhất được chế tạo. Thiết kế MotoGP khí động học kết hợp với một chiếc máy đua vô cùng thông minh, kết hợp với hệ thống phanh ABS, hệ thống treo trên cùng và một bộ dụng cụ trợ lý điện tử đầy đủ.', '470000000', 0, 1, 'wb9tmchr.jpg', '', '2021-01-28 22:47:03', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(69, 'Yamaha 2017 FZ6R', 'Động cơ bốn xi lanh 4 xi lanh 4 xi lanh được làm mát bằng chất lỏng đã được làm mát bằng chất lỏng 600cc đã sẵn sàng đáp ứng với tính năng vận hành mượt mà khi người lái vặn vít. Sản lượng tối đa đạt được ở tốc độ 10.000 vòng / phút và mômen xoắn cực đại đạt được ở 8.500 rpm. Động cơ 4 xi lanh mượt mà động cơ cung cấp năng lượng trơn tru như cách mà người lái xe ngày nay cần nó, cung cấp tăng tốc nhanh với nhiều mô men xoắn khiến cho việc đi lại của thành phố trở nên thoải mái, với nhiều dự trữ cho thời gian bạn muốn nhiều hơn. FZ6R được bơm nhiên liệu và điều chỉnh cho hiệu suất động cơ thấp đến giữa rpm.', 'Yamaha FZ6R là sự kết hợp tuyệt vời giữa phong cách thể thao và tính năng vận hành, FZ6R có chiều cao ghế ngồi thấp, có thể điều chỉnh được để phù hợp với nhiều tay đua hơn và cũng hẹp hơn ở nơi nó được tính để làm cho cả hai chân dễ dàng hơn mặt đất.', '300000000', 0, 2, 'sagn754b.jpg', '', '2021-01-28 22:47:59', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(70, 'Yamaha 2018 YZF-R3', 'Yamaha supersport lấy cảm hứng từ một khung gầm phù hợp với những người đi xe máy hay những tay đua giàu kinh nghiệm, những người thích loại máy nhẹ, linh hoạt hơn. Và có ba lựa chọn màu sắc đẹp có sẵn, điều này có nghĩa là có một sự lựa chọn màu phù hợp với bạn.\r\n\r\nYamaha YZF-R3  có thiết kế động cơ tiên tiến, nhịp điệu rèn - giống như R1 và R6 - rất nhẹ và mang lại sức mạnh vượt trội. Và các tính năng cải tiến của Yamaha như các xi lanh bù đắp giảm ma sát để có thêm sức mạnh.\r\n\r\nVới một thiết kế chỗ ngồi phẳng và chiều cao ghế chỉ 30,7 inch trên YZF-R3, rất dễ dàng để có được cả hai chân vững trên mặt đất và truyền cảm hứng cho sự tự tin, đặc biệt là cho người mới bắt đầu.', 'Yamaha YZF-R3 với động cơ đôi xi lanh mạnh mẽ, twin-cylinder 321cc lớn mang lại hiệu năng tuyệt vời cho dù có điều hướng đường giao thông giữa các thành phố, va đập vào twisties hay trên đường đua.', '190000000', 0, 0, 'hwogdvpu.jpg', '', '2021-01-28 22:48:52', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 2),
(71, 'V Star 250 2020', 'Yên Yamaha V Star 250 2020 thấp sẽ cho phép hầu hết mọi người ngồi trên chiếc xe moto nhỏ có trọng lượng 130 kgs với hai chân được đặt thẳng trên mặt đất, và đây là một trong những cách tốt nhất để giúp người mới bắt đầu tập chạy moto cảm thấy thoải mái nhất.  Ghi đông nằm trong tầm tay người lái dễ dàng vì chiếc mô tô cruiser nhỏ gọn có thanh kéo hẹp và điều khiển vị trí đặt chân ở phía trước thoải mái. Đáng ngạc nhiên Yamaha V Star 250 2020 có động cơ V twin đẹp và lực kéo không quá tồi.', 'Yamaha V Star 250 2020 chiếc xe moto mới được chào đón của rất nhiều Biker trên thế giới bởi xe thiết kế có tính thân thiện với người, một khái niệm đơn giản mà Yamaha đã tìm ra cách đây 30 năm và đã không bỏ qua với Yamaha V Star 250 2020. Những người mới lái sẽ ngay lập tức cảm thấy thoải mái khi họ bỏ chân đất rất dễdàng do trọng tâm yên khá thấp.', '203000000', 0, 1, 'q2cz1gtl.jpg', '', '2021-01-28 22:57:00', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 3),
(72, 'Yamaha 2018 V Star 250', 'Động cơ V-twin Potent, máy làm mát, 249cc, 60 độ động cơ V-twin với một cơn đột quỵ 66mm dài tạo ra nhiều mô-men xoắn từ dưới cuối và quyền lực roll-on trơn tru. Và đó cũng là động cơ V-twin duy nhất trong phân khúc của nó.', 'Yamaha V Star 250 có kích thước nhỏ gọn, trọng lượng nhẹ và một chỗ ngồi chỉ 27 inch. V Star 250 phù hợp cho những tay đua mới chơi xe trong phan khúc dưới 300cc.Phanh mạnh, phanh đĩa phía trước cung cấp công suất dừng kiểm soát cao.', '167000000', 0, 0, 'i9sxuo32.jpg', '', '2021-01-28 22:58:07', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 3),
(73, 'Yamaha SR400', 'Kiểu dáng đơn giản và đẹp mắt đã loại bỏ những thứ bổ sung.\r\nNgoài ra, cảm giác nhịp tim độc đáo duy nhất cho đĩa đơn lớn.\r\nKể từ khi ra đời vào năm 1978.\r\nĐó là hương vị của \"đích thực\" chỉ là những người đã được lặp đi lặp lại nhiều lần và sâu sắc trong một thời gian dài.\r\nVà bây giờ. Một SR bình thường và vui tươi, được thêm vào.\r\nTank đồ họa được xử lý với một logo 400 với 1978 motif năm sinh.\r\n\"Vintage Active Casual\" là một khái niệm.', 'Retro, mặc dù vẫn còn mới.\r\nKiểu dáng đơn giản và đẹp mắt đã loại bỏ những thứ bổ sung.\r\nNgoài ra, cảm giác nhịp tim độc đáo duy nhất cho đĩa đơn lớn.', '120000000', 0, 1, '7tjfa60k.png', '', '2021-01-28 22:59:58', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 3),
(74, 'Yamaha STAR VENTURE', 'Được đặt trên buồng lái để tăng cường khả năng hiển thị, màn hình LCD 7-inch đầy đủ màu sắc hiển thị thông tin và kiểm soát khổng lồ ở đầu ngón tay của người lái. Được điều khiển qua màn hình cảm ứng, điều khiển thanh hoặc điều khiển bằng giọng nói, gói thông tin giải trí này mang lại cho người lái xe quyền truy cập vào điều khiển và dữ liệu của xe, một loạt các nguồn âm thanh và các tùy chọn truyền thông không dây Bluetooth®. Bộ nhớ fairing khóa bao gồm cổng sạc và cổng giao tiếp USB để giữ cho thiết bị đứng vững.\r\n\r\nBằng cách tích hợp hệ thống xe vào bảng điều khiển thông tin giải trí, các dữ liệu chạy như các chức năng máy tính chuyến đi và áp suất lốp xe có thể dễ dàng xác nhận trên màn hình, trong khi các yếu tố như chỗ ngồi được sưởi ấm có thể được kiểm soát bởi người lái.', 'Yamaha SA=TAR VENTURE với động cơ mô-men xoắn cực mạnh với thiết bị trợ lực cho người lái tiên tiến Với động cơ V-twin làm mát bằng mô-men xoắn 1854cc, Star Venture® tạo ra sức mạnh vượt trội ngay cả khi nạp đầy. Và với điều khiển giảm tốc bằng tay, điều khiển lực kéo và các chế độ cưỡi được lựa chọn, Star Venture mang đến công nghệ hàng đầu cho lớp lưu động hạng sang.', '680000000', 0, 0, 'm7dyw3e8.jpg', '', '2021-01-28 23:02:57', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 4),
(75, 'Yamaha STAR ELUDER', 'Với loa kết hợp gắn kết và một hệ thống giải trí thông tin liên lạc, cảm ứng và điều khiển bằng giọng nói lớn, cao, Star Eluder đưa ra lệnh cho người điều khiển. Âm nhạc, chuyển hướng, truyền thông và các hệ thống xe được tích hợp hoàn toàn vào một hệ thống duy nhất mà đặt ra các tiêu chuẩn mới cho công nghệ hai bánh.\r\n\r\nStar Eluder được phát triển cẩn thận Star Eluder được thiết kế để đáp ứng nhu cầu của người lái và hành khách ngay từ sàn đại lý, với vị trí của người lái rông và điều khiển được điều chỉnh. Ghế ngồi sưởi ấm cho cả người lái và hành khách đều đạt tiêu chuẩn, với chiều cao ghế ngồi thấp cho sự tự tin ở mọi điểm dừng.', 'Yamaha STAR ELUDER với động cơ mô-men xoắn cực mạnh với thiết bị trợ lực tay cắt cạnh Với động cơ V-twin 1854cc làm mát bằng mô-men xoắn, Star Eluder® tạo ra điện năng truyền tải mượt mà và dễ dàng ngay cả khi nạp đầy.', '690000000', 0, 1, 'mh3y1pts.jpg', '', '2021-01-28 23:03:58', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 4),
(76, 'Yamaha 2018 FJR1300ES', 'Hệ thống Chiếu sáng trực tiếp FJR1300ES sử dụng hệ thống chiếu sáng LED tiên tiến của Yamaha tiên tiến cho phép người lái nhìn xuyên qua các góc để chiếu sáng không ngờ và tăng tầm nhìn ánh sáng yếu. FJR1300ES là chiếc xe máy Yamaha đầu tiên sử dụng công nghệ này.\r\n\r\nMột loạt các tính năng làm cho FJR1300ES đi du lịch lý tưởng bao gồm cả điều chỉnh kính chắn gió một nút ấn điều chỉnh, chỗ ngồi sang trọng được thiết kế cho người lái và người ngối sau, tích hợp hành lý cứng và một thùng nhiên liệu lớn 6,6 gallon.', 'Yamaha FJR1300ES có động cơ 1298cc, DOHC, 16 van, động cơ bốn xi lanh làm mát bằng chất lỏng cung cấp công suất và momen xoắn tuyệt vời cho tăng tốc cơ không hề có trên phạm vi RPM.', '594000000', 0, 0, 'm9zpajb1.jpg', '', '2021-01-28 23:05:05', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 4),
(77, 'Yamaha 2018 FJR1300A', 'Sử dụng hệ thống đèn pha LED và thiết kế đèn đuôi đuôi LED, FJR1300A có kiểu dáng thân động, thân thiện với supersport với quản lý luồng không khí tích hợp giúp người lái thoải mái khi điều kiện thời tiết thay đổi.\r\n\r\nMột loạt các tính năng làm cho FJR1300A lý tưởng đồng hành du lịch, bao gồm cả điều chỉnh thái, kính chắn gió một nút ấn điều chỉnh, một chỗ ngồi sang trọng được thiết kế cho người lái và người ngồi sau, tích hợp hành lý cứng và một thùng nhiên liệu lớn 6,6 gallon.', 'Yamaha FJR1300A có một động cơ bốn xi lanh nội tuyến làm mát bằng chất lỏng 1298cc, 16 van, động cơ 4 xi lanh nhỏ gọn cung cấp công suất và momen xoắn tuyệt vời cho tăng tốc cơ không hề có trên phạm vi RPM.', '532000000', 0, 1, 'ymsfoj3a.jpg', '', '2021-01-28 23:06:18', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 4),
(78, 'Yamaha 2017 FJ-09', 'Yamaha Chip Controlled Throttle (YCC-T) là hệ thống giảm áp bằng điện của Yamaha, được bắt nguồn từ công nghệ MotoGP®. YCC-T hoạt động đồng thời với Hệ thống kiểm soát lực kéo (TCS) được cập nhật nhằm mang đến cho người lái đáp ứng cảm giác bướm ga với sự an toàn của việc kiểm soát lực kéo đối với những con đường có sức kéo kém hơn.\r\n\r\nHiệu suất tiện nghi bao gồm một kính chắn gió có thể điều chỉnh chiều cao, fairing bên, vị trí cưỡi điều chỉnh, ổ cắm điện 12V và bồn chứa nhiên liệu 4,8 gallon hào phóng. FJ-09 ™ lý tưởng cho việc đi lại hàng ngày, đi chơi ngắn, hoặc đi nghỉ cuối tuần.\r\n\r\n', 'Yamaha FJ-09 với công suất 3 xi lanh động cơ 847cc làm mát bằng chất lỏng, động cơ DOHC, 12 van từ dòng 3 xy-lanh, có nguồn gốc từ chiếc FZ-09 ™. Động cơ này kết hợp các thành phần công nghệ cao, bao gồm YCC-T® và Yamaha D-Mode, với một trục khuỷu chéo ngang để mang lại một đặc tính động cơ thú vị, nhanh và nhanh.', '312000000', 0, 0, 'ajbofl3w.jpg', '', '2021-01-28 23:07:24', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 4),
(79, 'Yamaha Fazer 25', 'Fazer 25 mới đã được thiết kế ghế phân chia rộng hơn với vật liệu bao phủ chống trượt và một lượng lớn đệm. Vì vậy, cả người lái và người ngồi sau cùng lúc đều được hưởng một chuyến đi dài. Phần trước của ghế ngồi có một chỗ phình nhỏ để mang lại cảm giác thoải mái ngay cả khi tăng tốc và giảm tốc. Ngoài ra, điểm ngồi trên ghế ngồi gấp đôi cao hơn 12 cm so với tay đua để cung cấp khả năng hiển thị tốt cho người lái. Fazer25 cũng được trang bị hệ thống đèn LED.', 'Yamaha Fazer 25 với động cơ 4 thì, xi lanh đơn SOHC, động cơ phun nhiên liệu 249cc tạo ra mô men xoắn cực đại 20 Nm và sức mạnh 20,9 PS. Tinh chỉnh và tối ưu hóa cho đường cao tốc, nó giữ cho bạn bình tĩnh, yên tâm trong khi bạn đang chạy với tốc độ cao.', '960000000', 0, 1, 'myvl9pt3.jpg', '', '2021-01-28 23:09:23', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 5),
(80, 'Yamaha Byson FI', 'Về tem xe, Yamaha Byson FI có logo sọ bò tót cách điệu ở bình xăng. Logo này không chỉ giải nghĩa tên xe mà còn thể hiện đặc tính cơ bản của xe là mạnh mẽ và cơ bắp.\r\n\r\nCó thể nói Byson FI hay FZ Ver2.0 là bản nâng cấp toàn diện so với Byson hay FZ-16. Ngoài những nâng cấp rõ rệt về thiết kế và ngoại hình. Byson FI/FZ Ver 2.0 còn được trang bị công nghệ động cơ mới với hệ thống phun xăng điện tử. Động cơ mới hoạt động mạnh mẽ hơn nhưng có mức tiêu thụ nhiên liệu thấp hơn. Trên bảng đồng hồ của xe cũng có đồng hồ báo mức tiết kiệm nhiên liệu.', 'Yamaha Byson FI mang triết lý thiết kế mới, giúp làm nên một chiếc xe có vẻ ngoài sắc sảo, cơ bắp và mạnh mẽ.', '58000000', 0, 3, 'ydtp38q4.jpg', '', '2021-01-28 23:10:29', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 10, 5),
(81, 'Yamaha MT-25', '<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"360\" src=\"https://www.youtube.com/embed/diErNOChcj4\" width=\"640\"></iframe></p>\r\n\r\n<p>Những trang bị nổi bật kh&aacute;c của Yamaha MT-25 2017 bao gồm đ&egrave;n pha LED đi k&egrave;m k&iacute;nh chắn gi&oacute; nhỏ, phuộc ống lồng 41 mm ph&iacute;a trước v&agrave; giảm x&oacute;c đơn đằng sau. Lực h&atilde;m của xe bắt nguồn từ phanh đĩa c&oacute; đường k&iacute;nh 298 mm trước v&agrave; 220 mm sau. C&aacute;c số đo cơ bản của Yamaha MT-25 2017 bao gồm chiều d&agrave;i tổng thể 2.090 mm, chiều rộng 745 mm, chiều cao 1.035 mm v&agrave; chiều d&agrave;i cơ sở 1.380 mm. Y&ecirc;n của mẫu naked bike nh&agrave; Yamaha cao 780 mm trong khi trọng lượng l&agrave; 165 kg.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '<p>Yamaha MT-25 sử dụng chung động cơ với người anh em Yamaha R25, l&agrave; loại xy-lanh đ&ocirc;i, dung t&iacute;ch 250 cc, sản sinh c&ocirc;ng suất tối đa 35,5 m&atilde; lực tại 12.000 v&ograve;ng/ph&uacute;t v&agrave; m&ocirc;-men xoắn cực đại 16,7 lb-ft tại 10.000 v&ograve;ng/ph&uacute;t. Động cơ kết hợp với hộp số 6 cấp v&agrave; b&igrave;nh xăng c&oacute; dung t&iacute;ch 14 l&iacute;t.</p>\r\n', '130000000', 0, 4, '30okiq8f.jpg', '', '2021-03-01 16:23:59', 'kieule1', '2021-02-28 10:29:49', 'kieule1', '1', 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created`, `status`) VALUES
(1, 'kytrew', 'dhbbfdb', '2021-01-15 13:24:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `module` varchar(45) NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `name`, `module`, `controller`, `action`) VALUES
(1, 'Hiển thị danh sách người dùng', 'admin', 'user', 'index'),
(2, 'Thay đổi status của người dùng', 'admin', 'user', 'status'),
(3, 'Cập nhật thông tin của người dùng', 'admin', 'user', 'form'),
(4, 'Thay đổi status của người dùng sử dụng Ajax', 'admin', 'user', 'ajaxStatus'),
(5, 'Xóa một hoặc nhiều người dùng', 'admin', 'user', 'trash'),
(6, 'Thay đổi vị trí hiển thị của các người dùng', 'admin', 'user', 'ordering'),
(7, 'Truy cập menu Admin Control Panel', 'admin', 'index', 'index'),
(8, 'Đăng nhập Admin Control Panel', 'admin', 'index', 'login'),
(9, 'Đăng xuất Admin Control Panel', 'admin', 'index', 'logout'),
(10, 'Cập nhật thông tin tài khoản quản trị', 'admin', 'index', 'profile');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `rating_number` int(11) NOT NULL,
  `user_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User IP Address',
  `submitted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `post_id`, `rating_number`, `user_ip`, `submitted`) VALUES
(1, 11, 11, '11', '2021-01-20 13:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `picture` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `status` text DEFAULT NULL,
  `ordering` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `name`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`) VALUES
(14, 'banner 1', 'zf50ods2.jpg', '2021-02-27 18:03:47', 'kieule1', '2021-02-15 09:52:43', 'kieule1', '1', 1),
(15, 'banner 2', 'q4nmxzl3.jpg', '2021-02-27 18:03:55', 'kieule1', '2021-02-27 10:25:02', 'kieule1', '1', 2),
(16, 'banner 3', 'rvhtl89b.jpg', '2021-02-27 18:04:04', 'kieule1', '2021-02-28 10:30:38', 'kieule1', '1', 5),
(17, 'banner 4', '50ajdewn.jpg', '2021-02-27 18:04:10', 'kieule1', '2021-02-28 10:30:19', 'kieule1', '0', 4),
(18, 'banner 5', 's6by1u4n.jpg', '2021-02-27 18:07:05', 'kieule1', '2021-02-28 10:30:36', 'kieule1', '1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  `register_date` datetime DEFAULT '0000-00-00 00:00:00',
  `register_ip` varchar(25) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'inactive',
  `ordering` int(11) DEFAULT 10,
  `telephone` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `register_date`, `register_ip`, `status`, `ordering`, `telephone`, `address`, `group_id`) VALUES
(1, 'kieule1', 'kieule1@gmail.com', 'Kiều Lê 1', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'kieule', '2021-02-05 00:28:05', 'kieule1', '2020-10-24 22:59:48', '::1', '0', 2, 987651010, 'nam anh nek', 1),
(2, 'kieule2', 'kieule2@gmail.com', 'Kiều Lê 2', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'kieule', '2021-01-11 15:25:26', 'admin', '2020-10-24 23:28:38', '::1', '0', 10, 987651010, 'quận Thủ Đức nek 1', 1),
(39, 'kieule3', 'kieule3@gmail.com', 'Kiều Lê 3', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'kieule', '2021-01-11 19:40:42', 'admin', '0000-00-00 00:00:00', NULL, '0', 11, 23456789, 'sdfghjk', 3),
(42, 'kieule4', 'kieule4@gmail.com', 'Kiều Lê 4', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'admin', '2021-01-11 15:25:19', 'admin', '0000-00-00 00:00:00', NULL, '1', 10, 23456789, 'sdfghjk', 4),
(43, 'kieule5', 'kieule5@gmail.com', 'Kiều Lê 5', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'kieule', '2021-01-27 13:05:33', 'admin', '0000-00-00 00:00:00', NULL, '1', 10, 23456789, 'sdfghjk', 2),
(44, 'kieule6', 'kieule6@gmail.com', 'Kiều Lê 6', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'admin', '2021-01-27 13:48:35', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 7, 23456789, 'sdfghjk', 118),
(46, 'kieule7', 'kieule7@gmail.com', 'Kiều Lê 7', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'kieule', '2021-02-05 00:57:30', 'kieule1', '0000-00-00 00:00:00', NULL, '1', 11, 23456789, 'sdfghjk', 118),
(47, 'kieule8', 'kieule8@gmail.com', 'Kiều Lê 8', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 'admin', '2021-02-05 01:04:48', 'kieule1', '0000-00-00 00:00:00', NULL, '0', 6, 23456789, 'sdfghjk', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moto`
--
ALTER TABLE `moto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `moto`
--
ALTER TABLE `moto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
