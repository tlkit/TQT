/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-06-11 09:04:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for export
-- ----------------------------
DROP TABLE IF EXISTS `export`;
CREATE TABLE `export` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `export_code` varchar(255) NOT NULL COMMENT 'Mã phiếu xuất',
  `customers_id` int(11) NOT NULL DEFAULT '0',
  `export_customers_address` text COMMENT 'Địa chỉ nhận hàng',
  `export_customers_name` varchar(255) DEFAULT NULL COMMENT 'Người nhận hàng',
  `export_customer_phone` varchar(255) DEFAULT NULL,
  `export_customers_note` text,
  `export_delivery_time` int(11) DEFAULT '0' COMMENT 'Ngày giao hang',
  `export_user_store` int(11) DEFAULT '0' COMMENT 'Nhân viên thủ kho',
  `export_user_cod` int(11) DEFAULT '0' COMMENT 'Nhân viên giao hàng',
  `export_user_customer` varchar(255) DEFAULT NULL,
  `export_subtotal` int(11) DEFAULT '0' COMMENT 'Giá sản phẩm chưa triết khấu',
  `export_total` int(11) DEFAULT '0' COMMENT 'Giá đa chiết khấu',
  `export_total_pay` int(11) DEFAULT NULL COMMENT 'Gia thanh toan , sau khi co vat',
  `export_discount` int(11) DEFAULT '0' COMMENT 'Chiết khấu công ty',
  `export_discount_customer` int(11) DEFAULT '0' COMMENT 'Chiết khấu khách hàng',
  `export_vat` int(11) DEFAULT '0' COMMENT 'Phi VAT',
  `export_status` int(11) DEFAULT '1',
  `export_note` varchar(255) DEFAULT NULL,
  `export_create_id` int(11) DEFAULT NULL,
  `export_create_time` int(11) DEFAULT NULL,
  `export_update_id` int(11) DEFAULT NULL,
  `export_update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
