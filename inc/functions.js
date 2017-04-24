function $(id)
{
	var result;
	if(result = document.getElementById(id))
	{
		return result;
		}
	else
	{
		result = document.getElementsByTagName(id);
		return result;
		}
}
function createRequestObject()
{
var request_o;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer")
{
	request_o = new ActiveXObject("Microsoft.XMLHTTP");
}
else
{
	request_o = new XMLHTTPRequest();
}
return request_o;
}

var http = createRequestObject();
function getNewStatus()
{
	http.open('get','newstatus.php');
	http.onreadystatechange = handleEvent;
	http.send(null);
}
function handleEvent()
{
	if(http.readyState == 4)
	{
		var response = http.responseText;
		$('answer').innerHTML = response;		
	}
}
function check(msg)
{
	//this.alert($("name").value+$("email").value+$("password").value+$("password2").value);
	if($("name").value=="" || $("email").value=="" || $("password").value=="" || $("password2").value=="" ||($("password").value!=$("password2").value))
	{
		this.alert(msg);
		return false;
		
	}
	else
	{
		return true;
	}
}
function setAsHome(obj,url)
{
	obj.style.behavior='url(#default#homepage)';
	obj.setHomePage(url);
}
function showItem(obj){
if(obj.checked == true)
{
	document.getElementById("remberme").style.display="block";
	//showModelessDialog("inc/cookie.html","example02","dialogWidth:600px;dialogHeight:200px;center:yes;help:no;resizable:no;status:no");
}
else document.getElementById("jizhu").style.display="none";
}
