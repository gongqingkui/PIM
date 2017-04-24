var MAX_FILES = 6;
var fuplistArr =new Array();
function createFileup(fid){
  str  = "<div onmouseover=\"fileupin(this);\" onmouseout=\"fileupout(this);\" class=\"fileup\" id=\"fup" + fid + "\">";
  str += "<input type=file name=\"myfile[]\" onchange=\"chooseNewFile(" + fid + ",this.value)\" class=\"file\" id=file" + fid + ">";
  str += "</div>\n";
  return str;
}
function createFile(fid,fname){
  str  = "<div class=\"filelist\" id=\"fname" + fid + "\">";
  str += fname +";" + cancelImg(fid);
  str += "</div>";
  return str;
}
function cancelImg(fid){
  str = "&nbsp;<img src=17phpediter/img/cancel.gif style=\"cursor:pointer;\" title='撤销此附件' onclick=\"removeFile("+ fid +");\">";
  return str;
}
function addTofupList(str){
  document.getElementById("fuplist").innerHTML += str; 
}
function addTofList(str){
  document.getElementById("flist").innerHTML += str;
}
function chooseNewFile(fid,txt){
 var filename = txt.substr(txt.lastIndexOf("\\")+1);
 addTofList(createFile(fid,filename));
 document.getElementById("fup"+fid).style.display = 'none';
 fuplistArr[i]=1;
 setNextVisiable();
}
function fileupin(obj){
   obj.style.background = 'url(17phpEditer/img/up2.gif)';
}
function fileupout(obj){
   obj.style.background = 'url(17phpEditer/img/up.gif)';
}
function filesFull(){
 fuplistArr[0] = 1;
 document.getElementById('fup_default').style.display = 'block';
}
function setNextVisiable(){
   var find = false;
   for(i=1;i<=MAX_FILES;i++){
    if(fuplistArr[i]==0){
      document.getElementById("fup"+i).style.display = 'block'; 
      find = true;
      break;
     }
   }
   if(!find){
      filesFull();
   }
}
function removeFile(fid){
  document.getElementById("file" + fid).outerHTML=document.getElementById("file"+fid).outerHTML;
  fuplistArr[fid] = 0;
  document.getElementById('fname'+ fid).innerHTML = '';
  document.getElementById('fname'+ fid).removeNode();
  if(fuplistArr[0]==1){
     fuplistArr[0] = 0;
     document.getElementById('fup_default').style.display = 'none';
    setNextVisiable();
  }
}
function initfup(){
 fuplistArr[0] = 0;
 str = "<div id=fup_default class=filemax>附件已达最大个数。</div>";
 addTofupList(str);
 for(i=1;i<=MAX_FILES;i++){
   addTofupList(createFileup(i));
   fuplistArr[i] = 0;
 }
 setNextVisiable();
}