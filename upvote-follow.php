<?php

require_once('setting.php');

if(!isset($_GET['type'])) exit();
if(!isset($_GET['target'])) exit();

if($_GET['type'] == 'upvote'){
	$info = $db -> query(
		"select * from Collection
		 where articleID = '" . $_GET['target'] . "'
		 and userName = '" . $user -> userName . "'"
	);
	if($info -> num_rows == 0){ 
		$db -> query(
			"insert into Collection values (
			 '" . $user -> userName . "', '" . $_GET['target'] . "')"
		);
		echo $getState -> genNextURL(NULL, 0, 'image/upvote.png');
	} else {
		$db -> query(
			"delete from Collection
			 where articleID = '" . $_GET['target'] . "'
			 and userName = '" . $user -> userName . "'"
		);
		echo $getState -> genNextURL(NULL, 0, 'image/upvote2.png');
	}
} else if($_GET['type'] == 'follow'){
	$info = $db -> query(
		"select * from Follow
		 where followerID = '" . $user -> userName . "'
		 and beFollowerID = '" . $_GET['target'] . "'"
	);
	if($info -> num_rows == 0){
		$db -> query(
			"insert into Follow values (
			 '" . $user -> userName . "', '" . $_GET['target'] . "')"
		);
		echo $getState -> genNextURL(NULL, 0, 'image/follow.png');
	} else {
		$db -> query(
			"delete from Follow
			 where followerID = '" . $user -> userName . "'
			 and beFollowerID = '" . $_GET['target'] . "'"
		);
		echo $getState -> genNextURL(NULL, 0, 'image/follow2.png');
	}
} else if($_GET['type'] == 'countUpVote'){
	$info = $db -> query(
		"select count(*) as tot from Collection
		 where articleID = '" . $_GET['target'] . "'"
	);
	$info -> data_seek(0);
	$row = $info -> fetch_assoc();
	echo $row['tot'];
}
