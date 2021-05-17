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
-- 資料庫： `project_concierge`
--
CREATE DATABASE IF NOT EXISTS `project_concierge` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `project_concierge`;

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
(1, '999', '999@gmail.com', '999', 9, NULL),
(2, '001', '001@gmail.com', '001', 1, NULL),
(3, 'trista', '1234@yahoo.com.tw', '1234', 1, NULL);

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
(60, 1, '王小明', '999@gmail.com', 38, 'MOOD 木的生活 中山店', '0927756583', '0223334566', 'S型:50公分以下，20公斤以內', '2021-04-30 08:15:00', '2021-05-02 08:15:00', '2021-04-30 00:15:45', 'order_60', '請幫我放進冷凍庫'),
(61, 1, '林小美', '999@gmail.com', 39, 'MOOD 木的生活 松山店', '0975627365', '034421567', 'M型:100公分以下，20公斤以內', '2021-04-28 08:32:00', '2021-05-07 08:32:00', '2021-04-30 00:32:56', 'order_61_s', '易碎物品請勿重壓');

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
(38, 'MOOD 木的生活 中山店', 1, '0912345678', '台北市中山區錦州街215號', '09:30–17:00', '2021-02-18 07:45:57', ''),
(39, 'MOOD 木的生活 松山店', 2, '0917653688', '台北市松山區南京東路三段248號', '10:30–22:00', '2021-02-18 08:29:23', ''),
(40, '聽咕 TEAM GROUP 中山店', 1, '0911555555', '台北市中山區林森北路413號', '10:00–22:00', '2021-04-30 00:46:00', ''),
(41, '聽咕 TEAM GROUP 信義店', 3, '0987654321', '台北市信義區信義路五段5號', '10:30–23:00', '2021-02-18 14:53:15', ''),
(42, 'zoeywin_photo 中山店', 1, '0911245679', '台北市中山區長春路176號', '07:30–22:00', '2021-04-24 21:31:28', ''),
(43, 'zoeywin_photo 信義店', 3, '0933256664', '台北市信義區仁愛路四段505號', '12:30–23:00', '2021-04-24 21:31:02', ''),
(44, 'Le Caféisme 中山店', 1, '0911114333', '台北市中山區民權西路3號', '07:30–22:00', '2021-04-24 21:31:43', ''),
(45, 'Le Caféisme 信義店', 3, '0933333333', 'Le Caféisme 信義店', '07:00–22:00', '2021-04-24 21:30:59', '');

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
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- 使用資料表 AUTO_INCREMENT `mb`
--
ALTER TABLE `mb`
  MODIFY `mb_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `mem`
--
ALTER TABLE `mem`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- 使用資料表 AUTO_INCREMENT `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
