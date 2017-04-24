<?php
require_once "inc/functions.php";
check_login_status();
$HEAD_TITLE = tran("notes");

$note_cat_id = intval($_GET['note_cat_id']);
$note_id = intval($_GET['note_id']);

$s = new mysql;

if($_POST['newnote'])
{
	$sql ="INSERT INTO notes VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_POST['category']."', '".$_POST['title_content']."');";
	$s->excu($sql);
	//重定向后系统又执行了。
	header("location:".SITE_BASEURL."notes.php?note_cat_id=".$_POST['category']);
	}
elseif($_POST['updatenote'])
{
	$sql = "update notes set body ='".$_POST['body']."',cat_id=".$note_cat_id." where id = ".$note_id;
	$s->excu($sql);
	header("location:".SITE_BASEURL."notes.php?note_cat_id=".$_POST['category'])."&note_id".$note_id;
}elseif($_GET['func']=='del' &&$note_id && $note_cat_id)
{
	$sql = "delete from notes where id = ".$note_id;
	$s->excu($sql);
	header("location:".SITE_BASEURL."notes.php?note_cat_id=".$note_cat_id);
}
elseif($_GET['func']=='del'&& $note_cat_id && (!$note_id))
{
	$sql = "delete from note_cats where id = ".$note_cat_id;
	$s->excu($sql);
	header("location:".SITE_BASEURL."notes.php?note_cat_id=".$note_cat_id);
}
elseif(($note_id && $note_cat_id) ||$note_id)
{
	//note
	$sql = "select * from notes where user_id =".$_SESSION['SESS_USERID']." and id = ".$note_id;
	$s->excu($sql);
	$r = mysql_fetch_assoc($s->rs);
	$DEFAULT_CONTENT = ($r['body']?$r['body']:"");
	//cat note
	$sqlcat = "select * from note_cats where id = ".$note_cat_id ." and user_id =".$_SESSION['SESS_USERID'];
	$scat= new mysql;
	$scat->excu($sqlcat);
	$rcat = mysql_fetch_assoc($scat->rs);
}else
{}	
	

require("header.php");
	$scats= new mysql();
	$sqlcats = "select * from note_cats where user_id = ".$_SESSION['SESS_USERID'];
	$scats->excu($sqlcats);
	echo "<fieldset><legend><h3>".tran("notes")."</h3></legend>&nbsp;".printout($DEFAULT_CONTENT,1)."</fieldset>";
	echo "<fieldset><legend><h3>".tran("new").tran("notes")."</h3></legend><form action=''method='post'><table><tr><td>Category</td><td><select name='category'>";
	while($rcats = mysql_fetch_assoc($scats->rs))
	{
		echo "<option value='".$rcats['id']."' ".($rcats['id']==$rcat['id']?"selected":"").">".$rcats['category']."</option>";
	}
	
	echo "</select></td><td></td></tr><tr><td>Body:</td><td>";
	include "editer/textEditer.php";
	echo "</td><td></td></tr><tr><td></td><td valign='bottom'><input type='submit' name='".($note_id?"updatenote":"newnote")."' value=' ".($note_id?tran("update"):tran("new"))." '/></td><td></td>
	</table></form></fieldset>";
	
require ("footer.php");
?>