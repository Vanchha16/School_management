/*
 Navicat Premium Data Transfer

 Source Server         : SU25
 Source Server Type    : MySQL
 Source Server Version : 80407
 Source Host           : localhost:3306
 Source Schema         : school_management

 Target Server Type    : MySQL
 Target Server Version : 80407
 File Encoding         : 65001

 Date: 11/03/2026 22:47:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for borrows
-- ----------------------------
DROP TABLE IF EXISTS `borrows`;
CREATE TABLE `borrows`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `qty` int UNSIGNED NOT NULL DEFAULT 1,
  `borrow_date` datetime NOT NULL,
  `due_date` date NULL DEFAULT NULL,
  `return_date` datetime NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'BORROWED',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `return_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `condition` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `borrows_student_id_index`(`student_id` ASC) USING BTREE,
  INDEX `borrows_item_id_index`(`item_id` ASC) USING BTREE,
  INDEX `borrows_status_index`(`status` ASC) USING BTREE,
  CONSTRAINT `borrows_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`Itemid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `borrows_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of borrows
-- ----------------------------
INSERT INTO `borrows` VALUES (7, 1, 1, 1, '2026-03-09 20:12:33', NULL, NULL, 'BORROWED', NULL, NULL, NULL, '2026-03-09 20:12:33', '2026-03-09 20:12:33');
INSERT INTO `borrows` VALUES (8, 9, 1, 1, '2026-03-09 20:26:33', NULL, NULL, 'BORROWED', NULL, NULL, NULL, '2026-03-09 20:26:33', '2026-03-09 20:26:33');
INSERT INTO `borrows` VALUES (9, 1, 4, 1, '2026-03-09 20:33:47', NULL, NULL, 'BORROWED', NULL, NULL, NULL, '2026-03-09 20:33:47', '2026-03-09 20:33:47');
INSERT INTO `borrows` VALUES (10, 1, 1, 1, '2026-03-10 15:34:20', NULL, NULL, 'BORROWED', NULL, NULL, NULL, '2026-03-10 15:34:20', '2026-03-10 15:34:20');
INSERT INTO `borrows` VALUES (11, 10, 4, 1, '2026-03-10 15:34:52', NULL, NULL, 'BORROWED', NULL, NULL, NULL, '2026-03-10 15:34:52', '2026-03-10 15:34:52');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `group_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`group_id`) USING BTREE,
  UNIQUE INDEX `groups_group_name_unique`(`group_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 193 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (37, 'DU3', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (38, 'DU1', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (39, 'DU10', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (40, 'DU7', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (41, 'DU5', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (42, 'DU2.6', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (43, 'DU15', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (44, 'DU13.14', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (45, 'DU4', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (46, 'DU8', '2026-03-01 23:42:54', '2026-03-01 23:42:54');
INSERT INTO `groups` VALUES (47, 'SU1.2', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (48, 'SU3', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (49, 'SU4.13', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (50, 'SU5', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (51, 'SU6', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (52, 'SU7.9', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (53, 'SU8', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (54, 'SU10', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (55, 'SU14.23', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (56, 'SU15', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (57, 'SU20', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (58, 'SU24.34', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (59, 'SU25', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (60, 'SU30', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (61, 'SU33.53', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (62, 'SU35', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (63, 'SU40', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (64, 'SU43.44', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (65, 'SU54', '2026-03-01 23:44:18', '2026-03-01 23:44:18');
INSERT INTO `groups` VALUES (66, 'SV1', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (67, 'SV2.6', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (68, 'SV3', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (69, 'SV4.14', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (70, 'SV5', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (71, 'SV7', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (72, 'SV8.16', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (73, 'SV9', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (74, 'SV10', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (75, 'SV11.12', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (76, 'SV13.23', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (77, 'SV15', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (78, 'SV20', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (79, 'SV24.33', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (80, 'SV25', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (81, 'SV30', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (82, 'SV34', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (83, 'SV35', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (84, 'SV40', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (85, 'SV45', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (86, 'SV50', '2026-03-01 23:45:35', '2026-03-01 23:45:35');
INSERT INTO `groups` VALUES (87, 'SW1', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (88, 'SW2', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (89, 'SW3', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (90, 'SW4', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (91, 'SW5', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (92, 'SW6', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (93, 'SW7', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (94, 'SW8', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (95, 'SW9', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (96, 'SW10', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (97, 'SW11', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (98, 'SW13', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (99, 'SW14', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (100, 'SW15', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (101, 'SW20', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (102, 'SW23', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (103, 'SW24', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (104, 'SW25', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (105, 'SW30', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (106, 'SW33', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (107, 'SW34', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (108, 'SW35', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (109, 'SW40', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (110, 'SW43', '2026-03-01 23:47:06', '2026-03-01 23:47:06');
INSERT INTO `groups` VALUES (111, 'SX1', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (112, 'SX2', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (113, 'SX3', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (114, 'SX4', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (115, 'SX5', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (116, 'SX6', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (117, 'SX7', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (118, 'SX8', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (119, 'SX9', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (120, 'SX10', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (121, 'SX11', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (122, 'SX12', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (123, 'SX13', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (124, 'SX14', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (125, 'SX15', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (126, 'SX16', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (127, 'SX17', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (128, 'SX18', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (129, 'SX20', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (130, 'SX23', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (131, 'SX24', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (132, 'SX25', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (133, 'SX33', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (134, 'SX34', '2026-03-01 23:47:45', '2026-03-01 23:47:45');
INSERT INTO `groups` VALUES (135, 'DV1', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (136, 'DV2', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (137, 'DV3', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (138, 'DV4', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (139, 'DV5', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (140, 'DV6', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (141, 'DV7', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (142, 'DV8', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (143, 'DV10', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (144, 'DV13', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (145, 'DV15', '2026-03-01 23:48:49', '2026-03-01 23:48:49');
INSERT INTO `groups` VALUES (146, 'DW1', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (147, 'DW2', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (148, 'DW3', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (149, 'DW4', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (150, 'DW5', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (151, 'DW6', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (152, 'DW7', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (153, 'DW10', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (154, 'DW13', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (155, 'DW14', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (156, 'DW15', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (157, 'DW20', '2026-03-01 23:49:16', '2026-03-01 23:49:16');
INSERT INTO `groups` VALUES (158, 'DX1', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (159, 'DX2', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (160, 'DX3', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (161, 'DX4', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (162, 'DX5', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (163, 'DX6', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (164, 'DX7', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (165, 'DX8', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (166, 'DX10', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (167, 'DX13', '2026-03-01 23:50:03', '2026-03-01 23:50:03');
INSERT INTO `groups` VALUES (168, 'ASK1', '2026-03-01 23:50:41', '2026-03-01 23:50:41');
INSERT INTO `groups` VALUES (169, 'ASK2', '2026-03-01 23:50:41', '2026-03-01 23:50:41');
INSERT INTO `groups` VALUES (170, 'ASK3', '2026-03-01 23:50:41', '2026-03-01 23:50:41');
INSERT INTO `groups` VALUES (171, 'ASK4', '2026-03-01 23:50:41', '2026-03-01 23:50:41');
INSERT INTO `groups` VALUES (172, 'ASK5', '2026-03-01 23:50:41', '2026-03-01 23:50:41');
INSERT INTO `groups` VALUES (173, 'ASK10', '2026-03-01 23:50:41', '2026-03-01 23:50:41');
INSERT INTO `groups` VALUES (174, 'ADK1', '2026-03-01 23:51:09', '2026-03-01 23:51:09');
INSERT INTO `groups` VALUES (175, 'ADK3', '2026-03-01 23:51:09', '2026-03-01 23:51:09');
INSERT INTO `groups` VALUES (176, 'ADK5', '2026-03-01 23:51:09', '2026-03-01 23:51:09');
INSERT INTO `groups` VALUES (177, 'ASL1', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (178, 'ASL2', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (179, 'ASL3', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (180, 'ASL4', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (181, 'ASL5', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (182, 'ASL6', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (183, 'ASL10', '2026-03-01 23:51:42', '2026-03-01 23:51:42');
INSERT INTO `groups` VALUES (184, 'ADL1', '2026-03-01 23:52:14', '2026-03-01 23:52:14');
INSERT INTO `groups` VALUES (185, 'ADL5', '2026-03-01 23:52:14', '2026-03-01 23:52:14');
INSERT INTO `groups` VALUES (186, 'SBP1', '2026-03-01 23:53:05', '2026-03-01 23:53:05');
INSERT INTO `groups` VALUES (187, 'SBP2', '2026-03-01 23:53:05', '2026-03-01 23:53:05');
INSERT INTO `groups` VALUES (188, 'SBP3', '2026-03-01 23:53:05', '2026-03-01 23:53:05');
INSERT INTO `groups` VALUES (189, 'SBP5', '2026-03-01 23:53:05', '2026-03-01 23:53:05');
INSERT INTO `groups` VALUES (190, 'SBO1', '2026-03-01 23:53:30', '2026-03-01 23:53:30');
INSERT INTO `groups` VALUES (191, 'SBO5', '2026-03-01 23:53:30', '2026-03-01 23:53:30');
INSERT INTO `groups` VALUES (192, 'SBN1', '2026-03-01 23:53:52', '2026-03-01 23:53:52');

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `Itemid` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `available` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `qty` int NOT NULL DEFAULT 0,
  `borrow` int NOT NULL DEFAULT 0,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` tinyint NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Itemid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES (1, 'Socket', 0.00, 'items/qVT3amlw9NuXakTcJB0JtZOFsBAcdFy2rIydTAn2.jpg', 27, 0, NULL, 1, '2026-03-06 09:16:16', '2026-03-10 15:34:20');
INSERT INTO `items` VALUES (2, 'Adaptor', 0.00, 'items/mLJ0RxzNjk5qkhHfrFU3pnCtGvMfZKf7nDQ7KGFA.webp', 2, 0, NULL, 1, '2026-03-06 09:19:50', '2026-03-09 12:41:09');
INSERT INTO `items` VALUES (3, 'Mouse', 0.00, 'items/vtWmLXo7layvMY8nMVfLXpknAkAXo9PildN74KPA.jpg', 2, 0, NULL, 1, '2026-03-06 09:20:07', '2026-03-09 13:09:25');
INSERT INTO `items` VALUES (4, 'Keyboard', 0.00, 'items/Jmtr71aruPdqmmuoSUSI5OKWM6kEkk0qxeeUtz57.jpg', 0, 0, NULL, 1, '2026-03-06 09:20:17', '2026-03-10 15:34:52');
INSERT INTO `items` VALUES (5, 'USB', 0.00, 'items/GWW4kDorKBVTrUb5dcN99KLMhMrlXSJiXcGmg90w.jpg', 2, 0, NULL, 1, '2026-03-06 09:20:27', '2026-03-09 09:00:58');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2026_02_24_095304_create_items_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_02_24_101039_add_image_to_items_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_02_26_131746_create_students_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_02_26_170413_create_groups_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_02_26_170542_alter_students_add_group_id_drop_group_name', 1);
INSERT INTO `migrations` VALUES (9, '2026_02_26_190009_add_group_id_to_students_table', 1);
INSERT INTO `migrations` VALUES (10, '2026_02_27_113143_add_id_to_students_table', 1);
INSERT INTO `migrations` VALUES (11, '2026_03_01_080000_create_borrows_table', 1);
INSERT INTO `migrations` VALUES (12, '2026_03_01_084942_add_foreign_keys_to_borrows_table', 1);
INSERT INTO `migrations` VALUES (13, '2026_03_01_091711_add_qty_to_borrows_table', 1);
INSERT INTO `migrations` VALUES (14, '2026_03_01_103012_change_return_date_to_datetime_in_borrows_table', 1);
INSERT INTO `migrations` VALUES (15, '2026_03_01_115624_add_unique_student_group_phone_to_students_table', 1);
INSERT INTO `migrations` VALUES (16, '2026_03_01_120354_add_unique_student_name_group_to_students_table', 1);
INSERT INTO `migrations` VALUES (17, '2026_03_02_015901_add_role_status_to_users_table', 1);
INSERT INTO `migrations` VALUES (18, '2026_03_02_170126_create_student_submissions_table', 1);
INSERT INTO `migrations` VALUES (19, '2026_03_03_080142_add_unique_phone_number_to_students_and_submissions', 1);
INSERT INTO `migrations` VALUES (20, '2026_03_03_103849_add_unique_phone_to_student_submissions', 1);
INSERT INTO `migrations` VALUES (21, '2026_03_03_120753_add_gender_to_students_table', 1);
INSERT INTO `migrations` VALUES (22, '2026_03_09_093500_add_borrow_fields_to_submissions_table', 2);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('1AszCfI5uto4fId6QLOjp2soWBTOnZh5AsTzV83i', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieXBpQ25NWXRHTUVTamZCdmUyd2xrcWJDc2dBdDBOWWQ3Ym12OEdwdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWdpc3Rlci1zdHVkZW50IjtzOjU6InJvdXRlIjtzOjE2OiJzdHVkZW50LnJlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773216405);
INSERT INTO `sessions` VALUES ('E2hKLwAVT9kwLbKS1gTifP3LQutvdqw19p9ECF9p', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFhwdFE3T1dTbnIzZUtEQ2UwZGhjVzVDeFZGV084Z2FRTmtYVzhiRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWdpc3Rlci9jaGVjay1zdHVkZW50LW5hbWU/c3R1ZGVudF9uYW1lPUNodWwlMjBDaGl2b3JuIjtzOjU6InJvdXRlIjtzOjI1OiJyZWdpc3Rlci5jaGVja1N0dWRlbnROYW1lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773134723);
INSERT INTO `sessions` VALUES ('KKdh5k1S5xagNlW9ULWlDFyl0BLHN5YYw8KGeUTs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTXI2VVpleDBENmZpT0xjVFdlQXM0NmlMNE5zVXZ4bTRSdnp6VVl1dSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3N0dWRlbnRzIjtzOjU6InJvdXRlIjtzOjE0OiJzdHVkZW50cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1773213663);
INSERT INTO `sessions` VALUES ('rOdlL2pp01R3FBJe5zD0hKJ0tqjfzKKSD1NVu9gp', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia1RXMnFVSVBZQWRGUTNOdmVzN2p0VGlKZGV0TlhQTmp5UGV4UWVUYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9yZW5hdG8tYmFya3kta25veC5uZ3Jvay1mcmVlLmRldi9hZG1pbi9pdGVtcyI7czo1OiJyb3V0ZSI7czoxMToiaXRlbXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1773213458);
INSERT INTO `sessions` VALUES ('u33RVr34ggNLBCS1R81X0Edl4hlcjhrdU85hkY6c', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHZIRWJMbkJHaUF2M1k0QkJjb0dseTJ1Rk4zYlR2SnRvUllGRFJLdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9yZW5hdG8tYmFya3kta25veC5uZ3Jvay1mcmVlLmRldi9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1773213493);
INSERT INTO `sessions` VALUES ('WsU1ozgPsljkcpZgpZt7zR2mfqOvw05rjl9z3KZA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUmVSMVVvb2R5WWdVZ0tPQWs4bXhEM0JuQUlDTWk0M3dWYlhnNDdvdSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773135172);

-- ----------------------------
-- Table structure for student_submissions
-- ----------------------------
DROP TABLE IF EXISTS `student_submissions`;
CREATE TABLE `student_submissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `group_id` bigint UNSIGNED NULL DEFAULT NULL,
  `item_id` bigint UNSIGNED NULL DEFAULT NULL,
  `qty` int NOT NULL DEFAULT 1,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'BORROWED',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `due_date` date NULL DEFAULT NULL,
  `student_id` bigint UNSIGNED NULL DEFAULT NULL,
  `is_student_existing` tinyint(1) NOT NULL DEFAULT 0,
  `is_student_added` tinyint(1) NOT NULL DEFAULT 0,
  `is_borrow_approved` tinyint(1) NOT NULL DEFAULT 0,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `submissions_phone_number_unique`(`phone_number` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student_submissions
-- ----------------------------

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`  (
  `student_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `group_id` bigint UNSIGNED NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`student_id`) USING BTREE,
  UNIQUE INDEX `students_name_group_unique`(`student_name` ASC, `group_id` ASC) USING BTREE,
  UNIQUE INDEX `students_phone_number_unique`(`phone_number` ASC) USING BTREE,
  INDEX `students_group_id_foreign`(`group_id` ASC) USING BTREE,
  INDEX `students_name_group_phone_unique`(`student_name` ASC, `group_id` ASC, `phone_number` ASC) USING BTREE,
  CONSTRAINT `students_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (1, 'Loum Vanchha', '069271230', 'Male', 59, 1, '2026-03-06 09:51:14', '2026-03-06 09:51:14');
INSERT INTO `students` VALUES (2, 'Hong Dalin', '0887471975', 'Female', 59, 1, '2026-03-06 09:52:28', '2026-03-06 10:12:56');
INSERT INTO `students` VALUES (6, 'Chul Chivorn', '012345678', 'Male', 59, 1, '2026-03-09 10:45:30', '2026-03-09 10:45:51');
INSERT INTO `students` VALUES (7, 'Rann Dara', '012345677', 'Male', 70, 1, '2026-03-09 11:30:49', '2026-03-09 20:25:30');
INSERT INTO `students` VALUES (9, 'Engleng', '0122313', 'Female', 59, 1, '2026-03-09 20:26:02', '2026-03-09 20:26:02');
INSERT INTO `students` VALUES (10, 'Bo', '0122313000', 'Male', 59, 1, '2026-03-10 15:34:50', '2026-03-10 15:34:50');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'student',
  `status` tinyint NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$CZu93vsYnEO2u3QnIbdy/.8foKLCscmm.W5yspERHrLTf4sONZucC', 'Admin', 1, 'ePTPyILxl3o7gnGAyCbop8pORsGXss0JIzMX4N7qxPlvoJeKFyCg4GF709aN', '2026-03-05 13:26:16', '2026-03-05 13:26:16');

SET FOREIGN_KEY_CHECKS = 1;
