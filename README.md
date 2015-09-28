# wForum - smth_bbs based web forum (dvbbs like)
wForum project home page - https://github.com/zixia/wforum

1. wForum架设在清华大学水木清华BBS系统底层之上
2. 主页：http://wforum.aka.cn/
3. 推荐使用 linux 系统（redhat)
4. document 目录下有 sql 建表语句
5. 文档请参考 documents/DocBook/wForum.html 文件
6. 项目开发者列表情参考 CREDITS 文件
7. 最新进展请参考 NEWS 文件

zixia

## Install

安装说明请参见 wForum 文档：documents/DocBook/wForum.html

## Todo

0. 修改BUG
1. 增加手机短信WEB的支持
2. 增加个人形象系统
3. 增加统计数据的动态统计和显示
4. 管理功能 ( /admin 目录的建设 )

## Credit

欢迎加入！ :)

"瞿华" <roy at zixia.net>
"李卓桓" <zixia at zixia.net>

----------
Scripts for PHP4 domxml compatible with PHP5 dom
Credit to Alexandre Alapetite, used in inc/xml.inc.php

## Copyright

1. 这份软件基于GPL版本发布。
   请参考 COPYING.GPL 文件
   任何对本软件代码的修改需要同样遵循 GPL 许可。

2. 版权归属 阿卡信息技术(北京)有限公司 和 水木清华BBS 共同所有

3. 额外声明：未经北京阿卡公司书面许可，不允许将本软件作商业应用。


## Changelog

2004.8 - 2004.12

*) 发文前预览支持上传的附件，插入文中的附件图片，以及 tex
*) 加强 itex2mathml 支持
*) 文档转型为 DocBook，参见 documents/DocBook/
*) 随机签名档，回文抄送信箱
*) 允许重新填写注册单
*) 允许修改临时/永久昵称（ft 这个功能以前居然没有）
*) 文摘区阅读
*) 版面文章/文摘区 RSS 支持
*) 框架支持，从 frames.php 进入是 wForum 框架模式
*) 显示版内在线名单支持，默认关闭
*) ENABLE_UBB 站点配置选项，默认打开
*) 小字报数据库支持功能问题太多，默认关闭
*) 全站查询我发表的话题支持，默认关闭，这个在现有构架下太慢了
*) 和 bbs2www/html/ 下的传统 web 界面无缝配合
*) 设置了不可回复的版面不允许回复文章
*) 修正 safari 下 javascript 错误
*) 很多小问题的修正


2004.7

*) 分区版面列表提供三种显示方式，更方便用户，同时提高了程序效率。
*) bbs_getboards() 优化。版面文章列表和文章阅读页面的执行时间减少了很多。
*) 文章阅读页面用彩色/灰色头像表示作者在线/离线
   未知用户/注册日期以前发的文章不显示作者信息
*) 页面右上角可以显示服务器时间
*) 信件阅读支持附件，开始试验信件大小支持。
        以前的信件大小用 local_utl/sync_mailsize.c 同步。具体细节参见文档。
*) PHP5 兼容性
*) 支持 telnet 下的全文连接 URL。
*) 支持版面封人
*) alpha 测试 tex2mathml（自动把tex语言转换成mathml）。
        site.php 需要打开 SUPPORT_TEX 选项。目前还有不少问题，而且可能会造成
        系统不稳定，慎用。

2004.6

*) 优化产生版面文章索引的代码，主题数多的大版面的浏览速度有了质的飞跃；
*) 整理了一下分区版面列表的代码，还有一些小的优化；
*) 精华区浏览；
*) 帖子发表前初步的预览功能；
*) 调整了一下版面搜索的代码，搜索结果更合理；
*) 支持多版面/全站的搜索，默认关闭；
*) 支持显示回复树结构，默认开启；
*) 支持显示已经删除了原帖（楼主）的主题；
*) site.php 配置更为简化，数据库配置全部放入 site.php；
*) site.php 首次人工编辑配置之后可以在网页上直接调整 site.php 参数；
*) 其他一些小 bug 的修正。

2004.5

*) 统一界面，更好的兼容 firefox；apple 下的 Safari 还有问题；
*) 小字报管理功能: 版主和原发表者可以删除小字报；
*) 全面支持好友功能：好友管理，在线好友显示；
*) 全面支持收藏版面管理，支持收藏版面文件夹（好像没啥用？）；
*) 自定义参数功能增强：允许自定义隐藏 IP 和信箱选项；
*) 全面支持自定义头像；
*) 修正自动解析 URL 不能匹配 & # 字符的问题；
*) 有隐身权限的用户支持隐身/现身切换；
*) 解决 smthbbs 近半年来的修改给 wForum 带来的一系列问题。
*) 其他一些 bug 和笔误修正 :D 。

2003.8.17

加入对mozilla浏览器的支持
