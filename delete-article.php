<?php

require_once('setting.php');

if(isset($_GET['action']) && $_GET['action'] == 'delete') {
	if(!$db -> query(
		"delete from Article
		where articleID = '" . $_GET['articleID'] . "'"
	)){
		echo $db -> connect_errno . $db -> connect_error;
	}
}

ob_end_clean();
header('Location: ./index.php');
