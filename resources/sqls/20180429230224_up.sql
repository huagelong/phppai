DROP TABLE IF EXISTS `base_access`;

CREATE TABLE `base_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `access` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';



# Dump of table base_admin_action_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_admin_action_log`;

CREATE TABLE `base_admin_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(50) DEFAULT NULL,
  `route` varchar(100) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `input_data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table base_admin_user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_admin_user_role`;

CREATE TABLE `base_admin_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户权限';



# Dump of table base_backup
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_backup`;

CREATE TABLE `base_backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `tables` text,
  `path` varchar(100) DEFAULT NULL COMMENT '备份路径',
  `status` tinyint(1) DEFAULT '0' COMMENT '0-备份失败,1-备份中，2-备份成功',
  `note` text,
  `yun_file_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table base_dbsync
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_dbsync`;

CREATE TABLE `base_dbsync` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL DEFAULT '',
  `ftype` varchar(5) DEFAULT 'up',
  `fstatus` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table base_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_file`;

CREATE TABLE `base_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '上传文件ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传文件组ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传人ID',
  `obj` varchar(255) NOT NULL DEFAULT '' COMMENT '文件对象',
  `originalz_name` varchar(100) DEFAULT NULL COMMENT '文件原始名称',
  `mime` varchar(255) DEFAULT NULL COMMENT '文件MIME',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `thirdpart_data` text COMMENT '第三方数据',
  `created_at` int(11) DEFAULT NULL COMMENT '上传时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dump of table base_file_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_file_group`;

CREATE TABLE `base_file_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '上传文件组ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '上传文件组名称',
  `code` varchar(100) NOT NULL DEFAULT '' COMMENT '上传文件组编码',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `base_file_group` (`id`, `name`, `code`, `created_at`, `updated_at`)
VALUES
	(1,'默认','default',1543209055,1543209055),
	(2,'头像','face',1543209055,1543209055),
	(5,'sql备份','backupsql',1545045855,1545045855);


# Dump of table base_file_used
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_file_used`;

CREATE TABLE `base_file_used` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL COMMENT 'upload_files id',
  `target_type` varchar(32) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dump of table base_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_option`;

CREATE TABLE `base_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(50) DEFAULT NULL COMMENT '配置名称',
  `option_key` varchar(50) DEFAULT NULL COMMENT '配置key',
  `group_id` int(11) DEFAULT NULL COMMENT 'group id',
  `option_value` text COMMENT '配置值',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `base_option` (`id`, `option_name`, `option_key`, `group_id`, `option_value`, `created_at`, `updated_at`)
VALUES
	(1,'oss_accessKeyID','oss_accessKeyID',1,'1111',1543209055,1544666369),
	(2,'oss_accessKeySecret','oss_accessKeySecret',1,'11111',1543209055,1544671494),
	(3,'oss_endpoint','oss_endpoint',1,'http://xxx.com',1543209055,1544598358),
	(4,'oss_bucket','oss_bucket',1,'1111',1543209055,1543209055),
	(5,'oss_useCname','oss_useCname',1,'1',1543209055,1543209055),
	(6,'uss_serviceName','uss_serviceName',2,'2tagcn',1543209055,1543209055),
	(7,'uss_operatorName','uss_operatorName',2,'eqweq',1543209055,1543209055),
	(8,'uss_operatorPwd','uss_operatorPwd',2,'qweqwe',1543209055,1543209055),
	(9,'uss_endpoint','uss_endpoint',2,'//2tagcn.qweqweq.upcdn.net',1543209055,1543209055),
	(10,'云存储切换(aliyun,upyun)','file_adapter',3,'upyun',1543209055,1545120998),
	(11,'oss_timeout','oss_timeout',1,'10',1543209055,1543209055),
	(12,'oss_ConnectTimeout','oss_ConnectTimeout',1,'1',1543209055,1544603156),
	(13,'数据库备份目录','backup_dir',3,'/tmp/backup',1543209055,1543209055),
	(14,'网站名称','site_name',3,'2tag社区',1543209055,1543209055),
	(15,'主机','host',4,'smtp.163.com',1543209055,1543209055),
	(16,'端口','port',4,'465',1543209055,1543209055),
	(17,'账户','username',4,'eqweqw@163.com',1543209055,1543209055),
	(18,'密码','password',4,'qweqweqwe',1543209055,1543209055),
	(19,'传输协议','encryption',4,'ssl',1543209055,1543209055),
	(20,'网站网址','site_host',3,'www.2tag.cn',1543209055,1543209055),
	(21,'统计','tongji',3,'111',1543209055,1543209055);


# Dump of table base_option_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_option_group`;

CREATE TABLE `base_option_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) DEFAULT NULL COMMENT '组名称',
  `group_key` varchar(50) DEFAULT NULL COMMENT '组key',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `base_option_group` (`id`, `group_name`, `group_key`, `created_at`, `updated_at`)
VALUES
	(1,'阿里云','aliyun',1543209055,1543209055),
	(2,'又拍云','upyun',1543209055,1543209055),
	(3,'基本配置','base',1543209055,1543209055),
	(4,'邮箱发送','email_smtp',1543209055,1543209055);


# Dump of table base_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_role`;

CREATE TABLE `base_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `descr` text COMMENT '描述',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';


INSERT INTO `base_role` (`id`, `name`, `descr`, `created_at`, `updated_at`)
VALUES
	(1,'普通会员','普通会员,没有后台权限',1543209055,1543209055),
	(2,'测试管理员','测试管理员',1543209055,1543209055);


# Dump of table base_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `base_user`;

CREATE TABLE `base_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(12) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL COMMENT '昵称',
  `full_name` varchar(100) DEFAULT NULL COMMENT '姓名',
  `face_img` varchar(250) DEFAULT NULL COMMENT '人物头像',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `sex` tinyint(1) DEFAULT NULL COMMENT '1-男,2-女',
  `passwd` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是管理员账号',
  `is_lock` tinyint(1) DEFAULT '0' COMMENT '是否被锁定,1-是，0-否',
  `last_login_time` int(11) DEFAULT NULL,
  `report_uid` int(11) DEFAULT '1' COMMENT '汇报上级',
  `reg_source` varchar(11) DEFAULT NULL COMMENT 'pc,ios,android',
  `pc_login_token` varchar(100) DEFAULT NULL,
  `app_login_token` varchar(100) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `base_user` (`id`, `mobile`, `display_name`, `full_name`, `face_img`, `birthday`, `sex`, `passwd`, `is_admin`, `is_lock`, `last_login_time`, `report_uid`, `reg_source`, `pc_login_token`, `app_login_token`, `updated_at`, `created_at`)
VALUES
	(1,'11111111111','管理员',NULL,'',NULL,NULL,'jNUXj1rymueNxln5FkXYdRhqSdH53+xgGHyORC8H0OR0CYV5tC0zyb15NxQShuwNZQ==',2,0,1547861752,0,NULL,'7bac8b8b0aee058b310be61f31f64af14381993e',NULL,1547861752,1543209055);