<?php

require("inc/funcs.php");
require("inc/user.inc.php");
require("inc/ubbcode.php");
require_once("inc/myface.inc.php");

setStat("察看用户信息");

preprocess();

show_nav();

showUserMailBoxOrBR();
head_var();
if ($user !== false) {
	showUserData($user,$user_num);
}
showQueryForm();

show_footer();

function preprocess() {
	global $user,$user_num;
	if (!isset($_GET['id']) || $_GET['id'] == "") {
		$user = false;
		return;
	}
	$userarray=array();
	if (($user_num=bbs_getuser($_GET['id'],$userarray))==0) {
		foundErr("查找用户数据失败！");
	}
	$user=$userarray;
	return true;

}

function showQueryForm() {
?>
<form method="GET" action="dispuser.php">
<table align=center><tr><td>
请输入用户名: <input type="text" name="id">&nbsp;<input type="submit" value="查询用户">
</td></tr></table>
</form>
<?php
}

function showUserData($user, $user_num) {
	/* ToDo: 这里有三个部分: 1. 基本资料，2. 真实详细资料，3. 一般用户信息。1,2用户可以选择是否可以被人查到。
	   默认设置是 1 开启 2 关闭。下面的资料可能需要调整一下以和 BBS 系统一致？比方该看到的信息就应该永远可以看到...
	 */
require("inc/userdatadefine.inc.php");
?>
<table width=97% border=0 cellspacing=0 cellpadding=3 align=center>
  <tr> 
    <td><?php echo get_myface($user, "align=absmiddle"); ?>
<b><?php echo $user['userid']; ?></b>
</td>
    <td align=right>
<b>
<a href="sendmail.php?receiver=<?php echo $user['userid']; ?>" title="给该用户发信">发信问候</a> | 
<a href="friendlist.php?addfriend=<?php echo $user['userid']; ?>" title="将该用户添加到好友列表">加为好友</a>
</b>
<!-- 先注释掉 atppp
当前位置：[测试帖子列表]<img src=pic/zhuangtai.gif width=16 height=16 align=absmiddle> 
      状态：
正常  [在线：0Mins]
-->
  </td>
  </tr>
</table>
<?php
if ($user['userdefine0'] & BBS_DEF_SHOWDETAILUSERDATA) {
?>
<table cellspacing=1 cellpadding=3 align=center  style="table-layout:fixed;word-break:break-all" class=TableBorder1>
  <col width=20% ><col width=*><col width=40% > 
  <tr> 
    <th colspan=2 align=left height=25>基本资料</th>
    <td rowspan=8 align=center class=TableBody1 width=40% valign=top>
<?php
	$photo_url=htmlspecialchars(trim($user['photo_url']),ENT_QUOTES);
	if ($photo_url!='') {
		echo "<a href=\"$photo_url\" target=\"_blank\"><img onload=\"javascript:if (this.height > 150) this.height = 150; \" src=\"$photo_url\" border=\"0\"></a>"; 
	} else {
		echo  "<font color=gray>无</font>";
	}
?>
    </td>
  </tr>   
  <tr> 
    <td class=TableBody1 width=20% align=right>昵 称：</td>
    <td class=TableBody1><?php echo htmlspecialchars($user['username'],ENT_QUOTES); ?> </td>
  </tr>

  <tr> 
    <td class=TableBody1 width=20% align=right>性 别：</td>
    <td class=TableBody1><?php echo chr($user['gender'])=='M'?'男':'女'; ?> </td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>星 座：</td>
    <td class=TableBody1>
<?php
	echo get_astro($user['birthmonth'],$user['birthday']);
?></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>Ｑ Ｑ：</td>
    <td class=TableBody1>
	<?php echo showIt($user['OICQ']); ?>
</td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>ＩＣＱ：</td>
    <td class=TableBody2>
	<?php echo showIt($user['ICQ']); ?>
</td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>ＭＳＮ：</td>
    <td class=TableBody1>
	<?php echo showIt($user['MSN']); ?>
 </td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>主 页：</td>
    <td class=TableBody2>
	<?php 
	$homepage=htmlspecialchars(trim($user['homepage']),ENT_QUOTES);
	if ($homepage!='') {
		echo '<a href="'.$homepage.'" target="_blank">'.$homepage.'</a>'; 
	} else {
		echo "<font color=gray>未知</font>";
	}
	?>
</td>
  </tr>
</table>
<br>
<?php
}
if (SHOW_REGISTER_TIME && ($user['userdefine0'] & BBS_DEF_SHOWREALUSERDATA)) {
?>
<table cellspacing=1 cellpadding=3 align=center class=TableBorder1 style="table-layout:fixed;word-break:break-all">
  <col width=20% ><col width=*><col width=40% > 
  <tr> 
    <th colspan=2 align=left height=25>
      用户详细资料</th>
    <td rowspan=17 class=TableBody1 width=40% valign=top>
<b>性格：</b>
<br>
<?php   echo $character[$user['character']]; ?>
<br><br><br>
<b>个人简介：</b><br>
<?php   
	$filename=bbs_sethomefile($user["userid"],"plans");
	if (is_file($filename)) {
		$plans = bbs_printansifile($filename);
		$v_plans = split ( "<br />", $plans );
		$num = count ( $v_plans );

		$plans = "";

		for ( $i=0; $i<$num && $i<20 ; $i++ ){
			$plans .= $v_plans[$i];
			$plans .= "<br />";
		}
		echo dvbcode($plans,0);
	} else {
		echo "<font color=gray>这个家伙很懒，什么也没有留下^_^</font>";
	}
?>
<br>
</td>
  </tr>   
  <tr> 
    <td class=TableBody1 width=20% align=right>真实姓名：</td>
    <td class=TableBody1><?php echo showIt($user['realname']);	?></td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>国　　家：</td>
    <td class=TableBody2><?php echo showIt($user['country']); ?> </td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>出 生：</td>
    <td class=TableBody2>
<?php
	if ( ($user['birthyear']!=0) && ($user['birthmonth']!=0) && ($user['birthday']!=0)) {
		echo '19'.$user['birthyear'].'年'.$user['birthmonth'].'月'.$user['birthday'].'日';
	} else {
		echo "<font color=gray>未知</font>";
	}?>
 </td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>省　　份：</td>
    <td class=TableBody1><?php echo showIt($user['province']); ?></td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>城　　市：</td>
    <td class=TableBody2><?php  echo showIt($user['city']); ?></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>联系电话：</td>
    <td class=TableBody1>	<?php echo showIt($user['telephone']); ?></td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>通信地址：</td>
    <td class=TableBody2><?php   echo showIt($user['address']); ?></td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>Ｅｍａｉｌ：</td>
    <td class=TableBody2>
	<?php 
	$reg_email=htmlspecialchars(trim($user['reg_email']),ENT_QUOTES);
	if ($reg_email!='') {
		echo '<a href=mailto:'.$reg_email.'>'.$reg_email.'</a>'; 
	} else {
		echo "<font color=gray>未知</font>";
	}
	?>
</td>
  </tr>

  <tr> 
    <td class=TableBody1 width=20% align=right>生　　肖：</td>
    <td class=TableBody1><?php echo showIt($shengxiao[$user['shengxiao']]); ?> </td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>血　　型：</td>
    <td class=TableBody2><?php    echo showIt($bloodtype[$user['bloodtype']]); ?></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>信　　仰：</td>
    <td class=TableBody1><?php    echo showIt($religion[$user['religion']]) ?></td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>职　　业：</td>
    <td class=TableBody2><?php    echo showIt($profession[$user['profession']]); ?></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>婚姻状况：</td>
    <td class=TableBody1><?php    echo showIt($married[$user['married']]); ?></td>
  </tr>
  <tr> 
    <td class=TableBody2 width=20% align=right>最高学历：</td>
    <td class=TableBody2><?php    echo showIt($education[$user['education']]); ?></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>毕业院校：</td>
    <td class=TableBody1><?php    echo showIt($user['graduateschool']); ?></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=20% align=right>注册日期：</td>
    <td class=TableBody1><?php echo strftime("%Y-%m-%d %H:%M:%S", $user['firstlogin']); ?></td>
  </tr></table>
<br>
<?php
}
?>
<table cellspacing=1 cellpadding=3 align=center class=TableBorder1>
  <tr>
    <th align=left colspan=6 height=25> 论坛属性</th>
  </tr>
  <tr>
    <td class=TableBody1 width=15% align=right>积分：</td>

    <td  width=35%  class=TableBody1><b><?php echo $user['score']; ?> </b></td>
    <td width=15% align=right class=TableBody1>精华帖子：</td>
    <td width=35%  class=TableBody1> <b>N/A</b>篇</td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>魅力值：</td>
    <td  width=35%  class=TableBody1><b>N/A </b></td>
    <td width=15% align=right class=TableBody1>帖子总数：</td>
    <td width=35%  class=TableBody1><b><?php echo $user['numposts']; ?></b> 篇</td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>论坛等级：</td>
    <td  width=35%  class=TableBody1><b><?php echo bbs_getuserlevel($user['userid']); ?> </b></td>
    <td width=15% align=right class=TableBody1>被删主题：</td>
    <td width=35%  class=TableBody1><b><font color=#FF0000>N/A</font></b> 
      篇</td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>威望值：</td>
    <td  width=35%  class=TableBody1><b><font color=#FF0000>N/A</font> </b></td>
    <td width=15% align=right class=TableBody1>被删除率：</td>
<td width=35%  class=TableBody1><b></b> <font color=#FF0000><b>
N/A
</b></font> 
    </td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>门  派：</td>
    <td  width=35%  class=TableBody1><b>
<?php echo showIt($groups[$user['group']]); ?>
 </b></td>
    <td class=TableBody1 width=15% align=right>登录次数：</td>
    <td width=35%  class=TableBody1><b><?php echo $user['numlogins']; ?></b> 
    </td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>生命力：</td>
    <td  width=35%  class=TableBody1><b><?php echo bbs_compute_user_value($user["userid"]); ?></b></td>
    <td width=15% align=right class=TableBody1>上次登录：</td>
    <td width=35%  class=TableBody1><b><?php echo strftime("%Y-%m-%d %H:%M:%S", $user['lastlogin']); ?></b></td>
  </tr>
</table>
<br>
<table cellspacing=1 cellpadding=3 align=center class=TableBorder1>
  <tr> 
    <th align=left colspan=4>
      资产情况</th>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>现金货币：</td>
    <td width=35%  class=TableBody1><b><?php echo $user['money']; ?></b></td>
    <td colspan=2 valign=top rowspan=4 class=TableBody1>论坛职务：
      <hr size=1 width=100 align=left>
<?php echo bbs_getuserlevel($user['userid']); ?><br>
      </td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>股票市值：</td>
    <td  width=35%  class=TableBody1><b>N/A</b></td>
  </tr>

  <tr> 
    <td class=TableBody1 width=15% align=right>银行存款：</td>
    <td width=35%  class=TableBody1><b>N/A</b></td>
  </tr>
  <tr> 
    <td class=TableBody1 width=15% align=right>总 资 产：</td>
    <td width=35%  class=TableBody1><b>N/A</b></td>
  </tr>
</table>
<br>

<table class=TableBorder1 cellspacing=1 cellpadding=3 align=center>
<tr><th height="25" align=left colspan=2>快捷管理选项</th></tr>

<!-- 暂时禁止 - atppp
<tr><td class=TableBody1 height=25 colspan=2>
<B>用户管理选项</B>：   『 <a href=# onclick="alert('该功能尚在开发中。');" title=锁定该用户不允许登录和发言>锁定</a> | <a href=# onclick="alert('该功能尚在开发中。');" title=屏蔽该用户在论坛的发言>屏蔽</a> | <a href=# onclick="alert('该功能尚在开发中。');" title=解除该用户在论坛的锁定和屏蔽>解除</a> | <a href=# onclick="alert('该功能尚在开发中。');" title=对用户进行分值奖励>奖励</a> | <a href=# onclick="alert('该功能尚在开发中。');">编辑该用户论坛权限</a> 』
</td></tr>
-->

<tr><td class=TableBody1 valign=middle height=25 colspan=2>
<B>用户最后来访IP</B>：   <a href=# onclick="alert('该功能尚在开发中。');"><?php echo $user['lasthost']; ?></a>&nbsp;&nbsp;点击IP查看用户来源及操作
</td></tr>

</table>

<?php
}

?>
