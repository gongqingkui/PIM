<?php
require_once "inc/functions.php";
check_login_status();
$HEAD_TITLE = tran("task");
$s = new mysql;

if($_POST['newtask'])
{
	$sql = "INSERT INTO `pim`.`tasks` VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_POST['subject']."', '".$_POST['location']."', '0', '".$_POST['priority']."', '1', '');";
	//$s->excu($sql);
	//echo $s->error_msg;
	header("location:".SITE_BASEURL."tasks.php");
}elseif($_POST['updatetask'])
{
	$sql = "UPDATE `tasks` SET `subject` = '".$_POST['subject']."',`location` = '".$_POST['location']."',`status` = '".$_POST['status']."',`reminder` = '1',`priority` = '".$_POST['priority']."' WHERE `id` =".$_GET['task_id'];
	$s->excu($sql);
	echo $s->error_msg;
	//header("location:".SITE_BASEURL."tasks.php?task_id=".$_GET['task_id']);
	header("location:".SITE_BASEURL."tasks.php");
}elseif($_GET['func']=="del")
{
	$sql = "delete from tasks where id = ".intval($_GET['task_id']);
	$s->excu($sql);
	echo $s->error_msg;
	header("location:".SITE_BASEURL."tasks.php");
	
}elseif($_GET['func']=="conf")
{
	$sql = "UPDATE `tasks` SET `status` = 1 where id =".$_GET['task_id'];
	//$s->excu($sql);
	//echo $s->error_msg;
	header("location:".SITE_BASEURL."tasks.php");	
}
elseif($_GET['priority'])
{
	$sql = "select * from tasks where user_id = ".$_SESSION['SESS_USERID']." and priority = ";
	switch ($_GET['priority'])
	{
		case "3":
			$sql .="3";
		break;
		case "2":
			$sql .="2";
		break;
		case "1":
			$sql .="1";
		break;
		default:break;
		}
	require ("header.php");
}elseif(isset($_GET['status']))
	{
		$sql = "select * from tasks where user_id = ".$_SESSION['SESS_USERID']." and status = ";
		switch ($_GET['status'])
	{
		case "0":
			$sql.=0;
		break;
		case "1":
			$sql.=1;
		break;
		}
		require ("header.php");
}
elseif($_GET['location'])
	{
		$sql = "select * from tasks where user_id = ".$_SESSION['SESS_USERID']." and location = '".$_GET['location']."'";
		require ("header.php");
}elseif($_GET['task_id'])
{
	//显示
	$sql = "SELECT * FROM `tasks` where user_id = ".$_SESSION['SESS_USERID']." and id = ".intval($_GET['task_id']);
	$s->excu($sql);
	$r = mysql_fetch_assoc($s->rs);
	
	require ("header.php");
	echo "<fieldset><legend><h3>".tran("edit")."</h3></legend><form action=''method='post'>
	<table><tr><td>".tran("subject").":</td><td><input type='text' name='subject' value=".$r['subject']."></input></td></tr>
		<tr><td>".tran("location").":</td><td><select name='location'>";
		for($i=0;$i<=4;$i++)
		{
			echo "<option value='".$locationsarr[$i]."'".($locationsarr[$i]==$r['location']?"selected":"").">".$locationsarr[$i]."</option>";
			}
	echo "</select></td></tr><tr><td>".tran("priority").":</td><td><select name='priority'>";
		for($i=1;$i<=3;$i++){
				echo "<option value='".$i."'".($i==$r['priority']?"selected":"").">".$i."</option>";
			}
	echo "</select></td></tr><tr><td>".tran("status").":</td><td>
	<select name='status'>
		<option value='0' ".($r['status']==0?"selected":"").">Not Done</option>
		<option value='1' ".($r['status']==1?"selected":"").">Done</option>
	</select></td></tr>
	<tr><td><input type='submit' name='updatetask' value=' ".tran("update")." '/></td><td></td></tr>
	</table></form></fieldset>";
	}
else
{
	//什么都没有的时候新建
	require ("header.php");
	
	$sql = "select * from tasks where user_id =".$_SESSION['SESS_USERID'];
	$s->excu($sql);
	
}

//$s->excu($sql);
echo "<fieldset><legend><h3>".tran("new").tran("task")."</h3></legend><form action=''method='post'>
	<table><tr><td>Subject:</td><td><input type='text' name='subject'/></td></tr>
		<tr><td>Location:</td><td><select name='location'>";
		for($i=0;$i<=4;$i++)
		{
			echo "<option value='".$locationsarr[$i]."'>".$locationsarr[$i]."</option>";}
	echo "</select></td></tr><tr><td>Priority:</td><td><select name='priority'";
		for($i=0;$i<=3;$i++){
				echo "<option value='".$i."'".($i==2?"selected":"").">".$i."</option>";
			}
	echo "</select></td></tr><tr><td><input type='submit' name='newtask' value=' ".tran("new")." '/></td><td></td></tr>
	</table></form></fieldset>";

echo "<fieldset><legend><h3>".tran("location").":All-".tran("status").":All-".tran("priority").":All</h3></legend>
	<table><tr><th>Oper</th><th>Subject</th><th>Location</th><th>Priority</th><th>Status</th></tr>";
	
	$s->excu($sql);
	
	while($r = @mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor().">
			<td>[<a href='?func=del&task_id=".$r['id']."'>X</a>]<a href='?func=conf&task_id=".$r['id']."'>".($r['status']==0?"[C]":"")."</a></td>
			<td><strong><a href='?task_id=".$r['id']."'>".$r['subject']."</a></strong></td>
			<td>".$r['location']."</td>
			<td>".($r['priority']==3?"High":($r['priority']==2?"Medium":"Low"))."</td>
			<td>".($r['status']?"Done":"Not Done")."</td></tr>";
		}
		echo "</table></fieldset>";

require ("footer.php");
?>