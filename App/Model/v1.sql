CREATE TABLE `easy_admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `login_time` int(10) DEFAULT 0 COMMENT '登录时间',
  `name` VARCHAR(56) DEFAULT NULL COMMENT '用户名称',
  `number` VARCHAR(56) DEFAULT NULL COMMENT '用户账号',
  `login_ip` VARCHAR(50) DEFAULT NULL COMMENT '登录ip',
  `password` VARCHAR(255) DEFAULT NULL COMMENT '登录密码',
  `audit_status` tinyint(3) DEFAULT 1 COMMENT '用户状态（0禁用，1启用）',
  `create_time` int(10) DEFAULT 0 COMMENT '创建时间',
  `create_user` int(10) DEFAULT 0 COMMENT '创建人',
  `update_time` int(10) DEFAULT 0 COMMENT '更新时间',
  `remark` json default null COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

create table `easy_user` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
    `mobile` int(11) DEFAULT 0 COMMENT '手机号码',
    `email` VARCHAR(50) DEFAULT NULL COMMENT '邮箱',
    `name` VARCHAR(255) DEFAULT NULL COMMENT '用户名称',
    `openid` VARCHAR(255) DEFAULT NULL COMMENT 'openid',
    `level` tinyint(3) default 1 COMMENT '用户等级',
    `money` decimal(10,2) DEFAULT 0.00 COMMENT '账户金额',
    `frozen_money` decimal(10,2) DEFAULT 0.00 COMMENT '冻结金额',
    `password` VARCHAR(255) DEFAULT NULL COMMENT '登录密码',
    `reg_code` VARCHAR(255) DEFAULT NULL COMMENT '注册码',
    `audit_status` tinyint(3) DEFAULT 1 COMMENT '用户状态（0禁用，1启用）',
    `create_time` int(10) DEFAULT 0 COMMENT '创建时间',
    `update_time` int(10) DEFAULT 0 COMMENT '更新时间',
    `extends` json default null COMMENT '拓展参数',
    PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;

//抽奖+积分+返佣