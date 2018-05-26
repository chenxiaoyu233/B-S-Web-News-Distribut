<?php
require_once('setting.php');

//列出文件
if(isset($_GET['action']) && $_GET['action'] == 'select') {
	$curPage = 0;
	$material = new Material();
	if(isset($_GET['cur-page'])) $curPage = $_GET['cur-page'];
	echo $material -> listMaterial($curPage, 9) -> toString();
}

if(isset($_FILES['myFile'])){
	$material = new Material();
	$in = fopen($_FILES['myFile']['tmp_name'], 'r');
	$content = fread($in, filesize($_FILES['myFile']['tmp_name']));
	$material -> addMaterial($_FILES['myFile']['name'], $content);
}

