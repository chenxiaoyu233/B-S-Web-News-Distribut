//myArticleContentCode

function addImgToArticle() {
	var picList = document.querySelectorAll('.select-pic');

	console.log(picList);

	for(var i = 0; i < picList.length; i++){
		picList[i].onclick = function () {
			var text = myArticleContentCode.doc.getValue();
			text += "\n" + '![](' + picList[i].src  + ')';
			myArticleContentCode.doc.setValue(text);
		};
	}
}
