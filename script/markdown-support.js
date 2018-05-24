
var contentList = document.querySelectorAll('.content');

for( var i = 0; i <= contentList.length; i++) {
   var curContent = contentList[i];
   var text = curContent.innerHTML;
   curContent.innerHTML = marked(text);
   console.log(curContent);
   console.log(text);
}
