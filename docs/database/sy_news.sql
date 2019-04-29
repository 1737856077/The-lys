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

 Date: 29/04/2019 13:42:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sy_news
-- ----------------------------
DROP TABLE IF EXISTS `sy_news`;
CREATE TABLE `sy_news`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `contents` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varbinary(400) NULL DEFAULT NULL,
  `index_show` tinyint(1) NULL DEFAULT NULL,
  `admin_id` int(11) NULL DEFAULT NULL,
  `nums` int(11) NULL DEFAULT NULL,
  `static_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `send_author` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `source_address` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sort_rank` int(11) NULL DEFAULT NULL,
  `data_type` tinyint(1) NULL DEFAULT NULL,
  `data_statusint` tinyint(1) NULL DEFAULT NULL,
  `create_date` int(11) NULL DEFAULT NULL,
  `update_date` int(11) NULL DEFAULT NULL,
  `data_status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
