/*
Navicat MySQL Data Transfer

Source Server         : 可视化教学设计
Source Server Version : 50637
Source Host           : 139.224.54.245:3306
Source Database       : question

Target Server Type    : MYSQL
Target Server Version : 50637
File Encoding         : 65001

Date: 2020-10-24 17:05:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for question
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `type` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `ctime` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('1', 'zq测试', 'zq测试', '2', '2', '2020-10-22 21:39:14');
INSERT INTO `question` VALUES ('2', '新的', '撒撒撒上', '1', '2', '2020-10-22 21:39:37');
INSERT INTO `question` VALUES ('3', 'SHIAJ', 'ROOT WRITE', '2', '1', '2020-10-22 21:43:38');
INSERT INTO `question` VALUES ('4', '春', '<div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">盼望着，盼望着，东风来了，春天的脚步近了。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">一切都像刚睡醒的样子，欣欣然张开了眼。山朗润起来了，水涨起来了，太阳的脸红起来了。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">小草偷偷地从土里钻出来，嫩嫩的，绿绿的。园子里，田野里，瞧去，一大片一大片满是的。坐着，躺着，打两个滚，踢几脚球，赛几趟跑，捉几回迷藏。风轻悄悄的，草软绵绵的。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">桃树、杏树、梨树，你不让我，我不让你，都开满了花赶趟儿。红的像火，粉的像霞，白的像雪。花里带着甜味儿；闭了眼，树上仿佛已经满是桃儿、杏儿、梨儿。花下成千成百的蜜蜂嗡嗡地闹着，大小的蝴蝶飞来飞去。野花遍地是：杂样儿，有名字的，没名字的，散在草丛里，像眼睛，像星星，还眨呀眨的。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">“吹面不寒杨柳风”，不错的，像母亲的手抚摸着你。风里带来些新翻的泥土的气息，混着青草味儿，还有各种花的香，都在微微润湿的空气里酝酿。鸟儿将窠巢安在繁花嫩叶当中，高兴起来了，呼朋引伴地卖弄清脆的喉咙，唱出宛转的曲子，与轻风流水应和着。牛背上牧童的短笛，这时候也成天在嘹亮地响。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">雨是最寻常的，一下就是三两天。可别恼。看，像牛毛，像花针，像细丝，密密地斜织着，人家屋顶上全笼着一层薄烟。树叶儿却绿得发亮，小草儿也青得逼你的眼。傍晚时候，上灯了，一点点黄晕的光，烘托出一片安静而和平的夜。乡下去，小路上，石桥边，有撑起伞慢慢走着的人，地里还有工作的农民，披着蓑，戴着笠的。他们的草屋，稀稀疏疏的在雨里静默着。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">天上风筝渐渐多了，地上孩子也多了。城里乡下，家家户户，老老小小，他们也赶趟儿似的，一个个都出来了。舒活舒活筋骨，抖擞抖擞精神，各做各的一份事去。“一年之计在于春”，刚起头儿，有的是工夫，有的是希望。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">春天像刚落地的娃娃，从头到脚都是新的，它生长着。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">春天像小姑娘，花枝招展的，笑着，走着。</div><div class=\"para\" label-module=\"para\" style=\"overflow-wrap: break-word; margin-bottom: 15px; text-indent: 2em; line-height: 24px; zoom: 1; font-family: arial, 宋体, sans-serif;\">春天像健壮的青年，有铁一般的胳膊和腰脚，他领着我们上前去。</div>', '2', '1', '2020-10-23 11:50:46');
INSERT INTO `question` VALUES ('5', '测试echarts', '新的echarts', '3', '2', '2020-10-23 16:21:28');
INSERT INTO `question` VALUES ('6', '在意', 'echarts由于粗', '4', '2', '2020-10-23 16:21:54');
INSERT INTO `question` VALUES ('7', '测试新的内容', '逼啊急撒机撒是哪个', '4', '2', '2020-10-24 10:43:55');
INSERT INTO `question` VALUES ('8', '再来一个', '晒晒就撒就是卡机了声卡了；的；的', '4', '2', '2020-10-24 10:44:25');
INSERT INTO `question` VALUES ('9', '啊上帝啊都是看大门的话噶啥', '打电话是代送剪刀是跑快递啦上课的', '3', '2', '2020-10-24 10:44:48');
INSERT INTO `question` VALUES ('10', '再来一洗', '撒撒上放大发', '4', '2', '2020-10-24 11:05:41');

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `typename` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `ctime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES ('1', '未知', '1', null);
INSERT INTO `type` VALUES ('2', '测试', '2', null);
INSERT INTO `type` VALUES ('3', 'echarts', '2', null);
INSERT INTO `type` VALUES ('4', 'mecharts', '2', null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'root', '1', '6bWOj7vLbercX/wMLLg6PjYzNTQ2YWRlOTU0NzJiMDBmNDgzODkxZjY4YmU5NDJlY2Q3NzE0YWUxMGZjNjI1YjgxNzA0YTg1YmM3MTcwNzGnDjDtiWugCdXESDcoRb0412igZ8GCelm3Eh8Sma1Y2w==', '1');
INSERT INTO `user` VALUES ('2', 'zhouqing', '3', 'ziwavS3rPnBpCTzFrwuDQmI1ZjNlM2RkYzcxMWQ3ZTVkMjc4M2M1ZDlhNTk4MmEzNGYyN2U3YzRjMjJmMGQyMmU3MjliNThmNjhjYThkM2XKbjVrgtSfaz7TpZXSmL3RNW1pARoxBvdS18B5OOquDA==', '1');
