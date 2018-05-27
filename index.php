<?php

define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');

$_GET['articleID'] = '06d5ec3f-616c-11e8-98b1-000c2974e030';

if(isset($_GET['articleID'])){
	$comment = new Comment($_GET['articleID']);
	$dom = $comment -> genComment(true);
	echo $dom -> toString();
} else {
	$pusher = new Pusher();
	echo $pusher -> genPush() -> toString();
}

include('footer.php');
?>
