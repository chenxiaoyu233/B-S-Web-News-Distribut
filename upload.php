<?php
require_once('setting.php');

if(isset($_FILES['myFile'])){
	//move_uploaded_file($_FILES['myFile']['tmp_name'], "../uploads/" . $_FILES['myFile']['name']);
	$material = new Material();
	$in = fopen($_FILES['myFile']['tmp_name'], 'r');
	$content = fread($in, filesize($_FILES['myFile']['tmp_name']));
	$material -> addMaterial($_FILES['myFile']['name'], $content);
}

