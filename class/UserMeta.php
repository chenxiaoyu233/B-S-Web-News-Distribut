<?php

class UserMeta {
	public $inner;

	public function get_info_from_database() {
		global $db;
		$info = $db -> query(
			"select * from UserMeta
			 where userName = '" . $this -> inner['userName'] . "'"
		);

		//没有找到用户
		if($info -> num_rows == 0){
			ob_end_clean();
			header('Location: sad-panda.php?sentence=用户不存在');
			return false;
		}

		$info -> data_seek(0);
		$this -> inner = $info -> fetch_assoc();
	}
	public function __construct($userName) {
		$this -> inner['userName'] = $userName;
		$this -> get_info_from_database();
	}
	
	public function genProfile(){
		// TODO
	}
}
