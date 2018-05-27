var follow = document.querySelectorAll('.follow-pic');
var upvote = document.querySelectorAll('.vote-pic');

function handleClick(type, target, img, motion, later){
	var httpRequest = new XMLHttpRequest();
	var reqGET = '?type=' + type + '&target=' + target;
	httpRequest.open('GET', 'http://192.168.128.135/chenxiaoyu/upvote-follow.php' + reqGET, true);

	httpRequest.onreadystatechange = function () {
		if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
			motion(img, httpRequest.responseText);
			later(httpRequest.responseText);
		}
	};

	httpRequest.send();
}

for(var i = 0; i < upvote.length; i++){
	upvote[i].onclick = function(e) {
		console.log(e.target.parentElement.parentElement.parentElement.parentElement.parentElement);
		handleClick('upvote', e.target.alt, e.target, function(a, b){ a.src = b; }, function(){
			var upVoteCount = e.target.parentElement.parentElement.querySelector('.up-vote-count');
			handleClick('countUpVote', e.target.alt, upVoteCount, function(a, b){ a.innerText = b; }, function(){});
			author = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.querySelector('.follow-pic').alt;
			var sumVoteCount = document.getElementById('vote');
			handleClick('sumUpVote', author, vote, function(a, b){ a.innerText = b; }, function() {});
		});
	}
}

for(var i = 0; i < follow.length; i++){
	follow[i].onclick = function(e) {
		handleClick('follow', e.target.alt, e.target, function(a, b){ a.src = b; }, function(text){
			for(i = 0; i < follow.length; i++){
				follow[i].src = text;
			}
			var FollowCount = document.getElementById('follow');
			var author = e.target.alt;
			handleClick('countFollow', author, FollowCount, function(a, b){ a.innerText = b;}, function(){});
		});
	}
}

