<?php

require_once('setting.php');


if(isset($_GET['action']) && $_GET['action'] == 'add-category'){
	if($user -> permission == 'admin' || $user -> permission == 'root'){
		$category -> addCategory($_GET['categoryName'], $_GET['fatherCategory']);
	}
	$dom = new DOM(
		'div',
		array(
			'class' => 'category-container',
			'data-cur-height' => "20",
			'data-fold' => 'fold'
		),
		NULL,
		array(
			$category -> genThisCategory(
				'category-card', 1, $_GET['categoryName']
			)
		)
	);
	echo $dom -> toString();
}

if(isset($_GET['action']) && $_GET['action'] == 'remove-category'){
	if($user -> permission == 'admin' || $user -> permission == 'root'){
		$category -> removeCategory($_GET['categoryName']);
	}
}
