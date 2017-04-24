<?php
/*------------------------------------
SimsmaBBS商业版
一起PHP技术联盟发布并技术支持
官方站点：http://www.17php.com
系统总函数库 The total Functions Libary
Createed By rznqp@163.com (c)2007
本程序由 一起PHP站长 聂庆鹏 编写 QQ4304410
------------------------------------*/
error_reporting(E_ALL ^ E_NOTICE);
@ Session_start();
//设置时区为上海时区（PHP竟然没有北京时区，疑惑中）
date_default_timezone_set("Asia/Shanghai");
/**
 * 引入全局变量
 */
@require_once("inc/const.php");
/**
 * 数据库链接类。
 * 构造器有一个参数，设置是否自动开始链接，默认为TRUE
 */
class mysql{
  //The Default Database Settings
  var $db= DATA_DB;
  var $host= DATA_HOST;
  var $user= DATA_USER;
  var $pass= DATA_PASS;
  var $port= DATA_PORT;
  var $charset='gb2312';
  var $id=false;
  var $rs;
  var $error=false;
  var $error_msg='';
  function __construct($autoconnect = true){
    if($autoconnect){
   	 $this->link();
    }
   }
   public function link(){
        if(!is_object($this->id)){
   	   $this->id = @mysql_connect($this->host.':'.$this->port,$this->user,$this->pass);
        }
   	if(!$this->id){
        $this->error = true;
   		$this->error_msg = '无法连接到数据库.可能是服务器正在维护或服务没有启动.请检查.<br>技术参考信息:<br>'.mysql_errno();   	   	
                echo $this->error_msg;
 		exit;
   	}else{
   		if(!mysql_select_db($this->db,$this->id)){
   			$this->error = true;
   			$this->error_msg = '无法选择数据库，请检查数据库名称是否正确。<br>技术参考信息：<br>'.mysql_error();
   		}
   		//$this->excu('SET CHARACTER SET '.$this->charset);
   	}
   }
   public function excu($sql){
   	if(!$this->id){
   		$this->error = true;
   		$this->error_msg = '发生错误。技术参考信息：请先连接到MYSQL,然后再执行SQL语句.'; 
   		return false;  	
   	}else{
   		mysql_query("set names 'gbk'");
   		$result =@ mysql_query($sql,$this->id);
   		if(mysql_errno()>0){
   			$this->error = true;
   			$this->error_msg = '执行SQL语句失败.SQL语句为:<br>'.$sql.'<br>技术参考信息:<br>'.mysql_error();
   			return false;
   		}
                $this->rs = $result;
   		return $result;
   	}
   }
   public function close(){
   mysql_close($this->id);
   }
}
/**
 * 对数据记录进行分页的类
 *
 */

 function alert($message,$url = '#'){
	echo "<script language=javascript>";
	echo "alert('".TIPS.".'\n'.$message.'\n'.'\");";
	if($url!='#'){
		if($url!='-1'){
		echo "location.href='".$url."';";
		}else{
		echo "history.go(-1);";
		}
	}
	echo "</script>";
 }
 //跳转到错误页面的函数
 function popErrors($error_id){
   header("Location:error.php?id=".$error_id);
   exit;
 }
/* return some spaces in HTML fromt.
 @para $num: how many spaces you need
 @access:public
 @return:string
 */ 
function space($num){
	$spaces = '';
	for($i=1;$i<=$num;$i++){
		$spaces .= '&nbsp;';
	}
	return $spaces;
}
function cnSpace($num){
 $spaces='';
 for($i=0;$i<=$num;$i++){
 $spaces .= "　";
 }
 return $spaces;
}
/* return a format string with <font> tag
 @para $str:the string you want to format.
 @para $color:the color you want the characters to be.
 @para $pixs:the size of the character.
 @access :public
 @return :string
 */
function font($str,$color,$pixs = 12){
	return "<font style='font-size:".$pixs."px;color:".$color."'>".$str."</font>";
}
/**
 * return a format string with <a> tag
 * @param string $str
 * @param string $url
 * @param string $target
 * @return string
 */
function a($str,$title,$url,$target = '_self'){
   return "<a href='".$url."' target='".$target."' title='".$title."'>".$str."</a>";
}
 //检查登陆状态的函数
 function check_login_status($session_name = "SESS_USERNAME")
 {
  if($_SESSION[$session_name]==""){
    popErrors("011");
    exit;
  }
}
/*
以下为gongqingkui@126.com
//通过get得到的年月日存入session中。
*/
function setSESSday()
{
if($_GET['year'])
{
	if($_SESSION['SESS_YEAR'])
	{
		$_SESSION['SESS_YEAR'] = intval($_GET['year']);
	}
	else 
	{
		session_register("SESS_YEAR");
		$_SESSION['SESS_YEAR'] = intval($_GET['year']);
	}
}
else 
{
	if($_SESSION['SESS_YEAR'])
	{
		/*$_SESSION['SESS_YEAR'] = date("Y",time());*/
	}
	else 
	{
		session_register("SESS_YEAR");
		$_SESSION['SESS_YEAR'] = date("Y",time());
	}
}
if($_GET['month'])
{
	if($_SESSION['SESS_MONTH'])
	{
		$_SESSION['SESS_MONTH'] = sprintf("%02d",intval($_GET['month']));
	}
	else 
	{
		session_register("SESS_MONTH");
		$_SESSION['SESS_MONTH'] = sprintf("%02d",intval($_GET['month']));
	}
}
else
{
	if($_SESSION['SESS_MONTH'])
	{
		/*$_SESSION['SESS_MONTH'] = date("m",time());*/
	}
	else 
	{
		session_register("SESS_MONTH");
		$_SESSION['SESS_MONTH'] = date("m",time());
	}
}
if($_GET['day'])
{
	if($_SESSION['SESS_DAY'])
	{
		$_SESSION['SESS_DAY'] = sprintf("%02d",intval($_GET['day']));
	}
	else 
	{
		session_register("SESS_DAY");
		$_SESSION['SESS_DAY'] = sprintf("%02d",intval($_GET['day']));
	}
}
else
{
	if($_SESSION['SESS_DAY'])
	{
		/*$_SESSION['SESS_DAY'] = date("d",time());*/
	}
	else 
	{
		session_register("SESS_DAY");
		$_SESSION['SESS_DAY'] = date("d",time());
	}
}
}
/*
 * 将传入的英语翻译成各种语言，具体语言是由 后缀决定
 */
function tran($word)
{
	//echo $word;
	global $dic;
	if(LOCATION=="en")	
	{
		return $dic[$word][0];
	}
	elseif(LOCATION=="cn")
	{
		return $dic[$word][1];
	}elseif(LOCATION=="tw")
	{
		return $dic[$word][2];
	}
	else
	{
		//没有登录的情况下用汉语
		return $dic[$word][1];
	}
}
/**
 * get che Unix time of China(GMT+8)
 * no parameters
 * @return int
 */
function cntime(){
 return time();
}
/*
trcolor
*/
function trcolor()
{
	static $a=1;
	return ($a=$a*-1)==1?"color1":"color2";
}
function cnSubStr($string,$sublen){
  if($sublen>=strlen($string)){
    return $string;
  }
$s="";
for($i=0;$i<$sublen;$i++){
  if(ord($string{$i})>127){
    $s.=$string{$i}.$string{++$i};
    continue;
  }else{
    $s.=$string{$i};
    continue;
  }
}
return $s."..";
}
/*
 * setCookie($var,$value)
 */
function set_cookie($var,$value)
{
	setcookie ($var,$value,time()+3600*24*7);///一周时间  
}
/*
 * getCookie($var)
 */
function get_cookie($var)
{
	return $_COOKIE[$var];
}
//获得微妙
function weimiao(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
function with_get($script)
{
	$page = $script;
	$page = $page."?";
	foreach($_GET as $key => $val)
	{
		$page = $page.$key."=".$val."&";
	}
	return substr($page,0,strlen($page)-1);

}
//UBB代码的正则表达式函数
function  ubb($text){  
  $text=eregi_replace("\[hr\]","<hr>",$text);     
  $text=eregi_replace("\[i\]","<i>",$text);   
  $text=eregi_replace("\[/i\]","</i>",$text);   
  $text=eregi_replace("\[b\]","<b>",$text);   
  $text=eregi_replace("\[/b\]","</b>",$text);   
  $text=eregi_replace("\[u\]","<u>",$text);   
  $text=eregi_replace("\[/u\]","</u>",$text); 
  //5.1以上版本已经取消了h1-h5和email标记的支持。  
  $text=eregi_replace("\[code\]","<blockquote><div class=code><b>Code:</b>",$text); 
  $text=eregi_replace("\[/code\]","</div></blockquote>",$text);    
  $text=eregi_replace("\[color=#([a-fA-F0-9]{6})\]","<font   color=#\\1>",$text);   
  $text=eregi_replace("\[/color\]","</font>",$text); 
  $text=eregi_replace("\[emot=([a-zA-Z\_]+)\]","<img  src=editer/emoticons/\\1.png>",$text);   
  $text=eregi_replace("\[emot=([0-9]+)\]","<img  src=editer/emoticons/\\1.gif>",$text);     
  $text=eregi_replace("\[size=([0-9])\]","<font   size='\\1'>",$text);   
  $text=eregi_replace("\[/size\]","</font>",$text);   
  $text=eregi_replace("\[font=(.+)\](.+)\[/font\]","<font   face='\\1'>\\2</font>",$text);     
  $text=eregi_replace("\[email\](.+)\[/email\]","<a   href='mailto:\\1'>\\1</a>",$text);
  $text=eregi_replace("\[url=([-a-zA-Z0-9\:\/\.\?\=\&\_\-\%#]+)\]","<a   href='\\1'  target='_blank'>",$text);   
  $text=eregi_replace("\[/url\]","</a>",$text);   
  $text=eregi_replace("\[img]([-a-zA-Z0-9\:\/\.\&\_\%]+)\[/img\]","<a   href='\\1'  target='_blank'><img src='\\1' border=0 title='点击查看图片' onLoad='if(this.width>700){this.width=700;}'></a>",$text);   
  return  $text;   
} 
/**
 * 对将要输出的网页的大段数据进行处理
 * 如UBB解码、处理空格等两项重要操作
 * @param unknown_type $str
 */
function printout($str,$ubb){
	$str = str_replace(' ','&nbsp;',$str);
	if($ubb=='1'){
	$str = ubb($str);
	}
	return $str;	
}
?>