<?php

define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');

if(isset($_GET['articleID'])){
	$comment = new Comment($_GET['articleID']);
	$dom = $comment -> genComment(true);
	echo $dom -> toString();
} else {
	$pusher = new Pusher();
	echo $pusher -> genPush() -> toString();
}

echo $category -> genCategoryPanel() -> toString();

include('footer.php');
?>
