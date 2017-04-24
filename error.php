<?php
include "inc/functions.php";
$id=$_GET["id"];
if(LOCATION=="en"){
    $message["001"] = "无法连接到数据库，请确定MYSQL已经安装并启动。";
    $message["002"] = "不能执行SQL语句，可能是数据表不存在或者SQL语句有错误。";
    $message["003"] = "错误，登陆密码错误，您是否按下了CAPS LOCK键，请返回。";
    $message["004"] = "错误，没有这个用户，登陆失败，请返回重填。";
    $message["005"] = "错误，您试图饶过身份验证登陆系统，请通过登陆页面登陆系统再进行管理。";
    $message["006"] = "错误，您的旧密码输入错误。或者您的登陆已经超时，请重新输入密码或重登陆。";
    $message["011"] = "Error,you are not login or too long.please ".a(tran("login"),tran("login"),"login.php")." again.
    or ".a(tran("register"),tran("register"),"register.php");
    $message["012"] = "错误，你的积分不足，无法在主题中包含图片";
    $message["013"] = "<b><font color=red>严重警告：</font></b>你试图通过非法途径破坏论坛。";
    $message["014"] = "<b><font color=red>非法操作：</font></b>您不是超级管理员，无法进行该管理操作。";
    $message["015"] = "错误的ID,或者您要查找的帖子已经不存在。请查找其他您感兴趣的链接。";
    $message["016"] = "请勿手工修改URL参数！非法的参数将产生不可预期的后果！";
    $message["017"] = "错误的ID,或者您要查找的版块不存在。请查找其他您感兴趣的链接。";
    $message["018"] = "错误的ID,或者您要查找的回复不存在。请查找其他您感兴趣的链接。";
    $message["019"] = "您不是本主题的作者，也不是该主题所属板块的管理员，无权进行操作!";
    $message["020"] = "您无权进行此操作!";
    $message["021"] = "友情提示：该内容需要登录之后才能查看。请先登录。如果没有帐号，请先".a(REGISTER,REGISTER,"register.php")."。";
    $message["022"] = "图片文件上传失败!操作失败!请确认相关目录存在并具有写入权限。";
    $message["023"] = "<font color=red>您访问的板块仅会员可见</font>。请先登录再查看。如果您还不是会员，请先注册。";
    $message["024"] = "<font color=red>您访问的板块仅VIP会员可见</font>,如果您是VIP会员，请先登录。";
    $message["025"] = "<font color=red>该板块仅VIP会员可以发表新主题</font>，普通会员无法发表。";
    $message["026"] = "您不是本主题的作者，无权进行操作!";    
    $message["027"] = "附件列表中包含禁止上传的文件格式，请重新选择!";   
    $message["028"] = "附件中有附件大小超过了最大限制，请重新选择!";  
    $message["029"] = "附件上传动态创建目录失败！请确认目录是否有写入权限！";  
    $message["030"] = "主题已经发表成功！<font color=red>但有附件写入失败。</font>请确认目录是否有写入权限！"; 
    $message["031"] = "警告！<font color=red>你可能正试图通过非法途径编辑附件。</font>如有问题请联系管理员！";   
    $message["032"] = "<font color=red>fj_edit.php参数错误。</font>如有问题请联系管理员！";  
    $message["033"] = "<font color=red>参数设置失败。请确认inc/const.php拥有写权限！</font>";
    $message["034"] = "The start time is later than end time!";
    $message["035"] = "The input is incorrenct!";
    $message["036"] = "The username has been registed";
    $message["037"] = "The keyword must been input";
}
else
{
	$message["001"] = "无法连接到数据库，请确定MYSQL已经安装并启动。";
    $message["002"] = "不能执行SQL语句，可能是数据表不存在或者SQL语句有错误。";
    $message["003"] = "错误，登陆密码错误，您是否按下了CAPS LOCK键，请返回。";
    $message["004"] = "错误，没有这个用户，登陆失败，请返回重填。";
    $message["005"] = "错误，您试图饶过身份验证登陆系统，请通过登陆页面".a(LOGIN,LOGIN,"login.php")."系统再进行管理。";
    $message["006"] = "错误，您的旧密码输入错误。或者您的登陆已经超时，请重新输入密码或".a(LOGIN,LOGIN,"login.php")."。";
    $message["011"] = "错误，您没有登陆，或者登陆时间过长，请重新".a(tran("login"),tran("login"),"login.php")
    ."。如果您没有注册，请".a(tran("register"),tran("register"),"register.php")."。";
    $message["012"] = "错误，你的积分不足，无法在主题中包含图片";
    $message["013"] = "<b><font color=red>严重警告：</font></b>你试图通过非法途径破坏论坛。";
    $message["014"] = "<b><font color=red>非法操作：</font></b>您不是超级管理员，无法进行该管理操作。";
    $message["015"] = "错误的ID,或者您要查找的帖子已经不存在。请查找其他您感兴趣的链接。";
    $message["016"] = "请勿手工修改URL参数！非法的参数将产生不可预期的后果！";
    $message["017"] = "错误的ID,或者您要查找的版块不存在。请查找其他您感兴趣的链接。";
    $message["018"] = "错误的ID,或者您要查找的回复不存在。请查找其他您感兴趣的链接。";
    $message["019"] = "您不是本主题的作者，也不是该主题所属板块的管理员，无权进行操作!";
    $message["020"] = "您无权进行此操作!";
    $message["021"] = "友情提示：该内容需要登录之后才能查看。请先登录。如果没有帐号，请先".a(REGISTER,REGISTER,"register.php")."。";
    $message["022"] = "图片文件上传失败!操作失败!请确认相关目录存在并具有写入权限。";
    $message["023"] = "<font color=red>您访问的板块仅会员可见</font>。请先登录再查看。如果您还不是会员，请先".a(REGISTER,REGISTER,"register.php")."。";
    $message["024"] = "<font color=red>您访问的板块仅VIP会员可见</font>,如果您是VIP会员，请先登录。";
    $message["025"] = "<font color=red>该板块仅VIP会员可以发表新主题</font>，普通会员无法发表。";
    $message["026"] = "您不是本主题的作者，无权进行操作!";    
    $message["027"] = "附件列表中包含禁止上传的文件格式，请重新选择!";   
    $message["028"] = "附件中有附件大小超过了最大限制，请重新选择!";  
    $message["029"] = "附件上传动态创建目录失败！请确认目录是否有写入权限！";  
    $message["030"] = "主题已经发表成功！<font color=red>但有附件写入失败。</font>请确认目录是否有写入权限！"; 
    $message["031"] = "警告！<font color=red>你可能正试图通过非法途径编辑附件。</font>如有问题请联系管理员！";   
    $message["032"] = "<font color=red>fj_edit.php参数错误。</font>如有问题请联系管理员！";  
    $message["033"] = "<font color=red>参数设置失败。请确认inc/const.php拥有写权限！</font>";
    $message["034"] = "开始时间晚于结束时间";
    $message["035"] = "输入不合法";
    $message["036"] = "用户名已被注册";
    $message["037"] = "输入关键词";
}  
if($message[$id]!=""){
  $msg = $message[$id];
}else{
  if(LOCATION=="cn")
  {
	$msg = "该种错误类型尚未统计。";
  }
	else
	{
	$msg = "The type of this error have not been set!";
	}
}
$HEAD_TITLE = tran("error");
include "header.php";
echo "<strong>".$msg."</strong>";
?>
<h3><a href="#" onclick="history.go(-1)" ><?php echo tran("prevpage");?></a></h3>
<?php
include "footer.php";
?>