<?php

require_once('setting.php');

if(isset($_GET['action']) && $_GET['action'] == 'add-belong'){
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
