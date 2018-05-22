var myArticleContent = document.getElementById('article-content');
var myArticleContentCode= CodeMirror.fromTextArea(myArticleContent, {
   lineNumbers: true,
   viewportMargin: 50,
   mode: "text/x-csrc",
   keyMap: "vim",
   theme: "solarized",
   matchBrackets: true,
   showCursorWhenSelecting: true,
   inputStyle: "contenteditable"
});

for( var i = 1; i <= 19; i ++ ) {
   myArticleContentCode.execCommand('newlineAndIndent');
   myArticleContentCode.execCommand('goDocStart');
}

var myArticleTitle = document.getElementById('article-title');
var myArticleTitleCode = CodeMirror.fromTextArea(myArticleTitle, {
   viewportMargin: 1,
   mode: "text/x-csrc",
   keyMap: "vim",
   matchBrackets: true,
   showCursorWhenSelecting: true,
   inputStyle: "contenteditable"
});

var CM = document.querySelectorAll('.CodeMirror');
CM[0].style.height = '2em';
CM[1].style.height = 'auto';
