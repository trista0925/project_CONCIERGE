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
  `mem_level` int(11) NOT NULL DEFAULT '1' COMMENT '1:註冊未驗證 2:註冊已驗證 9管理者',
  `mem_chkcode` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `mem`
--

INSERT INTO `mem` (`mem_id`, `mem_name`, `mem_mail`, `mem_pwd`, `mem_level`, `mem_chkcode`) VALUES
(1, '999', '999@gmail.com', '999', 9, NULL),
(2, '001', '001@gmail.com', '001', 2, NULL),
(3, '002', '002@gmail.com', '002', 1, '684576');

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
  `order_pic` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_memo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `orderlist`
--

INSERT INTO `orderlist` (`order_id`, `order_mem_id`, `order_name`, `order_mail`, `order_store_id`, `order_store_name`, `order_phone`, `order_tele`, `order_size`, `order_time_arrive`, `order_time_get`, `order_time_buy`, `order_pic`, `order_memo`) VALUES
(1, 1, '王小明', '999@gmail.com', 1, 'MOOD 木的生活 中山店', '0927756583', '0223334566', 'S型:50公分以下，20公斤以內', '2021-04-30 08:15:00', '2021-05-02 08:15:00', '2021-04-30 00:15:45', 'order_1_s.jpg', '請幫我放進冷凍庫'),
(2, 2, '林小美', '001@gmail.com', 13, '聽咕 TEAM GROUP 中山店', '0975627365', '034421567', 'M型:100公分以下，20公斤以內', '2021-05-22 06:26:00', '2021-05-27 06:26:00', '2021-05-21 22:27:07', 'order_2_s.jpg', '易碎物品請勿重壓'),
(3, 1, '陳小華', '999@gmail.com', 14, '聽咕 TEAM GROUP 松山店', '0928475937', '0239858354', 'M型:100公分以下，20公斤以內', '2021-05-25 06:36:00', '2021-05-31 06:36:00', '2021-05-21 22:36:54', 'order_3_s.jpg', '');

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
(1, 'MOOD 木的生活 中山店', 1, '0912345678', '台北市中山區錦州街215號', '09:30–17:00', '2021-05-22 00:00:00', ''),
(2, 'MOOD 木的生活 松山店', 2, '0917653688', '台北市松山區南京東路三段248號', '09:30–22:00', '2021-05-22 00:00:00', ''),
(3, 'MOOD 木的生活 信義區', 3, '0914575436', '台北市信義區松仁路28號B1', '08:30–22:00', '2021-05-22 00:00:00', ''),
(4, 'MOOD 木的生活 文山店', 4, '0924626462', '台北市文山區興隆路三段111號', '07:30–22:00', '2021-05-22 00:00:00', ''),
(5, 'MOOD 木的生活 士林區', 5, '0957245742', '台北市士林區承德路四段67號', '10:30–23:00', '2021-05-22 00:00:00', ''),
(6, 'MOOD 木的生活 北投區', 6, '0917727940', '台北市北投區石牌路二段201號', '07:00–22:00', '2021-05-22 00:00:00', ''),
(7, 'MOOD 木的生活 大安區', 7, '0919385920', '台北市大安區羅斯福路三段301號', '10:30–22:00', '2021-05-22 00:00:00', ''),
(8, 'MOOD 木的生活 中正區', 8, '0942849869', '台北市中正區青島西路7號1樓', '08:30–22:00', '2021-05-22 00:00:00', ''),
(9, 'MOOD 木的生活 萬華區', 9, '0918092840', '台北市萬華區武昌街二段77號', '10:30–22:00', '2021-05-22 00:00:00', ''),
(10, 'MOOD 木的生活 南港區', 10, '0913839489', '台北市南港區忠孝東路七段371號B2', '07:00–22:00', '2021-05-22 00:00:00', ''),
(11, 'MOOD 木的生活 大同區', 11, '0934081084', '台北市大同區保安街11號', '09:30–22:00', '2021-05-22 00:00:00', ''),
(12, 'MOOD 木的生活 內湖區', 12, '0913849138', '台北市內湖區洲子街48號', '10:30–22:00', '2021-05-22 00:00:00', ''),
(13, '聽咕 TEAM GROUP 中山店', 1, '0911555555', '台北市中山區林森北路413號', '12:00–22:00', '2021-05-22 00:00:00', ''),
(14, '聽咕 TEAM GROUP 松山店', 2, '0987654321', '台北市松山區南京東路二段5號', '11:30–23:00', '2021-05-22 00:00:00', ''),
(15, 'zoeywin_photo 中山店', 1, '0911245679', '台北市中山區長春路176號', '07:30–22:00', '2021-05-22 00:00:00', ''),
(16, 'zoeywin_photo 信義店', 3, '0933256664', '台北市信義區仁愛路四段505號', '12:30–23:00', '2021-05-22 00:00:00', ''),
(17, 'Le Caféisme 中山店', 1, '0911114333', '台北市中山區民權西路3號', '07:30–22:00', '2021-05-22 00:00:00', ''),
(18, 'Le Caféisme 信義店', 3, '0933333333', 'Le Caféisme 信義店', '08:00–22:00', '2021-05-22 00:00:00', ''),
(19, 'Le Caféisme 文山店', 4, '0983757286', '台北市文山區汀州路四段88號', '07:30–22:00', '2021-05-21 22:39:38', '');

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
