function storeCaret (txtobj){
	if (txtobj.createTextRange){
		txtobj.curRange = document.selection.createRange().duplicate();
	}
}
function insertAtCaret (objtxt,txt1,txt2,overcast){
	txtobj = document.getElementById(objtxt);
	if (txtobj.curRange){
		if (overcast == 0){
		  txtobj.curRange.text = txt1+txtobj.curRange.text+txt2;
		}else{
		  txtobj.curRange.text = txt1+txt2;
		}
		txtobj.curRange.select();
	}else{
		txtobj.focus();
		storeCaret(txtobj);
		insertAtCaret (objtxt,txt1,txt2,overcast);
	}
}
function insertAtCaretURL(){
 if(str = prompt('\n请输入您要链接的网页地址：','http://')){
    insertAtCaret('title_content','[URL='+str+']点此打开链接：','[/URL]',0);
 }
}
function insertAtCaretIMG(){
 if(str = prompt('\n请输入您要插入的图片地址：','http://')){
    insertAtCaret('title_content','[IMG]'+str,'[/IMG]',1);
 }
}
function insertAtCaretCOLOR(){
 if(str = prompt('\n请输入文字的颜色(格式#000000～#FFFFFF)：','#')){
    insertAtCaret('title_content','[COLOR='+str+']','[/COLOR]',0);
 }
}
function insertAtCaretSIZE(){
 if(str = prompt('\n请输入文字的大小(格式：1～7的数字)：','3')){
    insertAtCaret('title_content','[SIZE='+str+']','[/SIZE]',0);
 }
}

function addemot(name){
    insertAtCaret("title_content","[emot="+name+"]","",0);
}

function imgmousein(obj){
  obj.border=1;
  obj.style.borderColor = "#8A8A8A";
}
function imgmouseout(obj){
  obj.border=1;
  obj.style.borderColor = "#FFFFDD";
}
function btnmousein(obj){
  obj.style.border="1px #8A8A8A dashed";
  obj.style.color="#FF0000";
}
function btnmouseout(obj){
  obj.style.border="1px #9C9C9C solid";
  obj.style.color="#0000FF";
}
function textout(obj){
  parent.document.getElementById("my17phpediter").value = obj.value;
}
 function textin(){
   document.getElementById("title_content").value = parent.document.getElementById("my17phpediter").value;
 }
function ubb(obj){
  if(obj.checked){
   parent.document.getElementById("ubb").value = "1";
  }else{
   parent.document.getElementById("ubb").value = "0";
  }
}