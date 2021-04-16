-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 
-- 伺服器版本: 5.7.15-log
-- PHP 版本： 7.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `project4`
--

-- --------------------------------------------------------

--
-- 資料表結構 `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `area`
--

INSERT INTO `area` (`area_id`, `area_name`) VALUES
(1, '中山區'),
(2, '松山區'),
(3, '信義區'),
(4, '文山區'),
(5, '士林區'),
(6, '北投區'),
(7, '大安區'),
(8, '中正區'),
(9, '萬華區'),
(10, '南港區'),
(11, '大同區'),
(12, '內湖區');

-- --------------------------------------------------------

--
-- 資料表結構 `mb`
--

CREATE TABLE `mb` (
  `mb_id` int(11) NOT NULL,
  `mb_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mb_content` text COLLATE utf8_unicode_ci NOT NULL,
  `mb_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `mb`
--

INSERT INTO `mb` (`mb_id`, `mb_name`, `mb_content`, `mb_time`) VALUES
(1, 'TEST0', 'TEST0TEST0TEST0', '2021-01-24 09:36:48'),
(2, 'TEST0-2', 'TEST0-2TEST0-2TEST0-2TEST0-2TEST0-2', '2021-01-24 09:36:53');

-- --------------------------------------------------------

--
-- 資料表結構 `mem`
--

CREATE TABLE `mem` (
  `mem_id` int(11) NOT NULL,
  `mem_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mem_mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mem_pwd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mem_level` int(11) NOT NULL DEFAULT '1',
  `mem_chkcode` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `mem`
--

INSERT INTO `mem` (`mem_id`, `mem_name`, `mem_mail`, `mem_pwd`, `mem_level`, `mem_chkcode`) VALUES
(1, 'ts009', 'ts009@gmail.com', 'ts1234', 9, NULL),
(2, 'test001', 'test001@gmail.com', 'ts1234', 2, NULL),
(3, 'test002', 'test002@gmail.com', 'ts1234', 2, NULL),
(4, 'test003', 'test003@gmail.com', 'ts1234', 2, NULL),
(5, 'ts999', 'ts999@gmail.com', 'ts1234', 9, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `orderlist`
--

CREATE TABLE `orderlist` (
  `order_id` int(11) NOT NULL,
  `order_mem_id` int(10) NOT NULL,
  `order_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_store_id` int(11) DEFAULT NULL,
  `order_store_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_phone` text COLLATE utf8_unicode_ci,
  `order_tele` text COLLATE utf8_unicode_ci,
  `order_size` text COLLATE utf8_unicode_ci,
  `order_time_arrive` datetime DEFAULT NULL,
  `order_time_get` datetime DEFAULT NULL,
  `order_time_buy` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_pic` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_memo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `orderlist`
--

INSERT INTO `orderlist` (`order_id`, `order_mem_id`, `order_name`, `order_mail`, `order_store_id`, `order_store_name`, `order_phone`, `order_tele`, `order_size`, `order_time_arrive`, `order_time_get`, `order_time_buy`, `order_pic`, `order_memo`) VALUES
(28, 1, 'ts009', 'ts009@gmail.com', 38, 'MOOD 木的生活 中山店', '0911111111', '07777777', 'S型:50公分以下，20公斤以內', '2021-02-18 00:00:00', '2021-02-19 00:00:00', '2021-02-18 18:38:43', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `store_area_id` int(10) NOT NULL,
  `store_phone` varchar(50) NOT NULL,
  `store_address` varchar(50) NOT NULL,
  `store_time_open` varchar(50) NOT NULL,
  `store_time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `store_memo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `store_area_id`, `store_phone`, `store_address`, `store_time_open`, `store_time_add`, `store_memo`) VALUES
(38, 'MOOD 木的生活 中山店', 1, '0911555555', 'MOOD 木的生活 中山店', '早上10點到下午5點', '2021-02-18 07:45:57', ''),
(40, 'MOOD 木的生活 松山店', 2, '0911555555', 'MOOD 木的生活 松山店', '早上10點到下午5點', '2021-02-18 08:29:23', ''),
(41, '聽咕 最棒!2', 1, '0911555555', '聽咕 TEAM GROUP 中山店', '早上10點到下午5點', '2021-02-18 08:30:44', ''),
(42, 'zoeywin_photo 中山店', 1, '0911111111', 'zoeywin_photo 中山店', '', '2021-02-18 14:53:15', NULL),
(43, 'Le Caféisme 中山店', 1, '0911111111', 'Le Caféisme 中山店', '', '2021-02-18 14:53:15', NULL),
(44, '聽咕 TEAM GROUP 信義店', 3, '0913333333', '聽咕 信義店', '', '2021-02-18 14:53:15', ''),
(45, 'zoeywin_photo 信義店', 3, '0933333333', 'zoeywin_photo 信義店', '', '2021-02-18 14:53:15', NULL),
(46, 'Le Caféisme 信義店', 3, '0933333333', 'Le Caféisme 信義店', '', '2021-02-18 14:53:15', NULL);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- 資料表索引 `mb`
--
ALTER TABLE `mb`
  ADD PRIMARY KEY (`mb_id`);

--
-- 資料表索引 `mem`
--
ALTER TABLE `mem`
  ADD PRIMARY KEY (`mem_id`);

--
-- 資料表索引 `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`order_id`);

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- 使用資料表 AUTO_INCREMENT `mb`
--
ALTER TABLE `mb`
  MODIFY `mb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `mem`
--
ALTER TABLE `mem`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- 使用資料表 AUTO_INCREMENT `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
