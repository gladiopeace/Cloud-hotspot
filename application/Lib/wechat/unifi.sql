/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.134
Source Server Version : 50549
Source Host           : 192.168.0.134:3306
Source Database       : unifi

Target Server Type    : MYSQL
Target Server Version : 50549
File Encoding         : 65001

Date: 2016-07-21 23:53:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mac_ID` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fromUserName` varchar(255) DEFAULT NULL,
  `ap` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for verify_code
-- ----------------------------
DROP TABLE IF EXISTS `verify_code`;
CREATE TABLE `verify_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Mac_ID` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for weixin_table
-- ----------------------------
DROP TABLE IF EXISTS `weixin_table`;
CREATE TABLE `weixin_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Mac_ID` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fromUserName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
