<?php

class Material{
	public $inner;

	public function get_data_from_table() {
		global $db;
		$info = $db -> query(
			"select * from Material
			 where materialID = '" . $this -> inner['materialID'] . "'"
		);
		// 没有找到素材
		if($info -> num_rows == 0){
			ob_end_clean();
			header('Location: sad-panda.php?sentence=素材不存在');
			return false;
		}

		$info -> data_seek(0);
		$this -> inner = $info -> fetch_assoc();
	}

	public function get_type_from_fileName() {
		$fileName = $this -> inner['materialFileName'];
		$len = strlen($fileName);
		$whe = 0;
		for($i = 0; $i < $len; $i++){
			if($fileName[$i] == '.') $whe = $i;
		}
		$ret = '';
		for($i = $whe + 1; $i < $len; $i++) {
			$ret = $ret . $fileName[$i];
		}
		$this -> inner['type'] = $ret;
	}

	public function __construct($materialID = NULL) {
		if($materialID == NULL){
			$this -> inner = NULL; 
			return;
		}
		$this -> inner['materialID'] = $materialID;
		$this -> get_data_from_table();
		$this -> get_type_from_fileName();
	}

	public function addMaterial($name, $content) {
		global $db;
		$info = $db -> query(
			'select UUID()'
		);
		$info -> data_seek(0);
		$ID = $info -> fetch_assoc()['UUID()'];
		echo $ID;
		if(!$db -> query(
			"insert into Material values
			('" . $ID . "', '" . $name . "', '" . 
			addslashes($content) . "')"
		)) {
			echo $db -> errno . ', ' . $db -> error;
		}
	}
}
