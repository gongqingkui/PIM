<?php
	require_once "inc/functions.php";
	$s = new mysql();
	
	$HEAD_TITLE=tran("register");
	if($_POST['newuser'])
	{
		if($_POST["name"]=="" || $_POST["email"]=="" || $_POST["password"]=="" || $_POST["password2"]=="" ||($_POST["password"]!=$_POST["password2"]))
		{
			header("location:".SITE_BASEURL."error.php?id=035");
		}
		else
		{
			//return true;
			$sql ="select id from users where name='".$_POST["name"]."'";
			$s->excu($sql);
			$r =@ mysql_fetch_assoc($s->rs);
			if(!$r)
			{
				for($i=1;$i<=32;$i++){$str.=rand(0,9);}
				//echo $str;
				$sql ="INSERT INTO users VALUES (NULL , '".$_POST["name"]."', MD5('".$_POST["password"]."') , '".$_POST["email"]."', '1', '".$str."', 'cn', 'default');";
				$s->excu($sql);
				header("location:".SITE_BASEURL."login.php");
		}
			else
			{
				header("location:".SITE_BASEURL."error.php?id=036");
			}
		}
	}
	
	require ("header.php");
		echo "<fieldset><legend><h3>".tran("register").tran("information")."</h3></legend>
			<form action='' method='post'><table>
			<tr><td>".tran("username").":</td><td><input type='text' name='name' id='name' ></input></td><td></td></tr>
			<tr><td>".tran("email").":</td><td><input type='text' name='email' id='email'></input></td><td></td></tr>
			<tr><td>".tran("password").":</td><td><input type='text' name='password' id='password'></input></td><td></td></tr>
			<tr><td>".tran("password").":</td><td><input type='text' name='password2'id='password2'></input></td><td></td></tr>
			<tr><td></td><td><textarea rows=15 cols=80 readonly>";
			include("inc\lisence.txt");
			echo "</textarea></td></tr><tr><td><input type='submit' name='newuser' value=' ".tran("new")." 'onclick='check('Error')'></input></td><td></td><td></td></tr>
			</table></form></fieldset>";
	require ("footer.php");
?>