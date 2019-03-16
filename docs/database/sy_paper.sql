-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 �?03 �?16 �?10:04
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lqy_zxpaiban`
--

-- --------------------------------------------------------

--
-- 表的结构 `sy_paper`
--

CREATE TABLE IF NOT EXISTS `sy_paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `thickness` int(11) NOT NULL DEFAULT '0',
  `thickness_unit` varchar(6) NOT NULL DEFAULT 'mm',
  `price` double NOT NULL DEFAULT '0',
  `sort_rank` int(11) DEFAULT '50',
  `data_desc` varchar(64) DEFAULT NULL,
  `data_type` tinyint(1) DEFAULT '0',
  `data_status` tinyint(1) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sy_paper`
--

INSERT INTO `sy_paper` (`id`, `title`, `thickness`, `thickness_unit`, `price`, `sort_rank`, `data_desc`, `data_type`, `data_status`, `create_time`, `update_time`) VALUES
(1, '材质2', 22, 'cm', 0.2, 50, '备注2', 0, 0, 0, 1552726432);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
