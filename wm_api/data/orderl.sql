# Host: localhost  (Version: 5.5.5-10.1.37-MariaDB)
# Date: 2021-01-05 13:28:00
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "rh_admin"
#

DROP TABLE IF EXISTS `rh_admin`;
CREATE TABLE `rh_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL COMMENT '用户名',
  `password` varchar(60) NOT NULL,
  `group_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '管理组ID',
  `ip` varchar(30) DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '是否禁用',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `ucid` int(1) DEFAULT '3' COMMENT 'ucid',
  `login_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';

#
# Data for table "rh_admin"
#


#
# Structure for table "rh_article"
#

DROP TABLE IF EXISTS `rh_article`;
CREATE TABLE `rh_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章编号',
  `type` int(11) NOT NULL COMMENT '0活动公告，1独立文章，3公告',
  `title` varchar(50) NOT NULL COMMENT '文章标题',
  `summary` varchar(140) DEFAULT '' COMMENT '文章摘要',
  `content` text NOT NULL COMMENT '文章正文',
  `image` varchar(255) DEFAULT '' COMMENT '文章标题图片',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示 1 显示 0 不显示',
  `author` varchar(50) DEFAULT NULL COMMENT '发布者用户名 ',
  `created_at` int(11) DEFAULT '0' COMMENT '文章发布时间',
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='CMS文章表';

#
# Data for table "rh_article"
#


#
# Structure for table "rh_banner"
#

DROP TABLE IF EXISTS `rh_banner`;
CREATE TABLE `rh_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='banner管理表';

#
# Data for table "rh_banner"
#

INSERT INTO `rh_banner` VALUES (1,'首页广告位','首页轮播图',NULL,0,3),(2,'点餐页广告','点餐页广告',NULL,0,3);

#
# Structure for table "rh_banner_item"
#

DROP TABLE IF EXISTS `rh_banner_item`;
CREATE TABLE `rh_banner_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '跳转类型',
  `jump_id` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `is_visible` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示  1 显示 0 不显示',
  `sort` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='banner子项表';

#
# Data for table "rh_banner_item"
#


#
# Structure for table "rh_category"
#

DROP TABLE IF EXISTS `rh_category`;
CREATE TABLE `rh_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL COMMENT '名称',
  `short_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类简称 ',
  `pid` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `is_visible` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示  1 显示 0 不显示',
  `sort` int(11) DEFAULT NULL,
  `category_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '商品分类图片',
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类表';

#
# Data for table "rh_category"
#


#
# Structure for table "rh_favorites"
#

DROP TABLE IF EXISTS `rh_favorites`;
CREATE TABLE `rh_favorites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `fav_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `img_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品收藏时价格',
  `create_time` int(11) DEFAULT '0' COMMENT '收藏时间',
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='收藏表';

#
# Data for table "rh_favorites"
#


#
# Structure for table "rh_goods"
#

DROP TABLE IF EXISTS `rh_goods`;
CREATE TABLE `rh_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
  `bannerimgs` text COMMENT '广告图片',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `market_price` decimal(10,2) DEFAULT NULL COMMENT '市场价',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '价格',
  `vip_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'vip价格',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `collects` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `star` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '好评星级',
  `evaluates` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评价数',
  `img_id` text NOT NULL COMMENT '商品主图',
  `video_id` int(11) NOT NULL DEFAULT '0' COMMENT '视频Id',
  `keywords` varchar(255) DEFAULT '' COMMENT '商品关键词',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简介，促销语',
  `content` text NOT NULL COMMENT '商品详情',
  `detailimgs` text COMMENT '图片详情',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '是否热销商品',
  `is_recommend` int(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_new` int(1) NOT NULL DEFAULT '0' COMMENT '是否新品',
  `state` tinyint(3) NOT NULL DEFAULT '1' COMMENT '商品状态 0下架，1正常，10违规（禁售）',
  `created_at` int(11) DEFAULT '0' COMMENT '商品添加时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '商品编辑时间',
  `deleted_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`goods_id`) USING BTREE,
  KEY `UK_ns_goods_category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品表';

#
# Data for table "rh_goods"
#


#
# Structure for table "rh_goods_sku"
#

DROP TABLE IF EXISTS `rh_goods_sku`;
CREATE TABLE `rh_goods_sku` (
  `sku_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表序号',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `json` text NOT NULL,
  PRIMARY KEY (`sku_id`) USING BTREE,
  UNIQUE KEY `goods_id` (`goods_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品skui规格价格库存信息表';

#
# Data for table "rh_goods_sku"
#


#
# Structure for table "rh_group"
#

DROP TABLE IF EXISTS `rh_group`;
CREATE TABLE `rh_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rule` text NOT NULL COMMENT '规则数组',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "rh_group"
#

INSERT INTO `rh_group` VALUES (1,'超级管理员','',NULL,NULL,3);

#
# Structure for table "rh_group_rule"
#

DROP TABLE IF EXISTS `rh_group_rule`;
CREATE TABLE `rh_group_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "rh_group_rule"
#


#
# Structure for table "rh_image"
#

DROP TABLE IF EXISTS `rh_image`;
CREATE TABLE `rh_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `use_name` varchar(80) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT '图片分类',
  `is_visible` int(11) NOT NULL DEFAULT '1' COMMENT '是否能显示1能0不能',
  `deleted_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='图片总表';

#
# Data for table "rh_image"
#


#
# Structure for table "rh_image_category"
#

DROP TABLE IF EXISTS `rh_image_category`;
CREATE TABLE `rh_image_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `is_visible` int(11) NOT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "rh_image_category"
#


#
# Structure for table "rh_money_log"
#

DROP TABLE IF EXISTS `rh_money_log`;
CREATE TABLE `rh_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `content` varchar(800) NOT NULL,
  `operator` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `wx_refund` varchar(50) DEFAULT NULL COMMENT '微信退款id',
  `created_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单日志表';

#
# Data for table "rh_money_log"
#


#
# Structure for table "rh_nav"
#

DROP TABLE IF EXISTS `rh_nav`;
CREATE TABLE `rh_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(50) NOT NULL COMMENT '名称',
  `img_id` varchar(255) NOT NULL COMMENT '图片ID',
  `url` varchar(255) DEFAULT NULL COMMENT '转跳路径',
  `url_name` varchar(20) DEFAULT NULL COMMENT '转跳名字',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '转跳分类ID',
  `is_visible` int(11) NOT NULL COMMENT '	是否显示 1 显示 0 不显示	',
  `sort` int(11) NOT NULL,
  `other` varchar(255) DEFAULT NULL COMMENT '其他',
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  `created_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='导航栏';

#
# Data for table "rh_nav"
#


#
# Structure for table "rh_order"
#

DROP TABLE IF EXISTS `rh_order`;
CREATE TABLE `rh_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_num` varchar(40) NOT NULL COMMENT '订单编号',
  `user_id` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '0未完成 1已完成 2已评价 -1退款中 -2已退款-3关闭订单',
  `shipment_state` int(11) NOT NULL DEFAULT '0' COMMENT '运输（验证）状态  0待配送 1已配送 2已收货',
  `payment_state` int(11) NOT NULL DEFAULT '0' COMMENT '支付状态 0 1',
  `rate_id` int(11) DEFAULT '0',
  `coupon_id` int(11) DEFAULT '0' COMMENT '优惠券ID',
  `order_from` varchar(4) DEFAULT NULL COMMENT '来源小程序或wap',
  `payment_type` varchar(60) DEFAULT NULL COMMENT '支付来源',
  `goods_money` decimal(10,2) NOT NULL COMMENT '商品总价',
  `reduction_money` decimal(10,2) NOT NULL COMMENT '满减价格',
  `coupon_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券价格',
  `edit_money` decimal(10,2) DEFAULT '0.00',
  `order_money` decimal(10,2) NOT NULL COMMENT '订单总价',
  `user_ip` varchar(40) DEFAULT NULL,
  `goods_picture` varchar(400) DEFAULT NULL,
  `message` varchar(300) DEFAULT NULL COMMENT '备注',
  `receiver_name` varchar(60) NOT NULL COMMENT '收货人',
  `receiver_mobile` varchar(60) NOT NULL COMMENT '收货人手机',
  `receiver_city` varchar(60) NOT NULL,
  `receiver_address` varchar(200) NOT NULL,
  `courier_num` varchar(60) DEFAULT NULL,
  `courier` varchar(255) DEFAULT NULL,
  `remark_one` varchar(255) DEFAULT NULL,
  `remark_two` varchar(255) DEFAULT NULL,
  `drive_type` varchar(255) DEFAULT NULL COMMENT '配送方式',
  `prepay_id` varchar(255) DEFAULT NULL,
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `other` text COMMENT '其他要求',
  `mobile` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT '收货地址',
  `count` int(11) NOT NULL DEFAULT '0',
  `pay_cate` varchar(255) NOT NULL DEFAULT '3' COMMENT '支付方式1微信支付2余额支付3暂不支付',
  `ucid` int(1) NOT NULL DEFAULT '3',
  `table_num` varchar(50) DEFAULT NULL COMMENT '几号桌',
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='订单表';

#
# Data for table "rh_order"
#


#
# Structure for table "rh_order_goods"
#

DROP TABLE IF EXISTS `rh_order_goods`;
CREATE TABLE `rh_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `goods_name` varchar(300) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `sku_name` varchar(300) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `number` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态0未完成 1已完成 2已评价 -1退款中 -2已退款-3关闭订单	',
  `pic` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remark` varchar(400) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='订单商品详情表';

#
# Data for table "rh_order_goods"
#


#
# Structure for table "rh_order_log"
#

DROP TABLE IF EXISTS `rh_order_log`;
CREATE TABLE `rh_order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `content` varchar(800) NOT NULL,
  `operator` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `wx_refund` varchar(50) DEFAULT NULL COMMENT '微信退款id',
  `created_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单日志表';

#
# Data for table "rh_order_log"
#


#
# Structure for table "rh_play_award"
#

DROP TABLE IF EXISTS `rh_play_award`;
CREATE TABLE `rh_play_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '类型ID',
  `name` varchar(50) NOT NULL,
  `lv` int(11) NOT NULL DEFAULT '0' COMMENT '概率',
  `award` varchar(50) NOT NULL COMMENT '奖励内容',
  `award_type` int(11) NOT NULL DEFAULT '0' COMMENT '奖品类型(0为积分1为商品)',
  `stock` int(11) NOT NULL DEFAULT '0',
  `img_id` int(11) NOT NULL DEFAULT '0',
  `ucid` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='玩法奖励表';

#
# Data for table "rh_play_award"
#


#
# Structure for table "rh_points_record"
#

DROP TABLE IF EXISTS `rh_points_record`;
CREATE TABLE `rh_points_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `credittype` varchar(10) NOT NULL DEFAULT '',
  `num` decimal(10,2) NOT NULL DEFAULT '0.00',
  `operator` int(10) unsigned DEFAULT '0',
  `module` varchar(30) NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `clerk_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `remark` varchar(200) NOT NULL DEFAULT '',
  `real_uniacid` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='积分记录表';

#
# Data for table "rh_points_record"
#


#
# Structure for table "rh_rate"
#

DROP TABLE IF EXISTS `rh_rate`;
CREATE TABLE `rh_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `rate` int(11) NOT NULL DEFAULT '5',
  `content` varchar(800) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `imgs` text NOT NULL COMMENT '图片集',
  `headpic` varchar(255) DEFAULT NULL COMMENT '头像',
  `nickname` varchar(20) NOT NULL DEFAULT '0',
  `reply_content` varchar(255) DEFAULT NULL COMMENT '回复内容',
  `reply_time` int(11) NOT NULL DEFAULT '0' COMMENT '回复时间',
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `created_at` int(11) DEFAULT NULL,
  `video` varchar(300) DEFAULT NULL COMMENT '视频地址',
  `updated_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='评价表';

#
# Data for table "rh_rate"
#


#
# Structure for table "rh_region"
#

DROP TABLE IF EXISTS `rh_region`;
CREATE TABLE `rh_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) NOT NULL COMMENT '父id',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `merger_name` varchar(255) NOT NULL COMMENT '全称',
  `level` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '层级 1 2 3 ',
  `ucid` int(1) NOT NULL DEFAULT '3' COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `name,level` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='地区总表';

#
# Data for table "rh_region"
#


#
# Structure for table "rh_sys_backup"
#

DROP TABLE IF EXISTS `rh_sys_backup`;
CREATE TABLE `rh_sys_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '名称',
  `size` varchar(20) NOT NULL COMMENT '大小',
  `url` varchar(255) NOT NULL COMMENT '路径',
  `create_time` int(11) NOT NULL,
  `ucid` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "rh_sys_backup"
#


#
# Structure for table "rh_sys_config"
#

DROP TABLE IF EXISTS `rh_sys_config`;
CREATE TABLE `rh_sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` text,
  `desc` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1基础2微信3支付宝4短信5物流6商家信息',
  `switch` int(11) NOT NULL DEFAULT '0' COMMENT '0填写框1开关2单选3多选',
  `other` varchar(255) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL COMMENT 'ucid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置表';

#
# Data for table "rh_sys_config"
#

INSERT INTO `rh_sys_config` VALUES (1,'api_url','','入口位置',1,0,NULL,1595573340,1595573340,3),(2,'web_name','','公众号名称',1,0,NULL,1595662367,1595573340,3),(3,'gzh_appid','','公众号appid',2,0,NULL,1595314101,1595314101,3),(4,'gzh_secret','','公众号秘钥',2,0,NULL,1595314101,1595314101,3),(5,'wx_app_id','','小程序appid',2,0,NULL,1595314101,1595314101,3),(6,'wx_app_secret','','小程序秘钥',2,0,NULL,1595314101,1595314101,3),(7,'pay_num','','商户id',2,0,NULL,1595314101,1595314101,3),(8,'pay_key','','商户key',2,0,NULL,1595314101,1595314101,3),(9,'wx_token_expire','7200','token有效期',1,0,NULL,1595573340,1595573340,3),(21,'exchang_points','1','购物获得积分',1,1,NULL,1595573340,1595573340,3),(22,'use_points','0','积分购物',1,1,NULL,1595573340,1595573340,3),(23,'points_to_money','100','积分1 ： 金额',1,0,'金额：积分=1:100',1595573340,1595573340,3),(24,'money_to_points','2','金额1 ： 积分',1,0,'金额：积分=1:1',1595573340,1595573340,3),(34,'code_url','','二维码链接',1,0,NULL,1595573340,1595573340,3),(37,'merge_mode','1','账号关联',1,2,'1微信开放平台关联2手机关联3手机登录',1595573340,1595573340,3),(45,'drive_type','2','配送方式',6,0,'0配送1店内就餐2配送+店内',1593482472,1593482472,3),(57,'feie_user','','飞蛾打印机账号',3,0,NULL,1595312622,1595312622,3),(58,'feie_ukey','','飞蛾打印机ukey',3,0,NULL,1595312622,1595312622,3),(59,'feie_sn','','飞蛾打印机Sn',3,0,NULL,1595312622,1595312622,3),(60,'feie_name','','打印名称',3,0,NULL,1595312622,1595312622,3),(61,'feie_key','','飞蛾打印机key',3,0,NULL,1595312622,1595312622,3),(62,'is_printer','0','是否开启云打印',1,1,NULL,1595573340,1595573340,3),(64,'merchant_name','','商家的店名',6,0,NULL,NULL,NULL,3),(65,'merchan_address','','商家店铺地址',6,0,NULL,NULL,NULL,3),(67,'merchant_brief','','店铺简介',6,0,NULL,NULL,NULL,3),(68,'merchant_phonto','','商家电话',6,0,NULL,NULL,NULL,3),(69,'ps_timme','','配送时间',6,0,NULL,NULL,NULL,3),(70,'shipping_dees','0','配送费',6,0,NULL,NULL,NULL,0),(71,'yzm_sign','','阿里云短信签名',4,0,'',1609381510,1609381510,0),(72,'yzm_keyid','','阿里云短信KeyId',4,0,'',1609381510,1609381510,0),(73,'yzm_secret','','阿里云短信秘钥',4,0,'',1609381510,1609381510,0),(74,'yzm_tmp_id','','验证码模板ID',4,0,'',1609381510,1609381510,0);

#
# Structure for table "rh_tui"
#

DROP TABLE IF EXISTS `rh_tui`;
CREATE TABLE `rh_tui` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `tui_num` varchar(30) NOT NULL DEFAULT '0' COMMENT '退款单号',
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `order_num` varchar(40) NOT NULL COMMENT '订单号',
  `money` decimal(10,2) NOT NULL COMMENT '价钱',
  `message` varchar(255) NOT NULL COMMENT '信息',
  `because` varchar(255) DEFAULT NULL COMMENT '原因',
  `ip` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0退款中1已退款2驳回中',
  `aid` int(11) NOT NULL DEFAULT '0',
  `wx_id` varchar(50) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `ucid` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='退货管理表';

#
# Data for table "rh_tui"
#


#
# Structure for table "rh_user"
#

DROP TABLE IF EXISTS `rh_user`;
CREATE TABLE `rh_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `unionid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `openid_gzh` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公众号openid',
  `openid_app` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小程序openid',
  `money` double(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `sign_time` bigint(20) DEFAULT NULL COMMENT '上次签到时间',
  `sign_day` bigint(20) DEFAULT NULL COMMENT '连续签到天数',
  `points` bigint(20) DEFAULT NULL COMMENT '积分',
  `headpic` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '电话',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户真实姓名',
  `ucid` int(1) DEFAULT NULL COMMENT 'ucid',
  `deleted_at` bigint(20) DEFAULT NULL,
  `created_at` int(20) DEFAULT NULL,
  `updated_at` int(20) DEFAULT NULL,
  `invite_code` int(11) DEFAULT NULL COMMENT '邀请码',
  `invite_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邀请链接',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "rh_user"
#


#
# Structure for table "rh_user_address"
#

DROP TABLE IF EXISTS `rh_user_address`;
CREATE TABLE `rh_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(255) NOT NULL,
  `city` varchar(400) DEFAULT NULL,
  `detail` varchar(400) DEFAULT NULL COMMENT '详细地址',
  `user_id` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户地址表';

#
# Data for table "rh_user_address"
#


#
# Structure for table "rh_video"
#

DROP TABLE IF EXISTS `rh_video`;
CREATE TABLE `rh_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `use_name` varchar(80) NOT NULL,
  `is_visible` int(11) NOT NULL DEFAULT '1' COMMENT '是否能显示1能0不能',
  `description` varchar(50) DEFAULT NULL COMMENT '描述字段',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `ucid` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='视频表';

#
# Data for table "rh_video"
#

