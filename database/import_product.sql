/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-06-05 07:35:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for import_product
-- ----------------------------
DROP TABLE IF EXISTS `import_product`;
CREATE TABLE `import_product` (
  `import_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `import_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `import_product_price` int(11) NOT NULL,
  `import_product_num` int(11) NOT NULL,
  `import_product_total` int(11) NOT NULL,
  `import_product_status` int(1) NOT NULL DEFAULT '1' COMMENT '1: hien , 0 : xóa ',
  `import_product_create_id` int(11) DEFAULT NULL,
  `import_product_create_time` int(11) DEFAULT NULL,
  `import_product_update_id` int(11) DEFAULT NULL,
  `import_product_update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`import_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
