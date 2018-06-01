
var contentList = document.querySelectorAll('.content');

function prework(str){
	var ret = '';
	for(var i = 0; i < str.length; i++) {
		ret = ret + str[i];
		if(i > 0 && str[i] == '\\' && str[i-1] == '\\'){
			ret = ret + '\\\\';
		}
	}
	return ret;
}

for( var i = 0; i <= contentList.length; i++) {
   var curContent = contentList[i];
   var text = marked(prework(curContent.innerHTML));
   curContent.innerHTML = text;
}

