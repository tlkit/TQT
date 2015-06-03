/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-06-03 17:15:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for import
-- ----------------------------
DROP TABLE IF EXISTS `import`;
CREATE TABLE `import` (
  `import_id` int(11) NOT NULL,
  `import_code` varchar(255) NOT NULL,
  `providers_id` int(11) NOT NULL DEFAULT '0',
  `import_price` int(11) DEFAULT '0',
  `import_note` text,
  `import_create_id` int(11) DEFAULT NULL,
  `import_create_time` int(11) DEFAULT NULL,
  `import_update_id` int(11) DEFAULT NULL,
  `import_update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`import_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
