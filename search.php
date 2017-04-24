<?php
	require_once "inc/functions.php";
	check_login_status();
	$s = new mysql();
	
	$HEAD_TITLE=tran("search");
	if($_GET['keyword']=="")
		header("location:".SITE_BASEURL."error.php?id=037");
	
	require ("header.php");
	
	//messages
	$sql = "select id,body subject,from_id,to_id from messages where body like '%".$_GET['keyword']."%' and (to_id=".$_SESSION['SESS_USERID']." or from_id=".$_SESSION['SESS_USERID'].")";
	$s->excu($sql);
	
	echo "<table><caption><h3>".tran("messages")."</caption><tr><th>Subject</th></tr>";
	while($r =mysql_fetch_assoc($s->rs) )
	{
		echo "<tr class=".trcolor()."><td>".a($r['subject'],$r['subject'],"messages.php?user_id=".(($_SESSION['SESS_USERID']==$r['to_id'])?$r['from_id']:$r['to_id']))."</td></tr>";
	}
	echo "</table>";
	
	//contancts
	$sql = "select id,name subject  from contancts where name like '%".$_GET['keyword']."%' and user_id=".$_SESSION['SESS_USERID'];
	$s->excu($sql);
	echo "<table><caption><h3>".tran("contanct")."</h3></caption><tr><th>Subject</th></tr>";
	while($r =mysql_fetch_assoc($s->rs) )
	{
		echo "<tr class=".trcolor()."><td>".a($r['subject'],$r['subject'],"contanct.php?contanct_id=".$r['id'])."</td></tr>";
	}
	echo "</table>";
	
	//calendar
	$sql = "select id,subject from calendars where subject like '%".$_GET['keyword']."%' and user_id=".$_SESSION['SESS_USERID'];
	$s->excu($sql);
	echo "<table><caption><h3>".tran("calendar")."</h3></caption><tr><th>Subject</th></tr>";
	while($r =mysql_fetch_assoc($s->rs) )
	{
		echo "<tr class=".trcolor()."><td>".a($r['subject'],$r['subject'],"calendar.php?calendar_id=".$r['id'])."</td></tr>";
	}
	echo "</table>";
	
	//tasks
	$sql = "select id,subject from tasks where subject like '%".$_GET['keyword']."%' and user_id=".$_SESSION['SESS_USERID'];
	$s->excu($sql);
	echo "<table><caption><h3>".tran("task")."</h3></caption><tr><th>Subject</th></tr>";
	while($r =mysql_fetch_assoc($s->rs) )
	{
		echo "<tr class=".trcolor()."><td>".a($r['subject'],$r['subject'],"tasks.php?task_id=".$r['id'])."</td></tr>";
	}
	echo "</table>";
	
	//notes
	$sql = "select id,body subject from notes where body like '%".$_GET['keyword']."%' and user_id=".$_SESSION['SESS_USERID'];
	$s->excu($sql);
	echo "<table><caption><h3>".tran("notes")."</h3></caption><tr><th>Subject</th></tr>";
	while($r =mysql_fetch_assoc($s->rs) )
	{
		echo "<tr class=".trcolor()."><td>".a($r['subject'],$r['subject'],"notes.php?note_id=".$r['id'])."</td></tr>";
	}
	echo "</table>";
	require ("footer.php");
?>