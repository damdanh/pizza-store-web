-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 03:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wd20302_n5_local`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `vai_tro` int(11) DEFAULT 1,
  `trang_thai_hoat_dong` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `ten`, `email`, `mat_khau`, `vai_tro`, `trang_thai_hoat_dong`, `created_at`, `updated_at`) VALUES
(1, 'Danh', 'danhdam200@gmail.com', '12345', 1, 1, '2025-11-28 01:38:49', '2025-12-08 13:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet`
--

CREATE TABLE `bai_viet` (
  `id_bai_viet` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `bai_doc` text DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `tom_tat` text DEFAULT NULL,
  `ngay_dang` datetime DEFAULT current_timestamp(),
  `trang_thai` varchar(50) DEFAULT 'Draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ban`
--

CREATE TABLE `ban` (
  `id_ban` int(11) NOT NULL,
  `id_khu_vuc` int(11) DEFAULT NULL,
  `ten_ban` varchar(100) NOT NULL,
  `so_dong` int(11) DEFAULT NULL,
  `so_ghe` int(11) DEFAULT NULL,
  `trang_thai_ban` varchar(50) DEFAULT 'Trống',
  `loai_ban` varchar(50) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_khach_hang` int(11) DEFAULT NULL,
  `people` int(11) DEFAULT 2,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `total` decimal(15,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `phone`, `email`, `id_khach_hang`, `people`, `booking_date`, `booking_time`, `branch`, `notes`, `total`, `created_at`) VALUES
(50, 'Vũ Vu Tien', '0326008989', 'tiend4693@gmail.com', NULL, 21, '2025-12-15', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa -', '', 0.00, '2025-12-05 01:26:14'),
(51, 'Vũ Vu Tien', '0326008989', 'tiend4693@gmail.com', NULL, 21, '2025-12-15', '15:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa -', '', 0.00, '2025-12-05 01:26:22'),
(52, 'Vũ Vu Tien', '0326008989', 'tiend4693@gmail.com', NULL, 2, '2025-12-15', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa -', '', 0.00, '2025-12-05 01:27:19'),
(53, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-15', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-05 22:28:22'),
(54, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-15', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-06 10:35:38'),
(55, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-06', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-06 16:47:12'),
(56, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-06', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-06 18:03:24'),
(57, 'Nguyễn Tấn', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-08 14:58:01'),
(58, 'Nguyễn Tấn', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-08 14:58:20'),
(59, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-08 14:59:00'),
(60, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 2, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-08 15:00:51'),
(61, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Saigon Centre', '', 0.00, '2025-12-08 15:08:58'),
(62, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Saigon Centre', '', 0.00, '2025-12-08 15:09:56'),
(63, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Bến Thành', '', 0.00, '2025-12-08 15:30:48'),
(64, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-08 15:33:36'),
(65, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Bến Thành', '', 0.00, '2025-12-08 15:35:42'),
(66, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Saigon Centre', '', 0.00, '2025-12-08 15:36:26'),
(67, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', NULL, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 0.00, '2025-12-08 15:44:49'),
(68, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', 2, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Bến Thành', '', 242240.00, '2025-12-08 15:54:53'),
(69, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', 2, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Bến Thành', '', 134240.00, '2025-12-08 16:29:50'),
(70, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', 2, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - Saigon Centre', '', 218480.00, '2025-12-08 16:47:45'),
(71, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', 2, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 123008.00, '2025-12-08 17:22:03'),
(72, 'Nguyễn Tấn Lộc', '0367474615', 'tanloccute0310@gmail.com', 2, 1, '2025-12-08', '19:00:00', 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa', '', 304880.00, '2025-12-08 21:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `booking_items`
--

CREATE TABLE `booking_items` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `id_mon` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL DEFAULT 1,
  `gia` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_items`
--

INSERT INTO `booking_items` (`id`, `booking_id`, `id_mon`, `so_luong`, `gia`, `created_at`) VALUES
(15, 72, 26, 1, 198000.00, '2025-12-05 18:30:05'),
(16, 72, 25, 1, 109000.00, '2025-12-05 18:30:05'),
(17, 72, 24, 1, 82000.00, '2025-12-05 18:30:05'),
(18, 73, 24, 1, 82000.00, '2025-12-05 18:30:53'),
(19, 74, 54, 1, 36000.00, '2025-12-05 18:31:30'),
(20, 76, 1, 2, 195000.00, '2025-12-05 18:34:00'),
(21, 77, 25, 1, 109000.00, '2025-12-05 18:39:15'),
(22, 77, 3, 1, 695000.00, '2025-12-05 18:39:15'),
(23, 79, 25, 1, 109000.00, '2025-12-05 18:46:02'),
(24, 79, 26, 1, 198000.00, '2025-12-05 18:46:02'),
(25, 82, 7, 1, 398000.00, '2025-12-05 19:07:06'),
(26, 82, 3, 1, 695000.00, '2025-12-05 19:07:06'),
(27, 88, 8, 1, 198000.00, '2025-12-06 03:44:18'),
(28, 55, 7, 1, 398000.00, '2025-12-06 09:47:12'),
(29, 55, 8, 2, 198000.00, '2025-12-06 09:47:12'),
(30, 56, 7, 1, 398000.00, '2025-12-06 11:03:24'),
(31, 56, 8, 1, 198000.00, '2025-12-06 11:03:24'),
(32, 57, 2, 1, 195000.00, '2025-12-08 07:58:01'),
(33, 57, 3, 1, 695000.00, '2025-12-08 07:58:01'),
(34, 61, 3, 1, 695000.00, '2025-12-08 08:08:58'),
(35, 61, 2, 1, 195000.00, '2025-12-08 08:08:58'),
(36, 66, 2, 1, 195000.00, '2025-12-08 08:36:26'),
(37, 66, 3, 1, 695000.00, '2025-12-08 08:36:26'),
(38, 66, 5, 1, 485000.00, '2025-12-08 08:36:26'),
(39, 67, 3, 1, 695000.00, '2025-12-08 08:44:49'),
(40, 67, 2, 1, 195000.00, '2025-12-08 08:44:49'),
(41, 67, 1, 1, 195000.00, '2025-12-08 08:44:49'),
(42, 68, 3, 1, 695000.00, '2025-12-08 08:54:53'),
(43, 68, 2, 1, 195000.00, '2025-12-08 08:54:53'),
(44, 69, 2, 1, 195000.00, '2025-12-08 09:29:50'),
(45, 69, 1, 1, 195000.00, '2025-12-08 09:29:50'),
(46, 70, 5, 1, 485000.00, '2025-12-08 09:47:45'),
(47, 70, 4, 1, 295000.00, '2025-12-08 09:47:45'),
(48, 71, 35, 1, 219000.00, '2025-12-08 10:22:03'),
(49, 71, 34, 1, 119000.00, '2025-12-08 10:22:03'),
(50, 72, 3, 1, 695000.00, '2025-12-08 14:44:43'),
(51, 72, 5, 1, 485000.00, '2025-12-08 14:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `chinhanh`
--

CREATE TABLE `chinhanh` (
  `id` int(11) NOT NULL,
  `ten_chi_nhanh` varchar(100) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `gio_mo_cua` time NOT NULL,
  `gio_dong_cua` time NOT NULL,
  `so_luong_ban` int(11) NOT NULL,
  `suc_chua` int(11) NOT NULL,
  `khung_gio` varchar(50) DEFAULT NULL,
  `ban_con_trong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chinhanh`
--

INSERT INTO `chinhanh` (`id`, `ten_chi_nhanh`, `dia_chi`, `gio_mo_cua`, `gio_dong_cua`, `so_luong_ban`, `suc_chua`, `khung_gio`, `ban_con_trong`) VALUES
(1, 'N5 Pasta – Saigon Centre', 'Saigon Centre, Quận 1, TP.HCM', '08:00:00', '22:00:00', 20, 80, '08:00-22:00', 5),
(2, 'N5 Pasta – Bến Thành', 'Gần chợ Bến Thành, Quận 1, TP.HCM', '09:00:00', '21:30:00', 15, 60, '09:00-21:30', 3),
(3, 'N5 Pasta – GigaMall', 'GigaMall, Thủ Đức, TP.HCM', '08:00:00', '22:00:00', 18, 72, '08:00-22:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_dat_ban`
--

CREATE TABLE `chi_tiet_dat_ban` (
  `id_dat_ban` int(11) NOT NULL,
  `id_mon` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_khuyen_mai`
--

CREATE TABLE `chi_tiet_khuyen_mai` (
  `id_khuyen_mai` int(11) NOT NULL,
  `id_mon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `noi_dung` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `ho_ten`, `sdt`, `email`, `noi_dung`, `created_at`) VALUES
(1, 'Vũ Tiến Đạt', '0326008989', 'tiend4693@gmail.com', 'tôi cần gặp quản lý', '2025-12-06 10:19:27'),
(2, 'Nguyễn Tấn Lộc ', '0367474615', 'tanloccute0310@gmail.com', 'aaaa', '2025-12-06 10:36:00'),
(3, 'Nguyễn Tấn Lộc ', '0367474615', 'tanloccute0310@gmail.com', 'hgdrxsees', '2025-12-06 11:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` int(11) NOT NULL,
  `id_khach_hang` int(11) NOT NULL,
  `id_don_hang` int(11) DEFAULT NULL,
  `sao` int(11) DEFAULT NULL CHECK (`sao` between 1 and 5),
  `nhan_xet` text DEFAULT NULL,
  `ngay_danh_gia` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_mon`
--

CREATE TABLE `danh_muc_mon` (
  `id_danh_muc_mon` int(11) NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danh_muc_mon`
--

INSERT INTO `danh_muc_mon` (`id_danh_muc_mon`, `ten_danh_muc`, `mo_ta`) VALUES
(1, 'Delivery Combo', NULL),
(2, 'Bánh Pizza', NULL),
(3, 'Khai vị', NULL),
(4, 'Salad', NULL),
(5, 'Món Chính/Mì ý', NULL),
(6, 'Tráng miệng', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dat_ban`
--

CREATE TABLE `dat_ban` (
  `id_dat_ban` int(11) NOT NULL,
  `id_khach_hang` int(11) DEFAULT NULL,
  `id_ban` int(11) DEFAULT NULL,
  `ngay_dat_ban` datetime NOT NULL,
  `trang_thai_dat_ban` varchar(50) DEFAULT 'Chờ xác nhận',
  `so_luong_nguoi` int(11) NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `phu_phi` decimal(10,2) DEFAULT 0.00,
  `tong_gia` decimal(10,2) DEFAULT 0.00,
  `danh_gia_dat_ban` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `id_don_hang` int(11) NOT NULL,
  `id_khach_hang` int(11) NOT NULL,
  `tong_tien` decimal(15,2) NOT NULL,
  `trang_thai` varchar(50) DEFAULT 'cho_xac_nhan',
  `ngay_dat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id_khach_hang` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `gioi_tinh` varchar(10) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `dia_chi` varchar(500) DEFAULT NULL,
  `trang_thai_tai_khoan` varchar(50) DEFAULT 'Active',
  `phan_hoi` text DEFAULT NULL,
  `tai_khoan_dang_nhap` varchar(100) DEFAULT NULL,
  `ma_xac_minh` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tong_chi_tieu` decimal(15,2) DEFAULT 0.00,
  `diem_tich_luy` int(11) DEFAULT 0,
  `hang_thanh_vien` enum('dong','bac','vang','kimcuong') DEFAULT 'dong',
  `reset_expires` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id_khach_hang`, `ten`, `sdt`, `email`, `mat_khau`, `gioi_tinh`, `ngay_sinh`, `dia_chi`, `trang_thai_tai_khoan`, `phan_hoi`, `tai_khoan_dang_nhap`, `ma_xac_minh`, `created_at`, `updated_at`, `tong_chi_tieu`, `diem_tich_luy`, `hang_thanh_vien`, `reset_expires`) VALUES
(2, 'Nguyễn Tấn Lộc', NULL, 'tanloccute0310@gmail.com', '$2y$10$I6bv7fbcGkSR.nYDUUXfjuGpxJTkfe/U6YoSSLBZpOL4fj57MHSuy', NULL, NULL, NULL, 'Active', NULL, '562781e230a6a807237767ea9c9d868fcae38b120c92be53549dee6a67ae078a', 'D6B8DE', '2025-12-01 23:25:58', '2025-12-08 21:44:43', 5383040.00, 0, 'vang', 1765167401),
(3, 'Nguyễn Tấn Lộc cccc', NULL, 'abc@gmail.com', '$2y$10$eCsCHfrbDzQxntj.taW.WOQkxe/pq8N6MtX4xD4Pl2Pz6MExzLeQa', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, '2025-12-06 11:33:20', '2025-12-06 11:33:20', 0.00, 0, 'dong', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `khuyen_mai`
--

CREATE TABLE `khuyen_mai` (
  `id_khuyen_mai` int(11) NOT NULL,
  `ten_chuong_trinh` varchar(255) NOT NULL,
  `ten_ctk` varchar(100) DEFAULT NULL,
  `chi_tiet_km` text DEFAULT NULL,
  `ngay_bat_dau` datetime NOT NULL,
  `ngay_ket_thuc` datetime NOT NULL,
  `phan_tram_giam_gia` decimal(5,2) DEFAULT NULL,
  `trang_thai_hoat_dong` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khu_vuc`
--

CREATE TABLE `khu_vuc` (
  `id_khu_vuc` int(11) NOT NULL,
  `ten_khu_vuc` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khu_vuc`
--

INSERT INTO `khu_vuc` (`id_khu_vuc`, `ten_khu_vuc`, `mo_ta`) VALUES
(1, 'N5 Pasta - Saigon Centre', 'Khu vực trung tâm thương mại'),
(2, 'N5 Pasta - Bến Thành', 'Gần chợ Bến Thành.'),
(3, 'N5 Pasta - GigaMall', 'Chi nhánh Thủ Đức');

-- --------------------------------------------------------

--
-- Table structure for table `mon_an`
--

CREATE TABLE `mon_an` (
  `id_mon` int(11) NOT NULL,
  `id_danh_muc_mon` int(11) DEFAULT NULL,
  `ten_mon` varchar(255) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(500) DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT 'Còn hàng',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mon_an`
--

INSERT INTO `mon_an` (`id_mon`, `id_danh_muc_mon`, `ten_mon`, `gia`, `mo_ta`, `hinh_anh`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 1, 'Wow Pasta', 195000.00, '- Mì Ý bò bằm và phô mai hun khói nhà làm\r\n\r\n- Salad 7 loại rau xanh (S)', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2FPasta_Combo_195_K_2_f9804febcb%2FPasta_Combo_195_K_2_f9804febcb.png&w=828&q=75', 'Còn hàng', '2025-11-27 10:16:43', '2025-11-29 11:04:21'),
(2, 1, 'Wow Pizza', 195000.00, '- Pizza Margherita\r\n\r\n- Salad 7 loại rau xanh (S)', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2FPizza_Combo_195_K_38158f7caf%2FPizza_Combo_195_K_38158f7caf.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:16:43', '2025-11-29 11:04:31'),
(3, 1, 'Happy Family', 695000.00, '2 Pizza nguyên + 1 Súp + 1 Salad + 3 Nước:\r\n- Pizza 3 loại phô mai nhà làm/Pizza 4 loại nấm\r\n- Pizza Cá hồi xốt Miso/Pizza Hải sản cay với phô mai hun khói/Pizza Tôm xốt mayo\r\n- Súp nghêu/Súp cà chua thịt viên ý\r\n- Salad rau Rocket hữu cơ và cà chua ăn kèm xốt giấm Balsamic\r\n- 3 Nước.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2FFamily_Combo_695_K_4ec91b3216%2FFamily_Combo_695_K_4ec91b3216.jpg&w=828&q=75', 'Còn Hàng', '2025-11-27 10:16:43', '2025-11-29 11:04:42'),
(4, 1, 'Happy Duo', 295000.00, '1 Pizza nguyên + 1 Salad + 2 Nước:\r\n- Pizza 3 loại phô mai nhà làm\r\n- Salad rau xanh với xốt mật ong mù tạt (S)\r\n- 2 Nước.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2FCombo_Pizza_295_K_3fd32e09c2%2FCombo_Pizza_295_K_3fd32e09c2.png&w=828&q=75', 'Còn hàng', '2025-11-27 10:16:43', '2025-11-29 11:04:54'),
(5, 1, 'Classic Delight', 485000.00, '1 Pizza nguyên + 1 Mì Ý + 1 Salad + 2 Nước:\r\n- Pizza Margherita- Mì Ý bò bằm và phô mai hun khói/Mì Ý nghêu\r\n- Salad tôm và bơ ăn kèm xốt chanh/ Salad rau xanh với xốt mù tạt mật ong\r\n- 2 Nước.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2FClassic_Combo_485_K_517e699910%2FClassic_Combo_485_K_517e699910.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:16:43', '2025-11-29 11:05:04'),
(6, 2, 'Pizza tôm sốt tỏi cay', 254000.00, 'Một sự kết hợp hài hoà từ tôm tươi và búp cải xanh baby được chế biến vừa đủ để tôn lên vị ngọt tự nhiên và hương thơm hấp dẫn từ tỏi phi.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Tôm\r\n- Trứng\r\n- Đậu nành\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F10010021_2_7dfb37814a%2F10010021_2_7dfb37814a.jpeg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:05:21'),
(7, 2, 'Pizza Phô mai Burrata Margherita thịt nguội\r\n', 398000.00, 'Nền bánh Margherita cổ điển được thêm thắt với thịt nguội Parma, rau Rocket và phô mai Burrata nhà làm béo ngậy.Lưu ý: Thịt nguội và rau rocket được đặt riêng để đảm bảo độ tươi ngon của pizza khi giao đến bạn\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000003_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:05:32'),
(8, 2, 'Pizza 3 loại phô mai nhà làm', 198000.00, '(Món chay) Bạn sẽ bất ngờ trước sự hợp cạ của bộ đôi “phô mai-mật ong” này đấy! Dòng pizza 3 loại phô mai nhà làm gồm: phô mai Mozzarella, Grano Padano và Camembert.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000005_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:05:46'),
(9, 2, 'Pizza 4 loại phô mai nhà làm\r\n', 248000.00, '(Món chay) Dòng pizza 4 loại phô mai nhà làm gồm: phô mai xanh, Mozzarella, Grano Padano, và Camembert.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000006_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:05:59'),
(10, 2, 'Pizza 5 loại phô mai nhà làm\r\n', 298000.00, '(Vegetarian) Dòng pizza 5 loại phô mai nhà làm gồm: phô mai xanh, Mozzarella, Grano Padano, Camembert và Raclette.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://img.dominos.vn/thumbnail+b32.jpg', 'Còn hàng', '2025-11-27 10:27:19', '2025-12-01 12:24:44'),
(11, 2, 'Pizza Margherita\r\n', 160000.00, '(Món chay) Chiếc bánh pizza nóng hổi với nền xốt cà chua, cùng nhân phô mai Mozzarella nhà làm điểm mùi thơm thảo mộc từ lá húng quế tươi.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000008_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:06:23'),
(12, 2, 'Pizza Thịt nguội Ý Parma và rau rocket với xốt cà chua\r\n', 331000.00, 'Nền bánh Margherita cổ điển được thêm thắt với thịt nguội Parma và rau rocket.Lưu ý: Thịt nguội và rau rocket được đặt riêng để đảm bảo độ tươi ngon của pizza khi giao đến bạn\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000009_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:06:31'),
(13, 2, 'Pizza Cá hồi xốt kem miso\r\n', 278000.00, 'Sự cân bằng hài hòa giữa xốt Miso, phô mai Mozzarella nhà làm, cá hồi xen lẫn vị ngọt thanh của hành tây và mùi thơm thoang thoảng từ tiêu cùng hành lá.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Cá\r\n- Đậu nành\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000013_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:06:43'),
(14, 2, 'Pizza Hải sản xốt cà chua cay với phô mai hun khói\r\n', 274000.00, 'Chiếc bánh với ba loại hải sản tươi (nghêu, tôm, mực) toát lên mùi thơm hấp dẫn từ phô mai Scamorza hun khói trên nền xốt cà chua và các loại thảo mộc, điểm xuyết chút cay nhẹ kích vị.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Nghêu\r\n- Tôm\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000014_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:27:19', '2025-11-29 11:06:54'),
(15, 2, 'Pizza Gà xốt Teriyaki\r\n', 218000.00, 'Vị mặn ngọt đặc trưng của xốt Teriyaki trong nền ẩm thực Nhật Bản là điểm nhấn của loại pizza này, nổi bật cùng những lát thịt gà mềm-mọng nước và mùi thơm từ rong biển và lá tía tô.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Trứng\r\n- Đậu nành\r\n- Sữa\r\n- Thịt Gà', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000017_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:07:05'),
(16, 2, 'Pizza Phô mai Camembert nhà làm và xốt nấm thịt nguội\r\n', 208000.00, 'Món bánh đáng thử cho thực khách yêu phô mai. Mùi thơm nhẹ nhàng từ lớp xốt nấm nổi bật cùng vị béo của phô mai Camembert nhà làm và vị đậm đà từ những lát thịt nguội.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa\r\n- Thịt Lợn', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000018_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:07:17'),
(17, 2, 'Pizza 4 loại nấm', 198000.00, '(Món chay) Sự kết hợp của 4 loại nấm tươi: linh chi trắng, linh chi nâu, nấm mỡ trắng, và nấm mỡ nâu; tất cả nổi bật trên nền xốt nấm và phô mai Mozzarella nhà làm.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Đậu nành\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000024_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:07:27'),
(18, 2, 'Pizza Xốt bí ngòi quế tây\r\n', 178000.00, '(Món chay) Sự kết hợp sáng tạo giữa xốt kem quế tây, bí ngòi, bông bí, hạt bí, phô mai Lactic nhà làm đã tạo nên một dòng pizza chay có hương vị phong phú.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa\r\n- Các loại hạt', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2FKaizen_Zucchini_Basil_Sauce_with_Flower_ee6553524b%2FKaizen_Zucchini_Basil_Sauce_with_Flower_ee6553524b.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:07:35'),
(19, 2, 'Pizza Gà Tandoori\r\n', 218000.00, 'Món bánh lấy cảm hứng từ nền ẩm thực Ấn Độ, kết hợp nguyên liệu gà Tandoori, mayonnaise và phô mai nhà làm, điểm mùi thơm từ lá rocket hoặc cải xoong cắt nhỏ.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Trứng\r\n- Đậu nành\r\n- Sữa\r\n- Thịt Gà', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10000072.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:07:42'),
(20, 2, 'Pizza Rau cải xoăn kèm phô mai Ricotta chanh nhà làm với xốt ô liu và nụ bạch hoa\r\n', 188000.00, '(Món chay) Pizza rau cải xoăn chay trên lớp xốt nền \"tapenade\" từ ô liu và nụ bạch hoa, kết hợp vị béo nhẹ của phô mai Ricotta nhà làm và một chút chua của chanh, điểm xuyết đầy màu sắc từ các loại hoa ăn được.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10004067_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:08:15'),
(21, 2, 'Pizza Sò điệp Hokkaido Gratin với xốt Miso ngọt\r\n', 420000.00, 'Sò điệp mọng nước từ Hokkaido, Nhật Bản được kết hợp hoàn hảo với xốt miso ngọt và bông cải non nướng giúp nâng tầm hương vị món ăn thêm đậm đà.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sò Điệp\r\n- Đậu nành\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10010008_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:08:22'),
(22, 2, 'Pizza Thịt bò cay kiểu Kebab\r\n', 294000.00, 'Hương vị đậm đà của thịt bò nướng kiểu Kebab, kết hợp phô mai nhà làm trên nền xốt cà chua, cùng vị cay đặc biệt từ ớt xanh, ớt Jalapeno, và hạt cumin.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa\r\n- Thịt Bò\r\n- SCR_SPICY', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10010010.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:08:31'),
(23, 2, 'Pizza Bò kho\r\n', 248000.00, 'Phần gân và thịt bò được om nhiều giờ cùng vang đỏ, ngũ vị hương, cà rốt, khoai tây, hành tây, cà chua, kết hợp với phô mai, bánh phở chiên, các loại rau xanh.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Trứng\r\n- Cá\r\n- Đậu nành\r\n- Sữa\r\n- Thịt Bò', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F10010014_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-27 10:43:09', '2025-11-29 11:08:40'),
(24, 3, 'Súp kem nấm', 82000.00, 'Vị nấm mộc mạc quyện trong súp kem mịn thoảng hương dầu nấm truffle trắng. Hành tím giòn tan cùng phô mai Grana Padano tan chảy. Món chay phù hợp mọi nhu cầu.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Đậu nành\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F20010033_2_86f01a3d03%2F20010033_2_86f01a3d03.png&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:08:47'),
(25, 3, 'Các loại phô mai nhà làm (S)', 109000.00, '(Món chay) Phô mai các loại là sự kết hợp của 5 loại Phô mai nhà làm 4P\'s gồm Raclette, Scamorza hun khói, Camembert Truffle và Phô mai xanh. Mứt ngọt, phúc bồn tử, sung khô và hạt hạnh nhân được thêm vào để tăng hương vị của từng loại phô mai. Món được ăn kèm cùng đế bánh pizza.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Đậu nành\r\n- Sữa\r\n- Các loại hạt\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F20000322_2_aa2f93ea45%2F20000322_2_aa2f93ea45.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:08:55'),
(26, 3, 'Các loại phô mai nhà làm (L)', 198000.00, '(Món chay) Phô mai các loại là sự kết hợp của 5 loại Phô mai nhà làm 4P\'s gồm Raclette, Scamorza hun khói, Camembert Truffle và Phô mai xanh. Mứt ngọt, phúc bồn tử, sung khô và hạt hạnh nhân được thêm vào để tăng hương vị của từng loại phô mai. Món được ăn kèm cùng đế bánh pizza.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Đậu nành\r\n- Sữa\r\n- Các loại hạt', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F20000323_2_054f6326a5%2F20000323_2_054f6326a5.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:18'),
(27, 3, 'Thịt nguội cuộn xoài kèm xốt chanh dây\r\n', 144000.00, 'Vị mặn của thịt nguội, vị thơm của xoài hoà quyện cùng với xốt chanh dây thơm lừng tạo nên một sự khởi đầu lôi cuốn.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20000006_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:23'),
(28, 3, 'Phô mai Camembert kẹp Mascarpone dầu nấm Truffle (1 miếng)\r\n', 47000.00, '(Món chay) Với hương thơm tinh tế của dầu nấm Truffle hòa quyện cùng vị ngon thuần túy của phô mai Camembert nhà làm.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20000010_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:31'),
(29, 3, 'Khoai tây Đức bỏ lò\r\n', 72000.00, 'Vị bùi của khoai tây, vị ngọt nhẹ của hành tây và vị mặn của thịt xông khói quyện với hương thơm đặc trưng của hương thảo.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa\r\n- Thịt Lợn', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20000013_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:37'),
(30, 3, 'Súp nghêu hầm\r\n', 82000.00, 'Cảm nhận từng muỗng súp nghêu béo ngậy, thơm lừng kết hợp cần tây làm gia tăng hương vị ngọt dịu của súp.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Nghêu\r\n- Đậu nành\r\n- Sữa\r\n- Thịt Lợn', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20000043_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:44'),
(31, 3, 'Súp cà chua thịt viên Ý với phô mai Mascarpone\r\n', 82000.00, 'Với hương vị tự nhiên đậm đà, chua ngọt hài hòa khi chúng tôi sử dụng nước xốt cà chua tươi truyền thống từ Ý. Một món súp thú vị để khởi đầu bữa ăn!\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Đậu nành\r\n- Sữa\r\n- Thịt Lợn', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20000045_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:51'),
(32, 3, 'Gà rán gia vị phương Đông với xốt ớt Jalapeño nhà làm (2 miếng)\r\n', 82000.00, 'Thơm ngon-giòn rụm, sự kết hợp độc đáo giữa gà rán kiểu Châu Mỹ với các gia vị đặc trưng của phương Đông và tiêu Sansho hữu cơ, chấm với xốt Jalapeno nhà làm.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Trứng\r\n- Đậu nành\r\n- Sữa\r\n- Mè\r\n- Thịt Gà', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20010016_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:13:31', '2025-11-29 11:09:59'),
(33, 3, 'Set thịt nguội và phô mai nhà làm (lớn)\r\n', 334000.00, 'Set khai vị với đế bánh pizza mỏng-giòn của 4P’s cùng thịt nguội Parma, xúc xích Milano và Chorizo; sự thơm béo từ các loại phô mai nhà làm cùng rau rocket và cà chua bi.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Đậu nành\r\n- Sữa\r\n- Các loại hạt', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F20000325_2_b2d2771461%2F20000325_2_b2d2771461.jpg&w=828&q=75', 'Hết hàng', '2025-11-28 01:13:31', '2025-11-29 11:10:06'),
(34, 4, 'Phô Mai Burrata với trái cây nhiệt đới với cà chua ngâm tương (nhỏ)\r\n', 119000.00, 'Thanh long, dưa hấu và xoài mọng ôm trọn phô mai Burrata mềm mượt, điểm nhẹ cà chua ướp xì dầu tinh tế. Món khai vị chay đa sắc, hài hòa vị ngọt thanh và mặn umami.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F20110010_2_47d901e45d%2F20110010_2_47d901e45d.png&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:11'),
(35, 4, 'Phô Mai Burrata với trái cây nhiệt đới với cà chua ngâm tương (lớn)\r\n', 219000.00, 'Thanh long, dưa hấu và xoài mọng ôm trọn phô mai Burrata mềm mượt, điểm nhẹ cà chua ướp xì dầu tinh tế. Món khai vị chay đa sắc, hài hòa vị ngọt thanh và mặn umami.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2F4ps_strapi%2F20110009_2_f6d9515d2c%2F20110009_2_f6d9515d2c.png&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:18'),
(36, 4, 'Salad tôm và bơ\r\n', 115000.00, 'Món salad đầy sắc màu tươi mát với các nguyên liệu tươi ngon từ rau rocket, bơ, cà chua, cần tây, tôm tươi và phô mai bột Parmesan.\r\n\r\nChất gây dị ứng & Thành phần chính:\r\n\r\n- Tôm\r\n- Sữa', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100012_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:24'),
(37, 4, 'Salad 7 loại rau xanh (L)\r\n', 80000.00, 'Gồm 7 loại rau xanh với cải bẹ xanh và 6 loại rau xà lách, và 6 loại rau mùi như kinh giới, ngò gai, húng quế, húng thơm, rau mùi và thì là.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100008_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:32'),
(38, 4, 'Phô mai Mozzarella nhà làm và cà chua Đà Lạt Salad\r\n', 105000.00, 'Tổng thể hương vị món ăn được cân bằng khi kết hợp phô mai tươi cùng vị chua ngọt từ cà chua, kèm mùi thơm của lá quế tây, dầu ô liu và điểm xuyến một chút muối, tiêu.', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100003_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:39'),
(39, 4, 'Phô mai Burrata kèm lá Rocket và Cà chua Salad\r\n', 185000.00, 'Sự tươi xanh của rau Rocket hữu cơ, vị mát từ cà chua và độ thơm béo đặc trưng đến từ phô mai Burrata nhà làm, điểm xuyết thêm hạt hạnh nhân giòn rụm.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100001_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:46'),
(40, 4, 'Lá Rocket và Cà chua Salad\r\n', 81000.00, 'Một sự hài hòa của lá Rocket hữu cơ và cà chua với một chút Giấm đen nhà làm.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100002_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:53'),
(41, 4, 'Rau cải xoăn hữu cơ với phô mai Lactic nhà làm và các loại hạt ngào đường caramen mặn Salad\r\n', 105000.00, 'Xà lách cải xoăn được phục vụ với phô mai Lactic nhà làm, các loại hạt ngào đường caramen mặn, đậu xanh, củ thì là và dầu giấm vị hành tây.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20110002_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:10:59'),
(42, 4, 'Phô mai Burrata kèm thịt nguội và trái cây nhiệt đới Salad (nhỏ)\r\n', 129000.00, 'Salad trái cây với nguyên liệu chính là những loại trái cây xanh tươi được nâng tầm với thịt nguội nhập khẩu cùng phô mai Burrata nhà làm\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100004_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:11:12'),
(43, 4, 'Cá hồi, bơ và phô mai Ricotta Salad\r\n', 158000.00, 'Một chút biến tấu trên nền các loại rau xanh kết hợp thêm vị béo từ cá hồi tươi, bơ và phô mai Ricotta. Dùng kèm xốt tương đậu nành và cá cơm kiểu Nhật cho ra vị mặn ngon.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20100305_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:25:28', '2025-11-29 11:11:06'),
(44, 5, 'Mì Ý xốt cà chua với phô mai Mascarpone nhà làm\r\n', 150000.00, '(Món cay) Sắc đỏ nổi bật và vị chua đặc trưng của xốt cà chua Ý hòa cùng vị béo thanh của phô mai Mascarpone nhà làm và điểm xuyết chút cay từ ớt. Chúng tôi có thể điều chỉnh độ cay theo mong muốn của bạn. Hãy cho chúng tôi biết.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200013_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:11:21'),
(45, 5, 'Mì Ý nghêu và xốt quế tây\r\n', 165000.00, 'Món mì với mùi thơm nồng của nghêu và màu xanh đặc trưng của xốt quế tây nhà làm quyện đều lên từng sợi mì, với thịt nghêu và hạt bí.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200003_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:11:27'),
(46, 5, 'Mì Ý bò bằm và phô mai hun khói nhà làm\r\n', 168000.00, 'Mì Ý xốt bò bằm Bolognese, điểm nhấn không chỉ ở sự đậm đà của nước xốt thịt bò bằm mà còn nổi bật với vị thơm béo khó cưỡng từ phần phô mai Scamozza hun khói phía bên trên.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200005_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:12:04'),
(47, 5, 'Mì Fettuccine nhà làm kèm xốt kem cá hồi\r\n', 194000.00, 'Hãy nhớ vắt một ít chanh lên và trộn đều, vị chua tự nhiên của chanh sẽ trung hòa vị béo ngậy của món ăn, hài hòa cùng cá hồi ngọt thanh và mùi thơm nồng của tiêu hồng.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200009_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:12:10'),
(48, 5, 'Mì Lasagna đút lò kèm phô mai Mozzarella nhà làm\r\n', 178000.00, 'Sự cân bằng tuyệt vời khi kết hợp vị đậm đà của thịt bò bằm xen kẽ những lớp mì Lasagna, hòa cùng vị chua dịu từ cà chua và vị béo của phô mai Scamozza.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200015_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:12:18'),
(49, 5, 'Cơm Ý Risotto mực với cà chua sấy khô và xốt Aioli nhà làm\r\n', 165000.00, 'Ăn kèm mực nướng và phô mai Caciocavallo nhà làm\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20210013_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:12:24'),
(50, 5, 'Mì Ý xốt kem với cua và xốt cà chua\r\n', 254000.00, 'Món mì “huyền thoại” ở Pizza 4P’s sẽ đánh thức khứu giác của bạn với mùi cua thơm nồng hấp dẫn hòa quyện cùng xốt kem cà chua và phô mai Ricotta béo dịu.Lưu ý: Món ăn sẽ không đi kèm mai cua.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200001_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:29:09', '2025-11-29 11:12:31'),
(51, 5, 'Mì Fettuccine nhà làm kèm xốt kem tôm, nấm và măng tây\r\n', 200000.00, 'Sợi mì dẹt Fettuccine tươi kết hợp vị ngọt thanh tự nhiên của tôm, nấm đùi gà và măng tây, hòa cùng vị thơm béo của xốt kem và hạnh nhân giòn rụm.\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F20200016_2.jpg&w=828&q=75', 'Hết hàng', '2025-11-28 01:29:09', '2025-11-29 11:12:43'),
(52, 6, 'Bánh phô mai kép\r\n', 75000.00, 'Bánh phô mai hai lớp\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F02-06-2021%2520Image%2F30000009.png&w=828&q=75', 'Còn hàng', '2025-11-28 01:32:11', '2025-11-29 11:12:57'),
(53, 6, 'Sữa chua kiểu Hy Lạp (90g)\r\n', 40000.00, 'Sữa chua có kết cấu đặc, béo mịn với đặc trưng nguyên bản nhà làm\r\n\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F88100015_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:32:11', '2025-11-29 11:13:02'),
(54, 6, 'Pudding kem trứng (90g)\r\n', 36000.00, 'Bánh pudding nhà làm có kết cấu mềm, mùi vị dịu nhẹ của kem trứng\r\n\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F88100009_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:32:11', '2025-11-29 11:13:08'),
(55, 6, 'Sữa chua xốt dâu (90g)\r\n', 28000.00, 'Sữa chua nhà làm với hương dâu ngọt ngào\r\n\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F88100011-2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:32:11', '2025-11-29 11:13:15'),
(56, 6, 'Bánh matcha pudding (90g)\r\n', 37000.00, 'Bánh pudding nhà làm hương vị trà xanh\r\n\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F88100010_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:32:11', '2025-11-29 11:13:21'),
(57, 6, 'Sữa chua xốt chanh dây (90g)\r\n', 28000.00, 'Sữa chua nhà làm mang vị chua ngọt hài hòa của chanh dây\r\n\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F88100012_2.jpg&w=828&q=75', 'Hết hàng', '2025-11-28 01:32:11', '2025-11-29 11:13:27'),
(58, 6, 'Sữa chua ít đường (90g)\r\n', 25000.00, 'Sữa chua nhà làm ít đường, vị thanh nhẹ\r\n\r\n\r\n', 'https://delivery.pizza4ps.com/_next/image?url=https%3A%2F%2Fstorage.googleapis.com%2Fdelivery-system-v2%2F03-04-2022-Image%2F88100013_2.jpg&w=828&q=75', 'Còn hàng', '2025-11-28 01:32:11', '2025-11-29 11:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoan_reset`
--

CREATE TABLE `tai_khoan_reset` (
  `id_reset` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `loai_tai_khoan` varchar(50) NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `het_han` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`id_bai_viet`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `ban`
--
ALTER TABLE `ban`
  ADD PRIMARY KEY (`id_ban`),
  ADD UNIQUE KEY `ten_ban` (`ten_ban`),
  ADD KEY `id_khu_vuc` (`id_khu_vuc`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `chinhanh`
--
ALTER TABLE `chinhanh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chi_tiet_dat_ban`
--
ALTER TABLE `chi_tiet_dat_ban`
  ADD PRIMARY KEY (`id_dat_ban`,`id_mon`),
  ADD KEY `id_mon` (`id_mon`);

--
-- Indexes for table `chi_tiet_khuyen_mai`
--
ALTER TABLE `chi_tiet_khuyen_mai`
  ADD PRIMARY KEY (`id_khuyen_mai`,`id_mon`),
  ADD KEY `id_mon` (`id_mon`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_khach_hang` (`id_khach_hang`),
  ADD KEY `id_don_hang` (`id_don_hang`);

--
-- Indexes for table `danh_muc_mon`
--
ALTER TABLE `danh_muc_mon`
  ADD PRIMARY KEY (`id_danh_muc_mon`),
  ADD UNIQUE KEY `ten_danh_muc` (`ten_danh_muc`);

--
-- Indexes for table `dat_ban`
--
ALTER TABLE `dat_ban`
  ADD PRIMARY KEY (`id_dat_ban`),
  ADD KEY `id_khach_hang` (`id_khach_hang`),
  ADD KEY `id_ban` (`id_ban`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id_don_hang`),
  ADD KEY `id_khach_hang` (`id_khach_hang`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id_khach_hang`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tai_khoan_dang_nhap` (`tai_khoan_dang_nhap`);

--
-- Indexes for table `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  ADD PRIMARY KEY (`id_khuyen_mai`),
  ADD UNIQUE KEY `ten_ctk` (`ten_ctk`);

--
-- Indexes for table `khu_vuc`
--
ALTER TABLE `khu_vuc`
  ADD PRIMARY KEY (`id_khu_vuc`);

--
-- Indexes for table `mon_an`
--
ALTER TABLE `mon_an`
  ADD PRIMARY KEY (`id_mon`),
  ADD KEY `id_danh_muc_mon` (`id_danh_muc_mon`);

--
-- Indexes for table `tai_khoan_reset`
--
ALTER TABLE `tai_khoan_reset`
  ADD PRIMARY KEY (`id_reset`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `id_bai_viet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ban`
--
ALTER TABLE `ban`
  MODIFY `id_ban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `booking_items`
--
ALTER TABLE `booking_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `chinhanh`
--
ALTER TABLE `chinhanh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `danh_muc_mon`
--
ALTER TABLE `danh_muc_mon`
  MODIFY `id_danh_muc_mon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dat_ban`
--
ALTER TABLE `dat_ban`
  MODIFY `id_dat_ban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id_don_hang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id_khach_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `khuyen_mai`
--
ALTER TABLE `khuyen_mai`
  MODIFY `id_khuyen_mai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khu_vuc`
--
ALTER TABLE `khu_vuc`
  MODIFY `id_khu_vuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mon_an`
--
ALTER TABLE `mon_an`
  MODIFY `id_mon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tai_khoan_reset`
--
ALTER TABLE `tai_khoan_reset`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `bai_viet_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL;

--
-- Constraints for table `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `ban_ibfk_1` FOREIGN KEY (`id_khu_vuc`) REFERENCES `khu_vuc` (`id_khu_vuc`) ON DELETE SET NULL;

--
-- Constraints for table `chi_tiet_dat_ban`
--
ALTER TABLE `chi_tiet_dat_ban`
  ADD CONSTRAINT `chi_tiet_dat_ban_ibfk_1` FOREIGN KEY (`id_dat_ban`) REFERENCES `dat_ban` (`id_dat_ban`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_dat_ban_ibfk_2` FOREIGN KEY (`id_mon`) REFERENCES `mon_an` (`id_mon`);

--
-- Constraints for table `chi_tiet_khuyen_mai`
--
ALTER TABLE `chi_tiet_khuyen_mai`
  ADD CONSTRAINT `chi_tiet_khuyen_mai_ibfk_1` FOREIGN KEY (`id_khuyen_mai`) REFERENCES `khuyen_mai` (`id_khuyen_mai`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_khuyen_mai_ibfk_2` FOREIGN KEY (`id_mon`) REFERENCES `mon_an` (`id_mon`);

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id_khach_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`id_don_hang`) REFERENCES `don_hang` (`id_don_hang`) ON DELETE SET NULL;

--
-- Constraints for table `dat_ban`
--
ALTER TABLE `dat_ban`
  ADD CONSTRAINT `dat_ban_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id_khach_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `dat_ban_ibfk_2` FOREIGN KEY (`id_ban`) REFERENCES `ban` (`id_ban`) ON DELETE SET NULL;

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id_khach_hang`) ON DELETE CASCADE;

--
-- Constraints for table `mon_an`
--
ALTER TABLE `mon_an`
  ADD CONSTRAINT `mon_an_ibfk_1` FOREIGN KEY (`id_danh_muc_mon`) REFERENCES `danh_muc_mon` (`id_danh_muc_mon`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
