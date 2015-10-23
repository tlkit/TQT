/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-10-22 22:44:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sale_list
-- ----------------------------
DROP TABLE IF EXISTS `sale_list`;
CREATE TABLE `sale_list` (
  `sale_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL DEFAULT '0',
  `sale_list_type` int(11) DEFAULT '0' COMMENT '0 : thanh toan , 1 : cong no',
  `sale_list_status` int(11) DEFAULT '1' COMMENT '0 : ẩn ; 1 : hiện',
  `sale_list_code` varchar(255) DEFAULT NULL COMMENT 'Mã bảng kê',
  `sale_list_bill` varchar(255) DEFAULT NULL COMMENT 'hóa đơn gtgt',
  `sale_list_total_pay` int(11) DEFAULT '0' COMMENT 'tổng thanh toán',
  `sale_list_create_id` int(11) DEFAULT '0',
  `sale_list_create_time` int(11) DEFAULT '0',
  `sale_list_pay_id` int(11) DEFAULT '0',
  `sale_list_pay_time` int(11) DEFAULT '0',
  PRIMARY KEY (`sale_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
