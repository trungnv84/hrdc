/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : localhost:3306
Source Database       : hrdc

Target Server Type    : MYSQL
Target Server Version : 60099
File Encoding         : 65001

Date: 2014-04-19 14:30:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `activities`
-- ----------------------------
DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`in`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of activities
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for `divisions`
-- ----------------------------
DROP TABLE IF EXISTS `divisions`;
CREATE TABLE `divisions` (
`id`  int(10) NOT NULL AUTO_INCREMENT ,
`name`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of divisions
-- ----------------------------
BEGIN;
INSERT INTO `divisions` VALUES ('1', 'Web'), ('2', 'iOS'), ('3', 'QA');
COMMIT;

-- ----------------------------
-- Table structure for `human_resources`
-- ----------------------------
DROP TABLE IF EXISTS `human_resources`;
CREATE TABLE `human_resources` (
`id`  int(10) NOT NULL AUTO_INCREMENT ,
`employee_id`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`name`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`user_id`  int(10) NULL DEFAULT 0 ,
`username`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`division_id`  int(10) NULL DEFAULT 0 ,
`role_id`  int(10) NULL DEFAULT 0 ,
`avatar`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`phone`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`email`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`skype`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`position`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=8

;

-- ----------------------------
-- Records of human_resources
-- ----------------------------
BEGIN;
INSERT INTO `human_resources` VALUES ('1', '6371', 'Nguyen Van Trung', '0', 'Trungnv6371', '1', '0', 'Penguins.jpg', '0987654321', 'trungnv6371@setacinq.com', 'trungt12', null), ('2', '6543', 'Hoang Tuan A', '0', 'AnhHT', '1', '0', 'Hydrangeas.jpg', '0987654321', 'AnhHT6543@setacinq.com.vn', 'anhht88', null), ('3', '6987', 'Chien Hoang Long', '0', 'LongHC6987', '2', '0', 'Chrysanthemum.jpg', '0978654321', 'ChienHL6987@setacinq.com.vn', 'chienhl90', null), ('4', '8888', 'Ha Minh Chien', '0', 'ChienHM8888', '3', '0', 'Koala-5.jpg', '123456789', 'ChienHM8888@setacinq.com.vn', 'ChienHM88', null), ('5', '8521', 'ABC', '0', 'ABC', '3', '0', 'Loi dang nhap.png', '54987878', null, null, null), ('6', '8798', 'Hoang Tuan Nhat', '0', 'NhatHT8798', '1', '0', 'Desert.jpg', '0987564321', 'NhatHT8798@setacinq.com.vn', 'NhatHT8798', null), ('7', '555', '5555', '0', null, '1', '0', null, null, null, null, null);
COMMIT;

-- ----------------------------
-- Table structure for `projects`
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
`id`  int(10) NOT NULL AUTO_INCREMENT ,
`name`  varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`short_name`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`image`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`logo`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`icon`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`type`  tinyint(3) UNSIGNED NULL DEFAULT 0 ,
`billable_effort`  int(10) NULL DEFAULT 0 ,
`total_effort`  int(10) NULL DEFAULT 0 ,
`actual_effort`  int(10) NULL DEFAULT 0 ,
`discovery_phase_starts`  int(10) NULL DEFAULT 0 ,
`development_phase_starts`  int(10) NULL DEFAULT 0 ,
`end_development_phase_starts`  int(10) NULL DEFAULT 0 ,
`uat_phase_starts`  int(10) NULL DEFAULT 0 ,
`resources`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`ordering`  int(10) NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of projects
-- ----------------------------
BEGIN;
INSERT INTO `projects` VALUES ('1', 'Best Fashion Friend', 'BFF', null, 'Nexus 4 (7).png', 'Nexus 4 (7).png', '2', '5000', '4500', '0', '1394100000', null, null, null, null, '0'), ('2', 'SellPoint', 'SPT', null, null, null, '1', '0', '0', '0', '1394013600', '1394100000', '1394186400', '1394272800', null, '0'), ('3', 'TiViTz College $avings Game-a-thon', 'TIV', null, null, null, '2', '5000', '5000', '0', '1377943200', '1380535200', '1391076000', '1392372000', null, '0'), ('4', '555', '555', null, null, null, '1', '0', '0', '0', null, null, null, null, null, '0');
COMMIT;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`username`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`password`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`email`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`roles`  tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '0: Dev; 1: Admin; 2: BOM; 3: Chief; 4: PM' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=25

;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'test1', 'pass1', 'test1@example.com', '1'), ('2', 'test2', 'pass2', 'test2@example.com', '1'), ('3', 'test3', 'pass3', 'test3@example.com', '0'), ('4', 'test4', 'pass4', 'test4@example.com', '0'), ('5', 'test5', 'pass5', 'test5@example.com', '0'), ('6', 'test6', 'pass6', 'test6@example.com', '0'), ('7', 'test7', 'pass7', 'test7@example.com', '0'), ('8', 'test8', 'pass8', 'test8@example.com', '0'), ('9', 'test9', 'pass9', 'test9@example.com', '0'), ('10', 'test10', 'pass10', 'test10@example.com', '0'), ('11', 'test11', 'pass11', 'test11@example.com', '0'), ('12', 'test12', 'pass12', 'test12@example.com', '0'), ('13', 'test13', 'pass13', 'test13@example.com', '0'), ('14', 'test14', 'pass14', 'test14@example.com', '0'), ('15', 'test15', 'pass15', 'test15@example.com', '0'), ('16', 'test16', 'pass16', 'test16@example.com', '0'), ('17', 'test17', 'pass17', 'test17@example.com', '0'), ('18', 'test18', 'pass18', 'test18@example.com', '0'), ('19', 'test19', 'pass19', 'test19@example.com', '0'), ('20', 'test20', 'pass20', 'test20@example.com', '0'), ('21', 'test21', 'pass21', 'test21@example.com', '0'), ('22', 'ty', 'd68b7bc0755d4dcca15be3258f76e9ac4a53245b:xUXg8jMzLExTrJITLb~Pkmsmb8jfle4An', null, '0'), ('23', 'admin', 'ca48f94bca966e20e4b4d54ff348532b116a04f5:7rr6qSs6pC0AokkSxcAglT3fHNg8ng6y8KDRlEkxiCRKkEBewsalI_skOFgnR~Dh', 'trungnv6371@setacinq.com.vn', '1'), ('24', 'admin2', '55c5204a65d96e99ef647ccd5acf96e4277ec837:m_3xS~ZeDElFXhYfHwsZ~neDW4nUCLkQcFlfJt3kuA_3', 'trungnv6371@setacinq.com.vn', '3');
COMMIT;

-- ----------------------------
-- Table structure for `working_times`
-- ----------------------------
DROP TABLE IF EXISTS `working_times`;
CREATE TABLE `working_times` (
`id`  int(10) NOT NULL AUTO_INCREMENT ,
`resource_id`  int(10) NULL DEFAULT 0 ,
`project_id`  int(10) NULL DEFAULT 0 ,
`role`  tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '1: PM; 2: TechLead; 3: Main Dev; 4: Supporter' ,
`start_time`  int(10) NULL DEFAULT 0 ,
`end_time`  int(10) NULL DEFAULT 0 ,
`left_point`  int(10) NULL DEFAULT 0 ,
`right_point`  int(10) NULL DEFAULT 0 ,
`status`  tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '1: visible' ,
`note`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=54

;

-- ----------------------------
-- Records of working_times
-- ----------------------------
BEGIN;
INSERT INTO `working_times` VALUES ('51', '1', '2', '0', '1395457660', '1395457200', '0', '52', '0', null), ('52', '1', '3', '4', '1395457200', '1395457809', '51', '53', '1', null), ('53', '1', '1', '4', '1395889740', '0', '52', '0', '1', null);
COMMIT;

-- ----------------------------
-- Auto increment value for `activities`
-- ----------------------------
ALTER TABLE `activities` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for `divisions`
-- ----------------------------
ALTER TABLE `divisions` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for `human_resources`
-- ----------------------------
ALTER TABLE `human_resources` AUTO_INCREMENT=8;

-- ----------------------------
-- Auto increment value for `projects`
-- ----------------------------
ALTER TABLE `projects` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for `users`
-- ----------------------------
ALTER TABLE `users` AUTO_INCREMENT=25;

-- ----------------------------
-- Auto increment value for `working_times`
-- ----------------------------
ALTER TABLE `working_times` AUTO_INCREMENT=54;
