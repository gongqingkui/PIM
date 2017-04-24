<?php $endtime = weimiao();
?>
</fieldset></div>
<div id="sidebar">
<fieldset><legend><h2><?php echo tran("tip");?></h2></legend>
<ul>
	<li><a href="#" class="f13" onclick="setAsHome(this,'<? echo SITE_BASEURL;?>')"><? echo tran('update').tran('as').tran('firstpage');?></a></li>
	<li>Profiles:Loud</li>
	<li>Signal:88</li>
	<li><div id="search"><form action="search.php" method="GET" name="searchform"><input type="text" name="keyword" size=10 maxlength=10></input><input type="submit" name="submit" value="<?php echo tran("search");?>"></input></form></div></li>
	<li><div id="login"><?php echo ($_SESSION['SESS_USERNAME']?$_SESSION['SESS_USERNAME']." ".a(tran("logout"),tran("logout"),"logout.php"):a(tran("login"),tran("login"),"login.php"));?></div></li>
	<li><div id="answer"></div></li>
</ul>
</fieldset>
</div>
	<div id="footer"><?php echo SITE_NAME." version:".SITE_VERSION." ".SITE_COMPANY."<BR>".SITE_CONTACT." <br>All rights reserved  Use: ".sprintf("%.5f",$endtime - $starttime)."sec";@$s->close();?></div>
</body>
</html>