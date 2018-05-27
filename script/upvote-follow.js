var upvote = document.getElementById('vote-pic');
var follow = document.getElementById('follow-pic');

function handleClick(type, target, img, motion, later){
	var httpRequest = new XMLHttpRequest();
	var reqGET = '?type=' + type + '&target=' + target;
	httpRequest.open('GET', 'http://192.168.128.135/chenxiaoyu/upvote-follow.php' + reqGET, true);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			motion(img, httpRequest.responseText);
			later();
		}
	};

	httpRequest.send();
}

upvote.onclick = function() {
	handleClick('upvote', this.alt, this, function(a, b){ a.src = b; }, function(){
		var upVoteCount = document.getElementById('up-vote-count');
		handleClick('countUpVote', upvote.alt, upVoteCount, function(a, b){ a.innerText = b; }, function(){});
	});
}

follow.onclick = function() {
	handleClick('follow', this.alt, this, function(a, b){ a.src = b; }, function(){});
}

