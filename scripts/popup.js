function popup (url)
{ 
  window.open(url,"Help","top=150,left=300,width=460,height=280,scrollbars=yes");
}

function popupvar (url,name,properties)
{ 
  childwindow = window.open(url,name,properties);
  if(childwindow){
	childwindow.focus();
  }
}

function OpenReg(){
	popupvar('register.php','Register',"top=150,left=300,width=300,height=300,scrollbars=yes");
}