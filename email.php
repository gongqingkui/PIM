<?php
	require_once "inc/functions.php";
	check_login_status();
	$s = new mysql();
	
	$HEAD_TITLE=tran("email");
	if($_GET['func']=='del'&&$_GET['email_id'])
	{
		$sql = "delete from emails where id = ".$_GET['email_id'];
		$s->excu($sql);
		header("location:".SITE_BASEURL."email.php");
	}elseif($_POST['submit'])
	{
		require_once('inc/phpmailer.php');

		$sql = "select * from emails where id = ".$_GET['email_id'];
		$s->excu($sql);
		$r = mysql_fetch_assoc($s->rs);
		if($r){
			$test =new PhpMailer($r['smtp'],$r['email'],$r['password']);
			$send =$test->send($_POST['to'],"TEST",$_POST['title'],$_POST['body']);
			require ("header.php");
			if($send){
				 echo "发送成功。";
			 }else{
			  echo "发送失败。错误信息：".$test->errMsg;
			 }
		}
	}elseif($_POST['newemail'])
	{
		$sql = "INSERT INTO emails VALUES (NULL , '".$_SESSION["SESS_USERID"]."', '".$_POST["email"]."', '".$_POST["smtp"]."', '".$_POST["password"]."')";

		$s->excu($sql);
		
		header("location:".SITE_BASEURL."email.php");
		
	}elseif($_GET['email_id'] || $_GET["to_email"]){
	require ("header.php");

	echo "<fieldset><legend><h3>".tran("email").tran("outbox")."</h3></legend><form action='' method='post'><table>
	<tr ><td>To</td><td><input type='text' name='to' value='".($_GET["to_email"]?$_GET["to_email"]:"XX@XX.com")."'></input></td>
	<tr ><td>Title</td><td><input type='text' name='title'></input></td>
	<tr ><td>Body</td><td><textarea rows=15 cols=50 name=body></textarea></td></tr>
	<tr ><td></td><td><input type='submit' name='submit' value='".tran('send')."'></input></td>";
	echo "</table></form></fieldset>";
	}
	else
	{
		require ("header.php");
		echo "<fieldset><legend><h3>".tran("new").tran("email")."</h3></legend><form action='' method='post'><table>
	<tr><td>".tran("email")."</td><td><input type='text' name='email' value='xxx@xxx.com'></input></td>
	<tr><td>Smtp</td><td><input type='text' name='smtp'></input></td>
	<tr><td>".tran("password")."</td><td><input name=password></input></td></tr>
	<tr><td></td><td><input type='submit' name='newemail' value='".tran('new')."'></input></td>";
	echo "</table></form></fieldset>";			
	}
require ("footer.php");
?>

