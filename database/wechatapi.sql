-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015-03-26 00:11:11
-- 服务器版本: 5.5.41-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wechatapi`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `openid` varchar(200) NOT NULL COMMENT 'openid',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `sex` tinyint(1) NOT NULL COMMENT '性别',
  `language` varchar(10) NOT NULL COMMENT '语言类别',
  `province` varchar(30) NOT NULL COMMENT '省份',
  `city` varchar(30) NOT NULL COMMENT '城市',
  `country` varchar(30) NOT NULL COMMENT '国家',
  `headimgurl` varchar(150) NOT NULL COMMENT '头像url',
  `privilege` varchar(300) NOT NULL COMMENT '用户特权信息（json 数组）',
  `unionid` varchar(100) NOT NULL COMMENT '需将公众号绑定到微信开放平台帐号',
  `createdtime` int(11) NOT NULL COMMENT '创建用户信息时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `openid`, `nickname`, `sex`, `language`, `province`, `city`, `country`, `headimgurl`, `privilege`, `unionid`, `createdtime`) VALUES
(3, 'oruPRskD6bl93GhQCQA6L1AaOVhQ', '王仨越', 1, 'zh_CN', '广东', '汕头', '中国', 'http://wx.qlogo.cn/mmopen/vp6ichVTlgwcITWVZ1bAg5SvoFuwX7hvf1UhYX6ibwq71DbDQWz3KiccXibiap0XDL3aFh5805XhVZIfP9Iu4op8dn1TmlBiaptgnr/0', '{}', '', 1427299586);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
