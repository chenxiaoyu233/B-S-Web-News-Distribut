
var profileBackground = document.querySelector('.profile-background');
var close = document.getElementById('close');
var edit = document.getElementById('edit');
var modifyPanel = document.getElementById('modify-panel');

close.onclick = function() { 
	console.log(1);
	if(profileBackground.style.left == '-490px') {
		profileBackground.style.left = '0px';
		edit.style.display = 'block';
	} else {
		profileBackground.style.left = '-490px';
		edit.style.display = 'none';
	}
};

edit.onclick = function() {
	if(modifyPanel.style.display == 'none'){
		modifyPanel.style.display = 'block';
	} else {
		modifyPanel.style.display = 'none';
	}
};
