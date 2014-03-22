/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : localhost:3306
Source Database       : hrdc

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2014-03-22 16:57:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `activities`
-- ----------------------------
DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `in` varchar(20) DEFAULT '',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activities
-- ----------------------------

-- ----------------------------
-- Table structure for `divisions`
-- ----------------------------
DROP TABLE IF EXISTS `divisions`;
CREATE TABLE `divisions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of divisions
-- ----------------------------
INSERT INTO `divisions` VALUES ('1', 'Web');
INSERT INTO `divisions` VALUES ('2', 'iOS');
INSERT INTO `divisions` VALUES ('3', 'QA');

-- ----------------------------
-- Table structure for `human_resources`
-- ----------------------------
DROP TABLE IF EXISTS `human_resources`;
CREATE TABLE `human_resources` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(10) DEFAULT '',
  `name` varchar(60) DEFAULT '',
  `user_id` int(10) DEFAULT '0',
  `username` varchar(60) DEFAULT '',
  `division_id` int(10) DEFAULT '0',
  `role_id` int(10) DEFAULT '0',
  `avatar` varchar(250) DEFAULT '',
  `phone` text,
  `email` varchar(250) DEFAULT '',
  `skype` varchar(60) DEFAULT '',
  `position` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of human_resources
-- ----------------------------
INSERT INTO `human_resources` VALUES ('1', '6371', 'Nguyen Van Trung', '0', 'Trungnv6371', '1', '0', 'Penguins.jpg', '0987654321', 'trungnv6371@setacinq.com', 'trungt12', null);
INSERT INTO `human_resources` VALUES ('2', '6543', 'Hoang Tuan A', '0', 'AnhHT', '1', '0', 'Hydrangeas.jpg', '0987654321', 'AnhHT6543@setacinq.com.vn', 'anhht88', null);
INSERT INTO `human_resources` VALUES ('3', '6987', 'Chien Hoang Long', '0', 'LongHC6987', '2', '0', 'Chrysanthemum.jpg', '0978654321', 'ChienHL6987@setacinq.com.vn', 'chienhl90', null);
INSERT INTO `human_resources` VALUES ('4', '8888', 'Ha Minh Chien', '0', 'ChienHM8888', '3', '0', 'Koala-5.jpg', '123456789', 'ChienHM8888@setacinq.com.vn', 'ChienHM88', null);
INSERT INTO `human_resources` VALUES ('5', '8521', 'ABC', '0', 'ABC', '3', '0', 'Loi dang nhap.png', '54987878', null, null, null);
INSERT INTO `human_resources` VALUES ('6', '8798', 'Hoang Tuan Nhat', '0', 'NhatHT8798', '1', '0', 'Desert.jpg', '0987564321', 'NhatHT8798@setacinq.com.vn', 'NhatHT8798', null);

-- ----------------------------
-- Table structure for `projects`
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT '',
  `short_name` varchar(30) DEFAULT '',
  `image` varchar(250) DEFAULT '',
  `logo` varchar(250) DEFAULT '',
  `icon` varchar(250) DEFAULT '',
  `type` tinyint(3) unsigned DEFAULT '0',
  `billable_effort` int(10) DEFAULT '0',
  `total_effort` int(10) DEFAULT '0',
  `actual_effort` int(10) DEFAULT '0',
  `discovery_phase_starts` int(10) DEFAULT '0',
  `development_phase_starts` int(10) DEFAULT '0',
  `end_development_phase_starts` int(10) DEFAULT '0',
  `uat_phase_starts` int(10) DEFAULT '0',
  `resources` text,
  `ordering` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of projects
-- ----------------------------
INSERT INTO `projects` VALUES ('1', 'Best Fashion Friend', 'BFF', null, 'Nexus 4 (7).png', 'Nexus 4 (7).png', '2', '5000', '4500', '0', '1394100000', null, null, null, null, '0');
INSERT INTO `projects` VALUES ('2', 'SellPoint', 'SPT', null, null, null, '1', '0', '0', '0', '1394013600', '1394100000', '1394186400', '1394272800', null, '0');
INSERT INTO `projects` VALUES ('3', 'TiViTz College $avings Game-a-thon', 'TIV', null, null, null, '2', '5000', '5000', '0', '1377943200', '1380535200', '1391076000', '1392372000', null, '0');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `roles` tinyint(3) DEFAULT '0' COMMENT '0: Dev; 1: Admin; 2: BOM; 3: Chief; 4: PM',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'test1', 'pass1', 'test1@example.com', '1');
INSERT INTO `users` VALUES ('2', 'test2', 'pass2', 'test2@example.com', '1');
INSERT INTO `users` VALUES ('3', 'test3', 'pass3', 'test3@example.com', '0');
INSERT INTO `users` VALUES ('4', 'test4', 'pass4', 'test4@example.com', '0');
INSERT INTO `users` VALUES ('5', 'test5', 'pass5', 'test5@example.com', '0');
INSERT INTO `users` VALUES ('6', 'test6', 'pass6', 'test6@example.com', '0');
INSERT INTO `users` VALUES ('7', 'test7', 'pass7', 'test7@example.com', '0');
INSERT INTO `users` VALUES ('8', 'test8', 'pass8', 'test8@example.com', '0');
INSERT INTO `users` VALUES ('9', 'test9', 'pass9', 'test9@example.com', '0');
INSERT INTO `users` VALUES ('10', 'test10', 'pass10', 'test10@example.com', '0');
INSERT INTO `users` VALUES ('11', 'test11', 'pass11', 'test11@example.com', '0');
INSERT INTO `users` VALUES ('12', 'test12', 'pass12', 'test12@example.com', '0');
INSERT INTO `users` VALUES ('13', 'test13', 'pass13', 'test13@example.com', '0');
INSERT INTO `users` VALUES ('14', 'test14', 'pass14', 'test14@example.com', '0');
INSERT INTO `users` VALUES ('15', 'test15', 'pass15', 'test15@example.com', '0');
INSERT INTO `users` VALUES ('16', 'test16', 'pass16', 'test16@example.com', '0');
INSERT INTO `users` VALUES ('17', 'test17', 'pass17', 'test17@example.com', '0');
INSERT INTO `users` VALUES ('18', 'test18', 'pass18', 'test18@example.com', '0');
INSERT INTO `users` VALUES ('19', 'test19', 'pass19', 'test19@example.com', '0');
INSERT INTO `users` VALUES ('20', 'test20', 'pass20', 'test20@example.com', '0');
INSERT INTO `users` VALUES ('21', 'test21', 'pass21', 'test21@example.com', '0');

-- ----------------------------
-- Table structure for `working_times`
-- ----------------------------
DROP TABLE IF EXISTS `working_times`;
CREATE TABLE `working_times` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `resource_id` int(10) DEFAULT '0',
  `project_id` int(10) DEFAULT '0',
  `role` tinyint(3) unsigned DEFAULT '0' COMMENT '1: PM; 2: TechLead; 3: Main Dev; 4: Supporter',
  `start_time` int(10) DEFAULT '0',
  `end_time` int(10) DEFAULT '0',
  `left_point` int(10) DEFAULT '0',
  `right_point` int(10) DEFAULT '0',
  `status` tinyint(3) unsigned DEFAULT '0' COMMENT '1: visible',
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of working_times
-- ----------------------------
INSERT INTO `working_times` VALUES ('47', '1', '1', '0', '1395457140', '0', '0', '0', '1', null);
