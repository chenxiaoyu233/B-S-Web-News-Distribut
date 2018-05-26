<?php

require_once('setting.php');

if(isset($_GET['materialID'])){
	$info =  $db -> query(
		"select materialContent from Material
		 where materialID = '" . $_GET['materialID'] . "'"
	);
	if($info -> num_rows == 0) {
		exit();
	}
	$info -> data_seek(0);
	$content = $info -> fetch_assoc()['materialContent'];
	ob_end_clean();
	header('Content-Type: image/');
	echo $content;
}
