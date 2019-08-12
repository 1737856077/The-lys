/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.188
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : oldyouqianhuan

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-08 15:10:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `w_about`
-- ----------------------------
DROP TABLE IF EXISTS `w_about`;
CREATE TABLE `w_about` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `n_content` text,
  `n_title` varchar(255) DEFAULT NULL COMMENT '标题',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='关于我们';

-- ----------------------------
-- Records of w_about
-- ----------------------------
INSERT INTO `w_about` VALUES ('1', '<span style=\"font-size:14px;\"> \n<p style=\"color:#2E2E2E;font-weight:bold;font-family:微软雅黑, 宋体, arial;font-size:14px;\">\n	<br />\n</p>\n</span>', '关于我们');
INSERT INTO `w_about` VALUES ('4', '代理说明', '代理说明');
INSERT INTO `w_about` VALUES ('2', '', '用户协议');
INSERT INTO `w_about` VALUES ('3', '<span style=\"font-size:16px;\"> \n<p style=\"text-align:left;font-size:16px;color:#333333;font-family:arial;background-color:#FFFFFF;\">\n	<br />\n</p>\n</span>', '常见问题');

-- ----------------------------
-- Table structure for `w_admin`
-- ----------------------------
DROP TABLE IF EXISTS `w_admin`;
CREATE TABLE `w_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `w_name` varchar(255) NOT NULL,
  `w_pass` varchar(255) NOT NULL,
  `w_nick` varchar(255) NOT NULL,
  `w_type` tinyint(1) NOT NULL,
  `w_ctime` int(10) NOT NULL,
  `w_ltime` int(10) NOT NULL,
  `w_role` int(10) DEFAULT '0' COMMENT '用户权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台账户';

-- ----------------------------
-- Records of w_admin
-- ----------------------------
INSERT INTO `w_admin` VALUES ('1', '18888888888', 'e10adc3949ba59abbe56e057f20f883e', '系统管理员', '1', '0', '1565074069', '1');
INSERT INTO `w_admin` VALUES ('2', '18888888882', 'e10adc3949ba59abbe56e057f20f883e', '小刘', '1', '1559719172', '1564506213', '2');

-- ----------------------------
-- Table structure for `w_agent`
-- ----------------------------
DROP TABLE IF EXISTS `w_agent`;
CREATE TABLE `w_agent` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '代理id',
  `a_name` char(50) NOT NULL COMMENT '代理名称',
  `a_level` int(10) NOT NULL COMMENT '代理级别',
  `a_benefit` int(10) NOT NULL COMMENT '总价比率',
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='代理商等级表';

-- ----------------------------
-- Records of w_agent
-- ----------------------------
INSERT INTO `w_agent` VALUES ('1', '镇代理', '1', '95');
INSERT INTO `w_agent` VALUES ('2', '区代理', '2', '90');
INSERT INTO `w_agent` VALUES ('3', '市代理', '3', '85');
INSERT INTO `w_agent` VALUES ('4', '省总代理', '4', '80');
INSERT INTO `w_agent` VALUES ('5', '全国代理', '5', '75');

-- ----------------------------
-- Table structure for `w_apply`
-- ----------------------------
DROP TABLE IF EXISTS `w_apply`;
CREATE TABLE `w_apply` (
  `l_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '代理商申请表id',
  `l_uid` int(10) NOT NULL COMMENT '申请用户id',
  `l_name` char(50) NOT NULL COMMENT '申请姓名',
  `l_tel` char(50) NOT NULL COMMENT '联系电话',
  `l_weichat` char(50) NOT NULL COMMENT '联系微信',
  `l_atime` int(10) NOT NULL COMMENT '申请时间',
  `l_ctime` int(10) NOT NULL COMMENT '同意时间',
  `l_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `l_level` int(10) NOT NULL COMMENT '想要申请的等级',
  PRIMARY KEY (`l_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理商申请表';

-- ----------------------------
-- Records of w_apply
-- ----------------------------

-- ----------------------------
-- Table structure for `w_auth`
-- ----------------------------
DROP TABLE IF EXISTS `w_auth`;
CREATE TABLE `w_auth` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '权限表',
  `a_name` varchar(255) NOT NULL COMMENT '权限名称',
  `a_ctl` varchar(255) NOT NULL DEFAULT 'shop' COMMENT '权限控制器',
  `a_fun` varchar(255) NOT NULL COMMENT '方法',
  `a_level` int(10) NOT NULL DEFAULT '1' COMMENT '等级',
  `a_addtime` int(10) NOT NULL DEFAULT '1558688852' COMMENT '添加时间',
  `a_pid` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of w_auth
-- ----------------------------
INSERT INTO `w_auth` VALUES ('1', '后台首页', 'index', 'index', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('2', '首页统计', 'index', 'main', '2', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('3', '修改密码', 'index', 'changepwd', '2', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('4', '后台账户', 'index', 'admin', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('6', '添加账户', 'index', 'addadmin', '2', '1558688852', '4');
INSERT INTO `w_auth` VALUES ('7', '编辑账户', 'index', 'editadmin ', '2', '1558688852', '4');
INSERT INTO `w_auth` VALUES ('8', '审核账户', 'index', 'shen', '2', '1558688852', '4');
INSERT INTO `w_auth` VALUES ('9', '删除账户', 'index', 'del ', '2', '1558688852', '4');
INSERT INTO `w_auth` VALUES ('10', '角色列表', 'index', 'role_index ', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('12', '角色添加', 'index', 'role_add ', '2', '1558688852', '10');
INSERT INTO `w_auth` VALUES ('13', '角色编辑', 'index', 'role_edit ', '2', '1558688852', '10');
INSERT INTO `w_auth` VALUES ('14', '权限列表', 'index', 'auth_index ', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('16', '权限添加', 'index', 'auth_add ', '2', '1558688852', '14');
INSERT INTO `w_auth` VALUES ('17', '权限编辑', 'index', 'auth_edit ', '2', '1558688852', '14');
INSERT INTO `w_auth` VALUES ('18', '会员列表', 'user', 'index', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('19', '会员结构', 'user', 'tree', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('20', '模拟登录', 'user', 'login', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('22', '会员导出', 'user', 'export_list', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('23', '余额明细', 'user', 'logs', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('25', '删除明细', 'user', 'del_log', '2', '1558688852', '23');
INSERT INTO `w_auth` VALUES ('26', '锁定/解锁', 'user', 't_lock', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('27', '用户删除', 'user', 'del', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('28', '添加用户', 'user', 'add_user', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('29', '余额充值', 'user', 'recharge', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('30', '用户回收站', 'user', 'recover_user', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('32', '移出回收站', 'user', 'user_reply', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('33', '彻底删除', 'user', 'user_del', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('34', '编辑用户', 'user', 'edit_user', '2', '1558688852', '18');
INSERT INTO `w_auth` VALUES ('35', '资料审核', 'user', 'wlogs', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('36', '删除审核', 'user', 'del_w', '2', '1558688852', '35');
INSERT INTO `w_auth` VALUES ('37', '审核通过', 'user', 'done_w', '2', '1558688852', '35');
INSERT INTO `w_auth` VALUES ('39', '投诉处理列表', 'user', 'mlogs', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('41', '删除投诉', 'user', 'del_m', '2', '1558688852', '39');
INSERT INTO `w_auth` VALUES ('42', '处理投诉', 'user', 'done_m', '2', '1558688852', '39');
INSERT INTO `w_auth` VALUES ('44', '升级列表', 'user', 'uplevel', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('45', '删除升级数据', 'user', 'del_up', '2', '1558688852', '44');
INSERT INTO `w_auth` VALUES ('46', '审核升级', 'user', 'shen_up', '2', '1558688852', '44');
INSERT INTO `w_auth` VALUES ('47', '站点设置', 'config', 'basic', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('48', '别名开关', 'config', 'switchlevel', '2', '1558688852', '67');
INSERT INTO `w_auth` VALUES ('49', '信息编辑', 'config', 'about', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('50', '信誉设置', 'config', 'save_credit', '2', '1558688852', '47');
INSERT INTO `w_auth` VALUES ('51', '短信设置', 'config', 'sms', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('53', '首页菜单', 'config', 'style', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('54', '添加菜单', 'config', 'add_menu', '2', '1558688852', '53');
INSERT INTO `w_auth` VALUES ('55', '移除菜单', 'config', 'removestyle', '2', '1558688852', '53');
INSERT INTO `w_auth` VALUES ('56', '修改升级设置', 'config', 'save_level', '2', '1558688852', '67');
INSERT INTO `w_auth` VALUES ('57', '轮播图列表', 'config', 'banner', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('59', '添加轮播图', 'config', 'banner_add', '2', '1558688852', '57');
INSERT INTO `w_auth` VALUES ('60', '删除轮播图', 'config', 'banner_del', '2', '1558688852', '57');
INSERT INTO `w_auth` VALUES ('61', '编辑轮播图', 'config', 'banner_edit', '2', '1558688852', '57');
INSERT INTO `w_auth` VALUES ('62', '公告管理', 'config', 'notice', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('64', '添加公告', 'config', 'notice_add', '2', '1558688852', '62');
INSERT INTO `w_auth` VALUES ('65', '编辑公告', 'config', 'notice_edit', '2', '1558688852', '62');
INSERT INTO `w_auth` VALUES ('66', '删除公告', 'config', 'notice_del', '2', '1558688852', '62');
INSERT INTO `w_auth` VALUES ('67', '升级设置', 'config', 'level', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('68', '行业分类', 'class', 'cates', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('70', '添加行业分类', 'class', 'addcate', '2', '1558688852', '68');
INSERT INTO `w_auth` VALUES ('71', '编辑行业分类', 'class', 'editcate', '2', '1558688852', '68');
INSERT INTO `w_auth` VALUES ('72', '删除行业分类', 'class', 'delcate', '2', '1558688852', '68');
INSERT INTO `w_auth` VALUES ('73', '课堂分类', 'class', 'index', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('75', '添加课堂类别', 'class', 'class_add', '2', '1558688852', '73');
INSERT INTO `w_auth` VALUES ('76', '编辑课堂类别', 'class', 'class_edit', '2', '1558688852', '73');
INSERT INTO `w_auth` VALUES ('77', '删除课堂类别', 'class', 'class_del', '2', '1558688852', '73');
INSERT INTO `w_auth` VALUES ('78', '产品列表', 'agent', 'product_list', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('80', '添加产品', 'agent', 'product_add', '2', '1558688852', '78');
INSERT INTO `w_auth` VALUES ('81', '编辑产品', 'agent', 'product_edit', '2', '1558688852', '78');
INSERT INTO `w_auth` VALUES ('82', '删除产品', 'agent', 'product_del', '2', '1558688852', '78');
INSERT INTO `w_auth` VALUES ('83', '用户入驻', 'agent', 'agent_apply', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('85', '代理商审核', 'agent', 'apply_sta', '2', '1558688852', '83');
INSERT INTO `w_auth` VALUES ('86', '订单管理', 'agent', 'order_list', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('88', '订单导出', 'agent', 'export_list', '2', '1558688852', '86');
INSERT INTO `w_auth` VALUES ('89', '订单发货', 'agent', 'order_delivery', '2', '1558688852', '86');
INSERT INTO `w_auth` VALUES ('90', '代理等级', 'agent', 'agent_level', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('92', '添加代理', 'agent', 'agent_add_level', '2', '1558688852', '90');
INSERT INTO `w_auth` VALUES ('93', '编辑代理', 'agent', 'agent_edit_level', '2', '1558688852', '90');
INSERT INTO `w_auth` VALUES ('94', '商盟分类', 'shop', 'cates', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('96', '添加商盟分类', 'shop', 'addcate', '2', '1558688852', '94');
INSERT INTO `w_auth` VALUES ('97', '编辑商盟分类', 'shop', 'editcate', '2', '1558688852', '94');
INSERT INTO `w_auth` VALUES ('98', '删除商盟分类', 'shop', 'delcate', '2', '1558688852', '94');
INSERT INTO `w_auth` VALUES ('99', '商户管理', 'shop', 'apply', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('100', '添加商户', 'shop', 'shop_add', '2', '1558688852', '99');
INSERT INTO `w_auth` VALUES ('101', '编辑商户', 'shop', 'shop_edit', '2', '1558688852', '99');
INSERT INTO `w_auth` VALUES ('102', '删除商户', 'shop', 'del', '2', '1558688852', '99');
INSERT INTO `w_auth` VALUES ('104', '商品列表', 'shop', 'goods_index', '1', '1558688852', '0');
INSERT INTO `w_auth` VALUES ('106', '商品添加', 'shop', 'goods_add', '2', '1558688852', '104');
INSERT INTO `w_auth` VALUES ('107', '商品编辑', 'shop', 'goods_edit', '2', '1558688852', '104');
INSERT INTO `w_auth` VALUES ('108', '商品删除', 'shop', 'goods_del', '2', '1558688852', '104');
INSERT INTO `w_auth` VALUES ('109', '审核会员', 'user', 'user_status', '1', '1559096617', '18');
INSERT INTO `w_auth` VALUES ('111', '删除角色', 'index', 'role_del', '1', '1559630188', '10');
INSERT INTO `w_auth` VALUES ('110', '删除入驻申请', 'agent', 'apply_del', '2', '1558688852', '83');
INSERT INTO `w_auth` VALUES ('112', '借款计划', 'user', 'jh_list', '1', '1564196846', '0');

-- ----------------------------
-- Table structure for `w_banner`
-- ----------------------------
DROP TABLE IF EXISTS `w_banner`;
CREATE TABLE `w_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `b_img` varchar(255) DEFAULT '',
  `b_name` varchar(255) DEFAULT '',
  `b_link` varchar(255) DEFAULT '',
  `b_pos` tinyint(1) DEFAULT '0',
  `b_index` int(10) DEFAULT '0',
  `b_time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告图片';

-- ----------------------------
-- Records of w_banner
-- ----------------------------
INSERT INTO `w_banner` VALUES ('1', './static/upload/201907311564573639538.jpg', '有钱还', '', '1', '0', '1564990418');
INSERT INTO `w_banner` VALUES ('2', './static/upload/201907311564573647134.jpg', '有钱还', '', '1', '0', '1564990425');
INSERT INTO `w_banner` VALUES ('7', './static/upload/201907311564573655202.jpg', '有钱还', '', '1', '0', '1564990431');

-- ----------------------------
-- Table structure for `w_cash`
-- ----------------------------
DROP TABLE IF EXISTS `w_cash`;
CREATE TABLE `w_cash` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '计划金额表ID',
  `c_num` decimal(10,2) DEFAULT '0.00' COMMENT '合计金额',
  `c_uid` int(10) DEFAULT NULL COMMENT '用户id',
  `c_time` int(10) DEFAULT NULL COMMENT '修改时间',
  `c_sp_num` decimal(10,2) DEFAULT '0.00' COMMENT '剩余金额',
  `c_ov_num` decimal(10,2) DEFAULT NULL COMMENT '已完成金额 ',
  `c_status` tinyint(1) DEFAULT '0' COMMENT '0未开始  1还款中 2已完成  ',
  `c_dtime` int(10) DEFAULT '0' COMMENT '激活时间',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='用户金额数据表';

-- ----------------------------
-- Records of w_cash
-- ----------------------------

-- ----------------------------
-- Table structure for `w_caten`
-- ----------------------------
DROP TABLE IF EXISTS `w_caten`;
CREATE TABLE `w_caten` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL,
  `c_img` varchar(255) DEFAULT NULL,
  `c_index` int(10) DEFAULT NULL,
  `c_title` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='课堂分类';

-- ----------------------------
-- Records of w_caten
-- ----------------------------
INSERT INTO `w_caten` VALUES ('1', '大咖训练营', './static/upload/201904251556184569019.png', '0', '');
INSERT INTO `w_caten` VALUES ('2', '创客素材库', './static/upload/201904251556184591767.png', '0', '');
INSERT INTO `w_caten` VALUES ('3', '创业时代', './static/upload/201904251556184734905.png', '0', '');
INSERT INTO `w_caten` VALUES ('4', '其他', './static/upload/201904251556184814525.png', '0', '');

-- ----------------------------
-- Table structure for `w_cates`
-- ----------------------------
DROP TABLE IF EXISTS `w_cates`;
CREATE TABLE `w_cates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL,
  `c_img` varchar(255) DEFAULT NULL,
  `c_index` int(10) DEFAULT NULL,
  `c_type` tinyint(1) DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='行业分类';

-- ----------------------------
-- Records of w_cates
-- ----------------------------
INSERT INTO `w_cates` VALUES ('1', '食品饮料', './static/upload/201904251556184008218.png', '0', '1');
INSERT INTO `w_cates` VALUES ('2', '日用百货', './static/upload/201904251556184034782.png', '0', '1');
INSERT INTO `w_cates` VALUES ('3', '美妆个护', './static/upload/201904251556184050002.png', '0', '1');
INSERT INTO `w_cates` VALUES ('4', '手机数码', './static/upload/201904251556184064786.png', '0', '1');
INSERT INTO `w_cates` VALUES ('5', '服装鞋包', './static/upload/201904251556184075532.png', '0', '1');
INSERT INTO `w_cates` VALUES ('6', '母婴用品', './static/upload/201904251556184099035.png', '0', '1');
INSERT INTO `w_cates` VALUES ('7', '户外用品', './static/upload/201904251556184114213.png', '0', '1');
INSERT INTO `w_cates` VALUES ('8', '其他分类', './static/upload/201904251556184122087.png', '0', '1');
INSERT INTO `w_cates` VALUES ('9', '日用百货', './static/upload/201904251556184238660.png', '0', '2');
INSERT INTO `w_cates` VALUES ('10', '保健食品', './static/upload/201904251556184247500.png', '0', '2');
INSERT INTO `w_cates` VALUES ('11', '家用电器', './static/upload/201904251556184341227.png', '0', '2');
INSERT INTO `w_cates` VALUES ('12', '生活服务', './static/upload/201904251556184355907.png', '0', '2');

-- ----------------------------
-- Table structure for `w_class`
-- ----------------------------
DROP TABLE IF EXISTS `w_class`;
CREATE TABLE `w_class` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `n_title` varchar(255) DEFAULT '',
  `n_cate` int(10) DEFAULT '0',
  `n_img` varchar(255) DEFAULT '',
  `n_time` int(10) DEFAULT '0',
  `n_read` int(10) DEFAULT '0',
  `n_index` int(10) DEFAULT '0',
  `n_content` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='平台公告';

-- ----------------------------
-- Records of w_class
-- ----------------------------
INSERT INTO `w_class` VALUES ('6', '0费率还款技巧', '0', './static/upload/201907311564542235967.png', '1564542231', '0', '0', '<img src=\"/kindeditor/attached/image/20190731/20190731110405_86592.jpg\" alt=\"\" />');
INSERT INTO `w_class` VALUES ('3', '如何让他人帮你还款？', '0', './static/upload/201907311564541110537.png', '1564541079', '0', '0', '<img src=\"/kindeditor/attached/image/20190731/20190731104520_79299.jpg\" alt=\"\" />');
INSERT INTO `w_class` VALUES ('5', '如果激活账户进行还款？', '0', './static/upload/201907311564542197673.png', '1564542190', '0', '0', '<img src=\"/kindeditor/attached/image/20190731/20190731110329_40700.jpg\" alt=\"\" />');
INSERT INTO `w_class` VALUES ('4', '借款人不还钱怎么办？', '0', './static/upload/201907311564542111053.png', '1564542086', '0', '0', '借款人不还钱怎么办？');

-- ----------------------------
-- Table structure for `w_config`
-- ----------------------------
DROP TABLE IF EXISTS `w_config`;
CREATE TABLE `w_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `w_name` varchar(255) DEFAULT '' COMMENT '网站名称',
  `w_logo` varchar(255) DEFAULT '' COMMENT '网站LOGO',
  `w_color1` varchar(255) DEFAULT '' COMMENT '系统主色',
  `w_color2` varchar(255) DEFAULT '' COMMENT '系统辅色',
  `w_temp` tinyint(1) DEFAULT '0' COMMENT '首页板式',
  `w_shenhe` tinyint(1) DEFAULT '0' COMMENT '微信审核',
  `w_reg` tinyint(1) DEFAULT '0',
  `w_user` int(10) DEFAULT '0',
  `w_user2` int(10) DEFAULT NULL COMMENT '0',
  `w_hour` int(10) DEFAULT '0',
  `w_notice` varchar(255) DEFAULT '',
  `w_words` text,
  `w_level` int(10) DEFAULT '0' COMMENT '星级设置',
  `w_frame` tinyint(1) DEFAULT '0',
  `w_hualuo` tinyint(1) DEFAULT '0' COMMENT '滑落设置',
  `w_huanum` int(10) DEFAULT '0' COMMENT '滑落数量',
  `w_hlevel` int(10) DEFAULT '0' COMMENT '滑落级别',
  `w_xinyu` tinyint(1) DEFAULT '0' COMMENT '是否开启信誉',
  `w_xinyu2` int(10) DEFAULT '0' COMMENT '最大分数',
  `w_xinyu1` int(10) DEFAULT '0' COMMENT '初始分数',
  `w_ping3` int(10) DEFAULT NULL,
  `w_ping2` int(10) DEFAULT NULL,
  `w_ping1` int(10) DEFAULT NULL,
  `w_ping` tinyint(1) DEFAULT '0',
  `w_online` tinyint(1) DEFAULT '0',
  `w_kefu` varchar(255) DEFAULT '',
  `w_tel` varchar(255) DEFAULT '',
  `w_lineurl` varchar(255) DEFAULT '',
  `w_linecode` varchar(255) DEFAULT NULL,
  `w_icon` varchar(255) DEFAULT NULL,
  `w_down2` varchar(255) DEFAULT NULL,
  `w_down1` varchar(255) DEFAULT NULL,
  `w_price` tinyint(1) DEFAULT '0' COMMENT '启用价格',
  `w_nick` tinyint(1) DEFAULT '0' COMMENT '启用别名',
  `w_shiming` tinyint(1) DEFAULT '0' COMMENT '实名认证',
  `w_pattern` tinyint(1) DEFAULT '1' COMMENT '1节点人和推荐人不一致 一单推荐一单节点  2强制第一单给推荐人,第二单正常匹配  3无论如何全部正常匹配',
  `w_price_num` decimal(10,2) DEFAULT '0.00' COMMENT '价格设置',
  `w_uphb` varchar(255) DEFAULT NULL COMMENT '升级海报',
  `w_yqhb` varchar(255) DEFAULT NULL COMMENT '邀请海报',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统设置';

-- ----------------------------
-- Records of w_config
-- ----------------------------
INSERT INTO `w_config` VALUES ('1', '有钱还', './static/upload/201907311564573099720.png', 'rgba(30, 159, 255, 1)', '', '3', '0', '2', '10672', '10672', '0', '', '', '9', '3', '0', '3', '1', '0', '100', '80', '-1', '0', '1', '1', '1', '客服', '135251107421', '', './static/upload/201904261556270761967.png', './static/upload/201907281564325213406.jpeg', '', '', '1', '1', '1', '1', '200.00', './static/upload/201908051564991832322.jpg', './static/upload/201908051564991841064.jpg');

-- ----------------------------
-- Table structure for `w_jihua`
-- ----------------------------
DROP TABLE IF EXISTS `w_jihua`;
CREATE TABLE `w_jihua` (
  `j_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '计划id',
  `j_uid` int(10) NOT NULL COMMENT '发起计划用户',
  `j_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `j_ctime` int(10) NOT NULL DEFAULT '0' COMMENT '发起时间',
  `j_bor_img` varchar(255) NOT NULL COMMENT '借款凭证',
  `j_type` tinyint(10) NOT NULL DEFAULT '0' COMMENT '借款类型 1信用卡 2房贷 3车贷 4其他',
  `j_status` tinyint(1) DEFAULT '0' COMMENT '借款状态 0发去借款 1审核通过 ',
  `j_dtime` int(10) DEFAULT '0' COMMENT '通过时间',
  PRIMARY KEY (`j_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='还款计划';

-- ----------------------------
-- Records of w_jihua
-- ----------------------------

-- ----------------------------
-- Table structure for `w_level`
-- ----------------------------
DROP TABLE IF EXISTS `w_level`;
CREATE TABLE `w_level` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(255) DEFAULT '',
  `l_user1` int(10) DEFAULT '0',
  `l_level1` int(10) DEFAULT NULL,
  `l_user2` int(10) DEFAULT '0',
  `l_level2` int(10) DEFAULT NULL,
  `l_znum` int(10) DEFAULT '0',
  `l_zlevel` int(10) DEFAULT NULL,
  `l_tnum` int(10) DEFAULT '0',
  `l_tlevel` int(10) DEFAULT NULL,
  `l_nick` varchar(255) DEFAULT '',
  `l_price1` int(10) DEFAULT '0',
  `l_price2` int(10) DEFAULT '0',
  `l_price` int(10) DEFAULT '0' COMMENT '阶段价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='升级设置';

-- ----------------------------
-- Records of w_level
-- ----------------------------
INSERT INTO `w_level` VALUES ('1', 'v1', '1', '0', '2', '9', '0', '0', '0', '0', '第一阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('2', 'v2', '2', '0', '0', '0', '0', '0', '3', '0', '第二阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('3', 'v3', '3', '0', '0', '0', '0', '0', '0', '0', '第三阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('4', 'v4', '4', '0', '0', '0', '0', '0', '0', '0', '第四阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('5', 'v5', '5', '0', '2', '0', '0', '0', '0', '0', '第五阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('6', 'v6', '6', '0', '0', '0', '0', '0', '0', '0', '第六阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('7', 'v7', '7', '0', '0', '0', '0', '0', '0', '0', '第七阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('8', 'v8', '8', '0', '0', '0', '0', '0', '0', '0', '第八阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('9', 'v9', '9', '0', '0', '0', '0', '0', '0', '0', '第九阶段', '0', '0', '0');
INSERT INTO `w_level` VALUES ('10', 'v10', '10', '0', '0', '0', '0', '0', '0', '0', '落英缤纷', '0', '0', '0');
INSERT INTO `w_level` VALUES ('11', 'v11', '11', '0', '0', '0', '0', '0', '0', '0', '红花绿叶', '0', '0', '0');
INSERT INTO `w_level` VALUES ('12', 'v12', '12', '0', '0', '0', '0', '0', '0', '0', '鬼舞枯藤', '0', '0', '0');
INSERT INTO `w_level` VALUES ('13', 'v13', '13', '0', '0', '0', '0', '0', '0', '0', '滴水穿石', '0', '0', '0');
INSERT INTO `w_level` VALUES ('14', 'v14', '14', '0', '0', '0', '0', '0', '0', '0', '雨恨云愁', '0', '0', '0');
INSERT INTO `w_level` VALUES ('15', 'v15', '15', '0', '0', '0', '0', '0', '0', '0', '悬河泻水', '0', '0', '0');
INSERT INTO `w_level` VALUES ('16', 'v16', '16', '0', '0', '0', '0', '0', '0', '0', '怒波狂涛', '0', '0', '0');
INSERT INTO `w_level` VALUES ('17', 'v17', '17', '0', '0', '0', '0', '0', '0', '0', '极地冰寒', '0', '0', '0');
INSERT INTO `w_level` VALUES ('18', 'v18', '18', '0', '0', '0', '0', '0', '0', '0', '搅海翻江', '0', '0', '0');
INSERT INTO `w_level` VALUES ('19', 'v19', '19', '0', '0', '0', '0', '0', '0', '0', '举火焚天', '0', '0', '0');
INSERT INTO `w_level` VALUES ('20', 'v20', '20', '0', '0', '0', '0', '0', '0', '0', '星火燎原', '0', '0', '0');
INSERT INTO `w_level` VALUES ('21', 'v21', '21', '0', '0', '0', '0', '0', '0', '0', '焰天火雨', '0', '0', '0');
INSERT INTO `w_level` VALUES ('22', 'v22', '22', '0', '0', '0', '0', '0', '0', '0', '焦金砾石', '0', '0', '0');
INSERT INTO `w_level` VALUES ('23', 'v23', '23', '0', '0', '0', '0', '0', '0', '0', '魂牵梦萦', '0', '0', '0');
INSERT INTO `w_level` VALUES ('24', 'v24', '24', '0', '0', '0', '0', '0', '0', '0', '炼狱火海', '0', '0', '0');
INSERT INTO `w_level` VALUES ('25', 'v25', '25', '0', '0', '0', '0', '0', '0', '0', '落土飞岩', '0', '0', '0');
INSERT INTO `w_level` VALUES ('26', 'v26', '26', '0', '0', '0', '0', '0', '0', '0', '土没尘埋', '0', '0', '0');
INSERT INTO `w_level` VALUES ('27', 'v27', '27', '0', '0', '0', '0', '0', '0', '0', '山崩地裂', '0', '0', '0');
INSERT INTO `w_level` VALUES ('28', 'v28', '28', '0', '0', '0', '0', '0', '0', '0', '天塌地陷', '0', '0', '0');
INSERT INTO `w_level` VALUES ('29', 'v29', '29', '0', '0', '0', '0', '0', '0', '0', '地束七魄', '0', '0', '0');
INSERT INTO `w_level` VALUES ('30', 'v30', '30', '0', '0', '0', '0', '0', '0', '0', '石破天惊', '0', '0', '0');

-- ----------------------------
-- Table structure for `w_logs`
-- ----------------------------
DROP TABLE IF EXISTS `w_logs`;
CREATE TABLE `w_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `l_uid` int(10) DEFAULT '0' COMMENT '用户id',
  `l_type` tinyint(1) DEFAULT '0' COMMENT '1是余额',
  `l_num` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `l_info` varchar(255) DEFAULT '' COMMENT '备注',
  `l_time` int(10) DEFAULT '0' COMMENT '产生',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of w_logs
-- ----------------------------

-- ----------------------------
-- Table structure for `w_message`
-- ----------------------------
DROP TABLE IF EXISTS `w_message`;
CREATE TABLE `w_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `m_uid` int(10) DEFAULT '0',
  `m_title` varchar(255) DEFAULT '',
  `m_type` tinyint(1) DEFAULT '0',
  `m_infos` varchar(255) DEFAULT '',
  `m_status` tinyint(1) DEFAULT '0',
  `m_ctime` int(10) DEFAULT '0',
  `m_dtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='留言反馈';

-- ----------------------------
-- Records of w_message
-- ----------------------------

-- ----------------------------
-- Table structure for `w_notice`
-- ----------------------------
DROP TABLE IF EXISTS `w_notice`;
CREATE TABLE `w_notice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `n_title` varchar(255) DEFAULT '',
  `n_img` varchar(255) DEFAULT '',
  `n_time` int(10) DEFAULT '0',
  `n_read` int(10) DEFAULT '0' COMMENT '阅读量',
  `n_index` int(10) DEFAULT '0',
  `n_desc` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='平台公告';

-- ----------------------------
-- Records of w_notice
-- ----------------------------
INSERT INTO `w_notice` VALUES ('2', '无忧裂变计划 长期稳定高收入', './static/upload/201907311564542963376.png', '1564542964', '0', '0', '长期稳定高收入');
INSERT INTO `w_notice` VALUES ('3', '担保抵押 平台担保', './static/upload/201907311564542995536.png', '1564542997', '0', '0', '帮助他人还卡赚利息，轻松摆脱债务');
INSERT INTO `w_notice` VALUES ('4', '随借随还 低门槛', './static/upload/201907311564543025476.png', '1564543027', '0', '0', '担保金抵扣利息');
INSERT INTO `w_notice` VALUES ('5', '还房贷 还车贷', './static/upload/201907311564543053043.png', '1564543060', '0', '0', '3-5个月还清百万债务');

-- ----------------------------
-- Table structure for `w_pay`
-- ----------------------------
DROP TABLE IF EXISTS `w_pay`;
CREATE TABLE `w_pay` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '收款ID',
  `p_uid` int(10) NOT NULL COMMENT '收款人id',
  `p_img` varchar(255) NOT NULL COMMENT '收款二维码',
  `p_num` char(50) NOT NULL COMMENT '收款账号',
  `p_addtime` int(10) NOT NULL COMMENT '添加时间',
  `p_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '收款方式 1支付宝 2微信',
  `p_status` tinyint(1) DEFAULT '0' COMMENT '0是  非默认 1是默认',
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='收款方式';

-- ----------------------------
-- Records of w_pay
-- ----------------------------

-- ----------------------------
-- Table structure for `w_role`
-- ----------------------------
DROP TABLE IF EXISTS `w_role`;
CREATE TABLE `w_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `r_name` varchar(255) NOT NULL COMMENT '角色名称',
  `r_auth_ids` text NOT NULL COMMENT '角色权限 ',
  `r_addtime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of w_role
-- ----------------------------
INSERT INTO `w_role` VALUES ('1', '顶级管理员', '0,1,2,3,4,6,7,8,9,10,12,13,14,16,17,18,19,20,22,23,26,27,28,29,30,32,33,34,35,36,37,39,41,42,44,45,46,47,48,67,49,50,51,53,54,55,56,57,59,60,61,62,64,65,66,67,68,70,71,72,73,75,76,77,78,80,81,82,83,85,86,88,89,90,92,93,94,96,97,98,99,100,101,102,104,106,107,108,109,110,111,112,0', '1564196922');
INSERT INTO `w_role` VALUES ('2', '业务管理员', '0,1,2,88,86,0', '1559719465');

-- ----------------------------
-- Table structure for `w_sms`
-- ----------------------------
DROP TABLE IF EXISTS `w_sms`;
CREATE TABLE `w_sms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `w_user_name` varchar(255) DEFAULT '',
  `w_user_pass` varchar(255) DEFAULT '',
  `w_user_reg` tinyint(1) DEFAULT '0',
  `w_user_reg_sms` varchar(255) DEFAULT '',
  `w_user_log` tinyint(1) DEFAULT '0',
  `w_user_log_sms` varchar(255) DEFAULT '',
  `w_user_rep` tinyint(1) DEFAULT '0',
  `w_user_rep_sms` varchar(255) DEFAULT '',
  `w_user_dnt` tinyint(1) DEFAULT '0',
  `w_user_dnt_sms` varchar(255) DEFAULT '0',
  `w_user_snt` tinyint(1) DEFAULT '0',
  `w_user_snt_sms` varchar(255) DEFAULT '',
  `w_user_pay` tinyint(1) DEFAULT '1',
  `w_user_pay_sms` varchar(255) DEFAULT NULL,
  `w_user_sm` tinyint(1) DEFAULT NULL COMMENT '实名认证',
  `w_user_sm_sms` varchar(255) DEFAULT NULL COMMENT '实名认证',
  `w_user_upzw` tinyint(1) DEFAULT NULL COMMENT '上传债务',
  `w_user_upzw_sms` varchar(255) DEFAULT NULL COMMENT '上传债务',
  `w_user_qrsk` tinyint(1) DEFAULT NULL,
  `w_user_qrsk_sms` varchar(255) DEFAULT NULL COMMENT '支付确认',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='短信设置';

-- ----------------------------
-- Records of w_sms
-- ----------------------------
INSERT INTO `w_sms` VALUES ('1', '', '', '0', '【有钱还】尊敬的用户您好，您的注册验证码为{CODE}，5分钟内有效！', '0', '', '0', '【有钱还】尊敬的{NAME}您好，您正在找回密码，验证码为{CODE}，5分钟内有效！', '1', '【有钱还】尊敬的{NAME}您好，您有新的订单，请登录系统查看！', '0', '【有钱还】尊敬的{NAME}您好，您的升级申请已审核通过，请登录系统查看！', '0', '【有钱还】尊敬的{NAME}您好，您正在设置收款码，验证码为{CODE}，5分钟内有效！', '0', '【有钱还】尊敬的{NAME}您好，您的实名认证已审核通过，请尽快到平台查看吧！', '0', '【有钱还】尊敬的{NAME}您好，您的上传的债务已审核通过，请尽快到平台查看吧！', '0', '【有钱还】尊敬的{NAME}您好，您的订单已确认，请尽快到平台查看确认吧！');

-- ----------------------------
-- Table structure for `w_style`
-- ----------------------------
DROP TABLE IF EXISTS `w_style`;
CREATE TABLE `w_style` (
  `s_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '首页样式表',
  `s_name` varchar(255) NOT NULL COMMENT '展示名称',
  `s_icon` varchar(255) NOT NULL COMMENT '图标',
  `s_url` varchar(255) NOT NULL COMMENT '跳转路径',
  `s_display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `s_sort` int(10) NOT NULL COMMENT '排序',
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='首页功能排序表';

-- ----------------------------
-- Records of w_style
-- ----------------------------
INSERT INTO `w_style` VALUES ('38', '在线课堂', '/public/icons/index.school.png', '?m=index&c=school', '0', '6');
INSERT INTO `w_style` VALUES ('39', '平台公告', '/public/icons/index.notice.png', '?m=index&c=notice', '1', '4');
INSERT INTO `w_style` VALUES ('40', '会员登录', '/public/icons/index.login.png', '?m=index&c=login', '0', '0');
INSERT INTO `w_style` VALUES ('41', '帮助注册', '/public/icons/index.helpreg.png', '?m=index&c=helpreg', '1', '0');
INSERT INTO `w_style` VALUES ('42', '会员注册', '/public/icons/index.register.png', '?m=index&c=register', '0', '0');
INSERT INTO `w_style` VALUES ('43', '找回密码', '/public/icons/index.find.png', '?m=index&c=find', '0', '0');
INSERT INTO `w_style` VALUES ('44', '系统首页', '/public/icons/index.index.png', '?m=index&c=index', '0', '0');
INSERT INTO `w_style` VALUES ('45', '人脉圈', '/public/icons/team.index.png', '?m=team&c=index', '0', '0');
INSERT INTO `w_style` VALUES ('46', '我的团队', '/public/icons/team.teams.png', '?m=team&c=teams', '0', '0');
INSERT INTO `w_style` VALUES ('47', '我的直推', '/public/icons/team.user.png', '?m=team&c=user', '1', '1');
INSERT INTO `w_style` VALUES ('48', '我的店铺', '/public/icons/shop.myshop.png', '?m=shop&c=myshop', '1', '2');
INSERT INTO `w_style` VALUES ('49', '发布产品', '/public/icons/shop.ag.png', '?m=shop&c=ag', '0', '0');
INSERT INTO `w_style` VALUES ('50', '热门产品', '/public/icons/shop.gl.png', '?m=shop&c=gl', '0', '7');
INSERT INTO `w_style` VALUES ('51', '商家入驻', '/public/icons/shop.apply.png', '?m=shop&c=apply', '0', '0');
INSERT INTO `w_style` VALUES ('52', '商盟首页', '/public/icons/shop.index.png', '?m=shop&c=index', '0', '0');
INSERT INTO `w_style` VALUES ('53', '会员中心', '/public/icons/user.index.png', '?m=user&c=index', '0', '0');
INSERT INTO `w_style` VALUES ('54', '我的订单', '/public/icons/user.order.png', '?m=user&c=order', '1', '3');
INSERT INTO `w_style` VALUES ('55', '邀请好友', '/public/icons/user.share.png', '?m=user&c=share', '0', '8');
INSERT INTO `w_style` VALUES ('56', '上传头像', '/public/icons/user.avatar.png', '?m=user&c=avatar', '0', '0');
INSERT INTO `w_style` VALUES ('57', '上传二维码', '/public/icons/user.qrcode.png', '?m=user&c=qrcode', '0', '0');
INSERT INTO `w_style` VALUES ('58', '退出登录', '/public/icons/user.logout.png', '?m=user&c=logout', '0', '0');
INSERT INTO `w_style` VALUES ('59', '微信修改记录', '/public/icons/user.wlogs.png', '?m=user&c=wlogs', '0', '0');
INSERT INTO `w_style` VALUES ('60', '个人资料', '/public/icons/user.setting.png', '?m=user&c=setting', '0', '0');
INSERT INTO `w_style` VALUES ('61', '修改密码', '/public/icons/user.repass.png', '?m=user&c=repass', '0', '0');
INSERT INTO `w_style` VALUES ('62', '申请升级', '/public/icons/user.uplevel.png', '?m=user&c=uplevel', '0', '0');
INSERT INTO `w_style` VALUES ('63', '升级记录', '/public/icons/user.logs.png', '?m=user&c=logs', '0', '0');
INSERT INTO `w_style` VALUES ('64', '关于我们', '/public/icons/user.about1.png', '?m=user&c=about&id=1', '0', '0');
INSERT INTO `w_style` VALUES ('65', '用户协议', '/public/icons/user.about2.png', '?m=user&c=about&id=2', '0', '0');
INSERT INTO `w_style` VALUES ('66', '常见问题', '/public/icons/user.about3.png', '?m=user&c=about&id=3', '0', '7');
INSERT INTO `w_style` VALUES ('67', '投诉反馈', '/public/icons/user.message.png', '?m=user&c=message', '1', '5');
INSERT INTO `w_style` VALUES ('68', '投诉记录', '/public/icons/user.mlogs.png', '?m=user&c=mlogs', '0', '0');
INSERT INTO `w_style` VALUES ('69', '代理申请', '/public/icons/agent.apply.png', '?m=agent&c=apply', '0', '8');
INSERT INTO `w_style` VALUES ('70', '代理商城', '/public/icons/agent.agent_shop.png', '?m=agent&c=agent_shop', '0', '0');
INSERT INTO `w_style` VALUES ('71', '余额明细', '/public/icons/agent.agent_alogs.png', '?m=agent&c=agent_alogs', '0', '0');
INSERT INTO `w_style` VALUES ('72', '代理订单', '/public/icons/agent.agent_order.png', '?m=agent&c=agent_order', '0', '0');

-- ----------------------------
-- Table structure for `w_token`
-- ----------------------------
DROP TABLE IF EXISTS `w_token`;
CREATE TABLE `w_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` char(100) DEFAULT NULL COMMENT '秘钥',
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `expire_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `UserId` (`uid`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='用户秘钥表';

-- ----------------------------
-- Records of w_token
-- ----------------------------
INSERT INTO `w_token` VALUES ('1', 'c70a277749654352', '10672', '1565679658', '1565247658');
INSERT INTO `w_token` VALUES ('26', '259e8d5d22e52cf7', '10717', '1565271392', '1564839392');

-- ----------------------------
-- Table structure for `w_uplevel`
-- ----------------------------
DROP TABLE IF EXISTS `w_uplevel`;
CREATE TABLE `w_uplevel` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '还款匹配id',
  `uid` int(10) DEFAULT NULL COMMENT '激活用户id',
  `sid` int(10) DEFAULT NULL COMMENT '审核用户id',
  `level` int(10) DEFAULT NULL COMMENT '激活等级',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0发起 1付款 2通过',
  `c_time` int(10) DEFAULT NULL COMMENT '发起时间',
  `d_time` int(10) DEFAULT NULL COMMENT '审核时间',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `ping` int(10) DEFAULT '0' COMMENT '评分',
  `l_type` tinyint(1) DEFAULT '0' COMMENT '单数',
  `l_pay_img` varchar(255) DEFAULT NULL COMMENT '付款凭证',
  `l_pay_time` int(10) DEFAULT '0' COMMENT '付款时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `sid` (`sid`) USING BTREE,
  KEY `level` (`level`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `c_time` (`c_time`) USING BTREE,
  KEY `d_time` (`d_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='升级记录';

-- ----------------------------
-- Records of w_uplevel
-- ----------------------------
INSERT INTO `w_uplevel` VALUES ('44', '10717', '10672', '1', '0', '1564838696', '0', '200.00', '0', '1', null, '0');
INSERT INTO `w_uplevel` VALUES ('45', '10717', '10672', '1', '0', '1564838696', '0', '200.00', '0', '2', null, '0');

-- ----------------------------
-- Table structure for `w_users`
-- ----------------------------
DROP TABLE IF EXISTS `w_users`;
CREATE TABLE `w_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `m_pid` int(10) DEFAULT '0',
  `m_tid` int(10) DEFAULT '0',
  `m_line` varchar(10000) DEFAULT '',
  `m_level` int(10) DEFAULT '0',
  `m_avatar` varchar(255) DEFAULT '',
  `m_name` varchar(255) DEFAULT '',
  `m_phone` varchar(255) DEFAULT '',
  `m_pass` varchar(255) DEFAULT '',
  `m_credit1` decimal(10,2) DEFAULT '0.00',
  `m_credit2` decimal(10,2) DEFAULT '0.00',
  `m_weixin` varchar(255) DEFAULT '',
  `m_qrcode` varchar(255) DEFAULT '',
  `m_regtime` int(10) DEFAULT '0',
  `m_del` tinyint(1) DEFAULT '0',
  `m_lock` tinyint(1) DEFAULT '0',
  `m_type` tinyint(1) DEFAULT '0' COMMENT '0是前台注册 1是系统默认账号',
  `m_sheng` varchar(255) DEFAULT '',
  `m_shi` varchar(255) DEFAULT '',
  `m_gender` tinyint(1) DEFAULT '0',
  `m_infos` varchar(255) DEFAULT '',
  `m_num` int(10) DEFAULT '0' COMMENT '第一层人数',
  `m_layer` int(10) DEFAULT '0' COMMENT '所在层级',
  `m_score` int(10) DEFAULT '0' COMMENT '信誉分',
  `m_carid` char(50) DEFAULT NULL COMMENT '身份证号',
  `m_carimg` varchar(500) DEFAULT NULL COMMENT '身份证照片',
  `m_zsxm` char(50) DEFAULT NULL COMMENT '真实姓名',
  `m_rz` tinyint(1) DEFAULT '0' COMMENT '是否认证  1是已认证',
  `m_pay_type` tinyint(1) DEFAULT '0' COMMENT '收款方式',
  `m_pay_id` int(10) DEFAULT '0' COMMENT '还款方式ID',
  `m_yqm` char(50) DEFAULT NULL COMMENT '邀请码',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `m_pid` (`m_pid`) USING BTREE,
  KEY `m_tid` (`m_tid`) USING BTREE,
  KEY `m_level` (`m_level`) USING BTREE,
  KEY `m_regtime` (`m_regtime`) USING BTREE,
  KEY `m_del` (`m_del`) USING BTREE,
  KEY `m_lock` (`m_lock`) USING BTREE,
  KEY `m_gender` (`m_gender`) USING BTREE,
  KEY `m_num` (`m_num`) USING BTREE,
  KEY `m_layer` (`m_layer`) USING BTREE,
  FULLTEXT KEY `m_line` (`m_line`),
  FULLTEXT KEY `m_phone` (`m_phone`),
  FULLTEXT KEY `m_sheng` (`m_sheng`),
  FULLTEXT KEY `m_shi` (`m_shi`)
) ENGINE=MyISAM AUTO_INCREMENT=10685 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员账号';

-- ----------------------------
-- Records of w_users
-- ----------------------------
INSERT INTO `w_users` VALUES ('10672', '0', '0', '0,10672', '1', '', '张三', '18888888881', 'e10adc3949ba59abbe56e057f20f883e', '0.00', '0.00', 'wx001', './static/upload/201904291556499248405.jpg', '1552288695', '0', '0', '0', '广东', '广州', '2', '暂无', '0', '1', '80', '513436200005297972', './static/upload/images/20190529/1559096934287.jpg,./static/upload/images/20190529/1559096934708.jpg', '李四', '1', '0', '0', '231asf');

-- ----------------------------
-- Table structure for `w_wlog`
-- ----------------------------
DROP TABLE IF EXISTS `w_wlog`;
CREATE TABLE `w_wlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `l_uid` int(10) DEFAULT '0',
  `l_old` varchar(255) DEFAULT '',
  `l_new` varchar(255) DEFAULT '',
  `l_time` int(10) DEFAULT '0',
  `l_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微信号修改记录';

-- ----------------------------
-- Records of w_wlog
-- ----------------------------
