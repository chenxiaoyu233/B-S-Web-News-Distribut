
var contentList = document.querySelectorAll('.content');

function prework(str){
	var ret = '';
	for(var i = 0; i < str.length; i++) {
		ret = ret + str[i];
		if(i > 0 && str[i] == '\\' && str[i-1] == '\\'){
			if(i + 1 < str.length && (str[i + 1] == '{' || str[i + 1] == '}')) continue;
			if(i + 1 < str.length && (str[i + 1] == '[' || str[i + 1] == ']')) continue;
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

