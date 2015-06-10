/*
Navicat MySQL Data Transfer

Source Server         : vpp
Source Server Version : 50625
Source Host           : 103.56.157.141:3306
Source Database       : vppbanbuon

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2015-06-10 11:30:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categories_discount_customers
-- ----------------------------
DROP TABLE IF EXISTS `categories_discount_customers`;
CREATE TABLE `categories_discount_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_price_discount` int(11) DEFAULT NULL,
  `category_price_hide_discount` int(11) DEFAULT NULL COMMENT 'giá triết khấu ẩn',
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
