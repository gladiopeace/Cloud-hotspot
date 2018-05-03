/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50556
Source Host           : 192.168.126.139:3306
Source Database       : youtu

Target Server Type    : MYSQL
Target Server Version : 50556
File Encoding         : 65001

Date: 2018-05-03 11:03:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zh_access_auth
-- ----------------------------
DROP TABLE IF EXISTS `zh_access_auth`;
CREATE TABLE `zh_access_auth` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `accesskey` varchar(64) DEFAULT NULL,
  `access_code` varchar(64) DEFAULT NULL,
  `device_mac` varchar(64) DEFAULT NULL,
  `request_data` text,
  `auth_type` varchar(32) DEFAULT NULL,
  `auth_time` varchar(32) DEFAULT NULL,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '//update for the time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_access_auth
-- ----------------------------

-- ----------------------------
-- Table structure for zh_config
-- ----------------------------
DROP TABLE IF EXISTS `zh_config`;
CREATE TABLE `zh_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(255) DEFAULT NULL,
  `config_content` text,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_config
-- ----------------------------

-- ----------------------------
-- Table structure for zh_hotspot_banner
-- ----------------------------
DROP TABLE IF EXISTS `zh_hotspot_banner`;
CREATE TABLE `zh_hotspot_banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `bid` int(10) NOT NULL,
  `accesskey` varchar(64) NOT NULL,
  `thumb` varchar(128) NOT NULL,
  `url` varchar(64) DEFAULT NULL,
  `title` varchar(32) NOT NULL,
  `content` varchar(128) NOT NULL,
  `order` int(2) NOT NULL,
  `addtime` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accesskey` (`accesskey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_hotspot_banner
-- ----------------------------

-- ----------------------------
-- Table structure for zh_hotspot_branch
-- ----------------------------
DROP TABLE IF EXISTS `zh_hotspot_branch`;
CREATE TABLE `zh_hotspot_branch` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '//id',
  `uid` int(10) NOT NULL COMMENT '//商家id',
  `normal_tid` int(10) NOT NULL COMMENT '//主题ID',
  `wechat_tid` int(10) NOT NULL COMMENT '//微信主题id',
  `account_tid` int(11) NOT NULL,
  `type` varchar(324) NOT NULL,
  `branch` varchar(32) NOT NULL COMMENT '//标题',
  `address` varchar(64) NOT NULL,
  `access_info` text NOT NULL,
  `point` varchar(32) NOT NULL,
  `qq` tinyint(1) NOT NULL,
  `weibo` tinyint(1) NOT NULL,
  `wechat` tinyint(1) NOT NULL,
  `overdue` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL COMMENT '//密钥',
  `accesscode` varchar(64) NOT NULL,
  `message_total` int(10) NOT NULL DEFAULT '10' COMMENT '//短信余额',
  `notice` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '//状态',
  `addtime` varchar(32) NOT NULL COMMENT '//添加时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `salt` (`salt`),
  KEY `salt_2` (`salt`),
  KEY `salt_3` (`salt`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_hotspot_branch
-- ----------------------------

-- ----------------------------
-- Table structure for zh_hotspot_slider
-- ----------------------------
DROP TABLE IF EXISTS `zh_hotspot_slider`;
CREATE TABLE `zh_hotspot_slider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `bid` int(10) NOT NULL,
  `accesskey` varchar(64) NOT NULL,
  `thumb` varchar(128) NOT NULL,
  `title` varchar(32) NOT NULL,
  `content` varchar(128) NOT NULL,
  `order` int(2) NOT NULL,
  `addtime` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accesskey` (`accesskey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_hotspot_slider
-- ----------------------------

-- ----------------------------
-- Table structure for zh_hotspot_users
-- ----------------------------
DROP TABLE IF EXISTS `zh_hotspot_users`;
CREATE TABLE `zh_hotspot_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '//id',
  `usercode` varchar(32) DEFAULT NULL,
  `accesskey` int(64) NOT NULL,
  `name` varchar(64) NOT NULL COMMENT '//设备id',
  `username` varchar(32) NOT NULL COMMENT '//用户名',
  `password` varchar(32) NOT NULL COMMENT '//密码',
  `email` varchar(64) NOT NULL,
  `start_time` varchar(64) NOT NULL,
  `end_time` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '//备注',
  `addtime` varchar(32) NOT NULL COMMENT '//增加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_hotspot_users
-- ----------------------------

-- ----------------------------
-- Table structure for zh_mail
-- ----------------------------
DROP TABLE IF EXISTS `zh_mail`;
CREATE TABLE `zh_mail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `type` varchar(64) NOT NULL,
  `accesskey` varchar(128) NOT NULL,
  `secretkey` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `addtime` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_mail
-- ----------------------------

-- ----------------------------
-- Table structure for zh_message_code
-- ----------------------------
DROP TABLE IF EXISTS `zh_message_code`;
CREATE TABLE `zh_message_code` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL,
  `bid` int(10) NOT NULL DEFAULT '0',
  `salt` varchar(64) DEFAULT NULL,
  `cellphone` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `code` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `mac` varchar(64) DEFAULT NULL,
  `content` text,
  `status` tinyint(1) DEFAULT NULL,
  `expired` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `addtime` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`,`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_message_code
-- ----------------------------

-- ----------------------------
-- Table structure for zh_themes
-- ----------------------------
DROP TABLE IF EXISTS `zh_themes`;
CREATE TABLE `zh_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `style` varchar(64) NOT NULL,
  `type` int(10) NOT NULL DEFAULT '0' COMMENT '//1为普通主题3.为账号认证2.微信主题',
  `picture` varchar(128) NOT NULL,
  `note` varchar(64) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `zh_themes` (`name`, `style`, `type`, `picture`, `note`, `status`) VALUES ('Portal主题','portal-lite',1,'http://image9.nphoto.net/news/image/201602/19e9354b45146c0a.jpg','手机短信,SMS验证码',1);
INSERT INTO `zh_themes` (`name`, `style`, `type`, `picture`, `note`, `status`) VALUES ('微信主题','wx-style',2,'http://image.cloudshotspot.com/20160108140229145223294947490.jpg','Wi-Fi via Wechat for free',1);
INSERT INTO `zh_themes` (`name`, `style`, `type`, `picture`, `note`, `status`) VALUES ('帐号认证主题','account-hotspot',3,'http://d.5857.com/shiyiuyue_151102/008.jpg','Account for Wi-Fi',1);


-- ----------------------------
-- Records of zh_themes
-- ----------------------------

-- ----------------------------
-- Table structure for zh_themes_copyright
-- ----------------------------
DROP TABLE IF EXISTS `zh_themes_copyright`;
CREATE TABLE `zh_themes_copyright` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `bid` int(10) NOT NULL,
  `accesskey` varchar(64) NOT NULL,
  `title` varchar(64) NOT NULL,
  `company` varchar(128) NOT NULL,
  `type` varchar(32) NOT NULL,
  `screen` varchar(64) NOT NULL,
  `number` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `a_num` int(10) NOT NULL,
  `b_num` int(10) NOT NULL,
  `order` int(2) NOT NULL,
  `addtime` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accesskey` (`accesskey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_themes_copyright
-- ----------------------------

-- ----------------------------
-- Table structure for zh_user
-- ----------------------------
DROP TABLE IF EXISTS `zh_user`;
CREATE TABLE `zh_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `truename` varchar(64) NOT NULL,
  `gender` tinyint(2) unsigned NOT NULL,
  `nickname` varchar(64) NOT NULL,
  `level` tinyint(2) unsigned NOT NULL COMMENT '//等级 6管理员',
  `salt` varchar(128) NOT NULL COMMENT '//加密盐',
  `accesskey` varchar(64) NOT NULL,
  `secretkey` varchar(64) NOT NULL,
  `swap` varchar(128) NOT NULL,
  `year` varchar(32) NOT NULL,
  `vip` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '//是否为商家',
  `branch` varchar(64) NOT NULL,
  `wid` varchar(32) NOT NULL COMMENT '//微信ID',
  `company` varchar(63) NOT NULL COMMENT '//微信名称',
  `thumb` varchar(256) NOT NULL,
  `money` decimal(10,2) unsigned NOT NULL,
  `message` int(10) NOT NULL,
  `credit` decimal(10,2) unsigned NOT NULL,
  `bank` varchar(12) NOT NULL COMMENT '//银行',
  `account` varchar(32) NOT NULL COMMENT '//银行帐号',
  `dist` varchar(20) NOT NULL COMMENT '//地区',
  `fee` varchar(20) NOT NULL COMMENT '//费率',
  `province` varchar(20) NOT NULL COMMENT '//省份',
  `city` varchar(200) NOT NULL COMMENT '//城市',
  `address` varchar(64) DEFAULT NULL,
  `cellphone` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `job` varchar(32) NOT NULL,
  `addtime` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_user
-- ----------------------------

-- ----------------------------
-- Table structure for zh_wifiapi
-- ----------------------------
DROP TABLE IF EXISTS `zh_wifiapi`;
CREATE TABLE `zh_wifiapi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `bid` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `appid` varchar(64) NOT NULL,
  `shopid` varchar(64) NOT NULL,
  `secretkey` varchar(64) NOT NULL,
  `accesskey` varchar(64) NOT NULL,
  `ssid` varchar(64) NOT NULL,
  `bssid` varchar(64) NOT NULL,
  `addtime` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_wifiapi
-- ----------------------------

-- ----------------------------
-- Table structure for zh_youtu
-- ----------------------------
DROP TABLE IF EXISTS `zh_youtu`;
CREATE TABLE `zh_youtu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `orginazition_id` int(10) NOT NULL,
  `img_id` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `api_url` varchar(125) NOT NULL,
  `download_url` varchar(128) NOT NULL,
  `addtime` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zh_youtu
-- ----------------------------
