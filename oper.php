<?php
	$s = new mysql();

	switch ($HEAD_TITLE)
	{
		case tran("firstpage"):
			echo "<ul>";
			$msgsql = "select count(*) num from messages where to_id =".$_SESSION['SESS_USERID']." and status = 0";
			$s->excu($msgsql);
			$arr = @mysql_fetch_assoc($s->rs);
			echo "<li><a href='messages.php'>".($arr['num']>=1?$arr['num']."Messages!":"No New Message")."</a></li>";
			
			$calsql = "select count(*) num from calendars where status = 0 and user_id=".$_SESSION['SESS_USERID'];
			$s->excu($calsql);
			$arr = @mysql_fetch_assoc($s->rs);
			echo "<li><a href='calendar.php'>".($arr['num']>=1?$arr['num']."Calendar!</sup>":"No Calendar")."</a></li>";
			
			$tassql = "select count(*) num from tasks where user_id =".$_SESSION['SESS_USERID']." and status =0";
			$s->excu($tassql);
			$arr = @mysql_fetch_assoc($s->rs);
			echo "<li><a href='tasks.php'>".($arr['num']>=1?$arr['num']."Tasks!":"No Task")."</a></li>";
			
			$consql ="SELECT count(*) num FROM contancts WHERE contancts.user_id =".$_SESSION['SESS_USERID']." AND now( ) > date_add( contancts.last_time, INTERVAL contancts.frequency DAY )";
			$s->excu($consql);
			$arr = @mysql_fetch_assoc($s->rs);
			echo "<li><a href='contanct.php'>".($arr['num']>=1?$arr['num']."Contancts!":"No Contanct")."</a></li>";
			
			
			echo "</ul>";
		break;
		//case "Messages":
		//case "消息";
		//case $MESSAGES[CL]:
		case tran("messages"):
			$s->excu("(SELECT users.name, users.id FROM users WHERE id IN ( SELECT DISTINCT from_id FROM messages WHERE to_id =".$_SESSION['SESS_USERID']."))UNION (SELECT users.name, users.id FROM users WHERE id IN ( SELECT DISTINCT to_id FROM messages WHERE from_id =".$_SESSION['SESS_USERID']."))");
			echo "<fieldset><legend><h3>".tran("contanct")."</h3></legend><ol>";
			while($arr = mysql_fetch_assoc($s->rs))
			{
				echo "<li>".a(cnSubStr($arr['name'],20),$arr['name'],"messages.php?user_id=".$arr['id'])."</li>";
			}
			echo "</ol></fieldset>";
		break;
		
		//case "Contanct":
		//case "联系人":
		//case $CONTANCT[CL]:
		case tran("contanct"):
			//$s->excu("select id,name from contancts where id in(select contanct_id from contanctlogs where user_id =".$_SESSION['SESS_USERID']." group by contanct_id  order by count(*) desc) limit 0,150");
			$s->excu("select id,name from contancts where user_id = ".$_SESSION['SESS_USERID']);
			echo $s->error_msg;
			echo "<fieldset><legend><h3>".tran("contanct")."</h3></legend><ol>";
			while($arr = mysql_fetch_assoc($s->rs))
			{
				echo "<li>".a("[X] ","delete","contanct.php?func=del&contanct_id=".$arr['id']).a(cnSubStr($arr['name'],20),$arr['name'],"contanct.php?contanct_id=".$arr['id'])."</li>";
			}
			echo "</ol></fieldset>";
		break;
		
		//case "Email":
		//case "邮件 ":
		//case $EMAIL[CL]:
		case tran("email"):
			$s->excu("select * from emails where user_id = ".$_SESSION['SESS_USERID']);
			echo $s->error_msg;
			echo "<fieldset><legend><h3>".tran("username")."&nbsp;</h3></legend><ol>";
			while($arr = mysql_fetch_assoc($s->rs))
			{
				echo "<li>".a("[X] ","delete","email.php?func=del&email_id=".$arr['id']).a(cnSubStr($arr['email'],8),$arr['email'],"email.php?email_id=".$arr['id'])."</li>";
			}
			echo "</ol></fieldset>";
		break;
		
		//case "Calendar":
		//case"日历":
		//case $CALENDAR[CL]:
		case tran("calendar"):
		echo "<fieldset><legend><h3>".tran("view")."</h3></legend><ul><li><a href='?view=day'>Day</a></li><li><a href='?view=month'>Month</a></li><li><a href='?view=year'>Year</a></li></ul></fieldset>";
		echo "<fieldset><legend><h3>".tran("location")."</h3></legend>";
		echo "<ul>";
		while (list ($key,$location) = each ($locationsarr))
		{
			echo "<li><a href='calendar.php?location=".$location."'>".$location."</a>";
		}
		echo "</ul></fieldset><fieldset><legend><h3>".tran("type")."</h3></legend><ul>";
		while (list ($key,$type) = each ($typesarr))
		{
			echo "<li><a href='calendar.php?type=".$type."'>".$type."</a>";
		}
		echo "</ul></fieldset>";
		unset($key);
		unset($location);
		unset($type);
		
		break;
		
		//case "Tasks":
		//case "任务":
		//case $TASKS[CL]:
		case tran("task"):
		echo "<fieldset><legend><h3>".tran("location")."</h3></legend>";
		echo "<ul>";
		while (list ($key,$location) = each ($locationsarr))
		{
			echo "<li><a href='tasks.php?location=".$location."'>".$location."</a>";
		}
		echo "</ul></fieldset>";
		echo "<fieldset><legend><h3>".tran("status")."</h3></legend><ul><li><a href='tasks.php?status=0'>Not Done</a></li><li><a href='tasks.php?status=1'>Done</a></li></ul></fieldset>";
		echo "<fieldset><legend><h3>".tran("priority")."</h3></legend><ul><li><a href='tasks.php?priority=3'>High</a></li><li><a href='tasks.php?priority=2'>Medium</a></li><li><a href='tasks.php?priority=1'>Low</a></li></fieldset>";
		break;
		
		//case "Notes":
		//case "便笺":
		//case $NOTES[CL]:
		case tran("notes"):
		if($_POST['newcategory'])
		{
			$sqlinsertcat = "INSERT INTO note_cats VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_POST['categoryname']."');";
			//$s = new mysql;
			$s->excu($sqlinsertcat);
			//$S->excu($sqlinsertcat);
			}
		echo "<fieldset><legend><h3>".tran("category")."</h3></legend>";
		$sqlnotecats = "select * from note_cats where user_id = ".$_SESSION['SESS_USERID'];
		$s->excu($sqlnotecats);
		echo "<ul>";
			while($rnotecats=mysql_fetch_assoc($s->rs))
			{
				echo "<li>".a("[X]",$rnotecats['category'],"notes.php?func=del&note_cat_id=".$rnotecats['id'])." <a href='notes.php?note_cat_id=".$rnotecats['id']."'>".$rnotecats['category']."</a></li>";
				if(intval($_GET['note_cat_id'])==$rnotecats['id'])
				{
					$sqlnotes = "select * from notes where user_id =".$_SESSION['SESS_USERID']." and cat_id = ".$rnotecats['id'];
					$snotes = new mysql;
					$snotes->excu($sqlnotes);
					echo $snotes->error_msg;
					//echo "<ul>";
					while($rnotes= mysql_fetch_assoc($snotes->rs))
					{
						echo "<li>&nbsp;&nbsp;&nbsp;&nbsp;[<a href='notes.php?func=del&note_cat_id=".$rnotecats['id']."&note_id=".$rnotes['id']."'>X</a>]<a href='notes.php?note_cat_id=".$rnotecats['id']."&note_id=".$rnotes['id']."'>".cnSubStr($rnotes['body'],20)."</a></li>";
					}
					}
					//echo "</ul>";
			}
		echo "</ul></fieldset>";
		echo "<fieldset><legend><h3>".tran("new")."</h3></legend><form action='' method='post'>
		<input type='text' name='categoryname' size='10' maxlength=10></input>
		<input type='submit' name='newcategory' value =' ".tran("new")."' ></input>
		</from></fieldset>";
		break;
		
		//case "Expense":
		//case "a理财":
		///case $EXPENSE[CL]:
		case tran("expense"):
		$systime =  $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-".$_SESSION['SESS_DAY'];
		echo "<fieldset><legend><h3>".tran("date")."</h3></legend><ul>";
		for($i=-7;$i<=7;$i++)
		{
			//echo $i;
			$day = date("Y-m-d",(strtotime($systime)+($i*24*3600)));
			echo "<li><a href='expense.php?date=".$day."'>".($i?"":"<strong>").$day.($i?"":"</strong>")."</a></li>";
			}
		echo "</ul></fieldset>";
		echo "<ul>";
		echo "<fieldset><legend><h3>".tran("category")."</h3></legend><ul>
			<li><a href='expense.php?out=1'>Out</a></li>";
			if($_GET['out']==1){
				//$sqlexpensecat = "SELECT * FROM `expense_cats` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND `out` =1";
				$sqlexpensecat = "SELECT * FROM `expense_cats` WHERE `out` =1";
				$s->excu($sqlexpensecat);
				echo "<ul>";
				while($r=mysql_fetch_assoc($s->rs))
				{
					echo "<li><a href='expense.php?out=1&category_id=".$r['id']."'>".$r['category']."</a></li>";
					}
				echo "</ul>";
			}
		echo "<li><a href='expense.php?out=0'>In</a></li>";
		if($_GET['out']==0){
				$sqlexpensecat = "SELECT * FROM `expense_cats` WHERE `out` =0";				
				$s->excu($sqlexpensecat);
				echo "<ul>";
				while($r=mysql_fetch_assoc($s->rs))
				{
					echo "<li><a href='expense.php?out=0&category_id=".$r['id']."'>".$r['category']."</a></li>";
					}
				echo "</ul>";
			}
		echo "</ul></fieldset>";
		break;
		
		//case "Report":
		//case "报表":
		//case $REPORT[CL]:
		case tran("report"):
			echo "<fieldset><legend><h3>".tran("type")."</h3></legend><ul>
			<li><a href='?type=contanct'>".tran("contanct")."</a></li>
			<li><a href='?type=work'>".tran("task")."</a></li>
			<li><a href='?type=expense'>".tran("expense")."</a></li></ul></fieldset>";
		break;
		//case "Applications":
		//case"插件程序":
		//case $APPLICATIONS[CL]:
		case tran("applications"):
			$path = getcwd()."\applications\\";
			$files = scandir($path);
			echo "<ul>";
			for($i=2;$i<count($files);$i++){echo "<li><a href='?app=$files[$i]'>".substr($files[$i],0,strpos($files[$i],"."))."</a></li>";}
			echo "</ul>";
		break;
		//case "Options":
		//case"选项":
		//case $OPTIONS[CL]:
		case tran("options"):
			echo "<ul>";
			echo "<li>this is option page!</li>";
			echo "</ul>";
		break;
		case tran("about"):
			echo "<ul>";
			echo "<li>this is copyright page</li>";
			echo "</ul>";	
		break;
		case tran("error"):
			
		break;
		case tran("register"):
			
		break;
		case tran("search"):
			break;
		default:echo "Error";
		}
	?>