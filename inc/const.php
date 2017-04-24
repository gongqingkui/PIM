<?php
/* ★★全局常量定义文件★★
 * 本常量值可通过后台操作设置
 * ★请勿手工修改此文件★
 */
//[siteinfo]
session_start();

define("SITE_VERSION","2.0");
define("SITE_BASEURL","http://localhost/PIM/");

define("SITE_NAME","PIM");
define("SITE_COMPANY","Linyi Normal Universtiy");
define("SITE_CONTACT","QQ:410743943 Tel:13954417735 E-mail: gongqignkui@126.com");

//[database]
define("DATA_HOST","localhost");
define("DATA_PORT","3306");
define("DATA_USER","root");
define("DATA_PASS","root");
define("DATA_DB","pim");

//[settings]

//current language
$db = mysql_connect(DATA_HOST,DATA_USER,DATA_PASS);
mysql_select_db(DATA_DB,$db);
$s = mysql_query("select location,skin from users where id =".$_SESSION['SESS_USERID']);
$r = mysql_fetch_assoc($s);
if($r['location'])
{	
	define("LOCATION",$r['location']);
}
elseif(get_cookie("userlocation"))
{
	define("LOCATION",get_cookie("userlocation"));
}else
{
	define("LOCATION","cn");
}

if($r['skin'])
{
	define("CSS",$r['skin']);
}elseif(get_cookie("userskin"))
{
	define("CSS",get_cookie("userskin"));
}else
{
	define("CSS","default");
}

//[menu]
$dic=array("ok"=>array("Ok ","确定","確定"),
	"advanced"=>array("Advanced ","高级","高級"),
	"add"=>array("Add ","增加","增加"),
	"as"=>array("As ","作为","作為"),
	"list"=>array("List ","列表","列表"),
	"date"=>array("Date ","日期","日期"),
	"firstpage"=>array("First Page ","首页","首頁"),	
	"messages"=>array("Messages ","消息","簡訊"),
	"contanct"=>array("Contanct ","联系人","聯繫人"),
	"email"=>array("Email ","电子邮件","電子郵件"),
	"edit"=>array("Edit ","编辑","編輯"),
	"error"=>array("Error ","错误","錯誤"),
	"calendar"=>array("Calendar ","日历","日曆"),
	
	"notes"=>array("Notes ","便笺","便箋"),
	"festival"=>array("Festival ","节日","節日"),
	
	"expense"=>array("Expense ","消费","消費"),
	"report"=>array("Report ","汇总","匯總"),
	"header"=>array("Header ","头像","頭像"),
	"information"=>array("Information ","信息","信息"),
	"applications"=>array("Applications ","插件","程式"),
	
	"about"=>array("About ","关于","關於"),
	
	"register"=>array("Register ","注册","註冊"),
	"login"=>array("Login ","登陆","登陸"),
	"logout"=>array("Logout ","注销","註銷"),
	"location"=> array("Location ","位置","位置"),
	"log"=> array("Log ","记录","記錄"),
	"new"=>array("New ","新建","新建"),
	"normal"=>array("Normal ","一般","一般"),
	"newStatus"=>array("New Status,Please visited the first page ","有新提示，访问首页","有新提示，訪問首頁"),
	"update"=>array("Update ","修改","修改"),
	"options"=>array("Options ","选项","選項"),
	"other"=>array("Ohter ","其他","其他"),
	"status"=>array("Status ","状态","狀態"),
	"subject"=>array("Subject ","主题","主題"),
	"skin"=>array("Skin ","皮肤","皮膚"),
	"search"=>array("Search ","搜索","搜索"),
	"securityLong"=>array("Please do not select this option when in net bar or public library.","为了确保你的信息安全，请不要在网吧或者公共机房选择此项。","為了確保你的資訊安全，請不要在網吧或者公共機房選擇此項。"),
	"send"=>array("Send ","发送","發送"),
	"tips"=>array("Tips ","提示","提示"),
	"type"=> array("Type ","类型","類型"),
	"task"=>array("Task ","任务","任務"),
	"tip"=>array("Tip ","提示","提示"),
	"prevpage"=>array("PrevPage ","前一页","前一頁"),
	"incorrect"=>array("Incorrect ","错误","錯誤"),
	"username"=>array("UserName ","用户","用戶"),
	"password"=>array("PassWord ","密码","密碼"),
	"inbox"=>array("InBox ","收件箱","收件箱"),
	"outbox"=>array("OutBox ","发件箱","發件箱"),
	"pagecount"=>array("PageCount ","页码","頁碼"),
	"nextpage"=>array("NextPage ","下一页","下一頁"),
	"lastpage"=>array("LastPage ","最后一页","最後一頁"),
	"reply"=>array("Reply ","回复","回復"),
	"view"=>array("view ","显示","顯示"),
	"wait"=>array("Wait ","亟待","亟待"),
	"priority"=>array("Priority ","优先级","優先順序"),
	"category"=>array("Category ","分类","分類"));
//PIM 
$locationsarr =array("Home ","Dormitory ","Office ","Road ","Net ","Library");
$typesarr = array("Reminder ","Meeting ","Call ","Birthday ","Anniversary ","Memo");
?>