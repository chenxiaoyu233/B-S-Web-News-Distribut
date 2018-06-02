var photo = document.getElementById('modify-photo');
var input = document.getElementById('m-materialID');

photo.ondragenter = function (event) {
	this.style.background = 'gray';
	event.stopPropagation(); 
	event.preventDefault();
};

photo.ondragover = function (event) {
	event.stopPropagation(); 
	event.preventDefault();
};

photo.ondrop = function (event) {
	event.stopPropagation(); 
	event.preventDefault();
	var dt = event.dataTransfer;
	var file = dt.files[0];

	var imageType = /^image\//;
	if(!imageType.test(file.type)) {
		return;
	}

	this.file = file;
	var reader = new FileReader();
	reader.onload = (function(img) { return function(e) { img.src = e.target.result; }; })(this);
	reader.readAsDataURL(file);

	
	var uri = SITE_ROOT + "upload.php";
	var xhr = new XMLHttpRequest();
	var fd = new FormData();

	xhr.open("POST", uri, true);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			alert(xhr.responseText); // handle response.
			input.value = xhr.responseText;
		}
	};
	fd.append('myFile', file);
	// Initiate a multipart/form-data upload
	xhr.send(fd);
};
