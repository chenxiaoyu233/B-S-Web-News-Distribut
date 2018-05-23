var myArticleContent = document.getElementById('article-content');
var myArticleContentCode= CodeMirror.fromTextArea(myArticleContent, {
   lineNumbers: true,
   viewportMargin: 50,
   mode: "text/x-markdown",
   keyMap: "vim",
   theme: "solarized",
   matchBrackets: true,
   showCursorWhenSelecting: true,
   inputStyle: "contenteditable",
});

var myArticleTitle = document.getElementById('article-title');
var myArticleTitleCode = CodeMirror.fromTextArea(myArticleTitle, {
   viewportMargin: 1,
   mode: "text/x-markdown",
   keyMap: "vim",
   matchBrackets: true,
   showCursorWhenSelecting: true,
   inputStyle: "contenteditable"
});

var CM = document.querySelectorAll('.CodeMirror');
CM[0].style.height = '2em';
CM[1].style.height = 'auto';
