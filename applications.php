<?php
require_once "inc/functions.php";
check_login_status();
$HEAD_TITLE = tran("applications");
	
	
	require ("header.php");
	$extname = substr($_GET['app'],strpos($_GET['app'],".")+1);
	if($extname =="html"){
	$file = fopen($path.$_GET['app'],"r");
	while (!feof($file)) {$buffer = fgets($file, 4096);echo $buffer;}
	}elseif($extname=='php')
	{
		include($path.$_GET['app']);			
	}
		
	
require ("footer.php");
?>