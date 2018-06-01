//
// add category
//
//
function initCategory() {
	var categoryContainerRoot = document.querySelector('.category-container-root');
	var categoryContainer = document.querySelectorAll('.category-container');
	var categoryCard = document.querySelectorAll('.category-card');
	var foldImg = document.querySelectorAll('.fold-img');
	var addCategoryButton = document.querySelectorAll('.add-category-button');

	categoryContainerRoot.style.height = '20px';
	categoryContainerRoot.dataset['curHeight'] = 20;
	categoryContainerRoot.dataset['fold'] = 1;
	for(var i = 0; i < categoryContainer.length; i++){
		categoryContainer[i].style.height = '0px';
		categoryContainer[i].dataset['curHeight'] = 0;
		categoryContainer[i].dataset['fold'] = 1;
	}
	rebuildEvent();
}
initCategory(); //初始化

function addHeight(curDiv, height){
	curDiv.dataset['curHeight'] = parseInt(curDiv.dataset['curHeight']) + height;
	curDiv.style.height = curDiv.dataset['curHeight'] + 'px';
	if(curDiv.classList[0] != 'category-container-root') 
		addHeight(curDiv.parentElement, height);
}

var foldURL = SITE_ROOT + 'image/fold.png';
var unfoldURL = SITE_ROOT + 'image/unfold.png';

function fold(curDiv){ // 一次性将所有子项全部关上
	if(curDiv.dataset['fold'] == 1) return;
	curDiv.dataset['fold'] = 1;
	var ch = curDiv.children;
	ch[0].children[0].src = foldURL;
	for(var i = 1; i < ch.length; i++){
		fold(ch[i]);
		addHeight(ch[i], -20);
	}
}


function unfold(curDiv){
	if(curDiv.dataset['fold'] == 0) return;
	curDiv.dataset['fold'] = 0;
	var ch = curDiv.children;
	ch[0].children[0].src = unfoldURL;
	for(var i = 1; i < ch.length; i++){
		addHeight(ch[i], 20);
	}
}

function buildFoldButton(){
	var foldImg = document.querySelectorAll('.fold-img');
	for(var i = 0; i < foldImg.length; i++){
		foldImg[i].onclick = function (e) {
			var cur = e.target.parentElement.parentElement;
			if(cur.dataset['fold'] == 1){
				unfold(cur);
			} else {
				fold(cur);
			}
		};
	}
}


function rebuildEvent(){
	buildFoldButton(); //折叠事件
	buildAddCategoryButton(); //添加目录事件
	buildRemoveCategoryButton(); //删除目录事件
	buildCategoryHead(); //隐藏目录事件
	buildAddArticleFunction();  //添加文章事件 
}

function addNewCategory(e) {
	var cur = e.target.parentElement;
	var categoryName = cur.children[0].value;
	cur = cur.parentElement;
	var fatherCatogory = cur.children[0].children[1].innerText;

	var httpRequest = new XMLHttpRequest();
	var reqGET = '?action=add-category' + '&categoryName=' + categoryName + '&fatherCategory=' + fatherCatogory;
	httpRequest.open('GET', SITE_ROOT + 'category.php' + reqGET, true);

	cur = e.target.parentElement;
	fa = cur.parentElement;
	fa.removeChild(cur);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			//alert(httpRequest.responseText);
			fa.innerHTML += httpRequest.responseText;
			//重新注册一次事件
			rebuildEvent();
		}
	};

	httpRequest.send();
}

function addCategoryButtonHandle(e){
	var cur = e.target.parentElement.parentElement;
	unfold(cur);

	var div = document.createElement('div');
	div.classList.add('category-container');
	div.dataset['fold'] = 1;

	var input = document.createElement('input');
	input.type = 'text';
	input.name = 'categoryName';
	input.classList.add('category-input');

	var button = document.createElement('button');
	button.classList.add('craete-category-button');
	button.onclick = addNewCategory;

	var target = cur.children[0].children[1].innerText;
	div.appendChild(input);
	div.appendChild(button);
	cur.appendChild(div);
	addHeight(div, 20);
}

function buildAddCategoryButton() {
	var addCategoryButton = document.querySelectorAll('.add-category-button');
	for(var i = 0; i < addCategoryButton.length; i++){
		addCategoryButton[i].onclick = addCategoryButtonHandle;
	}
}

//
// show / hide the category list
//
function buildCategoryHead() {
	var categoryHeadButton = document.getElementById('category-head-button');
	var categoryContainerRoot = document.querySelector('.category-container-root');
	categoryHeadButton.onclick = function () {
		if(categoryContainerRoot.style.left == ''){
			categoryContainerRoot.style.left = '100%';
		} else {
			categoryContainerRoot.style.left = '';
		}
	};
}

//
// delete items in the category
//


function deleteCategory(e){
	var cur = e.target.parentElement.parentElement;
	fold(cur);
	var categoryName = cur.children[0].children[1].innerText;

	var httpRequest = new XMLHttpRequest();
	var reqGET = '?action=remove-category' + '&categoryName=' + categoryName;
	httpRequest.open('GET', SITE_ROOT + 'category.php' + reqGET, true);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			addHeight(cur, -20);
			cur.parentElement.removeChild(cur);
		}
	};

	httpRequest.send();

}

function buildRemoveCategoryButton() {
	var removeCategoryButton = document.querySelectorAll('.remove-category-button');
	for(var i = 0; i < removeCategoryButton.length; i++){
		removeCategoryButton[i].onclick = deleteCategory;
	}
}

//
// add / remove article in the category
//


//从特定URL中提取出articleID
function getArticleIdFromUrl(s){
	var ret = '';
	var flag = 0;
	for(var i = 0; i < s.length; i++){
		if(flag) ret += s[i];
		if(s[i] == '=') flag = 1;
	}
	return ret;
}

function categorySwitcher(curDiv, articleID, categoryName){
	var httpRequest = new XMLHttpRequest();
	var reqGET = '?action=add-belong' + '&categoryName=' + categoryName + '&articleID=' + articleID;
	httpRequest.open('GET', SITE_ROOT + 'belong.php' + reqGET, true);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			if(httpRequest.responseText == 'success') {
				curDiv.classList.toggle('marked-category');
			}
		}
	};

	httpRequest.send();
}

function buildAddArticleFunction(){
	var categoryCard = document.querySelectorAll('.category-card');
	for(var i = 0; i < categoryCard.length; i++){
		categoryCard[i].ondragenter = function(e) {
			e.stopPropagation();
			e.preventDefault();
		};
		categoryCard[i].ondragover = function(e) {
			e.stopPropagation();
			e.preventDefault();
		};
		categoryCard[i].ondrop = function(e) {
			e.stopPropagation();
			e.preventDefault();
			var dt = e.dataTransfer;
			var item = dt.items[0];
			item.getAsString(function(s) {
				var articleID = getArticleIdFromUrl(s);
				var cur = e.target;
				if(cur.classList[0] != 'category-card'){
					cur = cur.parentElement;
				}
				var categoryName = cur.children[1].innerText;
				categorySwitcher(cur, articleID, categoryName);
			});
		};
	}
}
