<?php
require_once "inc/functions.php";
check_login_status();
$HEAD_TITLE = tran("options");


if($_POST['applicationssubmit'] && $_SESSION['SESS_USERLEVEL']==2)
	{
		$extname = substr($_FILES['userfile']['name'],strpos($_FILES['userfile']['name'],".")+1);
		$uploadfile = "applications/".$_FILES['userfile']['name'];
		if($extname=="php" ||$extname=="html"||$extname=="htm")
		{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
   				// echo "File is valid, and was successfully uploaded.\n";
			} else {
    		//echo "Possible file upload attack!\n";
			}
		}
		
	}
if($_GET['func']=="del" && $_SESSION['SESS_USERLEVEL']==2)
	{
		@unlink("applications/".$_GET['app']);
		header("location:".SITE_BASEURL."options.php");
	}
if($_POST['normalsubmit']){
	//echo $_POST['location'].$_POST['skin'];
	//print_r($_FILES['header']);
	$extname = substr($_FILES['header']['name'],strpos($_FILES['header']['name'],".")+1);
	$uploadfile = "headers/".$_SESSION['SESS_USERID'].".".$extname;
	if(($extname=="jpg" ||$extname=="JPG") && $_FILES['header']['size']<102400)
	{
		if (move_uploaded_file($_FILES['header']['tmp_name'], $uploadfile)) {
   			require("header.php");
			echo "File is valid, and was successfully uploaded.\n";
		} else {
   			require("header.php");
    		echo "Possible file upload attack!\n";
		}
	}
	$consql = "update users set location = '".$_POST['location']."',skin = '".$_POST['skin']."',email='".$_POST['email']."' where id = ".$_SESSION['SESS_USERID'];
}
require ("header.php");
$s->excu($consql);


$s->excu("select * from users where id =".$_SESSION['SESS_USERID']);
$r = mysql_fetch_assoc($s->rs);
$userlocation = $r['location'];
$userskin = $r['skin'];
?>
<form action="" method="post" enctype="multipart/form-data">
<fieldset><legend><h3><?php echo tran("normal");?></h3></legend>
	<table>
		<tr><td><?php echo tran("location");?></td><td><select name='location'>
			<option value="cn" <?php echo ($userlocation=="cn"?"selected":""); ?> >China(CN)</option>
			<option value="tw" <?php echo ($userlocation=="tw"?"selected":""); ?> >China(TW)</option>
			<option value="en" <?php echo ($userlocation=="en"?"selected":""); ?> >USA</option>
			<option value="jp" <?php echo ($userlocation=="jp"?"selected":""); ?> >Japan</option>
		</select></td><td>Language from this option.</td></tr>
		<tr><td><?php echo tran("skin");?></td><td><select name='skin'>
			<option value="default" <?php echo ($userskin=="dafault"?"selected":""); ?> >Default</option>
			<option value="img" <?php echo ($userskin=="img"?"selected":""); ?> >With Img</option>
			<option value="simple" <?php echo ($userskin=="simple"?"selected":""); ?> >Simple</option>
			<option value=" "> </option>
		</select></td><td></td></tr>
		<tr><td></td><td><img src="headers/<?php echo (file_exists("headers/".$_SESSION['SESS_USERID'].".jpg")?($_SESSION['SESS_USERID'].".jpg"):"0.jpg");?>" height=160></img></td><td></td></tr>
		<tr><td><?php echo tran("header");?></td><td><input type="file" name="header"></input></td><td>Only Jpg</td></tr>
		<tr><td><?php echo tran("update").tran("email");?></td><td><input type="text" name="email" value="<?php echo ($r['email']?$r['email']:"")?>"></input></td><td></td></tr>
		<tr><td><input type="submit" value=" <?php echo tran("update");?> " name="normalsubmit"></input></td><td></td><td></td></tr>
	</table>
</fieldset>
</form>
<? if($_SESSION['SESS_USERLEVEL']>=2){?>
<fieldset><legend><h3><?php echo tran("applications");?></h3></legend>
	<table>
		<tr><td><?php echo tran("new").tran("applications");?></td><td><form action="" method="post" enctype="multipart/form-data">
<input type="file" name="userfile"></input>
<input type="submit" name="applicationssubmit" value="Submit!"></input>
</form></td><td>Only administer</td></tr><tr><td colspan=3><h3><?php echo tran("applications").tran("list")?></h3></td></tr><table><tr><th>Oper</th><th>Subject</th></tr>
	
	<?php 
		$path = getcwd()."\applications\\";
		$files = scandir($path);
		for($i=2;$i<count($files);$i++){echo "<tr class=".trcolor()."><td><li><a href='?func=del&app=$files[$i]'>".($_SESSION["SESS_USERLEVEL"]==2?"[X]":"")."</a></td><td><a href='applications.php?app=$files[$i]'>".substr($files[$i],0,strpos($files[$i],"."))."</a></td><td> </td></tr>";}
	?>
	</table>
</table>
</fieldset>
<?
}
?>

<fieldset><legend><h3><?php echo tran("advanced");?></h3></legend>
<table><tr><td>Set system time</td><td><?php 
	$weekOfFirstday = date("N",strtotime($_SESSION['SESS_YEAR'].$_SESSION['SESS_MONTH']."01"));
	$daysOfMonth = date("t",strtotime($_SESSION['SESS_YEAR'].$_SESSION['SESS_MONTH'].$_SESSION['SESS_DAY']));
	$cols = 7;
	$rows = ceil(($weekOfFirstday+$daysOfMonth)/$cols);
	$day = 1;
	$dayleave = 7;
	echo "<div class='time'>";
	echo "<font size=5><a href='options.php?year=".($_SESSION['SESS_YEAR']-1)."'>- </a>".$_SESSION['SESS_YEAR']."><a href='options.php?year=".($_SESSION['SESS_YEAR']+1)."'>+</a>";
	echo "<a href='options.php?month=".($_SESSION['SESS_MONTH']-1)."'> - </a>".$_SESSION['SESS_MONTH']."<a href='options.php?month=".($_SESSION['SESS_MONTH']+1)."'> + </a>";
	echo $_SESSION['SESS_DAY']."</font>";
	echo "</div>";
	echo "<table><tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th></tr><tr class=".trcolor().">";
	//首行空白
	for($i=1;$i<$weekOfFirstday;$i++)
	{
		echo "<td></td>";
	}
	//首行有字部分
	for(;$i<=7;$i++)
	{		
		//如果是今天
		if(date("Y",time())==$_SESSION['SESS_YEAR'] && date("m",time())==$_SESSION['SESS_MONTH'] && date("d",time())==$day)
		{
			echo "<td><strong><a href='options.php?day=".$day."'>".$day++."</a></strong></td>";
			continue;
		}
		echo "<td><a href='options.php?day=".$day."'>".$day++."</a></td>";
	}
	echo "</tr>";
	for($i=1;$i<=$rows-1;$i++)
	{
		echo "<tr class=".trcolor().">";
		for($j=1;$j<=7;$j++)
		{
			if($day>$daysOfMonth)
			break;
			else
			{
				//如果是今天
				if(date("Y",time())==$_SESSION['SESS_YEAR'] && date("m",time())==$_SESSION['SESS_MONTH'] && date("d",time())==$day)
				{
					echo "<td><strong><a href='options.php?day=".$day."' title=Today>".$day++."</a></strong></td>";
					continue;
				}
				echo "<td><a href='options.php?day=".$day."'>".$day++."</a></td>";
			}
		}	
		echo "</tr>";
	}
	echo "</table>";
	
	?></td><td><?php echo "Today: ".date("Y-m-d");?></td></tr>
		
		</table>
</fieldset>
<?php 
require ("footer.php");
?>