-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 11 月 16 日 10:26
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `userdata`
--

-- --------------------------------------------------------

--
-- 表的结构 `userform`
--

CREATE TABLE IF NOT EXISTS `userform` (
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `pnumber` int(20) NOT NULL,
  `comment` varchar(5000) NOT NULL,
  `portrait` varchar(200) NOT NULL DEFAULT 'portrait.jpg',
  `id` int(200) NOT NULL,
  PRIMARY KEY (`email`),
  KEY `email` (`email`),
  KEY `email_2` (`email`),
  KEY `email_3` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `userform`
--

INSERT INTO `userform` (`email`, `password`, `username`, `gender`, `pnumber`, `comment`, `portrait`, `id`) VALUES
('mengwh@qq.com', 'lulyluly', 'luly', 'girl', 0, '我是luly', 'portrait1.jpg', 1),
('123456@qq.com', 'xiaoming', 'xiaoming', 'boy', 0, '我是小明', 'portrait2.jpg', 1),
('224624@qq.com', 'xiaohong', 'xiaohong', 'girl', 0, '我是小红', 'portrait3.jpg', 1),
('mengmanyan@qq.com', 'mengmanyan', 'haha', 'girl', 0, '我是新的数据，好厉害', 'portrait4.jpg', 1),
('meng@163.com', 'mengmeng', 'rainlofty', 'girl', 0, '死生契阔，与子相悦。执子之手，与子偕老', 'portrait.jpg', 1),
('youxiang@163.com', 'youxiang', 'zhixiang', 'boy', 0, '有美人兮，见之不忘，一日不见兮，思之如狂', 'portrait.jpg', 1),
('jicheng@163.com', 'mimamima', 'nicheng', 'boy', 0, '这次我离开你，是风，是雨，是夜晚；你笑了笑，我摆一摆手，一条寂寞的路便展向两头了', 'portrait.jpg', 1),
('mima@163.com', 'youxiangmima', 'huangshi', 'boy', 0, '入我相思门，知我相思苦，长相思兮长相忆，短相思兮无穷极', 'portrait.jpg', 1),
('sougou@163.com', 'sougousou', 'shouji', 'boy', 0, '曾经沧海难为水，除却巫山不是云。', 'portrait.jpg', 1),
('shujuku@qq.com', 'shujukushu', 'shujuku', 'boy', 0, '自君之出矣，明镜暗不治。思君如流水，何有穷已时', 'portrait.jpg', 1),
('ganmao@163.com', 'ganmaoganmao', 'ganmao', 'boy', 0, '落红不是无情物，化作春泥更护花', 'portrait.jpg', 1),
('yuyin@163.com', 'yuyinyuyin', 'yuyin', 'girl', 0, '兽炉沈水烟，翠沼残花片，一行行写入相思传', 'portrait.jpg', 1),
('xiaoman@163.com', 'xiaomanxiao', 'xiaoman', 'boy', 0, '梧桐树，三更雨，不道离情正苦。一叶叶，一声声，空阶滴到明', '20171116portrait4.jpg', 1),
('youxiang11@163.com', 'youxiang11', 'sangziyale', 'boy', 0, '尊前拟把归期说，未语春容先惨咽。－欧阳修《', '20171116show8.jpg', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
