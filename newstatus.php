<?php 
	require_once ('inc\functions.php');
	//check_login_status();
	header('Content-type:text/html; charset=gb2312');
	if($_SESSION['SESS_USERID']){
		$newstatus = 0;
		$s = new mysql;
		
		$messql = "select * from messages where status = 0 and to_id =".$_SESSION['SESS_USERID'];
		$s->excu($messql);
		if(($r = mysql_num_rows($s->rs)>=1))$newstatus=1;
	
		$calsql = "select * from calendars where status = 0 and user_id =".$_SESSION['SESS_USERID'];
		$s->excu($calsql);
		if(($r = mysql_num_rows($s->rs)>=1)&&$newstatus==0)$newstatus=1;
		
		
		$tassql = "select * from tasks where status = 0 and user_id =".$_SESSION['SESS_USERID'];
		$s->excu($tassql);
		if(($r = mysql_num_rows($s->rs)>=1)&&$newstatus==0)$newstatus=1;
		
		
		$tassql = "SELECT contancts.id FROM contancts WHERE contancts.user_id =".$_SESSION['SESS_USERID']." AND now( ) > date_add( contancts.last_time, INTERVAL contancts.frequency DAY ) ";		$s->excu($tassql);
		if(($r = mysql_num_rows($s->rs)>=1)&&$newstatus==0)$newstatus=1;
		
		if($newstatus==1)
		{
			echo a(tran("newStatus"),tran("newStatus"),"index.php");
		}
		else
		{
			echo "";
		}
	}
?>