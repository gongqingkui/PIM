<?php
	require_once ('inc\functions.php');
	check_login_status();
	
	$HEAD_TITLE=tran("firstpage");
	require ("header.php");
	
	if($_GET['func']=="del")
	{
		$sql = "delete from ".$_GET['oper_object']." where id = ".$_GET['object_id'];
	}elseif($_GET['func']=="conf")
	{
		$sql ="update ".$_GET['oper_object']." set status = 1 where id = ".$_GET['object_id'];
	}
	$s->excu($sql);
	
	$messql ="select messages.body,messages.id,messages.send_time,messages.status,messages.from_id,users.name from messages,users where messages.status = 0 and messages.from_id = users.id and messages.to_id = ".$_SESSION['SESS_USERID'];
	$s->excu($messql);
	echo "<fieldset><legend><h3>".tran("wait").tran("messages")."</h3></legend><table><tr><th>Oper</th><th>From</th><th>Body</th><th>Time</th></tr>";
	while($r = mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor()."><td>[<a href='?func=del&oper_object=messages&object_id=".$r['id']."'>X</a>]
		<a href='?func=conf&oper_object=messages&object_id=".$r['id']."'>".(($r['status']==0 and $r['to_id']== $_SESSION['SESS_USERID'])?"[C]":"")."</a></td>
		<td><strong>".a($r['name'],$r['name'],"messages.php?user_id=".$r['from_id'])."</strong></td>
		<td> ".$r['body']."</td><td>".$r['send_time']."</td></tr>";
	}
	echo "</table></fieldset>";
	
	$calsql = "select * from calendars where status = 0 and user_id =".$_SESSION['SESS_USERID']." and (starttime<now() or endtime<now())";
	$s->excu($calsql);
	echo "<fieldset><legend><h3>".tran("wait").tran("calendar")."</h3></legend>
	<table><tr><th>Oper</th><th>Subject</th><th>Location</th><th>Type</th><th>Start</th><th>End</th><th>Status</th></tr>";
	while($r =@ mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor()."><td>[<a href='?func=del&oper_object=calendars&object_id=".$r['id']."'>X</a>]
		<a href='?func=conf&oper_object=calendars&object_id=".$r['id']."'>".($r['status']==0?"[C]":"")."</a></td>
		<td><strong>".a($r['subject'],$r['subject'],"calendar.php?calendar_id=".$r['id'])."</strong></td><td>".$r['location']."</td><td>".$r['type']."</td>
		<td>".$r['starttime']."</td><td>".$r['endtime']."</td>
		<td>".($r['status']==1?"Pass":(strtotime($r['starttime'])>time()?"<img src='images/green.png'></img>":(strtotime($r['endtime'])>time()?"<img src='images/yellow.png'></img>":"<img src='images/red.png'></img>"))).
		"</td></tr>";
		}
	echo "</table></fieldset>";
	
	$tassql = "select * from tasks where status = 0 and user_id =".$_SESSION['SESS_USERID'];
	$s->excu($tassql);
	echo "<fieldset><legend><h3>".tran("wait").tran("task")."</h3></legend>
	<table><tr><th>Oper</th><th>Subject</th><th>Location</th><th>Priority</th><th>Status</th></tr>";
	while($r = @mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor()."><td>[<a href='?func=del&oper_object=tasks&object_id==".$r['id']."'>X</a>]
			<a href='?func=conf&oper_object=tasks&object_id=".$r['id']."'>".($r['status']==0?"[C]":"")."</a></td>
			<td><strong>".a($r['subject'],$r['subject'],"tasks.php?task_id=".$r['id'])."</strong></td>
			<td>".$r['location']."</td>
			<td>".($r['priority']==3?"High":($r['priority']==2?"Medium":"Low"))."</td>
			<td>".($r['status']?"Done":"Not Done")."</td></tr>";
		}
		echo "</table></fieldset>";
		
 	$consql ="SELECT contancts.name, contancts.last_time, contancts.frequency, contancts.id
FROM contancts
WHERE contancts.user_id =".$_SESSION['SESS_USERID']."
AND now( ) > date_add( contancts.last_time, INTERVAL contancts.frequency
DAY ) 
";
	$s->excu($consql);
	echo "<fieldset><legend><h3>".tran("wait").tran("contanct")."</h3></legend>
	<table><tr><th>Name</th><th>Last_time</th><th>Frequency(Days)</th></tr>";
	while($r = @mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor()."><td><strong>".a($r['name'],$r['name'],"contanct.php?contanct_id=".$r['id'])."</strong></td>
			<td>".$r['last_time']."</td>
			<td>".$r['frequency']."</td>";
			
		}
		echo "</table></fieldset>";
		
		
	require ("footer.php");
?>