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
		global $db, $user;
		$info = $db -> query(
			'select UUID()'
		);
		$info -> data_seek(0);
		$ID = $info -> fetch_assoc()['UUID()'];
		echo $ID; // 回显materialID
		if(!$db -> query(
			"insert into Material values
			('" . $ID . "', '" . $name . "', '" . $user -> userName ."', ". "now(), '" .
			addslashes($content) . "')"
		)) {
			echo $db -> errno . ', ' . $db -> error;
		}
	}

	public function genMaterialItem($row) {
		global $getState;
		$item = new DOM(
			'span',
			array(
				'class' => 'material-card'
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'class' => 'select-pic',
						'src' => $getState -> genNextURL(
							array(
								'materialID' => $row['materialID']
							),
							0,
							'show-pic.php'
						),
						'alt' => $row['materialFileName'],
						'title' => $row['materialFileName']
					)
				)
			)
		);
		return $item;
	}

	public function listMaterial($curPage, $listNum) {
		$curPos = $curPage * $listNum;
		global $db, $user;
		$dom = new DOM();
		$info = $db -> query( 
			"select * from Material 
			 where userName = '" . $user -> userName . "'
			 order by uploadTime desc"
		);
		for($i = 0; $i < $listNum; $i++){
			$cur = $i + $curPos;
			if($cur >= $info -> num_rows) break;
			$info -> data_seek($cur);
			$dom -> appendChildNode($this -> genMaterialItem($info -> fetch_assoc()));
		}
		return $dom;
	}
}
