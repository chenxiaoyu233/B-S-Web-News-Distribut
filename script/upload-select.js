var curPage = 0; //表示当前素材的页数

var openSelectPanel = document.getElementById('open-select-panel');
var selectPanelFirst = document.querySelector('.select-panel-first');
var selectPanelSecond = document.querySelector('.select-panel-second');
var preButton = document.getElementById('pre');
var nextButton = document.getElementById('next');


function addImgToArticle() {
	var picList = document.querySelectorAll('.select-pic');

	console.log(picList);

	for(var i = 0; i < picList.length; i++){
		picList[i].onclick = function () {
			var text = myArticleContentCode.doc.getValue();
			text += "\n" + '![](' + this.src  + ')';
			myArticleContentCode.doc.setValue(text);
		};
	}
}

function fetch_list() {
	selectPanelSecond.innerHTML = '';
	httpRequest = new XMLHttpRequest();
	var reqGet = '?action=select' + '&' + 'cur-page=' + curPage;

	httpRequest.open('GET', 'http://192.168.128.135/chenxiaoyu/upload.php' + reqGet, true);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE
				&& httpRequest.status === 200){
			//alert(httpRequest.responseText);
			selectPanelSecond.innerHTML += httpRequest.responseText;
			addImgToArticle(); // 其他地方可以去掉这句话
		}
	};

	httpRequest.send();
}

openSelectPanel.onclick = function() {
	if(selectPanelFirst.style.display == 'none'){
		selectPanelFirst.style.display = 'block';
		fetch_list();
	} else {
		selectPanelFirst.style.display = 'none';
	}
};
