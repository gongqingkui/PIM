<?php
require_once "inc/functions.php";
check_login_status();
$HEAD_TITLE = tran("expense");
 
$systime =  $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-".$_SESSION['SESS_DAY'];
$s = new mysql;
$expense_id = intval($_GET['expense_id']);

if($_POST['newexpense'])
{
	$sql ="INSERT INTO expenses VALUES (NULL , '".$_SESSION['SESS_USERID']."', '".$_POST['subject']."', '".$_POST['price']."','".$_POST['date2']."', '".$_POST['category']."');";
	//$s->excu($sql);
	header("location:".SITE_BASEURL."expense.php");
}elseif($_POST['updateexpense'])
{}elseif($_GET['date'])
{
	$sql = "SELECT * FROM `expenses` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND `expense_date` = '".$_GET['date']."'";
	
}elseif($_GET['func']=='del')
{
		$sql = "delete from expenses where user_id = ".$_SESSION['SESS_USERID']." and id = ".$expense_id;
		header("location:".SITE_BASEURL."expense.php");
}elseif(isset($_GET['out'])&& !$_GET['category_id'])
{
		$datestart = $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-01";
		$dateend = $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-31";
		//$sql = "SELECT * FROM `expenses` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND expense_date>='".$datestart."' and expense_date<='".$dateend."' and expense_cat in(SELECT id FROM `expense_cats` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND `out` =".$_GET['out']." ) order by expense_date asc";
		$sql = "SELECT * FROM `expenses` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND expense_date>='".$datestart."' and expense_date<='".$dateend."' and expense_cat in(SELECT id FROM `expense_cats` WHERE `out` =".$_GET['out']." ) order by expense_date asc";
}
elseif(isset($_GET['out'])&&$_GET['category_id'])
{
		$datestart = $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-01";
		$dateend = $_SESSION['SESS_YEAR']."-".$_SESSION['SESS_MONTH']."-31";
		//$sql = "SELECT * FROM `expenses` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND `expense_cat` = '".$_GET['category_id']."' and expense_date>='".$datestart."' and expense_date<='".$dateend."' order by expense_date asc";
		$sql = "SELECT * FROM `expenses` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND `expense_cat` = '".$_GET['category_id']."' and expense_date>='".$datestart."' and expense_date<='".$dateend."' order by expense_date asc";
	}
else
{
	//echo $systime;
	$sql = "SELECT * FROM `expenses` WHERE `user_id` =".$_SESSION['SESS_USERID']." AND `expense_date` = '".$systime."'";
}

require("header.php");
//将分组数据存入数组
//$s->excu("select * from expense_cats where user_id = ".$_SESSION['SESS_USERID']);
$s->excu("select * from expense_cats");
while($r=mysql_fetch_assoc($s->rs))
{
		$expenseCatsArr[$r['id']]=$r['category'];
}

echo "<fieldset><legend><h3>".tran("new").tran("expense")."</h3></legend><form action=''method='post'><table>
<tr><td>Date</td><td><input type='text' name='date2' value='".($_GET['date']?$_GET['date']:$systime)."'></input></td></tr>
<tr><td>Category</td><td><select name='category'>";
while (list ($key, $val) = each ($expenseCatsArr)) {
   echo "<option value='".$key."'>".$val."</option>";
}
	echo "</select></td><td></td></tr>
	<tr><td>Price</td><td><input type='text' name='price'></input></td></tr>
	<tr><td>Subject</td><td><input type='text' name='subject'></input></td></tr>
	<tr><td valign='bottom'><input type='submit' name='".($expense_id?"updateexpense":"newexpense")."' value=' ".($expense_id?"Update":"New")." '/></td><td></td></tr>
	</table></form></fieldset>";	
//显示记录
	$s->excu($sql);
	echo "<fieldset><legend><h3>".tran("date").":".($_GET['date']?$_GET['date']:$systime).
	"-".tran("category").":".($_GET['category_id']?$expenseCatsArr[$_GET['category_id']]:"All")."</h3></legend>
	<table><tr><th>Oper</th><th>Subject</th><th>Category</th><th>Price</th><th>Date</th></tr>";
	$total=0;
	while($r =@ mysql_fetch_assoc($s->rs))
	{
		echo "<tr class=".trcolor()."><td>[<a href='?func=del&expense_id=".$r['id']."'>X</a>]</td>
			<td>".$r['subject']."</td>
			<td>".$expenseCatsArr[$r['expense_cat']]."</td><td>".sprintf("$%.2f",$r['price'])."</td><td>".$r['expense_date']."</td></tr>";
			$total+=$r['price'];
		}
	echo "<tr><td></td><td></td><td>Total</td><td>$".$total."</td></tr></table></fieldset>";
require ("footer.php");
?>