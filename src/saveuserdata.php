<?php

require("inc/funcs.php");
require("inc/usermanage.inc.php");
require("inc/user.inc.php");
require_once("inc/myface.inc.php");
	
setStat("基本资料修改");

requireLoginok();

show_nav(false);

showUserMailbox();
head_var($userid."的控制面板","usermanagemenu.php",0);
showUserManageMenu();
main();

show_footer();

function main(){
	global $currentuser;
	require("inc/userdatadefine.inc.php");
	global $SiteName;
	@$userid=$_POST["userid"];
	@$nickname=$_POST["username"];

	@$realname=$_POST["realname"];

    @$address=$_POST["address"];
	@$year=$_POST["year"];
	@$month=$_POST["month"];
	@$day=$_POST["day"];
	@$email=$_POST["email"];
	@$phone=$_POST["userphone"];
	@$mobile_phone=$_POST["mobile"];
	@$gender=$_POST["gender"];
	if($gender!='1')$gender=2;
    settype($year,"integer");
	settype($month,"integer");
	settype($day,"integer");

$ret=bbs_saveuserdata($currentuser['userid'],$realname,$address,$gender,$year,$month,$day,$email,$phone,$mobile_phone, $_POST['OICQ'], $_POST['ICQ'], $_POST['MSN'],  $_POST['homepage'], intval($_POST['face']), $_POST['myface'], intval($_POST['width']), intval($_POST['height']), intval($_POST['groupname']), $_POST['country'],  $_POST['province'], $_POST['city'], intval($_POST['shengxiao']), intval($_POST['blood']), intval($_POST['belief']), intval($_POST['occupation']), intval($_POST['marital']), intval($_POST['education']), $_POST['college'], intval($_POST['character']), $_POST['userphoto'],FALSE);//自动生成注册单

	switch($ret)
	{
	case 0:
		break;
	case -1:
		foundErr("用户自定义图像宽度错误");
	case -2:
		foundErr("用户自定义图像高度错误");
	case 3:
		foundErr("该用户不存在!");
	default:
		foundErr("未知的错误!");
	}

/* 清除一下没用的上传头像 - atppp*/
	$myface = $_POST['myface']; $bClearAll = ($myface == "");
	$myface_dir = get_myface_dir($currentuser['userid']);
	if ($hDir = @opendir(get_myface_fs_filename($myface_dir))) {
		$prefix = $currentuser['userid']."."; $prefix_len = strlen($prefix);
		while($filename = readdir($hDir)) {
			if (strncmp($filename, $prefix, $prefix_len) != 0) continue;
			if ($bClearAll || (strpos($myface, $filename) === false)) unlink(get_myface_fs_filename($myface_dir."/".$filename));
		}
		closedir($hDir);
	}
	
//	$signature=trim($_POST["Signature"]);  /* preserve format - atppp */
	$signature = $_POST["Signature"];
//	if ($signature!='') { /* allow erase signature - atppp */
		$filename=bbs_sethomefile($currentuser['userid'],"signatures");
		$fp=@fopen($filename,"w+");
		if ($fp!=false) {
			fwrite($fp,str_replace("\r\n", "\n", $signature));
			fclose($fp);
			bbs_recalc_sig();
		}
//	}
//	$personal=trim($_POST["personal"]); /* preserve format - atppp */
	$personal=$_POST["personal"];
//	if ($personal!='') { /* allow erase - atppp */
		$filename=bbs_sethomefile($currentuser['userid'],"plans");
		$fp=@fopen($filename,"w+");
		if ($fp!=false) {
			fwrite($fp,str_replace("\r\n", "\n", $personal));
			fclose($fp);
		}
//	}
	setSucMsg("您的数据已成功修改！");
	return html_success_quit('返回控制面板', 'usermanagemenu.php');
}
?>
