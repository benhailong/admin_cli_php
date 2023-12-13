/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50744 (5.7.44)
 Source Host           : localhost:3306
 Source Schema         : admin_cli

 Target Server Type    : MySQL
 Target Server Version : 50744 (5.7.44)
 File Encoding         : 65001

 Date: 13/12/2023 23:17:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for up_config
-- ----------------------------
DROP TABLE IF EXISTS `up_config`;
CREATE TABLE `up_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `conf_key` varchar(255) NOT NULL,
  `conf_val` longtext,
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `conf_key` (`conf_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='系统配置项表';

-- ----------------------------
-- Records of up_config
-- ----------------------------
BEGIN;
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (125, 'smtp_char', 'UTF-8', '设定邮件编码', '2023-11-16 15:32:52', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (126, 'smtp_host', 'smtp.163.com', 'SMTP服务器', '2023-11-16 15:33:20', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (127, 'smtp_auth', 'true', '是否允许 SMTP 认证', '2023-11-16 15:34:23', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (128, 'smtp_address', 'xxxxx@163.com', '邮箱', '2023-11-16 15:34:53', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (129, 'smtp_password', 'xxxxx', '邮箱密码', '2023-11-16 15:35:24', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (130, 'smtp_secure', 'ssl', '允许 TLS 或者ssl协议', '2023-11-16 15:36:01', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (131, 'smtp_port', '465', '服务器端口 25 或者465 具体要看邮箱服务器支持', '2023-11-16 15:36:31', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (132, 'smtp_username', 'unpor', '发件人姓名', '2023-11-16 15:37:29', NULL);
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (133, 'sms_type', '1', '短信类型：1、阿里云，2：腾讯云', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (134, 'sms_aliyun_access_key_id', 'xxxxx', '阿里云短信的key_id', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (135, 'sms_aliyun_access_key_secret', 'xxxxx', '阿里云短信的access_key_secret', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (136, 'sms_aliyun_sign_name', '助商通', '阿里云短信的签名', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (137, 'sms_aliyun_template_register', 'SMS_126420110', '阿里云短信模板-注册', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (138, 'sms_aliyun_template_login', 'SMS_126420110', '阿里云短信模板-登录', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (139, 'sms_aliyun_template_seekpwd', 'SMS_126420110', '阿里云短信模板-忘记密码', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (140, 'sms_aliyun_template_updatePwd', 'SMS_126420110', '阿里云短信模板-修改密码', '2023-11-30 17:02:52', '2023-11-30 17:02:52');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (141, 'gzh_name', '副业淘客', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (142, 'gzh_app_id', 'xxxxx', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (143, 'gzh_app_secret', 'xxxxx', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (144, 'pay_wechat_type', 'true', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (145, 'pay_wechat_name', '悠珀', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (146, 'pay_wechat_appid', 'xxxxx', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (147, 'pay_wechat_mchid', '123123', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (148, 'pay_wechat_appkey', 'xxxxx', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (149, 'pay_wechat_cert', 'topic/20231130/92023d420db6e930beba6323f19bfa59.pem', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
INSERT INTO `up_config` (`id`, `conf_key`, `conf_val`, `description`, `create_time`, `update_time`) VALUES (150, 'pay_wechat_key', 'topic/20231130/7000964aabadb9e16c1dcc67198b150d.pem', NULL, '2023-11-30 23:20:17', '2023-11-30 23:20:17');
COMMIT;

-- ----------------------------
-- Table structure for up_port
-- ----------------------------
DROP TABLE IF EXISTS `up_port`;
CREATE TABLE `up_port` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '接口名称',
  `address` varchar(255) DEFAULT NULL COMMENT '接口地址',
  `introduce` varchar(255) DEFAULT NULL COMMENT '接口简介',
  `router_id` int(11) DEFAULT NULL COMMENT '路由ID',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `type` int(2) DEFAULT NULL COMMENT '接口类型：0：表示开放接口，1：需要登录，2：需要验证权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COMMENT='接口列表';

-- ----------------------------
-- Records of up_port
-- ----------------------------
BEGIN;
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (1, '查询所有的路由列表', 'router/getAllRouter', '后端查询所有的路由列表', 2, '2023-11-22 15:02:36', '2023-11-27 22:36:20', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (3, '获取用户前端路由接口', 'users/getRoutesByRole', '用户登录之后，获取用户的路由接口', NULL, '2023-11-22 15:38:28', NULL, 1);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (4, '新增路由列表', 'router/addRouter', '新增路由列表', 2, '2023-11-26 22:21:02', NULL, 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (5, '删除路由列表', 'router/delete', '删除路由列表', 2, '2023-11-26 22:47:41', NULL, 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (6, '根据ID查询路由详情', 'router/getInfoById', '更具ID查询路由详情', 2, '2023-11-26 23:25:36', NULL, 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (7, '根据ID修改路由详情', 'router/update', '根据ID修改路由详情', 2, '2023-11-27 00:02:48', NULL, 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (8, '查询所有接口', 'port/getAll', '查询所有接口', 6, '2023-11-27 11:39:16', NULL, 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (9, '新增接口', 'port/add', '新增接口', 6, '2023-11-27 22:17:10', NULL, 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (12, '删除接口', 'port/delete', '删除接口', 6, '2023-11-27 22:26:26', '2023-11-27 22:26:26', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (13, '根据接口ID查询接口详情', 'port/getInfoById', '根据接口ID查询接口详情', 6, '2023-11-27 22:31:03', '2023-11-27 22:31:03', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (14, '修改接口', 'port/update', '修改接口', 6, '2023-11-27 22:33:06', '2023-11-27 22:33:06', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (16, '角色-后台分页查询', 'role/getAll', '', 7, '2023-11-28 17:56:07', '2023-11-28 17:56:07', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (17, '角色-新增', 'role/add', '', 7, '2023-11-28 22:06:29', '2023-11-28 22:06:29', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (18, '角色-删除', 'role/delete', '', 7, '2023-11-28 22:08:33', '2023-11-28 22:08:33', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (19, '角色-根据ID查询详情', 'role/getInfoById', '', 7, '2023-11-28 22:10:50', '2023-11-28 22:10:50', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (20, '角色-根据ID修改保存', 'role/update', '', 7, '2023-11-28 22:14:16', '2023-11-28 22:14:16', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (21, '角色-根据角色ID查已授权路由', 'role/getRouterByRoleId', '', 7, '2023-11-29 11:53:25', '2023-11-29 11:53:25', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (22, '角色-根据角色ID 修改 授权路由', 'role/saveRouterByRoleId', '', 7, '2023-11-29 12:07:18', '2023-11-29 12:07:18', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (23, '更具路由分组查询所有需要授权访问的接口', 'port/getAllNeedAuthAndGroupByRouterId', '查询所有需要授权才能访问的接口列表,并更具路由id进行分组', 7, '2023-11-29 14:38:45', '2023-11-29 14:39:03', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (25, '角色-根据角色ID查已授权接口', 'role/getPortByRoleId', '', 7, '2023-11-29 15:17:29', '2023-11-29 15:18:06', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (26, '角色-根据角色ID 修改 授权接口', 'role/savePortByRoleId', '', 7, '2023-11-29 15:17:49', '2023-11-29 15:18:14', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (27, '配置-根据前缀查询配置信息', 'config/getInfoByKey', '', 8, '2023-11-30 16:53:35', '2023-11-30 16:53:35', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (28, '配置-保存或修改数据', 'config/save', '', 8, '2023-11-30 16:54:51', '2023-11-30 16:54:51', 2);
INSERT INTO `up_port` (`id`, `title`, `address`, `introduce`, `router_id`, `create_time`, `update_time`, `type`) VALUES (29, '文件上传到本地', 'file/uploadPem', '', 8, '2023-11-30 22:12:14', '2023-11-30 22:12:14', 2);
COMMIT;

-- ----------------------------
-- Table structure for up_role
-- ----------------------------
DROP TABLE IF EXISTS `up_role`;
CREATE TABLE `up_role` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `label` varchar(255) DEFAULT NULL COMMENT '英文标识',
  `introduce` varchar(255) DEFAULT NULL COMMENT '说明',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of up_role
-- ----------------------------
BEGIN;
INSERT INTO `up_role` (`id`, `name`, `label`, `introduce`, `create_time`, `update_time`) VALUES (1, '管理员', 'admin', '总管理员', '2023-11-16 22:31:24', NULL);
INSERT INTO `up_role` (`id`, `name`, `label`, `introduce`, `create_time`, `update_time`) VALUES (2, '注册用户', 'user', '前端注册的用户', '2023-11-16 22:31:36', NULL);
COMMIT;

-- ----------------------------
-- Table structure for up_role_port
-- ----------------------------
DROP TABLE IF EXISTS `up_role_port`;
CREATE TABLE `up_role_port` (
  `role_id` int(3) DEFAULT NULL COMMENT '角色id',
  `port_id` int(5) DEFAULT NULL COMMENT '路由ID',
  UNIQUE KEY `唯一` (`role_id`,`port_id`),
  KEY `role` (`role_id`) USING BTREE,
  KEY `up_role_port_ibfk_1` (`port_id`),
  CONSTRAINT `up_role_port_ibfk_1` FOREIGN KEY (`port_id`) REFERENCES `up_port` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `up_role_port_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `up_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of up_role_port
-- ----------------------------
BEGIN;
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 1);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 4);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 5);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 6);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 7);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 8);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 9);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 12);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 13);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 14);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 16);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 17);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 18);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 19);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 20);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 21);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 22);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 23);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 25);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 26);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 27);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 28);
INSERT INTO `up_role_port` (`role_id`, `port_id`) VALUES (1, 29);
COMMIT;

-- ----------------------------
-- Table structure for up_role_router
-- ----------------------------
DROP TABLE IF EXISTS `up_role_router`;
CREATE TABLE `up_role_router` (
  `role_id` int(3) DEFAULT NULL COMMENT '角色id',
  `router_id` int(5) DEFAULT NULL COMMENT '路由ID',
  UNIQUE KEY `唯一索引` (`role_id`,`router_id`),
  KEY `role` (`role_id`) USING BTREE,
  KEY `router` (`router_id`) USING BTREE,
  CONSTRAINT `router` FOREIGN KEY (`router_id`) REFERENCES `up_router` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `角色` FOREIGN KEY (`role_id`) REFERENCES `up_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of up_role_router
-- ----------------------------
BEGIN;
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 1);
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 2);
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 6);
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 7);
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 8);
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 9);
INSERT INTO `up_role_router` (`role_id`, `router_id`) VALUES (1, 10);
COMMIT;

-- ----------------------------
-- Table structure for up_router
-- ----------------------------
DROP TABLE IF EXISTS `up_router`;
CREATE TABLE `up_router` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题：中文',
  `path` varchar(100) NOT NULL COMMENT '路径',
  `name` varchar(100) NOT NULL COMMENT '标识，英文',
  `component` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `fid` int(5) NOT NULL DEFAULT '0' COMMENT '上级id',
  `sort` int(5) DEFAULT '0' COMMENT '排序，越大越靠前',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of up_router
-- ----------------------------
BEGIN;
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (1, '系统设置', '/system', 'system', '/system/router/add.vue', 'menu-setting', 0, 0, '2023-11-18 00:27:45', '2023-11-27 00:03:53');
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (2, '系统路由', '/system/router/list', 'systemRouter', '/system/router/list.vue', '', 1, 2, '2023-11-18 00:29:27', '2023-11-27 11:50:42');
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (6, '接口设置', '/system/port/list', 'systemPort', '/system/port/list.vue', '', 1, 1, '2023-11-27 00:13:49', '2023-11-27 11:50:37');
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (7, '角色', '/system/role/list', 'systemRole', '/system/role/list.vue', '', 1, 0, '2023-11-28 17:41:09', '2023-11-28 17:41:09');
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (8, '基础设置', '/system/setting/set', 'systemSettingSet', '/system/setting/set.vue', '', 1, 0, '2023-11-30 15:09:27', '2023-11-30 15:09:27');
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (9, '用户管理', '/users/users/list', 'users', '/users/users/list.vue', 'menu-user', 0, 0, '2023-11-30 23:38:29', '2023-11-30 23:40:25');
INSERT INTO `up_router` (`id`, `title`, `path`, `name`, `component`, `icon`, `fid`, `sort`, `create_time`, `update_time`) VALUES (10, '用户列表', '/users/users/list', 'usersUsersList', '/users/users/list.vue', '', 9, 0, '2023-11-30 23:40:19', '2023-11-30 23:40:19');
COMMIT;

-- ----------------------------
-- Table structure for up_users
-- ----------------------------
DROP TABLE IF EXISTS `up_users`;
CREATE TABLE `up_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `email` varchar(255) DEFAULT NULL COMMENT '用户邮箱',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `yan` varchar(255) NOT NULL COMMENT '随机盐',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `app_id` varchar(65) NOT NULL,
  `app_secret` varchar(100) NOT NULL,
  `vip_level` int(1) NOT NULL COMMENT '会员级别：1、普通，2、vip，3、svip',
  `role_id` int(3) NOT NULL COMMENT '角色ID',
  `vip_expire_time` datetime DEFAULT NULL COMMENT '会员等级过期时间',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '用户状态，1：正常，2：禁用',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE COMMENT '手机号不重复',
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户信息表';

-- ----------------------------
-- Records of up_users
-- ----------------------------
BEGIN;
INSERT INTO `up_users` (`id`, `phone`, `email`, `username`, `password`, `yan`, `create_time`, `update_time`, `app_id`, `app_secret`, `vip_level`, `role_id`, `vip_expire_time`, `status`) VALUES (2, '188888888', 'xxxxxxxxxx@qq.com', 'c7c87d42', 'xxxxxxxx', 'fb220967', '2023-11-16 22:50:53', '2023-12-10 11:59:13', 'upB16462534197084', '51b4b4ad-70b9-36ad-dfe3-a09fe03e6c03', 1, 1, NULL, 1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
