<?php
require_once 'inc\functions.php';

	if($_POST['submit'])
	{
		$s = new mysql();
		$s->excu("select id,name,level,location,skin from users where name = '".$_POST['username']."' and password = '".md5($_POST['password'])."'");
		$numrows = mysql_num_rows($s->rs);
		if($numrows==1)
		{
			session_register("SESS_USERID");
			session_register("SESS_USERNAME");
			session_register("SESS_USERLEVEL");
			//session_register("SESS_USERLOCATION");
			//session_register("SESS_USERSKIN");
			
			$r = mysql_fetch_assoc($s->rs);
			$_SESSION['SESS_USERID']=$r['id'];
			$_SESSION['SESS_USERNAME']=$r['name'];
			$_SESSION['SESS_USERLEVEL']=$r['level'];
			//$_SESSION['SESS_USERLOCATION']=$r['location'];
			//$_SESSION['SESS_USERSKIN']=$r['skin'];
			if($_POST['remeberme']){
				set_cookie("username",$r['name']);
				set_cookie("userlocation",$r['location']);
				set_cookie("userskin",$r['skin']);
		}
			header("location:".SITE_BASEURL."index.php");
		}
		else
		{
			header("location:".SITE_BASEURL."login.php?error=1");
		}
		
	}
	else
	{
		$HEAD_TITLE = tran("login");
		require ("header.php");
		if($_GET['error'])
		{
			echo tran("error");
		}
echo "<form action='' method='post'><table><tr><td>".tran("username")."</td><td><input type='text' name='username' value='".(get_cookie('username')?get_cookie('username'):"")."'></input></td></tr>
			<tr><td>".tran("password")."</td><td><input type='text' name='password' value=''></input></td></tr>
			<tr><td>Remeber me</td><td><input type='checkbox' name='remeberme' value='remeberme' onclick=showItem(this)></input><span id='remberme'>".tran("securityLong")."</span></td></tr>
			<tr><td><input type=submit name=submit value=".tran("login")."></input></input></td><td>".a(tran("register"),tran("register"),"register.php")."</td></tr>
		</table>
	</form>";
	}

require ("footer.php");
?>