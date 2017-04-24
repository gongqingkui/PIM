<?php
	require_once "inc/functions.php";
	check_login_status();
	
	$HEAD_TITLE=tran(report);
	require ("header.php");
if($_GET['type'])
{	
	switch ($_GET['type'])
	{
		case "contanct":
			$consql = "select * from messages where from_id = ".$_SESSION['SESS_USERID']." or to_id =".$_SESSION['SESS_USERID'];
			$s->excu($consql);
			$str ="<fieldset><legend><h3>".tran("messages")."</h3></legend><table><tr><th>From</th><th>To</th><th>Subject</th><th>Time</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str .="<tr class=".trcolor()."><td>".($r['from_id']==$_SESSION["SESS_USERID"]?"Me":$r['from_id'])."</td><td>".($r['to_id']==$_SESSION["SESS_USERID"]?"Me":$r['to_id'])."</td><td>".$r['body']."</td><td>".$r['send_time']."</td></tr>";
			}
			$str = $str."</table></fieldset>";
			$str.="<fieldset><legend><h3>".tran("contanct")."</h3></legend>";
			
			
			$consql = "select contanct_logs.contanct_id,contancts.name,count(contanct_id) num 
				from contanct_logs,contancts 
				where contancts.id = contanct_logs.contanct_id and contanct_logs.user_id=".$_SESSION['SESS_USERID']."
				group by contanct_id order by count(contanct_id) desc;";
			$s->excu($consql);
			$str.="<fieldset><legend><h4>Top 10</h4></legend><table><tr><th>Name</th><th>Nums</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str.="<tr class=".trcolor()."><td><strong><a href='contanct.php?contanct_id=".$r['contanct_id']."' target='_blank'>".$r['name']."</a></strong></td><td>".$r['num']."</td></tr>";				
			}
			$str.= "</table></fieldset>";
			
			$consql = "select * from contancts where user_id = ".$_SESSION['SESS_USERID'];
			$s->excu($consql);
			$str.="<fieldset><legend><h4>All</h4></legend><table><tr><th>Name</th><th>Mobile</th><th>Email</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str.="<tr class=".trcolor()."><td><strong><a href='contanct.php?contanct_id=".$r['id']."' target='_blank'>".$r['name']."</strong></a></td><td>".$r['mobile']."</td><td>".$r['email']."</td></tr>";				
			}
			$str.= "</table></fieldset>";
			
			$str.="</ol></table></fieldset><fieldset><legend><h3>".tran("email")."</h3></legend>All</fieldset>";
			echo $str;
		 	?>
		 	<script>
		 	//newWindow("<?php echo $str;?>");
		 	</script>
		 	
		 	<?php 
		break;
		case "work":
			$calsql = "select * from calendars where user_id = ".$_SESSION["SESS_USERID"];
			$s->excu($calsql);
			$str .= "<fieldset><legend><h3>".tran("calendar")."</h3></legend><table><tr><th>Subject</th><th>Location</th><th>Type</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str.="<tr class=".trcolor()."><td>".$r['subject']."</td><td>".$r['location']."</td><td>".$r['type']."</td></tr>";				
			}
			$str.="</table></fieldset>";
			
			$tassql = "select * from tasks where user_id = ".$_SESSION["SESS_USERID"];
			$s->excu($tassql);
			$str .= "<fieldset><legend><h3>".tran("task")."</h3></legend><table><tr><th>Subject</th><th>Location</th><th>Status</th><th>Priority</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str.="<tr class=".trcolor()."><td>".$r['subject']."</td><td>".$r['location']."</td><td>".$r['status']."</td><td>".$r['priority']."</td></tr>";				
			}
			$str.="</table></fieldset>";
			
			$tassql = "select * from notes where user_id = ".$_SESSION["SESS_USERID"];
			$s->excu($tassql);
			$str .= "<fieldset><legend><h3>".tran("notes")."</h3></legend><table><tr><th>Type</th><th>Category</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str.="<tr class=".trcolor()."><td>".cnsubstr($r['body'],50)."</td><td>".$r['cat_id']."</td></tr>";				
			}
			$str.="</table></fieldset>";
			echo $str;
		break;
		case "expense":
			$expsql = "select * from expenses where user_id = ".$_SESSION['SESS_USERID']." order by expense_date ";
			$s->excu($expsql);
			$str .= "<fieldset><legend><h3>".tran("expense")."</h3></legend><table><tr><th>Date</th><th>Price</th><th>Subject</th></tr>";
			while($r = mysql_fetch_assoc($s->rs))
			{
				$str.="<tr class=".trcolor()."><td>".$r['expense_date']."</td><td>".$r['price']."</td><td>".$r['subject']."</td></tr>";				
			}
			$str.="</table></fieldset>";
			echo $str;
		break;
		case "system":
			echo "<ul><li>User Name:".$_SESSION['SESS_USERNAME']."</li>
			<li>User Level:".($_SESSION['SESS_USERLEVEL']==1?"Registered user":($_SESSION['SESS_USERLEVEL']==2?"Administer":"Other user"))."</li>
			<li>Now:".date("Y-m-d H:i:s",time())."</li>
			<li>System time:".date("Y-m-d",strtotime($_SESSION['SESS_YEAR'].$_SESSION['SESS_MONTH'].$_SESSION['SESS_DAY']))."</li>
			</ul>";
		break;
		default:break;
	}
}
	require ("footer.php");
?>

	<script>
	function newWindow(str)
	{
		var newdoc = window.open("","_blank","fullscreen=true,status=yes,toolbar=no,menubar=yes,location=no");
		newdoc.alert(str);
		newdoc.document.write(str);
	}
</script>