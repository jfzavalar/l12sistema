/*
 Navicat Premium Dump SQL

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : l12sistema

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 03/10/2025 16:13:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for _users_
-- ----------------------------
DROP TABLE IF EXISTS `_users_`;
CREATE TABLE `_users_`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of _users_
-- ----------------------------
INSERT INTO `_users_` VALUES (1, 'Superadmin', 'superadmin@gmail.com', NULL, '$2y$12$oMAV1yrf4oe.zZw3Sptvner7SOEO8hYX2iouCrqyLm5t.gG52crUS', NULL, NULL, NULL, NULL, '2025-10-01 01:56:09', '2025-10-01 01:56:09');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('l12sistema_cache_da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1759525880);
INSERT INTO `cache` VALUES ('l12sistema_cache_da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1759525880;', 1759525880);
INSERT INTO `cache` VALUES ('l12sistema_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:5:\"grupo\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"e\";s:6:\"activo\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:14:{i:0;a:6:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"DASHBOARD\";s:1:\"c\";s:9:\"dashboard\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:6:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"PROCESOS\";s:1:\"c\";s:14:\"procesos.admin\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:6:{s:1:\"a\";i:3;s:1:\"b\";s:20:\"PROCESOS.ADMIN.USERS\";s:1:\"c\";s:26:\"procesos.admin.users.index\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:6:{s:1:\"a\";i:5;s:1:\"b\";s:20:\"PROCESOS.ADMIN.USERS\";s:1:\"c\";s:27:\"procesos.admin.users.create\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:6:{s:1:\"a\";i:6;s:1:\"b\";s:20:\"PROCESOS.ADMIN.USERS\";s:1:\"c\";s:25:\"procesos.admin.users.edit\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:6:{s:1:\"a\";i:7;s:1:\"b\";s:20:\"PROCESOS.ADMIN.USERS\";s:1:\"c\";s:28:\"procesos.admin.users.destroy\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:6:{s:1:\"a\";i:8;s:1:\"b\";s:20:\"PROCESOS.ADMIN.ROLES\";s:1:\"c\";s:26:\"procesos.admin.roles.index\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:6:{s:1:\"a\";i:9;s:1:\"b\";s:20:\"PROCESOS.ADMIN.ROLES\";s:1:\"c\";s:27:\"procesos.admin.roles.create\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:6:{s:1:\"a\";i:10;s:1:\"b\";s:20:\"PROCESOS.ADMIN.ROLES\";s:1:\"c\";s:25:\"procesos.admin.roles.edit\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:6:{s:1:\"a\";i:11;s:1:\"b\";s:20:\"PROCESOS.ADMIN.ROLES\";s:1:\"c\";s:28:\"procesos.admin.roles.destroy\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:6:{s:1:\"a\";i:12;s:1:\"b\";s:26:\"PROCESOS.ADMIN.PERMISSIONS\";s:1:\"c\";s:32:\"procesos.admin.permissions.index\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:6:{s:1:\"a\";i:13;s:1:\"b\";s:26:\"PROCESOS.ADMIN.PERMISSIONS\";s:1:\"c\";s:33:\"procesos.admin.permissions.create\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:6:{s:1:\"a\";i:14;s:1:\"b\";s:26:\"PROCESOS.ADMIN.PERMISSIONS\";s:1:\"c\";s:31:\"procesos.admin.permissions.edit\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:6:{s:1:\"a\";i:15;s:1:\"b\";s:26:\"PROCESOS.ADMIN.PERMISSIONS\";s:1:\"c\";s:34:\"procesos.admin.permissions.destroy\";s:1:\"d\";s:3:\"web\";s:1:\"e\";s:1:\"1\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"c\";s:10:\"Superadmin\";s:1:\"d\";s:3:\"web\";}}}', 1759612240);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2025_09_02_075243_add_two_factor_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_10_01_220309_create_tblsedes_table', 2);
INSERT INTO `migrations` VALUES (6, '2025_10_03_151741_create_permission_tables', 2);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 2);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'DASHBOARD', 'dashboard', 'web', '1', '2025-10-03 11:20:44', '2025-10-03 11:20:48');
INSERT INTO `permissions` VALUES (2, 'PROCESOS', 'procesos.admin', 'web', '1', '2025-10-03 12:02:50', '2025-10-03 12:02:52');
INSERT INTO `permissions` VALUES (3, 'PROCESOS.ADMIN.USERS', 'procesos.admin.users.index', 'web', '1', '2025-10-03 12:05:18', '2025-10-03 12:05:23');
INSERT INTO `permissions` VALUES (5, 'PROCESOS.ADMIN.USERS', 'procesos.admin.users.create', 'web', '1', '2025-10-03 12:05:21', '2025-10-03 12:05:25');
INSERT INTO `permissions` VALUES (6, 'PROCESOS.ADMIN.USERS', 'procesos.admin.users.edit', 'web', '1', '2025-10-03 12:05:27', '2025-10-03 12:05:29');
INSERT INTO `permissions` VALUES (7, 'PROCESOS.ADMIN.USERS', 'procesos.admin.users.destroy', 'web', '1', '2025-10-03 12:05:31', '2025-10-03 12:05:33');
INSERT INTO `permissions` VALUES (8, 'PROCESOS.ADMIN.ROLES', 'procesos.admin.roles.index', 'web', '1', '2025-10-03 12:31:14', '2025-10-03 12:31:16');
INSERT INTO `permissions` VALUES (9, 'PROCESOS.ADMIN.ROLES', 'procesos.admin.roles.create', 'web', '1', '2025-10-03 12:31:19', '2025-10-03 12:31:21');
INSERT INTO `permissions` VALUES (10, 'PROCESOS.ADMIN.ROLES', 'procesos.admin.roles.edit', 'web', '1', '2025-10-03 12:31:23', '2025-10-03 12:31:25');
INSERT INTO `permissions` VALUES (11, 'PROCESOS.ADMIN.ROLES', 'procesos.admin.roles.destroy', 'web', '1', '2025-10-03 12:31:27', '2025-10-03 12:31:29');
INSERT INTO `permissions` VALUES (12, 'PROCESOS.ADMIN.PERMISSIONS', 'procesos.admin.permissions.index', 'web', '1', '2025-10-03 15:49:08', '2025-10-03 15:49:11');
INSERT INTO `permissions` VALUES (13, 'PROCESOS.ADMIN.PERMISSIONS', 'procesos.admin.permissions.create', 'web', '1', '2025-10-03 15:49:14', '2025-10-03 15:49:16');
INSERT INTO `permissions` VALUES (14, 'PROCESOS.ADMIN.PERMISSIONS', 'procesos.admin.permissions.edit', 'web', '1', '2025-10-03 15:49:18', '2025-10-03 15:49:20');
INSERT INTO `permissions` VALUES (15, 'PROCESOS.ADMIN.PERMISSIONS', 'procesos.admin.permissions.destroy', 'web', '1', '2025-10-03 15:49:23', '2025-10-03 15:49:25');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (9, 1);
INSERT INTO `role_has_permissions` VALUES (10, 1);
INSERT INTO `role_has_permissions` VALUES (11, 1);
INSERT INTO `role_has_permissions` VALUES (12, 1);
INSERT INTO `role_has_permissions` VALUES (13, 1);
INSERT INTO `role_has_permissions` VALUES (14, 1);
INSERT INTO `role_has_permissions` VALUES (15, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Superadmin', 'web', '2025-10-03 16:54:35', '2025-10-03 16:54:35');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('YUNtoU3Jo2VDMdGd6cbM78r4UTSIn4vyAtL6ceLU', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaUZLRGpVVDdjWFZwNmVHOEpNVDk1TGZXVjBHNUkzUmkzSklrUTFVeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJtaXNzaW9ucyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1759525845);

-- ----------------------------
-- Table structure for tblsedes
-- ----------------------------
DROP TABLE IF EXISTS `tblsedes`;
CREATE TABLE `tblsedes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `coddepofi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomdepofi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anomdepofi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sedepofi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codsedeofi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomsedeofi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `activo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 139 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tblsedes
-- ----------------------------
INSERT INTO `tblsedes` VALUES (1, 'D001', 'Presidencia de la Junta de Fiscales Superiores de Junín', 'PJFS JUNIN', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (2, 'D002', 'Oficina Descentralizada de Control Interno de Junín', 'ODCI JUNIN', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (3, 'D003', 'Administración del Distrito Fiscal de Junín', 'ADMJ - ADMINISTRADOR', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (4, 'D004', 'Administración del Distrito Fiscal de Junín - Central de Notificaciones de Huancayo', 'ADMJ - CENTRAL NOTIFICACIONES', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (5, 'D005', 'Administración del Distrito Fiscal de Junín - Area de Bienes Incautados', 'ADMJ - BIENES INCAUTADOS', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (6, 'D006', 'Administración del Distrito Fiscal de Junín - Area de Bienes Patrimoniales', 'ADMJ - BIENES PATRIMONIALES', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (7, 'D007', 'Administración del Distrito Fiscal de Junín - Area de Asistencia Social', 'ADMJ - ASISTENTE SOCIAL', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (8, 'D008', 'Administración del Distrito Fiscal de Junín - Area de Indicadores', 'ADMJ - INDICADORES', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (9, 'D009', 'Administración del Distrito Fiscal de Junín - Area de Audio y Video', 'ADMJ - AUDIO Y VIDEO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (10, 'D010', 'Administración del Distrito Fiscal de Junín - Area de Fondos de Pagos', 'ADMJ - FONDOS Y PAGOS', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (11, 'D011', 'Administración del Distrito Fiscal de Junín - Area de Logistica', 'ADMJ - LOGISTICA', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (12, 'D012', 'Administración del Distrito Fiscal de Junín - Area de Recursos Humanos', 'ADMJ - RECURSOS HUMANOS', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (13, 'D013', 'Administración del Distrito Fiscal de Junín - Area de Transportes', 'ADMJ - TRANSPORTES', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (14, 'D014', 'Administración del Distrito Fiscal de Junín - Area de Infraestructura', 'ADMJ - INFRAESTRUCTURA', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (15, 'D015', 'Administración del Distrito Fiscal de Junín - Area de Informática', 'ADMJ - INFORMÁTICA', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (16, 'D016', 'Administración del Distrito Fiscal de Junín - Atención al Usuario', 'ADMJ - ATENCION AL USUARIO', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (17, 'D017', 'Administración del Distrito Fiscal de Junín - Area de Mesa de Partes', 'ADMJ - MESA DE PARTES', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (18, 'D018', 'Administración del Distrito Fiscal de Junín - Area de Archivo', 'ADMJ - ARCHIVO', 'HUANCAYO', 'L04', 'AV. HVCA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (19, 'D019', 'Registro Nacional de Detenidos y Sentenciados a Pena Privativa de la Libertad de Junín', 'RENADESPLE', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (20, 'D020', '1° Fiscalia Superior en lo Penal de Junín', '1° FSP JUNIN', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (21, 'D021', '2° Fiscalia Superior en lo Penal de Junín', '2° FSP JUNIN', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (22, 'D022', '3° Fiscalia Superior en lo Penal de Junín', '3° FSP JUNIN', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (23, 'D023', '4° Fiscalia Superior en lo Penal de Junín', '4° FSP JUNIN', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (24, 'D024', '5° Fiscalia Superior en lo Penal de Junín', '5° FSP JUNIN', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (25, 'D025', 'Fiscalia Superior Civil y Familia de Junín', 'FSCF - JUNIN', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (26, 'D026', 'Fiscalia Provincial Corporativa Especializada Contra la Criminalidad Organizada de Junín', 'FECOR - JUNIN', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (27, 'D027', 'Fiscalía Penal Supraprovincial Transitoria Especializada en Terrorismo y Derechos Humanos de Junín.', 'FPSTETDH - JUNÍN', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (28, 'D028', 'Fiscalia Provincial Especializada en Delitos de Trafico Ilicito de Drogas de Junín / Sede Huancayo', 'FPEDTID - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (29, 'D029', 'Fiscalia Provincial Especializada en Materia Ambiental de Huancayo', 'FPEMA - HUANCAYO', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (30, 'D030', 'Pool de Fiscales de Junín', 'POOL FISCALES JUNÍN', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (31, 'D031', '1° Fiscalia Provincial Especializada en Prevencion del Delito de Huancayo', '1° PPEPPD - HYO', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (32, 'D032', '2° Fiscalia Provincial Especializada en Prevencion del Delito de Huancayo', '2° PPEPPD - HYO', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (33, 'D033', 'Fiscalia Provincial Transitoria de Extincion de Dominio de Junín', 'FPTED - JUNIN', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (34, 'D034', 'Fiscalia Superior Especializada en Delitos de Corrupcion de Funcionarios de Junín', 'FSEDCF JUNIN', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (35, 'D035', 'Fiscalia Superior Especializada en Delitos de Corrupcion de Funcionarios de Junín - Area de Imagen, Audio y Video', 'FSEDCF JUNIN - AREA DE IMAGEN', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (36, 'D036', 'Fiscalia Superior Especializada en Delitos de Corrupcion de Funcionarios de Junín - Area de Peritos', 'FSEDCF JUNIN - PERITOS', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (37, 'D037', 'Fiscalia Provincial Especializada en Delitos de Corrupcion de Funcionarios de Junín - 1° Despacho', 'FPEDCF JUNIN - 1° DESPACHO', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (38, 'D038', 'Fiscalia Provincial Especializada en Delitos de Corrupcion de Funcionarios de Junín - 2° Despacho', 'FPEDCF JUNIN - 2° DESPACHO', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (39, 'D039', 'Fiscalia Provincial Especializada en Delitos de Corrupcion de Funcionarios de Junín - 3° despacho', 'FPEDCF JUNIN - 3° DESPACHO', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (40, 'D040', 'Fiscalia Provincial Especializada en Delitos de Corrupcion de Funcionarios de Junín - 4° despacho', 'FPEDCF JUNIN - 4° DESPACHO', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (41, 'D041', '1° Fiscalia Provincial Penal Corporativa de Huancayo', '1° FPPC - HUANCAYO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (42, 'D042', '2° Fiscalia Provincial Penal Corporativa de Huancayo', '2° FPPC - HUANCAYO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (43, 'D043', '3° Fiscalia Provincial Penal Corporativa de Huancayo', '3° FPPC - HUANCAYO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (44, 'D044', '4° Fiscalia Provincial Penal Corporativa de Huancayo', '4° FPPC - HUANCAYO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (45, 'D045', '5° Fiscalia Provincial Penal Corporativa de Huancayo', '5° FPPC - HUANCAYO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (46, 'D046', '6° Fiscalia Provincial Penal Corporativa de Huancayo', '6° FPPC - HUANCAYO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (47, 'D047', '1° Fiscalia Provincial Civil y Familia de Huancayo', '1° FPCF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (48, 'D048', '2° Fiscalia Provincial Civil y Familia de Huancayo', '2° FPCF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (49, 'D049', '3° Fiscalia Provincial Civil y Familia de Huancayo', '3° FPCF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (50, 'D050', '4° Fiscalia Provincial Civil y Familia de Huancayo', '4° FPCF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (51, 'D051', '5° Fiscalia Provincial Civil y Familia de Huancayo', '5° FPCF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (52, 'D052', 'Fiscalia Provincial Civil y Familia de Huancayo', 'FPCF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (53, 'D053', 'Fiscalia Provincial Penal Corporativa de Tayacaja', 'FPPC - TAYACAJA', 'TAYACAJA', 'L01', 'TAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (54, 'D054', 'Fiscalia Provincial Civil y Familia de Tayacaja', 'FPCF - TAYACAJA', 'TAYACAJA', 'L01', 'TAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (55, 'D055', 'Fiscalia Provincial Mixta de Surcubamba', 'FPM- SURCUBAMBA', 'SURCUBAMBA', 'L22', 'SURCUBAMBA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (56, 'D056', 'Fiscalia Provincial Penal Corporativa de Chupaca', 'FPPC - CHUPACA', 'CHUPACA', 'L09', 'CHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (57, 'D057', 'Fiscalia Provincial Civil y Familia de Chupaca', 'FPCF - CHUPACA', 'CHUPACA', 'L09', 'CHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (58, 'D058', 'Fiscalia Provincial Penal Corporativa de Concepción', 'FPPC - CONCEPCION', 'CONCEPCION', 'L11', 'CONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (59, 'D059', 'Fiscalia Provincial Civil y de Familia de Concepción', 'FPPC - CONCEPCION', 'CONCEPCION', 'L11', 'CONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (60, 'D060', 'Fiscalia Provincial Mixta de Santo Domingo de Acobamba', 'FPM - SD ACOBAMBA', 'SD ACOBAMBA', 'L21', 'SD ACOBAMBA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (61, 'D061', 'Fiscalia Provincial Penal Corporativa de Jauja', 'FPPC - JAUJA', 'JAUJA', 'L13', 'JAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (62, 'D062', 'Fiscalia Provincial Civil y Familia de Jauja', 'FPCF - JAUJA', 'JAUJA', 'L13', 'JAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (63, 'D063', 'Fiscalia Superior Penal de Tarma', 'FSP - TARMA', 'TARMA', 'L15', 'OTERO - TARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (64, 'D064', 'Fiscalia Superior Civil y Familia de Tarma', 'FSCF - TARMA', 'TARMA', 'L16', 'AMAZONAS - TARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (65, 'D065', '1° Fiscalia Provincial Penal Corporativa de Tarma', '1° FPPC - TARMA', 'TARMA', 'L15', 'OTERO - TARMA', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (66, 'D066', '2° Fiscalia Provincial Penal Corporativa de Tarma', '2° FPPC - TARMA', 'TARMA', 'L15', 'OTERO - TARMA', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (67, 'D067', 'Fiscalia Provincial Penal Corporativa de Tarma', 'FPPC - TARMA', 'TARMA', 'L15', 'OTERO - TARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (68, 'D068', 'Fiscalia Provincial Civil y Familia de Tarma', 'FPCF - TARMA', 'TARMA', 'L16', 'AMAZONAS - TARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (69, 'D069', 'Fiscalia Provincial Penal Corporativa de Yauli / La Oroya', 'FPPC - YAULI / LA OROYA', 'YAULI', 'L18', 'YAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (70, 'D070', 'Fiscalia Provincial Civil y de Familia de Yauli', 'FPCF - YAULI / LA OROYA', 'YAULI', 'L18', 'YAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (71, 'D071', 'Fiscalia Provincial Penal Corporativa de Junín', 'FPPC - JUNIN', 'JUNIN', 'L20', 'JUNIN', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (72, 'D072', 'Fiscalia Provincial Civil y de Familia de Junín', 'FPPC - JUNIN', 'JUNIN', 'L20', 'JUNIN', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (73, 'D073', 'Unidad Distrital de Asistencia a Victimas y Testigos de Junín / Sede Huancayo', 'UDAVIT - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (74, 'D074', 'Unidad de Asistencia Inmediata a Victimas y Testigos de Tayacaja', 'UAIVIT - TAYACAJA', 'TAYACAJA', 'L01', 'TAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (75, 'D075', 'Unidad de Asistencia Inmediata a Victimas y Testigos de Concepción', 'UAIVIT - CONCEPCION', 'CONCEPCION', 'L11', 'CONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (76, 'D076', 'Unidad de Asistencia Inmediata a Victimas y Testigos de Jauja', 'UAIVIT - JAUJA', 'JAUJA', 'L13', 'JAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (77, 'D077', 'Unidad de Asistencia Inmediata a Victimas y Testigos de Tarma', 'UAIVIT - TARMA', 'TARMA', 'L16', 'AMAZONAS - TARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (78, 'D078', 'Unidad de Asistencia Inmediata a Victimas y Testigos de Yauli / La Oroya', 'UAIVIT - YAULI / LA OROYA', 'YAULI', 'L18', 'YAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (79, 'D079', 'Fiscalía Superior Especializada en Violencia Contra La Mujer y Los Integrantes del Grupo Familiar de Huancayo', 'FSEVCMIGF - HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (80, 'D080', '1° Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Huancayo', '1° FPEVCMIGF - HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (81, 'D081', '2° Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Huancayo', '2° FPEVCMIGF - HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (82, 'D082', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Huancayo', 'FPEVCMIGF - HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '0', NULL, NULL);
INSERT INTO `tblsedes` VALUES (83, 'D083', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Tayacaja', 'FPEVCMIGF - TAYACAJA', 'TAYACAJA', 'L02', 'VTAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (84, 'D084', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Chupaca', 'FPEVCMIGF - CHUPACA', 'CHUPACA', 'L10', 'VCHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (85, 'D085', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Concepción', 'FPEVCMIGF - CONCEPCIÓN', 'CONCEPCION', 'L12', 'VCONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (86, 'D086', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Jauja', 'FPEVCMIGF - JAUJA', 'JAUJA', 'L14', 'VJAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (87, 'D087', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Tarma', 'FPEVCMIGF - TARMA', 'TARMA', 'L17', 'VTARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (88, 'D088', 'Fiscalía Provincial Especializada en Violencia Contra Las Mujeres y Los Integrantes del Grupo Familiar de Yauli', 'FPEVCMIGF - YAULI / LA OROYA', 'YAULI', 'L19', 'VYAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (89, 'D089', '1° Fiscalia Provincial de Familia de Huancayo', '1° FPF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (90, 'D090', '2° Fiscalia Provincial de Familia de Huancayo', '2° FPF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (91, 'D091', '3° Fiscalia Provincial de Familia de Huancayo', '3° FPF - HUANCAYO', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (92, 'D092', 'Fiscalia Penal Supraprovincial Transitoria Especializada en Derechos Humanos e Interculturalidad del DFJunín', 'FPSTEDHI - JUNIN', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (93, 'D093', 'Fiscalia Penal Supraprovincial Transitoria Especializada en Delitos de Terrorismo y Delitos Conexos del DFJunín', 'FPSTEDTDC - JUNIN', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (94, 'D094', 'Fiscalia Penal Supraprovincial Especializada en Derechos Humanos e Interculturalidad del DFJunín', 'FPSEDHI - JUNIN', 'HUANCAYO', 'L05', 'REAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (95, 'D095', 'Administración del Distrito Fiscal de Junín - Sede Central', 'ADMJ - SEDE CENTRAL', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (96, 'D096', 'Administración del Distrito Fiscal de Junín - Sede San Carlos', 'ADMJ - SEDE SAN CARLOS', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (97, 'D097', 'Administración del Distrito Fiscal de Junín - Almacen Control Patrimonial', 'ADMJ - ALMACEN CONTROL PATRIMONIAL', 'HUANCAYO', 'L06', 'SAN CARLOS', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (98, 'D098', 'Administración del Distrito Fiscal de Junín - Almacen Informática', 'ADMJ - ALMACEN INFORMATICA', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (99, 'D099', 'Administración del Distrito Fiscal de Junín - Area de Recaudación Fiscal', 'ADMJ - RECAUDACIÓN FISCAL', 'HUANCAYO', 'L04', 'AV. HVCA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (100, 'D100', 'Administración del Distrito Fiscal de Junín - Auditorio', 'ADMJ - AUDITORIO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (101, 'D101', 'Administración del Distrito Fiscal de Junín - Camara Gessel', 'ADMJ - CAMARA GESSEL', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (102, 'D102', 'Administración del Distrito Fiscal de Junín - Lactario', 'ADMJ - LACTARIO', 'HUANCAYO', 'L03', 'CENTRAL', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (103, 'D103', 'Area de Notificaciones Tayacaja', 'ANOTIF - TAYACAJA ', 'TAYACAJA', 'L01', 'TAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (104, 'D104', 'Area de Notificaciones Chupaca', 'ANOTIF - CHUPACA', 'CHUPACA', 'L09', 'CHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (105, 'D105', 'Area de Notificaciones Concepción', 'ANOTIF - CONCEPCION ', 'CONCEPCION', 'L11', 'CONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (106, 'D106', 'Area de Notificaciones Jauja', 'ANOTIF - JAUJA', 'JAUJA', 'L13', 'JAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (107, 'D107', 'Area de Notificaciones Yauli', 'ANOTIF - YAULI', 'YAULI', 'L18', 'YAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (108, 'D108', 'Area de Notificaciones Junín', 'ANOTIF - JUNIN', 'JUNIN', 'L20', 'JUNIN', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (109, 'D109', 'Area de Notificaciones Tarma', 'ANOTIF - TARMA', 'TARMA', 'L15', 'OTERO - TARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (110, 'D110', 'Area de Notificaciones Surcubamba', 'ANOTIF - SURCUBAMBA', 'SURCUBAMBA', 'L22', 'SURCUBAMBA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (111, 'D111', 'Area de Notificaciones Santo Domingo de Acobamba', 'ANOTIF - SD ACOBAMBA', 'SD ACOBAMBA', 'L21', 'SD ACOBAMBA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (112, 'D112', 'Casa de Acogida El Tambo', 'CASA DE ACOGIDA - EL TAMBO', 'HUANCAYO', 'L23', 'CASA ACOGIDA TAMBO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (113, 'D113', 'Coordinación Fiscalia Provincial Especializada en Delitos de Corrupción de Funcionarios de Junín', 'COORD. FPEDCF JUNIN', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (114, 'D114', 'Fiscalia Provincial Especializada en Delitos de Corrupción de Funcionarios de Junín - Mesa de Partes', 'MESA DE PARTES - FPEDCF JUNIN', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (115, 'D115', 'Fiscalia Especializada en Delitos de Corrupción de Funcionarios de Junín - Area de Notificaciones', 'ANOTIF - FEDCF JUNIN', 'HUANCAYO', 'L07', 'AV. 13 DE NOVIEMBRE', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (116, 'D116', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Junín - Mesa de Partes', 'MESA DE PARTES - FEVCMIGF JUNIN', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (117, 'D117', 'Equipo de Apoyo Fiscal de la Fiscalia Corporativa Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Junín', 'EQUIPO APOYO FISCAL - FPEVCMIGF JUNIN', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (118, 'D118', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Junín - Area de Archivo', 'ARCHIVO - FEVCMIGF JUNIN', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (119, 'D119', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Junín - Area de Imagen, Audio y Video', 'IMAGEN AUDIO VIDEO - FEVCMIGF JUNIN', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (120, 'D120', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Junín - Area de Informática', 'INFORMATICA - FEVCMIGF JUNIN', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (121, 'D121', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Huancayo - Area de Notificaciones', 'ANOTIF - FEVCMIGF HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (122, 'D122', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Tayacaja - Area de Notificaciones', 'ANOTIF - FPEVCMIGF TAYACAJA', 'TAYACAJA', 'L02', 'VTAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (123, 'D123', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Chupaca - Area de Notificaciones', 'ANOTIF - FPEVCMIGF CHUPACA', 'CHUPACA', 'L10', 'VCHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (124, 'D124', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Concepción - Area de Notificaciones', 'ANOTIF - FPEVCMIGF CONCEPCION', 'CONCEPCION', 'L12', 'VCONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (125, 'D125', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Jauja - Area de Notificaciones', 'ANOTIF - FPEVCMIGF JAUJA', 'JAUJA', 'L14', 'VJAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (126, 'D126', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Yauli - Area de Notificaciones', 'ANOTIF - FPEVCMIGF YAULI', 'YAULI', 'L19', 'VYAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (127, 'D127', 'Fiscalia Especializada en Violencia Contra la Mujer y Los Integrantes del Grupo Familiar de Tarma - Area de Notificaciones', 'ANOTIF - FPEVCMIGF TARMA', 'TARMA', 'L17', 'VTARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (128, 'D128', 'Registro Unico de Victimas y Personas Agresoras de Huancayo', 'RUVA - HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (129, 'D129', 'Registro Unico de Victimas y Personas Agresoras de Chupaca', 'RUVA - CHUPACA', 'CHUPACA', 'L10', 'VCHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (130, 'D130', 'Registro Unico de Victimas y Personas Agresoras de Jauja', 'RUVA - JAUJA', 'JAUJA', 'L14', 'VJAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (131, 'D131', 'Registro Unico de Victimas y Personas Agresoras de Tarma', 'RUVA - TARMA', 'TARMA', 'L17', 'VTARMA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (132, 'D132', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Huancayo', 'UDAVIT FEVCMIGF - HUANCAYO', 'HUANCAYO', 'L08', 'VHUANCAYO', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (133, 'D133', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Tayacaja', 'UDAVIT FEVCMIGF - TAYACAJA', 'TAYACAJA', 'L02', 'VTAYACAJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (134, 'D134', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Concepción', 'UDAVIT FEVCMIGF - CONCEPCION', 'CONCEPCION', 'L12', 'VCONCEPCION', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (135, 'D135', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Jauja', 'UDAVIT FEVCMIGF - JAUJA', 'JAUJA', 'L14', 'VJAUJA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (136, 'D136', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Chupaca', 'UDAVIT FEVCMIGF - CHUPACA', 'CHUPACA', 'L10', 'VCHUPACA', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (137, 'D137', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Yauli', 'UDAVIT FEVCMIGF - YAULI', 'YAULI', 'L19', 'VYAULI', '1', NULL, NULL);
INSERT INTO `tblsedes` VALUES (138, 'D138', 'Unidad de Asistencia Inmediata a Victimas y Testigos de la FEVCMIGF Tarma', 'UDAVIT FEVCMIGF - TARMA', 'TARMA', 'L17', 'VTARMA', '1', NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `dni` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sede` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dependencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `regimen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `correo_personal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `correo_institucional` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cel_personal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cel_institucional` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `activo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `updated_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `dni`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'ADMIN', 'SUPER ADMINISTRADOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jfzavalar@gmail.com', NULL, '$2y$12$IyT5xAZazrgQwq4R31Q69O.CxKBeRT3xYz8z7rWI1/wFBc7m0c0Ny', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-10 14:17:29', '2025-07-10 14:17:29');
INSERT INTO `users` VALUES (2, '43016828', 'ZAVALA RAMIREZ JIMY FRANCISCO', 'CENTRAL', 'ADMINISTRACION DEL DISTRITO JUDICIAL DE JUNIN', 'CAS', 'ESPECIALISTA ADMINISTRATIVO', 'jfzavalar@gmail.com', '', '954468663', '', 'jzavalar@mpfn.gob.pe', NULL, '$2y$12$m6w.tVdq/FKHfrqNGkPx0.jwWTnXE.9/XJT8mXO8pfvy3rLqEeOLq', NULL, '', '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-24 16:31:30');
INSERT INTO `users` VALUES (3, '42711141', 'CURACACHI CARLOS ROGGER RUBEN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'roger@gmail.com', NULL, '$2y$12$UdMez66JphAE1zfkNOz5/OE6bPlA6GKary2JOtZ5D8DrA7w/CbziG', NULL, '', '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-25 14:20:13');
INSERT INTO `users` VALUES (4, '48184681', 'PARIONA LOPEZ KATTHERINE ROCIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'katy@gmail.com', NULL, '$2y$12$iT7D/M.MDbhPDSzCArRMo.Xb6GWmuEzXA/Rn./b8FX6ZI.RwMubKq', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:42:09');
INSERT INTO `users` VALUES (5, '33333333', 'PEREZ GILVONIO IVAN LINCOL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ivan@gmail.com', NULL, '$10$1INSL99bP47zxzijOlW7XO5qou7qLIp6ipbPeUXH6H8WQk8fuL3WK', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:51');
INSERT INTO `users` VALUES (6, '47492652', 'ROMERO BERNALDO NELIDA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nelida@gmail.com', NULL, '$2y$12$NqLR39YDvA5f8sFTF6DCj.F1zvh3XySbMvL.mZ8Lb.eckW/HzY8Pa', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:51');
INSERT INTO `users` VALUES (7, '74247875', 'ROMERO HOCES JESUS MICHAEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'michael@gmail.com', NULL, '$2y$12$bP/Q0nKTdRSoBJzbljxGYOsyzHqVKhEDw6jUGmNE9iAsv7KaVOgWu', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:42');
INSERT INTO `users` VALUES (8, '72206230', 'SURICHAQUI SURICHAQUI DAYGURO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dayguro@gmail.com', NULL, '$2y$12$IcpJJQOaAiobKusnBq0Fzuyxh1w2gHQzK0nmImNyDwDJpIJZfHTC2', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:31');
INSERT INTO `users` VALUES (9, '71403634', 'ZUÑIGA QUISPE ROMIL VLADIMIR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vladimir@gmail.com', NULL, '$2y$12$z3miPy.gCmKZIEkxirarXOjrx8ss7Zti./BM5ULhU3QfPb8q8Kbjm', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:24');
INSERT INTO `users` VALUES (10, '10708588', 'CARHUAMACA VILCHEZ DENIS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dcarhuamacadj@mpfn.gob.pe', NULL, '$2y$12$Ua46cJ.lsLSXg5S3M0JxeOh4h4rvVcJqMrwNndCudX/YpFyXdSYeW', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-10-03 19:45:33');
INSERT INTO `users` VALUES (11, '41560390', 'CASIMIRO BRAVO MIGUEL ANGEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mcasimiro@mpfn.gob.pe', NULL, '$2y$12$NZQcHQtvDKMEz4gj9f5.NelwioSDzd8j5LzCBNux65G4a3E/NFFIi', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-07-31 15:11:06');
INSERT INTO `users` VALUES (12, '20090729', 'GUTIERREZ MAYTA HECTOR RAUL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'hegutierrez@mpfn.gob.pe', NULL, '$2y$12$xI1kBFnkyV34fVuWJirXeebstv0slRTr5z4HqyCKZMgjCjXAW9nzW', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:09');
INSERT INTO `users` VALUES (13, '70399135', 'HUAMAN FLORES ANDY JONATHAN', 'CENTRAL', 'ADMINISTRACION DEL DISTRITO JUDICIAL DE JUNIN', 'DL.728', 'OPERADOR ADMINISTRATIVO', 'ingandyhuaman@gmail.com', 'ajhuaman@mpfn.gob.pe', '904748027', '', 'ajhuaman@mpfn.gob.pe', NULL, '$2y$12$Pi1vRATQP3Z5tu/Pr5E.0el81GYyIqWorPvXdQEen.0bKlssETj/O', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-23 13:41:01');
INSERT INTO `users` VALUES (14, '88888888', 'JIMENEZ CHUQUIMANTARI JESUS DAVID', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'david@gmail.com', NULL, '$2y$12$GU1M2AkPEW5dg7wJRbjCOOW2CDrjJdUDa7ytcaVDL04u9EofR3VsG', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'SUPER ADMINISTRADOR', '2025-07-21 16:03:46', '2025-09-15 14:52:32');
INSERT INTO `users` VALUES (15, '99999999', 'ROMERO CONDOR KEVIN JHON', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kevin@gmail.com', NULL, '$2y$12$DLZBOabtsqmEIek5NWJ0v.sooZgMiDFGLJNBLuTD4EK2AfraIV0Ye', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'SUPER ADMINISTRADOR', '2025-07-21 16:03:46', '2025-09-15 14:12:23');
INSERT INTO `users` VALUES (16, '74692057', 'RIVEROS PARAGUAY JHON KENEDY', 'VIOLENCIA HUANCAYO', 'FISCALIA SUPERIOR ESPECIALIZADA EN VIOLENCIA CONTRA LAS MUJERES Y LOS INTEGRANTES DEL GRUPO FAMILIAR DE JUNIN', 'CAS', 'ANALISTA INFORMATICO', 'JHONKENRP@GMAIL.COM', 'jriveros@mpfn.gob.pe', '999406932', '', 'jriveros@mpfn.gob.pe', NULL, '$2y$12$pWgnMpJ7yQ0hWgW.j9TjYuSAjkzUZhW7Nm6PschQxsRbjPPMV/3YK', NULL, '', '1', 'SUPER ADMINISTRADOR', 'ZAVALA RAMIREZ JIMY FRANCISCO', '2025-07-21 16:03:46', '2025-09-25 14:32:17');
INSERT INTO `users` VALUES (17, '41022662', 'ÑAVINCOPA SANCHEZ KENDY FRIGIA', 'SAN CARLOS', 'ADMINISTRACION DEL DISTRITO JUDICIAL DE JUNIN', 'CAS', 'ANALISTA', 'kendy918@hotmail.com', 'knavincopadj@mpfn.gob.pe', '955954080', '', NULL, NULL, '$2y$12$pbk00d0ybeoTir7EpygRkuOeBYrNZXRYgxJa2OTnfG3PMagKA5XnG', NULL, NULL, '1', 'SUPER ADMINISTRADOR', 'SUPER ADMINISTRADOR', '2025-09-12 15:18:29', '2025-09-12 15:18:29');

SET FOREIGN_KEY_CHECKS = 1;
