<?php

$SiteName="������";

$SiteURL = "http://bbs.zixia.net/";

$Banner="bar/bar.jpg";

define('OLD_REPLY_STYLE', true); //�Ƿ�ʹ�ô�ͳ telnet re �ķ�ʽ

define('SMS_SUPPORT', true);

define('AUDIO_CHAT', true);

define ("MAINTITLE","<img src=\"bar/title.jpg\"/>");

define("ATTACHMAXSIZE","4194304");
define ("ATTACHMAXTOTALSIZE","20971520");
define("ATTACHMAXCOUNT","20");

define('MYFACEMAXSIZE','102400');

define('ALLOW_SELF_MULTIQUERY', true);
define('SUPPORT_TEX', true);
define("ONBOARD_USERS", true);

$section_nums = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
$section_names = array(
    array("�� ͷ ��", "[�ڰ�/ϵͳ]"),
    array("������", "[��/����]"),
    array("��С�ֶ�", "[����/У��]"),
    array("�Ժ�����", "[��ʳ/����]"),
    array("��Ϸ����", "[��Ϸ/����]"),
    array("����Ū��", "[����/�Ļ�]"),
    array("����֮·", "[����/�ۻ�]"),
    array("������ʩ", "[����/��ѵ]"),
    array("��������", "[ʡ��/����]"),
    array("��ʥȡ��", "[רҵ/����]") 
);

define("DB_ENABLED", true);
require "dbconn.php";
require "default.php";
?>