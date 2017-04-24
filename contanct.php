<?php
	require_once "inc/functions.php";
	check_login_status();
	$s = new mysql();
	
	$HEAD_TITLE=tran("contanct");
		
	$contanct_id = intval($_GET['contanct_id']);
	$contanctlog_id = intval($_GET['contanctlog_id']);
	
	if($_POST['newcontanct'])
	{
		$sql ="INSERT INTO contancts VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_POST['name']."', '".$_POST['email']."', '".$_POST['company']."', '".$_POST['home']."', '".$_POST['mobile']."', '".$_POST['pager']."','".$_POST['frequency']."',now(), '".($_POST['pim_id']?$_POST['pim_id']:0)."', '');";
		$s->excu($sql);
		header("location:".SITE_BASEURL."contanct.php");
		}
	elseif($_POST['newcontanctlog'])
	{
		$sql = "INSERT INTO contanct_logs VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$contanct_id."', '".$_POST['contanctlog']."', NOW( ));";
		$s->excu($sql);
		$updateLast_timeSql ="update contancts set last_time=now() where id =".$contanct_id;
		$s->excu($updateLast_timeSql);
		header("location:".SITE_BASEURL."contanct.php?contanct_id=".$contanct_id);
		}
	elseif($_POST['updatecontanct'])
	{
		$sql ="UPDATE contancts SET `name` = '".$_POST['name']."',`email` = '".$_POST['email']."',`company` = '".$_POST['company']."',`home` = '".$_POST['home']."',`mobile` = '".$_POST['mobile']."',`pager` = '".$_POST['pager']."',`frequency` ='".$_POST['frequency']."' WHERE `contancts`.`id` =".$contanct_id;
		$s->excu($sql);
		header("location:".SITE_BASEURL."contanct.php?contanct_id=".$contanct_id);
	}elseif($_GET['func']=='del' && $_GET['contanctlog_id'])
	{
		$sql = "delete from contanct_logs where id = ".$contanctlog_id;
		$s->excu($sql);
		header("location:".SITE_BASEURL."contanct.php?contanct_id=".$contanct_id);
	}elseif($_GET['func']=='del'&& $_GET['contanct_id']&&!($_GET['conf']))
	{
		require ("header.php");
		echo "<strong>Are you sure to delete the contanct?</strong><h4><a href='".with_get($_SERVER['PHP_SELF'])."&conf=1'>YES</a><a href='contanct.php?contanct_id=".$_GET['contanct_id']."'>No</a></h4>";
	}elseif($_GET['func']=="add" && $_GET['user_id'])
	{
		$sql = "select id,name,email from users where id=".$_GET['user_id'];
		$s->excu($sql);
		$r = mysql_fetch_assoc($s->rs);
		$sql = "INSERT INTO contancts VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$r['name']."', '".$r['email']."', '', '', '', '', '30', NOW( ) , '".$r['id']."', '')";
		$s->excu($sql);
		//$r = mysql_fetch_assoc($s->rs);
		header("location:".SITE_BASEURL."contanct.php");
	}elseif($_GET['func']=='del' && $_GET['contanct_id'] && $_GET['conf']==1)
	{
		$sql = "delete from contancts where id = ".$contanct_id;
		$s->excu($sql);
		//$sql = "delete from contanct_logs where contanct_id = ".$contanct_id;
		//$s->excu($sql);
		header("location:".SITE_BASEURL."contanct.php?contanct_id=".$contanct_id);
	}elseif($contanct_id)
	{
		//view user info(update button) and logs (insert button) X
		require ("header.php");
		$s->excu("select * from contancts where user_id = ".$_SESSION['SESS_USERID']." and id = ".$contanct_id);
			echo $s->error_msg;
			$r = mysql_fetch_assoc($s->rs);
			echo "<fieldset><legend><h3>".tran("contanct").tran("information")."</h3></legend><form action='' method='post'><table>
			<tr><td>Name:</td><td><input type='text' name='name' value = '".$r['name']."'></input></td><td></td></tr>
			<tr><td>Mobile:</td><td><input type='text' name='mobile' value = '".$r['mobile']."'></input></td><td></td></tr>
			<tr><td>Email:</td><td><input type='text' name='email' value = '".$r['email']."'></input></td><td>".a(tran("send").tran("email"),$r['email'],"email.php?to_email=".$r['email'])."</td></tr>
			<tr><td>HomePager:</td><td><input type='text' name='pager' value = '".$r['pager']."'></input></td><td><a href='".$r['pager']."'>".$r['pager']."</a></td></tr>
			<tr><td>Company:</td><td><input type='text' name='company' value = '".$r['company']."'></input></td><td></td></tr>
			<tr><td>Home:</td><td><input type='text' name='home' value = '".$r['home']."'></input></td><td></td></tr>
			<tr><td>Frequency(Days):</td><td><input type='text' name='frequency' value = '".$r['frequency']."'></input></td><td></td></tr>
			<tr><td>PIM id:</td><td><input type='text' name='pim_id' value = '".$r['pim_id']."' disabled></input></td><td><a href='messages.php?to_id=".$r['pim_id']."'>".tran("send").tran("messages")."</a></td></tr>
			<tr><td><input type='submit' name='updatecontanct' value=' ".tran("update")." '></input></td><td></td><td></td></tr>
			</table></form></fieldset>";
			
			$s->excu("select * from contanct_logs where user_id = ".$_SESSION['SESS_USERID']." and contanct_id = ".$contanct_id ." order by contanct_time desc");
			echo "<fieldset><legend><h3>".tran("contanct").tran("log")."</h3></legend><form action='' method='post'><input type='text' name='contanctlog'></input><input type='submit' name='newcontanctlog' value=' ".tran("new")." '></input></form><table><tr><th>Oper</th><th>Subject</th><th>Date</th></tr>";
			while($r =mysql_fetch_assoc($s->rs) )
			{
				echo "<tr class=".trcolor()."><td>[<a href='?func=del&contanctlog_id=".$r['id']."&contanct_id=".$contanct_id."'>X</a>]</td><td>".$r['subject']."</td><td>".$r['contanct_time']."</td></tr>";
			}
			echo "</table></fieldset>";
	}
	else
	{
		//new contanct
		require ("header.php");
		echo "<fieldset><legend><h3>".tran("contanct").tran("information")."</h3></legend><form action='' method='post'><table>
			<tr><td>Name:</td><td><input type='text' name='name' ></input></td><td></td></tr>
			<tr><td>Mobile:</td><td><input type='text' name='mobile' value = '13'></input></td><td></td></tr>
			<tr><td>Email:</td><td><input type='text' name='email' ></input></td><td><a href='mailto:".$r['email']."'>".$r['email']."</a></td></tr>
			<tr><td>HomePager:</td><td><input type='text' name='pager' value = 'http://www.'></input></td><td><a href='".$r['pager']."'>".$r['pager']."</a></td></tr>
			<tr><td>Company:</td><td><input type='text' name='company' value = ' co ltd.,'></input></td><td></td></tr>
			<tr><td>Home:</td><td><input type='text' name='home' ></input></td><td></td></tr>
			<tr><td>Frequency(Days):</td><td><input type='text' name='frequency'value='30' ></input></td><td></td></tr>
			<tr><td>PIM id:</td><td><input type='text' name='pim_id'></input></td><td></td></tr>
			<tr><td><input type='submit' name='newcontanct' value=' ".tran("new")." '></input></td><td></td><td></td></tr>
			</table></form></fieldset>";
		
		$s->excu("SELECT contancts.name, contancts.last_time, contancts.frequency, contancts.id FROM contancts WHERE contancts.user_id =".$_SESSION['SESS_USERID']." AND now( ) > date_add( contancts.last_time, INTERVAL contancts.frequency DAY ) ");
		echo "<fieldset><legend><h3>".tran("wait").tran("contanct")."</h3></legend>
		<table><tr><th>Name</th><th>Last_time</th><th>Frequency(Days)</th></tr>";
		while($r = @mysql_fetch_assoc($s->rs))
		{
			echo "<tr class=".trcolor()."><td>".a($r['name'],$r['name'],"contanct.php?contanct_id=".$r['id'])."</td>
			<td>".$r['last_time']."</td>
			<td>".$r['frequency']."</td>";
			
		}
		echo "</table></fieldset>";
		
	}
	//可以加为联系人的人
	$s->excu("select * from users where id not in(select pim_id from contancts where user_id = '".$_SESSION['SESS_USERID']."') and id !=".$_SESSION['SESS_USERID']) ." and limit 0,20";
			echo "<fieldset><legend><h3>".tran("other").tran("contanct")."</h3></legend><table><tr>";
			for($i=1;$i<=3;$i++){
				echo "<th>Oper</th><th>Name</th><th>Header</th>";
			}
			echo "</tr>";
			$i=1;
			while($r =mysql_fetch_assoc($s->rs) )
			{
				if($i%3==3 || $i==1){echo "<tr class='.trcolor().'>";}
				echo "<td>".a("[+]",tran("add").$r['name'].tran("as").tran("contanct"),"?func=add&user_id=".$r['id'])."</td>
				<td>".$r['name']."</td>
				<td><img src='headers/".(file_exists("headers/".$r['id'].".jpg")?($r[id].".jpg"):"0.jpg")."' class='header' height=160></img></td>";
				if($i%3==0 || $i==3){echo "</tr>";}
				$i++;
			}
			echo "</table></fieldset>";
	
require ("footer.php");
?>