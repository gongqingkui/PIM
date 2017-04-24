<?php
	require("inc/functions.php");
	$weekOfFirstday = date("N",strtotime($_SESSION['SESS_YEAR'].$_SESSION['SESS_MONTH']."01"));
	$daysOfMonth = date("t",strtotime($_SESSION['SESS_YEAR'].$_SESSION['SESS_MONTH'].$_SESSION['SESS_DAY']));
	$cols = 7;
	$rows = ceil(($weekOfFirstday+$daysOfMonth)/$cols);
	$day = 1;
	$dayleave = 7;
	echo "<div class='time'>";
	echo "<a href='index.php?year=".($_SESSION['SESS_YEAR']-1)."'>- </a>".$_SESSION['SESS_YEAR']."<a href='index.php?year=".($_SESSION['SESS_YEAR']+1)."'> + </a>";
	echo "<a href='index.php?month=".($_SESSION['SESS_MONTH']-1)."'> - </a>".$_SESSION['SESS_MONTH']."<a href='index.php?month=".($_SESSION['SESS_MONTH']+1)."'> + </a>";
	echo $_SESSION['SESS_DAY'];
	echo "</div>";
	echo "<table><tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th></tr><tr>";
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
			echo "<td><strong><a href='index.php?day=".$day."'>".$day++."</a></strong></td>";
			continue;
		}
		echo "<td><a href='index.php?day=".$day."'>".$day++."</a></td>";
	}
	echo "</tr>";
	for($i=1;$i<=$rows-1;$i++)
	{
		echo "<tr>";
		for($j=1;$j<=7;$j++)
		{
			if($day>$daysOfMonth)
			break;
			else
			{
				//如果是今天
				if(date("Y",time())==$_SESSION['SESS_YEAR'] && date("m",time())==$_SESSION['SESS_MONTH'] && date("d",time())==$day)
				{
					echo "<td><strong><a href='index.php?day=".$day."' title=Today>".$day++."</a></strong></td>";
					continue;
				}
				echo "<td><a href='index.php?day=".$day."'>".$day++."</a></td>";
			}
		}	
		echo "</tr>";
	}
	echo "</table>";
?>