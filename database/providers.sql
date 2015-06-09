/*
Navicat MySQL Data Transfer

Source Server         : vpp
Source Server Version : 50625
Source Host           : 103.56.157.141:3306
Source Database       : vppbanbuon

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2015-06-09 10:57:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for providers
-- ----------------------------
DROP TABLE IF EXISTS `providers`;
CREATE TABLE `providers` (
  `providers_id` int(11) NOT NULL AUTO_INCREMENT,
  `providers_Code` varchar(255) DEFAULT NULL,
  `providers_Name` varchar(255) DEFAULT NULL,
  `providers_Address` varchar(255) DEFAULT NULL,
  `providers_StoreAddress` varchar(255) DEFAULT NULL,
  `providers_Phone` varchar(255) DEFAULT NULL,
  `providers_Website` text,
  `providers_Description` varchar(255) DEFAULT NULL,
  `providers_TotalImport` int(255) DEFAULT NULL,
  `providers_TotalExport` int(11) DEFAULT NULL,
  PRIMARY KEY (`providers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of providers
-- ----------------------------
INSERT INTO `providers` VALUES ('1', '', 'Vpp Minh Anh', ' 176 Định Công', ' 176 Định Công', '', 'vanphongpham24.com', ' <p>Nh&agrave; cung cấp số 1</p>', '0', '0');
INSERT INTO `providers` VALUES ('2', '', 'Giấy Phú Khánh', 'Đại Cồ Việt', '', '0436230811', '', '', '0', '0');
INSERT INTO `providers` VALUES ('3', '', 'Vpp Hoàng Minh', '', '82/651 Minh Khai - Hà Nội', '01646101637', 'http://www.vanphongphamhoangminh.com.vn/', '', '0', '0');
INSERT INTO `providers` VALUES ('4', '', 'Vpp Đức Thịnh', '25 Chợ Đồng Xuân', '', '0439281268', '', '', '0', '0');
INSERT INTO `providers` VALUES ('5', '', 'Ngọc Hà', '176 Định Công', '', '0435665400', '', '', '0', '0');
INSERT INTO `providers` VALUES ('6', '', 'Minh Nam', '', '93 Vũ Ngọc Phan, Đống Đa, Hà Nội', '01273104391', 'http://www.minhnamhn.com.vn/', '', '0', '0');
INSERT INTO `providers` VALUES ('7', '', 'Hùng Anh', '', '88 hàng Mã', '0914269205', '', '', '0', '0');
INSERT INTO `providers` VALUES ('8', '', 'TST', '', 'Số 2, Ngõ 71/14 Hoàng Văn Thái, Thanh Xuân, Hà Nội', '0435682354', 'http://vanphongphamtst.com.vn/', '', '0', '0');
INSERT INTO `providers` VALUES ('9', '', 'ton dauki', '', '73 Nguyễn Văn Trỗi', '0973323333', '', '', '0', '0');
INSERT INTO `providers` VALUES ('10', '', 'Tân Lực', '', 'Cảng Hà Nội', '0966404326', '', '', '0', '0');
INSERT INTO `providers` VALUES ('11', '', 'Cty cổ phần thương mại Hải Tường', '', 'A8 - 252 Lương Thế Vinh,Từ Liêm,Hà Nội', '0988309158', '', '', '0', '0');
INSERT INTO `providers` VALUES ('12', '', 'Thiên Long', '', 'Cảng Hà Nội', '0989530687', '', '', '0', '0');
INSERT INTO `providers` VALUES ('13', '', 'Giấy Liên sơn', 'Lạc trung', '', '04) 3636 4646', '', '', '0', '0');
INSERT INTO `providers` VALUES ('14', '', 'Trà My', '', '31 Hàng chiếu', '0439322411', '', '', '0', '0');
INSERT INTO `providers` VALUES ('15', '', 'CÔNG TY TNHH ĐẦU TƯ THƯƠNG MẠI DỊCH VỤ ETEK VIỆT NAM', '', '78 ngõ 41 Phố vọng', '0986052079', '', '', '0', '0');
INSERT INTO `providers` VALUES ('16', '', 'Trí Minh', '', 'Số 41, Dãy B, Ngõ 33, Đường Tân Ấp, Q. Ba Đình, Hà Nội', '0944456688', '', '', '0', '0');
INSERT INTO `providers` VALUES ('17', '', 'VPP Nga Lâm', '', '', '0437669153', '', '', '0', '0');
INSERT INTO `providers` VALUES ('18', '', 'công ty Việt Hương', '', '', '01658214996', 'vanphongpham360.vn', '<p>&nbsp;Cung cấp h&agrave;ng staledatler</p>', '0', '0');
INSERT INTO `providers` VALUES ('19', '', 'Cô mùi', '', '', '0936256835', '', '', '0', '0');
INSERT INTO `providers` VALUES ('20', '', 'Công ty cổ phần giấy Hải Tiến', '', 'Số 05 - K3 ngõ 208 Giải phóng', '0436291079', '', '', '0', '0');
INSERT INTO `providers` VALUES ('21', '', 'Mua ở chợ', '', '', '', '', '', '0', '0');
INSERT INTO `providers` VALUES ('22', '', 'Văn phòng phẩm Hiền Lương', '', 'Số 60 Tôn Thất Tùng', '0435747729', '', '', '0', '0');
INSERT INTO `providers` VALUES ('23', '', 'Siêu thị Co.op mart', '', 'Số 609 trương định phường thịnh liệt quận hoàng mai thành phố Hà Nội', '0436421111', 'www.co-opmart.com.vn', '', '0', '0');
INSERT INTO `providers` VALUES ('24', '', 'Việt Tuấn', '', '', '', '', '', '0', '0');
INSERT INTO `providers` VALUES ('25', '', 'Hà thành', '1', 'Nguyễn Văn trỗi', '', '', '', null, null);
INSERT INTO `providers` VALUES ('26', '', 'Công ty TNHH Hiệp Anh', '', 'Số 177 phố Kim Hoa (Kim Liên), Đống Đa, HN', '04 3 7763928 - 04 39745468 - 04 62751740', 'http://www.vanphongphamhiepanh.com/', '', '0', '0');
