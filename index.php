<?php

define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');

if(!isset($_GET['page'])){
	$_GET['page'] = 1;
}



$subpage = $_GET['page'];

if(isset($_GET['articleID'])){
	$comment = new Comment($_GET['articleID']);
	$dom = $comment -> genComment(true);
	echo $dom -> toString();
} else if(isset($_GET['categoryName']) && $_GET['categoryName'] != 'NULL'){
	$page = new Page();
	echo $page -> genPageController() -> toString();
	$pusher = new Pusher($subpage);
	echo $pusher -> genPush(
		"select articleID from Article natural join Belong
		 where type = 'news'
		 and categoryName = '" . $_GET['categoryName'] . "'
		 order by time desc"
	) -> toString();
} else {
	$page = new Page();
	echo $page -> genPageController() -> toString();
	$pusher = new Pusher($subpage);
	echo $pusher -> genPush() -> toString();
}

//if(isset($_GET['articleID'])){
//	$category -> setArticleConstraint($_GET['articleID']);
//}
//echo $category -> genCategoryPanel() -> toString();

include('footer.php');
?>
