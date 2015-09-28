<?php

/**
 * Checking whether a board is set with some specific flags or not.
 * 
 * @param $board the board object to be checked
 * @param $flag the flags to check
 * @return TRUE  the board is set with the flags
 *         FALSE the board is not set with the flags
 * @author flyriver
 */
function bbs_check_board_flag($board,$flag)
{
	if ($board["FLAG"] & $flag)
		return TRUE;
	else
		return FALSE;
}

/**
 * Checking whether a board is an anonymous board or not.
 * 
 * @param $board the board object to be checked
 * @return TRUE  the board is an anonymous board
 *         FALSE the board is not an anonymous board
 * @author flyriver
 */
function bbs_is_anony_board($board)
{
	global $BOARD_FLAGS;
	return bbs_check_board_flag($board, $BOARD_FLAGS["ANONY"]);
}

/**
 * Checking whether a board is an outgo board or not.
 * 
 * @param $board the board object to be checked
 * @return TRUE  the board is an outgo board
 *         FALSE the board is not an outgo board
 * @author flyriver
 */
function bbs_is_outgo_board($board)
{
	global $BOARD_FLAGS;
	return bbs_check_board_flag($board, $BOARD_FLAGS["OUTGO"]);
}

/**
 * Checking whether a board is a junk board or not.
 * 
 * @param $board the board object to be checked
 * @return TRUE  the board is a junk board
 *         FALSE the board is not a junk board
 * @author flyriver
 */
function bbs_is_junk_board($board)
{
	global $BOARD_FLAGS;
	return bbs_check_board_flag($board, $BOARD_FLAGS["JUNK"]);
}

/**
 * Checking whether a board is an attachment board or not.
 * 
 * @param $board the board object to be checked
 * @return TRUE  the board is an attachment board
 *         FALSE the board is not an attachment board
 * @author flyriver
 */
function bbs_is_attach_board($board)
{
	global $BOARD_FLAGS;
	return bbs_check_board_flag($board, $BOARD_FLAGS["ATTACH"]);
}

/**
 * Checking whether a board is a readonly board or not.
 * 
 * @param $board the board object to be checked
 * @return TRUE  the board is a readnoly board
 *         FALSE the board is not a readonly board
 * @author flyriver
 */
function bbs_is_readonly_board($board)
{
	global $BOARD_FLAGS;
	return bbs_check_board_flag($board, $BOARD_FLAGS["READONLY"]);
}


function bbs_is_noreply_board($board)
{
	global $BOARD_FLAGS;
	return bbs_check_board_flag($board, $BOARD_FLAGS["NOREPLY"]);
}


/* $ftype == -1: ������, false: Ĭ������ģʽ */
function showBoardStaticsTop($boardArr, $is_bm, $ftype=false){
	global $conn;
	global $loginok;
	global $dir_modes;
?>
<TABLE cellpadding=3 cellspacing=1 class=TableBorder1 align=center>
<TR><Th height=25 width=100% align=left id=TableTitleLink style="font-weight:normal">
���浱ǰ����<b><?php echo $boardArr['CURRENTUSERS']+1;?></b>�����ߡ���������<?php echo bbs_get_today_article_num($boardArr['NAME'] ); ?>��
[<a href="favboard.php?bname=<?php echo $boardArr["NAME"]; ?>" title="�ղر����浽�ղؼж���Ŀ¼">�ղر���</a>]
<?php
	if ($loginok && SHOW_POST_UNREAD) {
?>
&nbsp;[<a href="doclear.php?boardName=<?php echo $boardArr["NAME"]; ?>" title="�������������±�ǳ��Ѷ�">���δ��</a>]
<?php
	}
?>
<span id="onboard_users"></span></Th></TR></TABLE>
<BR>
<table cellpadding=2 cellspacing=0 border=0 width=97% align=center valign=middle><tr><td align=center width=2> </td>
<td align=left style="height:27" valign="center"><table cellpadding=0 cellspacing=0 border=0 ><tr>
<td width="110"><a href="postarticle.php?board=<?php echo $boardArr['NAME']; ?>"><div class="buttonClass1" border="0" title="������"></div></a></td>
<!--<td width="110"><a href=# onclick="alert('���������ڿ����У�')"><div class="buttonClass2" border="0" title="������ͶƱ"></div></a></td>-->
<?php
	if ($conn !== false) {
?>
<td width="110"><a href="smallpaper.php?board=<?php echo $boardArr['NAME']; ?>"><div class="buttonClass3" border="0" title="����С�ֱ�"></div></a></td>
<?php
	}
?>
</tr></table></td>
<td align=right>
<?php
	if (RSS_SUPPORT) {
?>
	<a title="���� RSS" href="rsslinks.php?board=<?php echo $boardArr['NAME']; ?>"><img src="pic/xml.gif" align="top" width="36" height="14" alt="XML" border="0" /></a> &nbsp;
<?php
	}
	if ($is_bm) {
?>
	<a href="bmdeny.php?board=<?php echo $boardArr['NAME']; ?>" title=�鿴�Ͳ�������������><font color=red>�������</font></a> | 
<?php
	}
	if ($ftype !== false) {
?>
	<a href="board.php?name=<?php echo $boardArr['NAME']; ?>" title=�鿴��������><font color=blue><B>������</B></font></a> 
<?php
	}
	if ($ftype != -1) {
		$ann_path = bbs_getannpath($boardArr['NAME']);
		if ($ann_path != FALSE) {
	    	if (!strncmp($ann_path,"0Announce/",10))
			$ann_path=substr($ann_path,9);
?>
	<a href="elite.php?path=<?php echo urlencode($ann_path); ?>" title=�鿴���澫����><font color=#FF0000><B>������</B></font></a> 
<?php
		}
	}
	if ($dir_modes["DIGEST"] != $ftype) {
?>
	<a href="boarddoc.php?name=<?php echo $boardArr['NAME']; ?>&amp;ftype=1" title=�鿴������ժ��><font color=#FF00FF><B>��ժ��</B></font></a> 
<?php
	}
?>
&nbsp;&nbsp;<img src=pic/team2.gif align=absmiddle>
<?php 
	$bms=split(' ',$boardArr['BM']);
	foreach($bms as $bm) {
?>
<a href="dispuser.php?id=<?php echo $bm; ?>" target=_blank title=����鿴�ð�������><?php echo $bm; ?></a>
<?php
	}
?>
</td></tr></table>
<?php
}


function showBroadcast($boardID,$boardName){
	global $conn;
	if ($conn === false) return;
?>
<tr><td class=TableBody1 colspan=5 height=20>
	<table width=100% ><tr><td valign=middle height=20 width=50><a href=allpaper.php?board=<?php echo $boardName; ?> title=����鿴����̳����С�ֱ�><b>�㲥</b></a>��</td><td width=*> <marquee scrolldelay=150 scrollamount=4 onmouseout="{this.start()}" onmouseover="{this.stop()}">
<?php
	$sth = $conn->query("SELECT ID,Owner,Title FROM smallpaper_tb where Addtime>=subdate(Now(),interval 1 day) and boardID=" . $boardID . " ORDER BY Addtime desc limit 5");
	while($rs = $sth->fetchRow(DB_FETCHMODE_ASSOC)) {
		print "����<font color=#ff0000>".$rs['Owner']."</font>˵��<a href=javascript:openScript('viewpaper.php?id=".$rs['ID']."&boardname=".$boardName."',500,400)>".htmlspecialchars($rs['Title'],ENT_QUOTES)."</a>";
  } 
  unset($rs);
  $sth->free();
?>
	</marquee>
</td></tr></table>
</td></tr>
<?php
}

function board_head_var($boardDesc,$boardName,$secCode)
{
  GLOBAL $SiteName;
  GLOBAL $stats;
  global $section_names;
  if ($URL=='') {
	  $URL=$_SERVER['PHP_SELF'];
  }
  $secIndex = get_secname_index($secCode);
?>
<table cellspacing="1" cellpadding="3" align="center" class="TableBorder2">
<tr><td><nobr>
<img src="pic/forum_nav.gif"/> <a href="index.php"><?php   echo $SiteName; ?></a> �� 
<a href="section.php?sec=<?php echo $secIndex; ?>"><?php echo $section_names[$secIndex][0] ; ?></a> �� 
<a href="board.php?name=<?php echo $boardName; ?>"><?php echo htmlspecialchars($boardDesc); ?></a> �� 
<?php echo $stats; ?> 
</nobr></td>
<td align="right" id="serverTime"> </td>
</tr>
</table>
<?php
	if (SHOW_SERVER_TIME) {
?>
<script language="JavaScript">
<!--
	initTime(<?php echo time()+intval(date("Z")); ?>);
//-->
</script>
<?php
	}
?>
<br/>
<?php 
}

function boardJump(){
	global $section_names;
	global $sectionCount;
	global $section_nums;
	global $yank;
?>
<div align="right"><select onchange="if(this.options[this.selectedIndex].value!=''){location=this.options[this.selectedIndex].value;}">
<option selected="selected">��ת��̳��...</option>
<?php
	for ($i=0;$i<$sectionCount;$i++){
		echo "<option value=\"section.php?sec=".$i."\">��".$section_names[$i][0]."</option>";
		$boards = bbs_getboards($section_nums[$i], 0, $yank | 2);
		if ($boards != FALSE) {
			$brd_desc = $boards["DESC"]; // ��������
			$brd_name = $boards["NAME"];
			$rows = sizeof($brd_desc);
			for ($t = 0; $t < $rows; $t++)	{
				echo "<option value=\"board.php?name=".$brd_name[$t]."\">&nbsp;&nbsp;��".htmlspecialchars($brd_desc[$t])."</option>";
			}
		}
	}
?>
</select></div>
<?php
}
function boardSearchAndJump($boardName, $boardID){

?>
<table border=0 cellpadding=0 cellspacing=3 width=97% align=center>
<tr>
<FORM METHOD=GET ACTION="queryresult.php">
<input type="hidden" name="boardNames" value="<?php echo $boardName; ?>">
<td width=50% valign=middle nowrap height=40>����������<input type=text name=title>&nbsp;<input type=submit value=����></td>
</FORM>
<td valign=middle nowrap width=50% > 
<?php
	boardJump();
?>
</td></tr></table><br/>
<?php
}

function showBoardSampleIcons(){
	global $SiteName;
?>
<table cellspacing=1 cellpadding=3 width=100% class=TableBorder1 align=center><tr><th width=80% align=left>��-=&gt; <?php echo $SiteName; ?>ͼ��</th><th noWrap width=20% align=right>����ʱ���Ϊ - <?php echo SERVERTIMEZONE; ?> &nbsp;</th></tr><tr><td colspan=2 class=TableBody1><table cellspacing=4 cellpadding=0 width=92% border=0 align=center><tr><td><img src=pic/blue/folder.gif> ���ŵ�����</td><td><img src=pic/blue/hotfolder.gif> �ظ�����10��</td><td><img src=pic/blue/lockfolder.gif> ����������</td><td><img src=pic/istop.gif> �̶������� </td><!--<td><img src=pic/ztop.gif> �̶ܹ������� </td>--><td> <img src=pic/isbest.gif> �������� </td><!--<td> <img src=pic/closedb.gif> ͶƱ���� </td>--></tr></table></td></tr></table>
<?php
}

function isMultiQueryAllowed() {
	global $currentuser;

	if (ALLOWMULTIQUERY) return true;
	if (ALLOW_SYSOP_MULTIQUERY) {
		if ($currentuser["userlevel"] & BBS_PERM_SYSOP) return true;
	}
	return false;
}

function isSelfMultiQueryAllowed() {
	global $loginok;

    if ($loginok != 1) return false;
    if (isMultiQueryAllowed()) return true;
    return (ALLOW_SELF_MULTIQUERY);
}

/* title === false ��ʱ��ֻ�������� */
function getBoardRSS($boardName, $ftype=-1, $title="") {
	global $SiteURL;
	if (RSS_SUPPORT) {
		if ($ftype == -1) {
			$title = "��������";
			$link = "rss.php?board=".$boardName;
		} else {
			$link = "rss.php?board=".$boardName."&amp;ftype=$ftype";
		}
		if ($title === false) return $link;
		else return "<link id=\"RSSLink\" title=\"$title RSS\" type=\"application/rss+xml\" rel=\"alternate\" href=\"".$SiteURL.$link."\"></link>";
	} else return "";
}

/* ��������ģʽ���� false�����Ҫ֧�ֻ���վ��ģʽǧ��ע��Ȩ�޺� web cache �������⣡ */
function getModenameIfAllowed($ftype, &$sorted) {
	global $dir_modes;
	switch($ftype) {
		case $dir_modes["NORMAL"]:
			$sorted = true;
			return "������"; //ft
		case $dir_modes["DIGEST"]:
			$sorted = false;
			return "��ժ��";
		case $dir_modes["ORIGIN"]:
			$sorted = true;
			return "ԭ����";
		default:
			return false;
	}
}

function pageJumperHelper($page, $linkpage, $urlbase) {
	if ($linkpage == $page)	{
		return "<font color='#ff0000'><b>".$page."</b></font> ";
	} else {
		return "<a href='$urlbase$linkpage'><b>$linkpage</b></a> ";
	}
}

function showPageJumpers($page, $totalPages, $urlbase) {
	$HalfPageShow = 4;
	$str = "";
	if ($page > 1) {
		$str .= "<a href='$urlbase".($page-1)."' title='��һҳ'>&lt;&lt;</a> ";
	}
	$min = $page - $HalfPageShow;
	$max = $page + $HalfPageShow;
	if (($min < 1) && ($max > $totalPages)) {
		$min = 1;
		$max = $totalPages;
	} else if ($min < 1) {
		$min = 1;
		$max = $min + 2 * $HalfPageShow;
		if ($max > $totalPages) $max = $totalPages;
	} else if ($max > $totalPages) {
		$max = $totalPages;
		$min = $max - 2 * $HalfPageShow;
		if ($min < 1) $min = 1;
	}

	if ($min > 1) $str .= pageJumperHelper($page, 1, $urlbase);
	if ($min > 2) $str .= "... ";
	for ($i = $min; $i <= $max; $i++) {
		$str .= pageJumperHelper($page, $i, $urlbase);
	}
	if ($max < $totalPages - 1) $str .= "... ";
	if ($max < $totalPages) $str .= pageJumperHelper($page, $totalPages, $urlbase);
	if ($page < $totalPages) {
		$str .= "<a href='$urlbase".($page+1)."' title='��һҳ'>&gt;&gt;</a> ";
	}
	echo $str;
}
?>