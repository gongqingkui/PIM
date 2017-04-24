<?php 
require_once('inc/functions.php');
$starttime = weimiao();
setSESSday();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"></meta>
<title><?php echo SITE_NAME."-".$HEAD_TITLE;?></title>
<link rel="stylesheet" href="inc/base.css" type="text/css"></link>
<link rel="stylesheet" href="inc/<?php echo (CSS?CSS:"default");?>.css" type="text/css"></link>
<script src="inc/functions.js"> </script>
</head>
<!-- 60秒测试一次新状态 -->
<body onload="getNewStatus();window.setInterval('getNewStatus()',60000)">
	<div id="header"><h1><?php echo SITE_NAME?></h1></div>
	<div id="menu"><?php require("menu.php");?></div>
	
	<div id="oper">
	<fieldset><legend><?php echo "<h2>".$HEAD_TITLE."</h2></legend>";require("oper.php");?></fieldset></div>
	<div id="main"><fieldset><legend><?php echo "<h2>".$HEAD_TITLE."</h2>";?></legend>