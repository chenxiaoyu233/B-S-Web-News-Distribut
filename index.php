<?php

define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');

if(isset($_GET['articleID'])){
	$comment = new Comment($_GET['articleID']);
	$dom = $comment -> genComment(true);
	echo $dom -> toString();
} else if(isset($_GET['categoryName'])){
	$pusher = new Pusher();
	echo $pusher -> genPush(
		"select articleID from Article natural join Belong
		 where type = 'news'
		 and categoryName = '" . $_GET['categoryName'] . "'
		 order by time desc"
	) -> toString();
} else {
	$pusher = new Pusher();
	echo $pusher -> genPush() -> toString();
}

if(isset($_GET['articleID'])){
	$category -> setArticleConstraint($_GET['articleID']);
}
echo $category -> genCategoryPanel() -> toString();

include('footer.php');
?>
