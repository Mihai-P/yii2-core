-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `AdminMenu`;
CREATE TABLE `AdminMenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AdminMenu_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `internal` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ap` text,
  `order` int(11) NOT NULL,
  `show_mobile` varchar(255) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `AdminMenu_ibfk_1` (`AdminMenu_id`),
  CONSTRAINT `AdminMenu_ibfk_1` FOREIGN KEY (`AdminMenu_id`) REFERENCES `AdminMenu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
(1,	NULL,	'Dashboard',	'dashboard',	'/',	'',	1,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(2,	NULL,	'Administrators',	'Administrators',	'',	'read::Group',	2,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(3,	2,	'Groups',	'GroupController',	'/core/Group/admin/',	'read::Group',	1,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(4,	2,	'Administrators',	'AdministratorController',	'/core/Administrator/admin/',	'read::Administrator',	2,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(5,	NULL,	'Contacts',	'ContactController',	'/core/Contact/admin/',	'read::Contact',	1,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(6,	NULL,	'Website',	'Website',	'',	'update::Website',	3,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(7,	6,	'Websites',	'WebsiteController',	'/core/Website/update?id=1',	'update::Website',	4,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(8,	6,	'Menus',	'MenuController',	'/core/Menu/admin/',	'read::Menu',	2,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(9,	6,	'Pages',	'PageController',	'/core/Page/admin/',	'read::Page',	3,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(10,	NULL,	'Tags',	'TagController',	'/core/Tag/admin/',	'read::Tag',	1,	'1',	'active',	NULL,	NULL,	NULL,	NULL),
(11,	6,	'Page Templates',	'PageTemplateController',	'/core/PageTemplate/admin/',	'read::PageTemplate',	4,	'1',	'active',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `audit_trail`;
CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_value` text,
  `new_value` text,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `field` varchar(255) DEFAULT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_model_id` (`model_id`),
  KEY `idx_audit_trail_model` (`model`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `AuthAssignment`;
CREATE TABLE `AuthAssignment` (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bizrule` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data` text CHARACTER SET utf8 COLLATE utf8_bin,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `AuthAssignment` (`item_name`, `user_id`, `bizrule`, `data`, `created_at`) VALUES
('1',	'1',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE `AuthItem` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `bizrule` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data` text CHARACTER SET utf8 COLLATE utf8_bin,
  `rule_name` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`, `rule_name`, `created_at`, `updated_at`) VALUES
('1',	1,	'',	NULL,	'N;',	NULL,	NULL,	NULL),
('create::Administrator',	0,	'create Administrator',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:14:\"Administrators\";}',	NULL,	NULL,	NULL),
('create::Contact',	0,	'create Contact',	NULL,	'a:2:{s:6:\"module\";s:8:\"Contacts\";s:10:\"controller\";s:8:\"Contacts\";}',	NULL,	NULL,	NULL),
('create::Group',	0,	'create Group',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:6:\"Groups\";}',	NULL,	NULL,	NULL),
('create::Menu',	0,	'create Menu',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Menus\";}',	NULL,	NULL,	NULL),
('create::Page',	0,	'create Page',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Pages\";}',	NULL,	NULL,	NULL),
('create::PageTemplate',	0,	'create PageTemplate',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:14:\"Page Templates\";}',	NULL,	NULL,	NULL),
('create::Tag',	0,	'create Tag',	NULL,	'a:2:{s:6:\"module\";s:4:\"Tags\";s:10:\"controller\";s:4:\"Tags\";}',	NULL,	NULL,	NULL),
('delete::Administrator',	0,	'delete Administrator',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:14:\"Administrators\";}',	NULL,	NULL,	NULL),
('delete::Contact',	0,	'delete Contact',	NULL,	'a:2:{s:6:\"module\";s:8:\"Contacts\";s:10:\"controller\";s:8:\"Contacts\";}',	NULL,	NULL,	NULL),
('delete::Group',	0,	'delete Group',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:6:\"Groups\";}',	NULL,	NULL,	NULL),
('delete::Menu',	0,	'delete Menu',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Menus\";}',	NULL,	NULL,	NULL),
('delete::Page',	0,	'delete Page',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Pages\";}',	NULL,	NULL,	NULL),
('delete::PageTemplate',	0,	'delete PageTemplate',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:14:\"Page Templates\";}',	NULL,	NULL,	NULL),
('delete::Tag',	0,	'delete Tag',	NULL,	'a:2:{s:6:\"module\";s:4:\"Tags\";s:10:\"controller\";s:4:\"Tags\";}',	NULL,	NULL,	NULL),
('read::Administrator',	0,	'read Administrator',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:14:\"Administrators\";}',	NULL,	NULL,	NULL),
('read::Contact',	0,	'read Contact',	NULL,	'a:2:{s:6:\"module\";s:8:\"Contacts\";s:10:\"controller\";s:8:\"Contacts\";}',	NULL,	NULL,	NULL),
('read::Group',	0,	'read Group',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:6:\"Groups\";}',	NULL,	NULL,	NULL),
('read::Menu',	0,	'read Menu',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Menus\";}',	NULL,	NULL,	NULL),
('read::Page',	0,	'read Page',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Pages\";}',	NULL,	NULL,	NULL),
('read::PageTemplate',	0,	'read PageTemplate',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:14:\"Page Templates\";}',	NULL,	NULL,	NULL),
('read::Tag',	0,	'read Tag',	NULL,	'a:2:{s:6:\"module\";s:4:\"Tags\";s:10:\"controller\";s:4:\"Tags\";}',	NULL,	NULL,	NULL),
('update own::Administrator',	0,	'update own Administrator',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:14:\"Administrators\";}',	NULL,	NULL,	NULL),
('update::Administrator',	0,	'update Administrator',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:14:\"Administrators\";}',	NULL,	NULL,	NULL),
('update::Contact',	0,	'update Contact',	NULL,	'a:2:{s:6:\"module\";s:8:\"Contacts\";s:10:\"controller\";s:8:\"Contacts\";}',	NULL,	NULL,	NULL),
('update::Group',	0,	'update Group',	NULL,	'a:2:{s:6:\"module\";s:14:\"Administrators\";s:10:\"controller\";s:6:\"Groups\";}',	NULL,	NULL,	NULL),
('update::Menu',	0,	'update Menu',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Menus\";}',	NULL,	NULL,	NULL),
('update::Page',	0,	'update Page',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:5:\"Pages\";}',	NULL,	NULL,	NULL),
('update::PageTemplate',	0,	'update PageTemplate',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:14:\"Page Templates\";}',	NULL,	NULL,	NULL),
('update::Tag',	0,	'update Tag',	NULL,	'a:2:{s:6:\"module\";s:4:\"Tags\";s:10:\"controller\";s:4:\"Tags\";}',	NULL,	NULL,	NULL),
('update::Website',	0,	'update Website',	NULL,	'a:2:{s:6:\"module\";s:7:\"Website\";s:10:\"controller\";s:8:\"Websites\";}',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `AuthItemChild_ibfk_2` (`child`),
  CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('1',	'create::Administrator'),
('1',	'create::Contact'),
('1',	'create::Group'),
('1',	'create::Menu'),
('1',	'create::Page'),
('1',	'create::PageTemplate'),
('1',	'create::Tag'),
('1',	'delete::Administrator'),
('1',	'delete::Contact'),
('1',	'delete::Group'),
('1',	'delete::Menu'),
('1',	'delete::Page'),
('1',	'delete::PageTemplate'),
('1',	'delete::Tag'),
('1',	'read::Administrator'),
('1',	'read::Contact'),
('1',	'read::Group'),
('1',	'read::Menu'),
('1',	'read::Page'),
('1',	'read::PageTemplate'),
('1',	'read::Tag'),
('1',	'update own::Administrator'),
('1',	'update::Administrator'),
('1',	'update::Contact'),
('1',	'update::Group'),
('1',	'update::Menu'),
('1',	'update::Page'),
('1',	'update::PageTemplate'),
('1',	'update::Tag'),
('1',	'update::Website');

DROP TABLE IF EXISTS `Contact_Tag`;
CREATE TABLE `Contact_Tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tag_id` int(11) NOT NULL,
  `Contact_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Contact_Tag_unique` (`Tag_id`,`Contact_id`,`status`),
  KEY `Contact_Tag_Contact_id` (`Contact_id`),
  CONSTRAINT `Contact_Tag_Contact_id` FOREIGN KEY (`Contact_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Contact_Tag_Tag_id` FOREIGN KEY (`Tag_id`) REFERENCES `Tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Email`;
CREATE TABLE `Email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `to_name` varchar(255) NOT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT '',
  `text` text,
  `html` text,
  `route` varchar(255) NOT NULL DEFAULT 'mandrill',
  `tries` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Group`;
CREATE TABLE `Group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Group` (`id`, `name`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
(1,	'Super Admin',	'active',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `History`;
CREATE TABLE `History` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `History_create_by` (`create_by`),
  CONSTRAINT `History_create_by` FOREIGN KEY (`create_by`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Menu`;
CREATE TABLE `Menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Menu_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `internal` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `rel` varchar(255) DEFAULT NULL,
  `responsive` varchar(255) NOT NULL DEFAULT '',
  `target` varchar(255) DEFAULT NULL,
  `ap` text,
  `order` int(11) NOT NULL,
  `root` int(11) unsigned DEFAULT NULL,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Menu_Menu_id` (`Menu_id`),
  CONSTRAINT `Menu_Menu_id` FOREIGN KEY (`Menu_id`) REFERENCES `Menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base',	1411223281),
('m130524_201442_init',	1411223282),
('m131204_122510_create_AdminMenu_table',	1411223301),
('m131205_091056_auth',	1411223301),
('m131205_091157_create_Group_table',	1411223301),
('m131205_101258_create_User_table',	1411223302),
('m131205_113511_create_Website_table',	1411223302),
('m131205_124521_create_WebsiteStat_table',	1411223302),
('m131205_131516_create_Menu_table',	1411223302),
('m131205_134345_create_Page_table',	1411223302),
('m131206_222244_create_Tag_table',	1411223302),
('m131207_234947_create_Note_table',	1411223302),
('m131207_234948_create_Email_table',	1411223302),
('m131213_135444_create_Seo_table',	1411223302),
('m131219_135444_create_Object_table',	1411223302),
('m140629_123324_alter_Auth_Tables',	1411223303),
('m140709_000727_create_Contact_Tag_table',	1411223303),
('m140713_055442_create_History_table',	1411223303),
('m140822_021737_create_PageTemplate_table',	1411223303),
('m140831_093732_create_audit_trail',	1411223303);

DROP TABLE IF EXISTS `Note`;
CREATE TABLE `Note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Model` varchar(255) NOT NULL,
  `Model_id` int(11) NOT NULL,
  `description` text,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Object`;
CREATE TABLE `Object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Model` varchar(255) NOT NULL,
  `Model_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text,
  `required` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Page`;
CREATE TABLE `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `PageTemplate_id` int(11) NOT NULL DEFAULT '1',
  `url` varchar(255) DEFAULT NULL,
  `h1` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `content` text,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Page_PageTemplate_id` (`PageTemplate_id`),
  CONSTRAINT `Page_PageTemplate_id` FOREIGN KEY (`PageTemplate_id`) REFERENCES `PageTemplate` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `PageTemplate`;
CREATE TABLE `PageTemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `PageTemplate` (`id`, `name`, `template`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
(1,	'Main',	'main.php',	'active',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `Seo`;
CREATE TABLE `Seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Model` varchar(255) NOT NULL,
  `Model_id` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Tag`;
CREATE TABLE `Tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Tag_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Group_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Contact',
  `password` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(64) DEFAULT NULL,
  `auth_key` varchar(128) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `validation_key` varchar(255) DEFAULT NULL,
  `login_attempts` int(10) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `User_Group_id` (`Group_id`),
  CONSTRAINT `User_Group_id` FOREIGN KEY (`Group_id`) REFERENCES `Group` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `User` (`id`, `Group_id`, `type`, `password`, `password_reset_token`, `auth_key`, `name`, `firstname`, `lastname`, `picture`, `email`, `phone`, `mobile`, `validation_key`, `login_attempts`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
(1,	1,	'Administrator',	'$2y$13$urIOkFrYLekr55J97kmX/eIHSm3kSP0NrvAaCgNdAG91cRQhNximG',	NULL,	'YCrxodub8SMQLrBV-Q5MKeclbAoCJ7XT',	'Firstname Lastname',	'Firstname',	'Lastname',	NULL,	'webmaster@2ezweb.com.au',	NULL,	NULL,	NULL,	0,	'active',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Website`;
CREATE TABLE `Website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Website` (`id`, `name`, `host`, `theme`, `template`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
(1,	'Default',	'default',	'default',	'@core/views/website/default',	'active',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `WebsiteStat`;
CREATE TABLE `WebsiteStat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pageviews` int(11) unsigned NOT NULL DEFAULT '0',
  `visitors` int(11) unsigned NOT NULL DEFAULT '0',
  `visits` int(11) unsigned NOT NULL DEFAULT '0',
  `newvisits` int(11) unsigned NOT NULL DEFAULT '0',
  `theme` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `WebsiteStat` (`id`, `name`, `pageviews`, `visitors`, `visits`, `newvisits`, `theme`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
(1,	'2014-09-21',	0,	0,	0,	0,	'',	'active',	NULL,	NULL,	NULL,	NULL);

-- 2014-09-20 14:28:36
