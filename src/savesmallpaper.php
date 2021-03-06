<?php

require("inc/funcs.php");
require("inc/board.inc.php");
require("inc/user.inc.php");
require("inc/conn.php");

global $boardArr;
global $boardID;
global $boardName;

setStat("发布小字报");

requireLoginok("游客不能发表小字报。");

preprocess();

show_nav(false);

showUserMailBox();
board_head_var($boardArr['DESC'],$boardName,$boardArr['SECNUM']);
main($boardID,$boardName);

show_footer();

function preprocess(){
	global $boardID;
	global $boardName;
	global $currentuser;
	global $boardArr;
	global $conn;
	global $title;
	global $Content;
	
	if ($conn === false) {
		foundErr("数据库故障。");
	}
	$title=trim($_POST["title"]);
	$Content=trim($_POST["Content"]);

	if ($title=="") {
	    foundErr("主题不应为空。");
	}
	if (strlen($title)>80) {
		foundErr("主题长度不能超过80");
	}
	if ($Content=="") {
		foundErr("没有填写内容。");
	}
	if (strlen($Content)>500) {
		foundErr("发言内容不得大于500");
	} 
	if (!isset($_POST['board'])) {
		foundErr("未指定版面。");
	}
	$boardName=$_POST['board'];
	$brdArr=array();
	$boardID= bbs_getboard($boardName,$brdArr);
	$boardArr=$brdArr;
	$boardName=$brdArr['NAME'];
	if ($boardID==0) {
		foundErr("指定的版面不存在。");
	}
	$usernum = $currentuser["index"];
	if (bbs_checkreadperm($usernum, $boardID) == 0) {
		foundErr("您无权阅读本版！");
	}
	if (bbs_is_readonly_board($boardArr)) {
		foundErr("本版为只读讨论区！");
	}
	if (bbs_checkpostperm($usernum, $boardID) == 0) {
		foundErr("您无权在本版发表小字报！");
	}

	return true;
}



function main($boardID,$boardName) {
	global $conn;
	global $currentuser;
	global $title;
	global $Content;

    $sql="insert into smallpaper_tb (boardID,Owner,Title,Content,Addtime) values (".$boardID.",'". $currentuser['userid']."','". htmlspecialchars($title, ENT_QUOTES)."','". htmlspecialchars($Content,ENT_QUOTES)."',now())";
	$conn->query($sql);
	setSucMsg("您成功的发布了小字报。");
  	return html_success_quit('返回版面', 'board.php?name='.$boardName);
} 

?>
