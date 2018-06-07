<?php

require_once('setting.php');


if(isset($_GET['action']) && $_GET['action'] == 'add-belong'){
	$article -> openArticle();
	//非超级用户或者作者不允许修改belong关系
	if($user -> permission != 'admin' && $user -> permission != 'root' && $user -> userName != $article -> userName){
		echo 'fail';
		exit();
	}
	$info = $db -> query(
		"select * from Belong
		where articleID = '" . $_GET['articleID'] . "'
		and categoryName = '" . $_GET['categoryName'] . "'"
	);
	if($info -> num_rows == 0){
		if($db -> query(
			"insert into Belong values(
				'" . $_GET['articleID'] . "', '" . $_GET['categoryName'] . "')"
			)) {
				echo 'success';
		} else {
			echo 'fail';
		}
	} else {
		if($db -> query(
			"delete from Belong
			where articleID = '" . $_GET['articleID'] . "'
			and categoryName = '" . $_GET['categoryName'] . "'"
		)) {
			echo 'success';
		} else {
			echo 'fail';
		}
	}
} else {
	echo 'fail';
}
