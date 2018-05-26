//当按下Add Material时显示添加素材的div
var openAddPanel = document.getElementById('open-add-panel');
var addPanel = document.querySelector('.add-panel-first');
var preview = document.querySelector('.add-panel-second');

openAddPanel.onclick = function () {
	if(addPanel.style.display == 'none'){
		addPanel.style.display = 'block';
		preview.innerHTML = '';
	} else {
		addPanel.style.display = 'none';
	}
};

//拖放添加素材列表

addPanel.ondragenter = function (event) {
	event.stopPropagation(); 
	event.preventDefault();
	preview.innerHTML = '';
};

addPanel.ondragover = function (event) {
	event.stopPropagation(); 
	event.preventDefault();
};

addPanel.ondrop = function (event) {
	event.stopPropagation(); 
	event.preventDefault();
	var dt = event.dataTransfer;
	var file = dt.files[0];
	handleFile(file);
};

function handleFile(file) {
	var imageType = /^image\//;
	if(!imageType.test(file.type)) {
		return;
	}

	var img = document.createElement("img");
	img.classList.add('preview-img');
	img.file = file;
	preview.appendChild(img);
	console.log(img.style.width);

	var reader = new FileReader();
	reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
	reader.readAsDataURL(file);
}

function sendFile(file) {
	var uri = "http://192.168.128.135/chenxiaoyu/upload.php";
	var xhr = new XMLHttpRequest();
	var fd = new FormData();

	xhr.open("POST", uri, true);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			alert(xhr.responseText); // handle response.
		}
	};
	fd.append('myFile', file);
	// Initiate a multipart/form-data upload
	xhr.send(fd);
}

var addMaterial = document.getElementById('add-material');
addMaterial.onclick = function() {
	var img = document.querySelector('.preview-img');
	sendFile(img.file);
}
