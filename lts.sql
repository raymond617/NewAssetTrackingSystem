-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 �?11 ??18 ??06:22
-- 服务器版本: 5.6.11
-- PHP 版本: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lts`
--
CREATE DATABASE IF NOT EXISTS `lts` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lts`;

-- --------------------------------------------------------

--
-- 表的结构 `lts_users`
--

CREATE TABLE IF NOT EXISTS `lts_users` (
  `id` int(8) NOT NULL,
  `level` smallint(1) NOT NULL DEFAULT '0',
  `password` varchar(40) NOT NULL,
  `email` varchar(75) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lts_users`
--

INSERT INTO `lts_users` (`id`, `level`, `password`, `email`, `username`) VALUES
(10302009, 0, '1234567', 's1030200@ouhk.edu.hk', 'Raymond Yuen');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
