//
// add category
//
//
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

function addHeight(curDiv, height){
	curDiv.dataset['curHeight'] = parseInt(curDiv.dataset['curHeight']) + height;
	curDiv.style.height = curDiv.dataset['curHeight'] + 'px';
	if(curDiv.classList[0] != 'category-container-root') 
		addHeight(curDiv.parentElement, height);
}

var foldURL = 'http://192.168.128.135/chenxiaoyu/image/fold.png';
var unfoldURL = 'http://192.168.128.135/chenxiaoyu/image/unfold.png';

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

function addNewCategory(e) {
	var cur = e.target.parentElement;
	var categoryName = cur.children[0].value;
	cur = cur.parentElement;
	var fatherCatogory = cur.children[0].children[1].innerText;

	var httpRequest = new XMLHttpRequest();
	var reqGET = '?action=add-category' + '&categoryName=' + categoryName + '&fatherCategory=' + fatherCatogory;
	httpRequest.open('GET', 'http://192.168.128.135/chenxiaoyu/category.php' + reqGET, true);

	cur = e.target.parentElement;
	fa = cur.parentElement;
	fa.removeChild(cur);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			//alert(httpRequest.responseText);
			fa.innerHTML += httpRequest.responseText;
			//重新注册一次事件
			var addCategoryButton = document.querySelectorAll('.add-category-button');
			for(var i = 0; i < addCategoryButton.length; i++){
				addCategoryButton[i].onclick = addCategoryButtonHandle;
			}
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

for(var i = 0; i < addCategoryButton.length; i++){
	addCategoryButton[i].onclick = addCategoryButtonHandle;
}

//
// show / hide the category list
//

var categoryHeadButton = document.getElementById('category-head-button');
categoryHeadButton.onclick = function () {
	if(categoryContainerRoot.style.left == ''){
		categoryContainerRoot.style.left = '100%';
	} else {
		categoryContainerRoot.style.left = '';
	}
};


//
// delete items in the category
//


function deleteCategory(e){
	var cur = e.target.parentElement.parentElement;
	fold(cur);
	var categoryName = cur.children[0].children[1].innerText;

	var httpRequest = new XMLHttpRequest();
	var reqGET = '?action=remove-category' + '&categoryName=' + categoryName;
	httpRequest.open('GET', 'http://192.168.128.135/chenxiaoyu/category.php' + reqGET, true);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			addHeight(cur, -20);
			cur.parentElement.removeChild(cur);
		}
	};

	httpRequest.send();

}

var removeCategoryButton = document.querySelectorAll('.remove-category-button');
for(var i = 0; i < removeCategoryButton.length; i++){
	removeCategoryButton[i].onclick = deleteCategory;
}
