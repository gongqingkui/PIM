<?php
require_once "inc/functions.php";
//check_login_status();
$s = new mysql();
$HEAD_TITLE = tran("about");
require ("header.php");
$sql ="select * from helps where location='".LOCATION."' order by id desc";
$s->excu($sql);
echo "<dl>";
while($r =mysql_fetch_assoc($s->rs) )
{
	echo "<dt><h3>".$r['title']."</h3></dt><dd>".$r['answer']."</dd>";
}
echo "</dl>";
require ("footer.php");
?>