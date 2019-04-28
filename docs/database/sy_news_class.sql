/*
 Navicat MySQL Data Transfer

 Source Server         : 发
 Source Server Type    : MySQL
 Source Server Version : 50557
 Source Host           : 122.114.163.11:3306
 Source Schema         : tzs_sindns_com

 Target Server Type    : MySQL
 Target Server Version : 50557
 File Encoding         : 65001

 Date: 28/04/2019 14:14:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sy_news_class
-- ----------------------------
DROP TABLE IF EXISTS `sy_news_class`;
CREATE TABLE `sy_news_class`  (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `father_id` int(11) NOT NULL,
  `level` int(11) NULL DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `index_show` tinyint(1) NULL DEFAULT NULL,
  `static_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'newsList_classid_',
  `product_template_id` int(11) NULL DEFAULT NULL,
  `sort_rank` int(11) NULL DEFAULT NULL,
  `data_type` tinyint(1) NULL DEFAULT NULL,
  `data_status` tinyint(1) NULL DEFAULT NULL,
  `create_date` int(11) NULL DEFAULT NULL,
  `update_date` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`class_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
