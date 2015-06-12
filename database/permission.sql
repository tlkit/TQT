/*
Navicat MySQL Data Transfer

Source Server         : dev
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : db_vpp

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-06-12 07:13:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_code` varchar(50) NOT NULL COMMENT 'MÃ£ quyá»n',
  `permission_name` varchar(50) NOT NULL COMMENT 'TÃªn quyá»n',
  `permission_status` int(1) NOT NULL DEFAULT '1' COMMENT '1:hiá»‡n , 0:áº©n',
  `permission_group_name` varchar(255) DEFAULT NULL COMMENT 'group ten controller',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('1', 'user_view', 'Xem danh sách tài khoản', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('2', 'user_create', 'Tạo tài khoản', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('3', 'user_edit', 'Sửa tài khoản', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('4', 'user_change_pass', 'Đổi mật khẩu', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('5', 'group_user_view', 'Xem danh sách nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('6', 'group_user_create', 'Tạo nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('7', 'group_user_edit', 'Sửa thông tin nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('8', 'categories_view', 'Xem danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('9', 'categories_create', 'Tạo danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('10', 'categories_edit', 'Sửa danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('11', 'customers_view', 'Xem danh sách khách hàng', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('12', 'customers_create', 'Thêm mới khách hàng', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('13', 'customers_edit', 'Sửa thông tin khách hàng', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('14', 'personnel_view', 'Xem dach sách nhân viên', '1', 'Nhân viên');
INSERT INTO `permission` VALUES ('15', 'personnel_create', 'Thêm nhân viên', '1', 'Nhân viên');
INSERT INTO `permission` VALUES ('16', 'personnel_edit', 'Sửa thông tin nhân viên', '1', 'Nhân viên');
INSERT INTO `permission` VALUES ('17', 'product_view', 'Xem thông tin sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('18', 'product_create', 'Tạo sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('19', 'product_edit', 'Sửa sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('20', 'providers_view', 'Xem danh sách ncc', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('21', 'providers_create', 'Thêm nhà cung cấp', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('22', 'providers_edit', 'Sửa thông tin ncc', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('23', 'import_view', 'Xem phiếu nhập', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('24', 'import_create', 'Lập phiếu nhập', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('25', 'import_edit', 'Hủy phiếu nhập', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('26', 'export_view', 'Xem phiếu xuất', '1', 'Xuất kho');
INSERT INTO `permission` VALUES ('27', 'export_create', 'Lập phiếu xuất', '1', 'Xuất kho');
INSERT INTO `permission` VALUES ('28', 'export_edit', 'Hủy phiếu xuất', '1', 'Xuất kho');
