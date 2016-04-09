
function showhideelement(divelement, showhide){
	var show1="";var show2="";
	if(showhide){
		show1="block";show2="visible";	
	}else{
		show1="none";show2="hidden";	
	}
	if (document.getElementById) { // DOM3 = IE5, NS6
		if(document.getElementById(divelement)){
			document.getElementById(divelement).style.display = show1;
		}
	}else {
	    if (document.layers) { // Netscape 4
			if(document.layers[divelement]){
				document.layers[divelement].visibility = show2;
			}
	    }else { // IE 4
			if(document.all(divelement)){
				document.all(divelement).style.visibility = show2;
			}
	    } 
	}
}
function FindElement(objform,divelement){
    var retval;

	if (document.getElementById) { // DOM3 = IE5, NS6
		if(document.getElementById(divelement)){
			return document.getElementById(divelement);
		}
	}else {
	    if (document.layers) { // Netscape 4
			if(document.layers[divelement]){
				return document.layers[divelement];
			}
	    }else { // IE 4
			if(document.all(divelement)){
				return document.all(divelement);
			}
	    } 
	}
	return retval;
}

function uncache(url){
	var d = new Date();
	var time = d.getTime();
	return url + '&time='+time;
}
	function addOption(selectbox,text,value)
	{
		var optn = document.createElement("OPTION");
		optn.text = text;
		optn.value = value;
		optn.selected = true;
		selectbox.options.add(optn);
	}
