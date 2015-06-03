/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-06-03 17:15:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for import_product
-- ----------------------------
DROP TABLE IF EXISTS `import_product`;
CREATE TABLE `import_product` (
  `import_product_id` int(11) NOT NULL,
  `import_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `import_product_price` int(11) NOT NULL,
  `import_product_num` int(11) NOT NULL,
  `import_product_total` int(11) NOT NULL,
  PRIMARY KEY (`import_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
