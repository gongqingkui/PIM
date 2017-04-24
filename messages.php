<?php
	require_once "inc/functions.php";
	check_login_status();
	
	$HEAD_TITLE=tran("messages");
	
	$user_id = intval($_GET['user_id']);
	$to_id = intval($_GET['to_id']);
	$s = new mysql();
	
if($_POST['replymessage'])
{
		$sql = "INSERT INTO `messages` (`id` ,`from_id` ,`to_id` ,`body` ,`send_time`,`status` )VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_GET['user_id']."', '".$_POST['messages']."', NOW( ),'0' );";
		echo $sql->error_msg;
		$s->excu($sql);
		header("location:".with_get($_SERVER['PHP_SELF']));
}
elseif($_POST['newmessage'])
{
			//insert
			$sql = "INSERT INTO messages VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$to_id."', '".$_POST['messages']."', NOW( ),'0');";
			echo $sql->error_msg;
			$s->excu($sql);
			header("location:".SITE_BASEURL."messages.php?user_id=".$to_id);
}elseif($_GET['func']=='del')
{
		$sql ="delete from messages where id = ".$_GET['message_id'];
		$s->excu($sql);
		header("location:".SITE_BASEURL."messages.php?user_id=".$_GET['user_id']);
}elseif($_GET['func']=='read')
{
		$sql = "UPDATE messages SET `status` = '1' WHERE id =  ".$_GET['message_id'];
		$s->excu($sql);
		header("location:".SITE_BASEURL."messages.php?user_id=".$_GET['user_id']);
}
elseif($user_id)
{
				//显示回复和记录显示
				require ("header.php");
		echo "<fieldset><legend><h3>".tran("reply")."</h3></legend><form action='' method='post'>
			<textarea rows=3 cols=40 name=messages></textarea>
			<input type=submit name='replymessage' value=' Reply '></input>
</form></fieldset>";
$s->excu("(
SELECT messages.id ,messages.to_id,messages.body, messages.send_time,messages.status, users.name
FROM messages, users
WHERE from_id =".$user_id."
AND users.id =".$user_id."
AND to_id =".$_SESSION['SESS_USERID']."
)
UNION (

SELECT messages.id ,messages.to_id,messages.body, messages.send_time, messages.status,''
FROM messages, users
WHERE to_id =".$user_id."
AND users.id =".$user_id."
AND from_id =".$_SESSION['SESS_USERID']."
)
ORDER BY send_time DESC ");
	echo "<fieldset><legend><h3>".tran("messages").tran("list")."</h3></legend><table><tr><th>Oper</th><th>From</th><th>Body</th><th>Time</th></tr>";
	while($r = mysql_fetch_assoc($s->rs))
	{
		echo "<tr class='".trcolor()."'><td>[<a href='messages.php?func=del&message_id=".$r['id']."&user_id=".$user_id."'>X</a>]
		<a href='messages.php?func=read&message_id=".$r['id']."&user_id=".$user_id."'>".(($r['status']==0 and $r['to_id']== $_SESSION['SESS_USERID'])?"[C]":"")."</a></td>
		<td><strong>".($r['name']?$r['name']:$_SESSION['SESS_USERNAME'])."</strong>:</td>
		<td> ".$r['body']."</td><td>".$r['send_time']."</td></tr>";
	}
	echo "</table></fieldset>";
}
elseif($to_id)
{
						//显示新建
						require ("header.php");
						//echo "select name from users where id = ".$to_id;
						$s->excu("select name from users where id = ".$to_id);
						echo $s->error_msg;
						$r = mysql_fetch_assoc($s->rs);
						echo "<form action='' method='post'>
						<input type='text' name='to_name' value=";
						echo $r['name'];
						echo "></input><br><textarea rows=3 cols=40 name=messages></textarea>
						<input type=submit name='newmessage' value=' Send '></input>
</form>";
}
else{//显示所有状态为0的消息
	require ("header.php");
	$sql ="select messages.body,messages.id,messages.send_time,messages.status,messages.from_id,users.name from messages,users where messages.status = 0 and messages.from_id = users.id and messages.to_id = ".$_SESSION['SESS_USERID'] ;
	$s->excu($sql);
	echo "<fieldset><legend><h3>".tran("wait").tran("messages").tran("list")."</h3></legend><table><tr><th>Oper</th><th>From</th><th>Body</th><th>Time</th></tr>";
	while($r = mysql_fetch_assoc($s->rs))
	{
		echo "<tr class='".trcolor()."'><td>
		<a href='messages.php?func=read&message_id=".$r['id']."&user_id=".$user_id."'>".(($r['status']==0)?"[C]":"")."</a></td>
		<td><strong>".a($r['name'],$r['name'],"messages.php?user_id=".$r['from_id'])."</strong></td>
		<td> ".$r['body']."</td><td>".$r['send_time']."</td></tr>";
	}
	echo "</table></fieldset>";
}
	require ("footer.php");
?>