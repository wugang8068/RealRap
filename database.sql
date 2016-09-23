# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.25)
# Database: mm
# Generation Time: 2016-09-23 03:44:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table inf_api_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_api_keys`;

CREATE TABLE `inf_api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table inf_api_limits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_api_limits`;

CREATE TABLE `inf_api_limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table inf_api_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_api_logs`;

CREATE TABLE `inf_api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table inf_cd_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_cd_keys`;

CREATE TABLE `inf_cd_keys` (
  `cdk_id` int(11) NOT NULL AUTO_INCREMENT,
  `cdk_str` varchar(50) NOT NULL COMMENT 'idk值',
  `cdk_bind_user` int(11) DEFAULT NULL COMMENT '绑定的用户id',
  `cdk_binded` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '是否已绑定 1已绑定  -1未绑定',
  `cdk_bind_device` varchar(45) NOT NULL,
  `cdk_create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cdk_active_time` datetime DEFAULT NULL,
  `cdk_expire_time` datetime DEFAULT NULL COMMENT '失效时间',
  `cdk_belong_agent` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '是否删除   -1 未删除  1已删除',
  `has_been_sold` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已售',
  `sold_time` datetime DEFAULT NULL COMMENT '出售时间',
  `comments` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cdk_id`),
  UNIQUE KEY `cdk_id_UNIQUE` (`cdk_id`),
  UNIQUE KEY `cdk_str_UNIQUE` (`cdk_str`),
  KEY `cdk_bind_user` (`cdk_bind_user`),
  KEY `cdk_str` (`cdk_str`),
  KEY `cdk_bind_device_UNIQUE` (`cdk_bind_device`) USING BTREE,
  KEY `cdk_str_2` (`cdk_str`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table inf_cd_keys_process
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_cd_keys_process`;

CREATE TABLE `inf_cd_keys_process` (
  `process_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_key_id` int(11) NOT NULL,
  `process_content` text NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`process_id`),
  UNIQUE KEY `process_id_UNIQUE` (`process_id`),
  KEY `cd_key_id` (`cd_key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table inf_example_head_image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_example_head_image`;

CREATE TABLE `inf_example_head_image` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `image_path` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table inf_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `inf_user`;

CREATE TABLE `inf_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_nick_name` varchar(45) DEFAULT NULL,
  `user_device_id` text NOT NULL,
  `user_mobile` varchar(20) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_create_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_mobile_UNIQUE` (`user_mobile`),
  KEY `user_mobile` (`user_mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sf_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sf_config`;

CREATE TABLE `sf_config` (
  `sf_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `sf_table` varchar(64) NOT NULL DEFAULT '',
  `sf_field` varchar(64) NOT NULL DEFAULT '',
  `sf_type` varchar(16) DEFAULT 'default',
  `sf_related` varchar(100) DEFAULT '',
  `sf_label` varchar(64) DEFAULT '',
  `sf_desc` tinytext,
  `sf_order` int(3) DEFAULT NULL,
  `sf_hidden` int(1) DEFAULT '0',
  PRIMARY KEY (`sf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wx_def_order_state
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_def_order_state`;

CREATE TABLE `wx_def_order_state` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_name` varchar(50) NOT NULL,
  `state_comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table wx_his_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_his_order`;

CREATE TABLE `wx_his_order` (
  `history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_state` int(11) NOT NULL,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table wx_inf_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_inf_order`;

CREATE TABLE `wx_inf_order` (
  `index_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(50) NOT NULL,
  `fee` float(10,0) NOT NULL COMMENT '金额  单位元',
  `create_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `related_user` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单状态',
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `cdk` int(50) DEFAULT NULL,
  PRIMARY KEY (`index_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table wx_inf_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_inf_product`;

CREATE TABLE `wx_inf_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `price` float(10,0) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `goods_tag` varchar(255) DEFAULT NULL COMMENT '商品标记，代金券或立减优惠功能的参数，',
  `product_detail_info` text COMMENT '商品详细描述',
  `commets` text,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table wx_inf_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_inf_user`;

CREATE TABLE `wx_inf_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_openid` varchar(255) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_nick_name` varchar(100) DEFAULT NULL,
  `user_avatar` varchar(255) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_gender` tinyint(1) NOT NULL DEFAULT '1',
  `user_province` varchar(50) DEFAULT NULL,
  `rebate_already_mentioned` double(11,1) NOT NULL DEFAULT '0.0' COMMENT '已提现',
  `rebate_unmentioned` double(11,1) NOT NULL DEFAULT '0.0' COMMENT '未提现',
  `rebate_being_mention` double(11,1) NOT NULL DEFAULT '0.0' COMMENT '提现中',
  `is_subscribed` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已关注',
  `user_extension_qrcode_media_id` varchar(225) DEFAULT NULL COMMENT '用户推广素材id',
  `user_extension_qrcode_expire_time` datetime DEFAULT NULL COMMENT '二维码素材过期时间',
  `subscribe_time` datetime NOT NULL COMMENT '用户关注时间',
  `agent_user` int(11) DEFAULT NULL COMMENT '管理的用户, 即是代理的用户',
  `bank_real_name` varchar(50) DEFAULT NULL COMMENT '银行卡名称',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table wx_inf_user_agent_relation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_inf_user_agent_relation`;

CREATE TABLE `wx_inf_user_agent_relation` (
  `relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `related_user_id` int(11) NOT NULL,
  `agent_user_id` int(11) NOT NULL,
  PRIMARY KEY (`relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
