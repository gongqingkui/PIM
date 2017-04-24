<?php
require_once "inc/functions.php";
check_login_status();
$HEAD_TITLE = tran("calendar");
$systime =  $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-".$_SESSION['SESS_DAY'];

//require ("header.php");
$s = new mysql;

if($_POST['newcalendar'])
{
	if($_POST['endtime']>$_POST['starttime'])
	{
	$sql ="INSERT INTO `calendars` VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_POST['subject']."', '".$_POST['location']."','".$_POST['type']."', '".$_POST['starttime']."' , '".$_POST['endtime']."' , '1','0', '');";
	//$s->excu($sql);
	header("location:".SITE_BASEURL."calendar.php?view=year");
	}
	else
	{
		popErrors("034");
	}
}elseif($_POST['editcalendar'])
{
	$sql = "update calendars set subject = '".$_POST['subject']."' ,location='".$_POST['location']."' ,type='".$_POST['type']."',starttime='".$_POST['starttime']."',endtime='".$_POST['endtime']."' where id='".$_GET['calendar_id']."'";
	$s->excu($sql);
	header("location:".SITE_BASEURL."calendar.php?contanct_id=".$_GET['calendar_id']);
}elseif($_GET['func']=='del')
{
	$sql = "delete from calendars where id = ".$_GET['calendar_id'];
	$s->excu($sql);
	header("location:".SITE_BASEURL."calendar.php?view=year");
}elseif($_GET['func']=='conf')
{
	$sql = "update calendars set status =1 where id =".$_GET['calendar_id'];
	$s->excu($sql);
	header("location:".SITE_BASEURL."calendar.php?view=year");
}

elseif($_GET['view'])
{
	switch($_GET['view'])
	{
	case "day":
		$systime =  $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-".$_SESSION['SESS_DAY'];
		$sql = "SELECT * FROM `calendars` WHERE (starttime >= '".$systime." 00:00:00' AND starttime <= '".$systime." 24:00:00')OR (endtime >= '".$systime." 00:00:00' AND endtime <= '".$systime." 24:00:00')AND user_id =".$_SESSION['SESS_USERID']." ORDER BY starttime";
	break;
	case "month":$systime =  $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH'];
		$sql = "SELECT * FROM `calendars` WHERE (starttime >= '".$systime."-01 00:00:00' AND starttime <= '".$systime."-31 24:00:00')OR (endtime >= '".$systime."-01 00:00:00' AND endtime <= '".$systime."-31 24:00:00')AND user_id =".$_SESSION['SESS_USERID']." ORDER BY starttime";
	break;
	case "year":
		$systime =  $_SESSION['SESS_YEAR'];
		$sql = "SELECT * FROM `calendars` WHERE (starttime >= '".$systime."-01-01 00:00:00' AND starttime <= '".$systime."-12-31 24:00:00')OR (endtime >= '".$systime."-01-01 00:00:00' AND endtime <= '".$systime."-12-31 24:00:00')AND user_id =".$_SESSION['SESS_USERID']." ORDER BY starttime";
	break;
	default :exit();
	}	
}elseif($_GET['location'])
{
	$sql = "select * from calendars where user_id = ".$_SESSION['SESS_USERID'] ." and location = '";
		switch($_GET['location'])
		{
			case "Home":$sql.="Home'";break;
			case "Dormitory":$sql.="Dormitory'";break;
			case "Office":$sql.="Office'";break;
			case "Road":$sql.="Road'";break;
			case "Net":$sql.="Net'";break;
			case "Library":$sql.="Library'";break;
			default:exit();
			}
			$sql.=" order by starttime asc";
			//echo $sql;
	}elseif($_GET['type'])
{
	//为安全此处最好用switch判断一下
	$sql = "select * from calendars where user_id = ".$_SESSION['SESS_USERID'] ." and type = '".$_GET['type']."'";
	$sql.=" order by starttime asc";
	//echo $sql;
}elseif($_GET['calendar_id'])
{
	$sql = "select * from calendars where user_id = ".$_SESSION['SESS_USERID'] ." and id=".$_GET['calendar_id'];
}
else
{
	//什么都不传入，列出显示suoyou的句子。
	$sql = "SELECT * FROM calendars WHERE user_id =".$_SESSION['SESS_USERID']." order by  starttime";
}
require("header.php");
$s->excu($sql);
echo $s->error_msg;
if($s->rs)
{
	//$r =@ mysql_fetch_assoc($s->rs);
	echo "<fieldset><legend><h3>".($_GET['calendar_id']==false?tran("new"):tran("edit")).tran("calendar")."</h3></legend><form action=''method='post'>
	<table><tr><td>Subject:</td><td><input type='text' name='subject' value=".($_GET['calendar_id']?$r['subject']:"")."></input></td></tr>
		<tr><td>Location:</td><td><select name='location'>";
		for($i=0;$i<=4;$i++)
		{
			echo "<option value='".$locationsarr[$i]."'".($locationsarr[$i]==$r['location']?"selected":"").">".$locationsarr[$i]."</option>";
			}
	echo "</select></td></tr><tr><td>Type</td><td><select name='type'>";
		for($i=0;$i<=4;$i++)
		{
			echo "<option value='".$typesarr[$i]."' ".($typesarr[$i]==$r['type']?"selected":"").">".$typesarr[$i]."</option>";
			}
	echo "</select></td></tr>
		<tr><td>Starttime:</td><td><input type='text' name='starttime' value='".($r['starttime']?$r['starttime']:date('Y-m-d H:i:s',time()))."'/></td></tr>
		<tr><td>Endtime:</td><td><input type='text' name='endtime' value='".($r['endtime']?$r['endtime']:date('Y-m-d H:i:s',time()+1800))."'/></td></tr>
		<tr><td><input type='submit' name='".($_GET['calendar_id']?"editcalendar":"newcalendar")."' value=' ".($_GET['calendar_id']?tran('edit'):tran("new"))." '/></td><td></td></tr>
	</table></form></fieldset>";
	echo "<fieldset><legend><h3>".tran("view").":".($_GET['view']?$_GET['view']:"All")."-".tran("location").":".($_GET['location']?$_GET['location']:"All")."-".tran("type").":".($_GET['type']?$_GET['type']:"All")."</h3></legend>
	<table><tr><th>Oper</th><th>Subject</th><th>Location</th><th>Type</th><th>Start</th><th>End</th><th>Status</th></tr>";
	while($r =@ mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor()."><td>[<a href='?func=del&calendar_id=".$r['id']."'>X</a>]
		<a href='?func=conf&calendar_id=".$r['id']."'>".($r['status']==0?"[C]":"")."</a></td>
		<td><strong>".a($r['subject'],$r['subject'],"calendar.php?calendar_id=".$r['id'])."</strong></td>
		<td>".$r['location']."</td><td>".$r['type']."</td>
		<td>".$r['starttime']."</td><td>".$r['endtime']."</td>
		<td>".($r['status']==1?"Pass":(strtotime($r['starttime'])>time()?"<img src='images/green.png'></img>":(strtotime($r['endtime'])>time()?"<img src='images/yellow.png'></img>":"<img src='images/red.png'></img>"))).
		"</td></tr>";
		}
	echo "</table></fieldset>";
}
//print_r($locationsarr);
require ("footer.php");
?>