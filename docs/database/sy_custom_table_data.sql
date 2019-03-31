-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 �?03 �?20 �?04:44
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
-- 表的结构 `sy_custom_table_data`
--

CREATE TABLE IF NOT EXISTS `sy_custom_table_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `database_id` int(11) NOT NULL DEFAULT '0',
  `table_id` int(11) NOT NULL DEFAULT '0',
  `content` text,
  `data_desc` varchar(64) DEFAULT NULL,
  `data_type` tinyint(4) DEFAULT '0',
  `data_status` tinyint(4) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sy_custom_table_data`
--

INSERT INTO `sy_custom_table_data` (`id`, `database_id`, `table_id`, `content`, `data_desc`, `data_type`, `data_status`, `create_time`, `update_time`) VALUES
(1, 1, 1, '{"cell1":"苹果A1","cell2":"规格01","cell3":"型号01"}', NULL, 0, 0, 0, 0),
(2, 1, 1, '{"cell1":"苹果A2","cell2":"规格02","cell3":"型号02"}', NULL, 0, 0, 0, 0),
(3, 1, 1, '{"cell1":"苹果A3","cell2":"规格03","cell3":"型号03"}', NULL, 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
