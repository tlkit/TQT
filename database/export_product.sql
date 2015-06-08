/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-06-08 07:57:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for export_product
-- ----------------------------
DROP TABLE IF EXISTS `export_product`;
CREATE TABLE `export_product` (
  `export_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `customers_id` int(11) NOT NULL DEFAULT '0',
  `export_product_price` int(11) DEFAULT '0',
  `export_product_num` int(11) DEFAULT '0',
  `export_product_subtotal` int(11) DEFAULT '0',
  `export_product_discount` int(11) DEFAULT '0',
  `export_product_discount_customer` int(11) DEFAULT '0',
  `export_product_total` int(11) DEFAULT '0',
  `export_report_status` int(11) DEFAULT '1',
  `export_product_create_id` int(11) DEFAULT NULL,
  `export_product_create_time` int(11) DEFAULT NULL,
  `export_product_update_id` int(11) DEFAULT NULL,
  `export_product_update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`export_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
