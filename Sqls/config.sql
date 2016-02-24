# Host: localhost  (Version: 5.5.47)
# Date: 2016-02-24 18:54:44
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES gb2312 */;

#
# Structure for table "g_menu"
#

DROP TABLE IF EXISTS `g_menu`;
CREATE TABLE `g_menu` (
  `MenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '�˵�Id',
  `MenuName` varchar(255) NOT NULL DEFAULT '' COMMENT '�˵���',
  `NodeLevel` int(11) NOT NULL DEFAULT '0' COMMENT '���ڵ�㼶',
  `ParentMenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '���˵�Id',
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '����ģ��Id',
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '������ҳ��Id',
  `IconCls` varchar(255) DEFAULT NULL COMMENT 'ͼ������',
  `IconAlign` varchar(255) DEFAULT NULL COMMENT 'ͼ���λ��',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '�Ƿ񼤻�',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  PRIMARY KEY (`MenuId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='�˵�';

#
# Data for table "g_menu"
#

INSERT INTO `g_menu` VALUES ('100000','ϵͳ����ģ��',0,'0','System','0',NULL,NULL,1,0),('100001','Ȩ�޹���',1,'100000','System','100000',NULL,NULL,1,0),('100002','�û���ά��',2,'100001','System','100000',NULL,NULL,1,0),('100003','�û���-�û�',2,'100001','System','100000',NULL,NULL,1,1),('100004','�û���-Ȩ��',2,'100001','System','100000',NULL,NULL,1,2),('100005','ҳ�����',1,'100000','System','0',NULL,NULL,1,1),('100006','�˵�ά��',2,'100005','System','100000',NULL,NULL,1,0),('100007','ҳ��ά��',2,'100005','System','100000',NULL,NULL,1,1),('100008','��ťά��',2,'100005','System','100000',NULL,NULL,1,2),('100009','ҳ��-��ť',2,'100005','System','100000',NULL,NULL,1,3),('100010','ҳ��-��������',2,'100005','System','100000',NULL,NULL,1,4),('100011','ģ�����',1,'100000','System','0',NULL,NULL,1,2),('100012','ģ��ά��',2,'100011','System','100000',NULL,NULL,1,0),('100013','��������',1,'100000','System','0',NULL,NULL,1,3),('100014','����˵��',2,'100013','System','100000',NULL,NULL,1,0),('100015','��ϵ��ʽ',2,'100013','System','100000',NULL,NULL,1,1);

#
# Structure for table "g_module"
#

DROP TABLE IF EXISTS `g_module`;
CREATE TABLE `g_module` (
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT 'ģ��Id',
  `ModuleName` varchar(255) NOT NULL DEFAULT '' COMMENT 'ģ����',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '�Ƿ񼤻�',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '����',
  PRIMARY KEY (`ModuleId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='ģ��';

#
# Data for table "g_module"
#

INSERT INTO `g_module` VALUES ('1111','ModuleName',1,10),('module1','ģ��1',0,0),('module2','ģ��2',0,1),('module3','ģ��3',1,2),('module4','ģ��4',1,3),('module5','ģ��5',1,4),('System','ϵͳ����',1,5);

#
# Structure for table "g_page"
#

DROP TABLE IF EXISTS `g_page`;
CREATE TABLE `g_page` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT 'ҳ��Id',
  `PageName` varchar(255) NOT NULL DEFAULT '' COMMENT 'ҳ������',
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '����ģ��Id',
  `Controller` varchar(255) NOT NULL DEFAULT '' COMMENT '������',
  `OuterLink` varchar(255) DEFAULT '' COMMENT '������',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '�Ƿ񼤻�',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='ҳ��';

#
# Data for table "g_page"
#

INSERT INTO `g_page` VALUES ('100000','ģ���ѯ��ɾ��','System','ModuleMG','',1),('100001','ģ�����ӡ��޸�','System','ModuleMG','',1),('100002','�˵���ѯ��ɾ�������ӡ��޸�','System','PageMG','',1),('100003','ҳ���ѯ��ɾ��','System','PageMG','',1),('100004','ҳ�����ӡ��޸�','System','PageMG','',1),('100005','��ť��ѯ��ɾ��','System','PageMG','',1),('100006','��ť���ӡ��޸�','System','PageMG','',1),('100007','ҳ�水ť���ӡ�ɾ��','System','PageMG','',1),('100008','ҳ��������ӡ��޸�','System','PageMG','',1);

#
# Structure for table "r_page_base"
#

DROP TABLE IF EXISTS `r_page_base`;
CREATE TABLE `r_page_base` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT 'ҳ��ID',
  `Width` varchar(255) DEFAULT NULL COMMENT '���',
  `Height` varchar(255) DEFAULT NULL COMMENT '�߶�',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '������ɫ',
  `Page` varchar(255) DEFAULT NULL COMMENT 'ҳ��',
  `Rows` varchar(255) DEFAULT NULL COMMENT '����',
  `DataSource` varchar(1000) DEFAULT NULL COMMENT '����Դsql',
  `BtnIdLst` varchar(1000) DEFAULT NULL COMMENT '��ťID�б�',
  `FormIdLst` varchar(1000) DEFAULT NULL COMMENT '��ID�б�',
  `FieldIdLst` varchar(1000) DEFAULT NULL COMMENT '�ֶ�Id�б�',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='ҳ���������';

#
# Data for table "r_page_base"
#


#
# Structure for table "r_page_btn"
#

DROP TABLE IF EXISTS `r_page_btn`;
CREATE TABLE `r_page_btn` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT 'ҳ��ID',
  `BtnId` varchar(255) NOT NULL DEFAULT '' COMMENT '��ťId',
  `BtnClass` varchar(255) DEFAULT NULL COMMENT '��ť����',
  `BtnName` varchar(255) DEFAULT NULL COMMENT '��ť��',
  `IconCls` varchar(255) DEFAULT NULL COMMENT '��ťͼ������',
  `Width` varchar(255) DEFAULT NULL COMMENT '���',
  `Height` varchar(255) DEFAULT NULL COMMENT '�߶�',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '������ɫ',
  `TriggerType` varchar(255) DEFAULT NULL COMMENT '������ʽ post/get/dialog/window.open/tab',
  `Action` varchar(255) DEFAULT NULL COMMENT '����',
  `IsActive` varchar(255) DEFAULT '1' COMMENT '�Ƿ񼤻�',
  PRIMARY KEY (`PageId`,`BtnId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='ҳ�水ť';

#
# Data for table "r_page_btn"
#


#
# Structure for table "r_page_form"
#

DROP TABLE IF EXISTS `r_page_form`;
CREATE TABLE `r_page_form` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT 'ҳ��ID',
  `FormId` varchar(255) NOT NULL DEFAULT '' COMMENT '��ID',
  `FormName` varchar(255) DEFAULT NULL COMMENT '������',
  `FormType` varchar(255) DEFAULT NULL COMMENT '������',
  `Width` varchar(255) DEFAULT NULL COMMENT '���',
  `Height` varchar(255) DEFAULT NULL COMMENT '�߶�',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '������ɫ',
  `DefaultVal` varchar(255) DEFAULT NULL COMMENT 'Ĭ��ֵ',
  `ValType` varchar(255) DEFAULT NULL COMMENT 'ֵ����',
  `ComparisonSign` varchar(255) DEFAULT NULL COMMENT '�ȽϷ���',
  `DBField` varchar(255) DEFAULT NULL COMMENT '���ݿ�Ƚϵ�����ֶ�',
  `IsRequired` int(11) DEFAULT '0' COMMENT '�Ƿ����',
  `IsActive` varchar(255) DEFAULT '1' COMMENT '�Ƿ񼤻�',
  PRIMARY KEY (`PageId`,`FormId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='ҳ���';

#
# Data for table "r_page_form"
#


#
# Structure for table "r_page_grid"
#

DROP TABLE IF EXISTS `r_page_grid`;
CREATE TABLE `r_page_grid` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT 'ҳ��ID',
  `FieldId` varchar(255) DEFAULT NULL COMMENT '�ֶ�Id',
  `FieldName` varchar(255) DEFAULT NULL COMMENT '�ֶ�����',
  `Width` varchar(255) DEFAULT NULL COMMENT '���',
  `Height` varchar(255) DEFAULT NULL COMMENT '�߶�',
  `BackgroundColor` varchar(255) DEFAULT NULL COMMENT '������ɫ',
  `IsDefaultSort` varchar(255) DEFAULT NULL COMMENT '�Ƿ�Ĭ������',
  `IsJumpParam` varchar(255) DEFAULT NULL COMMENT '�Ƿ���ת���ò���',
  `IsActive` varchar(255) DEFAULT '1' COMMENT '�Ƿ񼤻�',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='ҳ������';

#
# Data for table "r_page_grid"
#

