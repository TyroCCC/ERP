# Host: localhost  (Version: 5.5.47)
# Date: 2016-02-23 21:36:46
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES gb2312 */;

#
# Structure for table "g_menu"
#

DROP TABLE IF EXISTS `g_menu`;
CREATE TABLE `g_menu` (
  `MenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '菜单Id',
  `MenuName` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名',
  `NodeLevel` int(11) NOT NULL DEFAULT '0' COMMENT '树节点层级',
  `ParentMenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '父菜单Id',
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块Id',
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '关联的页面Id',
  `IconCls` varchar(255) DEFAULT NULL COMMENT '图标类名',
  `IconAlign` varchar(255) DEFAULT NULL COMMENT '图标的位置',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`MenuId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='菜单';

#
# Data for table "g_menu"
#

INSERT INTO `g_menu` VALUES ('100000','系统配置模块',0,'0','System','0',NULL,NULL,1,0),('100001','权限管理',1,'100000','System','100000',NULL,NULL,1,0),('100002','用户组维护',2,'100001','System','100000',NULL,NULL,1,0),('100003','用户组-用户',2,'100001','System','100000',NULL,NULL,1,1),('100004','用户组-权限',2,'100001','System','100000',NULL,NULL,1,2),('100005','页面管理',1,'100000','System','0',NULL,NULL,1,1),('100006','菜单维护',2,'100005','System','100000',NULL,NULL,1,0),('100007','页面维护',2,'100005','System','100000',NULL,NULL,1,1),('100008','按钮维护',2,'100005','System','100000',NULL,NULL,1,2),('100009','页面-按钮',2,'100005','System','100000',NULL,NULL,1,3),('100010','页面-参数配置',2,'100005','System','100000',NULL,NULL,1,4),('100011','模块管理',1,'100000','System','0',NULL,NULL,1,2),('100012','模块维护',2,'100011','System','100000',NULL,NULL,1,0),('100013','其他管理',1,'100000','System','0',NULL,NULL,1,3),('100014','操作说明',2,'100013','System','100000',NULL,NULL,1,0),('100015','联系方式',2,'100013','System','100000',NULL,NULL,1,1);

#
# Structure for table "g_module"
#

DROP TABLE IF EXISTS `g_module`;
CREATE TABLE `g_module` (
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '模块Id',
  `ModuleName` varchar(255) NOT NULL DEFAULT '' COMMENT '模块名',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`ModuleId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='模块';

#
# Data for table "g_module"
#

INSERT INTO `g_module` VALUES ('1111','ModuleName',1,10),('module1','模块1',0,0),('module2','模块2',0,1),('module3','模块3',1,2),('module4','模块4',1,3),('module5','模块5',1,4),('System','系统配置',1,5);

#
# Structure for table "g_page"
#

DROP TABLE IF EXISTS `g_page`;
CREATE TABLE `g_page` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面Id',
  `PageName` varchar(255) NOT NULL DEFAULT '' COMMENT '页面名字',
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块Id',
  `Controller` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器',
  `OuterLink` varchar(255) DEFAULT '' COMMENT '外链接',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面';

#
# Data for table "g_page"
#

INSERT INTO `g_page` VALUES ('100000','模块查询、删除','System','ModuleMG','',1),('100001','模块增加、修改','System','ModuleMG','',1),('100002','菜单查询、删除、增加、修改','System','PageMG','',1),('100003','页面查询、删除','System','PageMG','',1),('100004','页面增加、修改','System','PageMG','',1),('100005','按钮查询、删除','System','PageMG','',1),('100006','按钮增加、修改','System','PageMG','',1),('100007','页面按钮增加、删除','System','PageMG','',1),('100008','页面参数增加、修改','System','PageMG','',1);

#
# Structure for table "r_page_base"
#

DROP TABLE IF EXISTS `r_page_base`;
CREATE TABLE `r_page_base` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面ID',
  `Width` varchar(255) DEFAULT NULL COMMENT '宽度',
  `Height` varchar(255) DEFAULT NULL COMMENT '高度',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '背景颜色',
  `Page` varchar(255) DEFAULT NULL COMMENT '页码',
  `Rows` varchar(255) DEFAULT NULL COMMENT '行数',
  `DataSource` varchar(1000) DEFAULT NULL COMMENT '数据源sql',
  `BtnIdLst` varchar(1000) DEFAULT NULL COMMENT '按钮ID列表',
  `FormIdLst` varchar(1000) DEFAULT NULL COMMENT '表单ID列表',
  `FieldIdLst` varchar(1000) DEFAULT NULL COMMENT '字段Id列表',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面基本配置';

#
# Data for table "r_page_base"
#


#
# Structure for table "r_page_btn"
#

DROP TABLE IF EXISTS `r_page_btn`;
CREATE TABLE `r_page_btn` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面ID',
  `BtnId` varchar(255) NOT NULL DEFAULT '' COMMENT '按钮Id',
  `BtnClass` varchar(255) DEFAULT NULL COMMENT '按钮类名',
  `BtnName` varchar(255) DEFAULT NULL COMMENT '按钮名',
  `IconCls` varchar(255) DEFAULT NULL COMMENT '按钮图标类名',
  `Width` varchar(255) DEFAULT NULL COMMENT '宽度',
  `Height` varchar(255) DEFAULT NULL COMMENT '高度',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '背景颜色',
  `TriggerType` varchar(255) DEFAULT NULL COMMENT '触发方式 post/get/dialog/window.open/tab',
  `Action` varchar(255) DEFAULT NULL COMMENT '方法',
  `IsActive` varchar(255) DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`PageId`,`BtnId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面按钮';

#
# Data for table "r_page_btn"
#


#
# Structure for table "r_page_form"
#

DROP TABLE IF EXISTS `r_page_form`;
CREATE TABLE `r_page_form` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面ID',
  `FormId` varchar(255) NOT NULL DEFAULT '' COMMENT '表单ID',
  `FormName` varchar(255) DEFAULT NULL COMMENT '表单标题',
  `FormType` varchar(255) DEFAULT NULL COMMENT '表单类型',
  `Width` varchar(255) DEFAULT NULL COMMENT '宽度',
  `Height` varchar(255) DEFAULT NULL COMMENT '高度',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '背景颜色',
  `DefaultVal` varchar(255) DEFAULT NULL COMMENT '默认值',
  `ValType` varchar(255) DEFAULT NULL COMMENT '值类型',
  `ComparisonSign` varchar(255) DEFAULT NULL COMMENT '比较符号',
  `DBField` varchar(255) DEFAULT NULL COMMENT '数据库比较的相对字段',
  `IsActive` varchar(255) DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`PageId`,`FormId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面表单';

#
# Data for table "r_page_form"
#


#
# Structure for table "r_page_grid"
#

DROP TABLE IF EXISTS `r_page_grid`;
CREATE TABLE `r_page_grid` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面ID',
  `FieldId` varchar(255) DEFAULT NULL COMMENT '字段Id',
  `FieldName` varchar(255) DEFAULT NULL COMMENT '字段名字',
  `Width` varchar(255) DEFAULT NULL COMMENT '宽度',
  `Height` varchar(255) DEFAULT NULL COMMENT '高度',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '背景颜色',
  `IsDefaultSort` varchar(255) DEFAULT NULL COMMENT '是否默认排序',
  `IsJumpParam` varchar(255) DEFAULT NULL COMMENT '是否跳转所用参数',
  `IsActive` varchar(255) DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面网格';

#
# Data for table "r_page_grid"
#

