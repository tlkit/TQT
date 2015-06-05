/*
Navicat MySQL Data Transfer

Source Server         : vpp
Source Server Version : 50625
Source Host           : 103.56.157.141:3306
Source Database       : vppbanbuon

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2015-06-05 12:00:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for personnel
-- ----------------------------
DROP TABLE IF EXISTS `personnel`;
CREATE TABLE `personnel` (
  `personnel_id` int(11) NOT NULL AUTO_INCREMENT,
  `personnel_name` varchar(255) NOT NULL,
  `personnel_brithday` int(12) DEFAULT NULL,
  `personnel_village` varchar(255) DEFAULT NULL COMMENT 'Quê quán',
  `personnel_adress_1` varchar(255) DEFAULT NULL COMMENT 'địa chỉ thường trú',
  `personnel_adress_2` varchar(255) DEFAULT NULL COMMENT 'địa chỉ hiện tại',
  `personnel_email` varchar(255) DEFAULT NULL,
  `personnel_phone` varchar(11) DEFAULT '1' COMMENT '-1: xÃ³a , 1: active',
  `personnel_time_star_work` int(12) DEFAULT NULL,
  `personnel_time_out_work` int(11) DEFAULT NULL,
  `personnel_status` tinyint(2) DEFAULT '1' COMMENT 'trạng thái nhân viên: 1:đang làm việc, 2: thực tập: 3: đã nghỉ việc',
  `personnel_user_id` int(11) DEFAULT '0' COMMENT 'id user đăng nhập',
  `personnel_user_name` varchar(255) DEFAULT NULL COMMENT 'tên user đăng nhập',
  PRIMARY KEY (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
