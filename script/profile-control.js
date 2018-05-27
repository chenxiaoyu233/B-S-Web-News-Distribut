
var profileBackground = document.querySelector('.profile-background');
var close = document.getElementById('close');

close.onclick = function() { 
	if(profileBackground.style.left == '-490px') {
		profileBackground.style.left = '0px';
	} else {
		profileBackground.style.left = '-490px';
	}
}
