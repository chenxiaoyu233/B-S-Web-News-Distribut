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
	
	public function genPhoto($id1 = 'profile-photo-panel', $id2 = 'profile-photo') {
		global $getState;
		$target = $getState -> genNextURL(NULL, 0, 'image/user.png');
		if(!is_null($this -> inner['photo'])){
			$target = $getState -> genNextURL(array('materialID' => $this -> inner['photo']), 0, 'show-pic.php');
		}
		$photo = new DOM(
			'div',
			array(
				'id' => $id1
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'id' => $id2,
						'src' => $target
					)
				)
			)
		);
		return $photo;
	}

	public function genNickName(){
		global $getState;
		$nickName = new DOM(
			'p',
			array(
				'id' => 'nickname'
			),
			is_null($this -> inner['nickName']) ? 'nickname' : $this -> inner['nickName']
		);
		$nickNamePanel = new DOM(
			'div',
			array(
				'id' => 'nickname-panel'
			),
			NULL,
			array(
				$nickName
			)
		);
		return $nickNamePanel;
	}

	public function genSex() {
		global $getState;
		$target = 'image/sex.png';
		if(!is_null($this -> inner['sex'])){
			if($this -> inner['sex'] == 'f'){
				$target = 'image/female.png';
			} else if($this -> inner['sex'] == 'm'){
				$target = 'image/male.png';
			}
		}
		$sex = new DOM(
			'img',
			array(
				'id' => 'sex-pic',
				'src' => $getState -> genNextURL(NULL, 0, $target)
			)
		);
		return $sex;
	}

	public function genLeft(){
		global $getState;
		$left = new DOM (
			'div',
			array(
				'id' => 'profile-left'
			),
			NULL,
			array(
				$this -> genPhoto(),
				new DOM(
					'div',
					array(
						'id' => 'below-photo'
					),
					NULL,
					array(
						$this -> genNickName(),
						$this -> genSex()
					)
				)
			)
		);
		return $left;
	}

	public function genEmail(){
		global $getState;
		$email = new DOM(
			'div',
			array(
				'id' => 'email-panel'
			),
			NULL,
			array(
				new DOM(
					'p',
					array(
						'id' => 'email'
					),
					$this -> inner['userName'] . ': ' . (is_null($this -> inner['email']) ? 'email' : $this -> inner['email'])
				)
			)
		);
		return $email;
	}

	public function genGoodNum(){
		global $db, $getState;
		$info = $db -> query(
			"select count(*) as tot
			from (
				select userName as author, articleID from
				Manuscript natural join Article
				where userName = '" . $this -> inner['userName'] . "'
			) as tb1 natural join Collection"
		);
		$info -> data_seek(0);
		$row = $info -> fetch_assoc();
		$target = is_null($row['tot']) ? 0 : $row['tot'];
		$goodNum = new DOM(
			'div',
			array(
				'id' => 'vote-panel'
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'id' => 'vote-img',
						'src' => $getState -> genNextURL(NULL, 0, 'image/upvote.png')
					)
				),
				new DOM(
					'p',
					array(
						'id' => 'vote',
						'class' => 'right-num'
					),
					$target
				)
			)
		);
		return $goodNum;
	}

	public function genFollow(){
		global $db, $getState;
		$info = $db -> query(
			"select count(followerID) as tot
			 from Follow
			 where beFollowerID = '" . $this -> inner['userName'] . "'"
		);
		$info -> data_seek(0);
		$row = $info -> fetch_assoc();
		$target = is_null($row['tot']) ? 0 : $row['tot'];
		$follow = new DOM(
			'div',
			array(
				'id' => 'follow-panel'
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'id' => 'follow-img',
						'src' => $getState -> genNextURL(NULL, 0, 'image/follow.png')
					)
				),
				new DOM(
					'p',
					array(
						'id' => 'follow',
						'class' => 'right-num'
					),
					$target
				)
			)
		);
		return $follow;
	}

	public function genArticleNum(){
		global $db, $getState;
		$info = $db -> query(
			"select count(articleID) as tot
			 from Manuscript
			 where userName = '" . $this -> inner['userName'] . "'"
		);
		$info -> data_seek(0);
		$row = $info -> fetch_assoc();
		$target = is_null($row['tot']) ? 0 : $row['tot'];
		$articleNum = new DOM(
			'div',
			array(
				'id' => 'article-num-panel'
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'id' => 'article-num-img',
						'src' => $getState -> genNextURL(NULL, 0, 'image/book.png')
					)
				),
				new DOM(
					'p',
					array(
						'id' => 'article-num',
						'class' => 'right-num'
					),
					$target
				)
			)
		);
		return $articleNum;
	}

	public function genButtomImg(){
		global $getState;
		$img = new DOM(
			'div',
			array(
				'id' => 'below-blow'
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'id' => 'buttom-img',
						'src' => $getState -> genNextURL(NULL, 0, 'image/profile-buttom.jpg')
					)
				)
			)
		);
		return $img;
	}

	public function genRight(){
		global $getState;
		$right = new DOM(
			'div',
			array(
				'id' => 'profile-right'
			),
			NULL,
			array(
				$this -> genEmail(),
				new DOM(
					'div',
					array(
						'id' => 'below-email'
					),
					NULL,
					array(
						$this -> genGoodNum(),
						$this -> genFollow(),
						$this -> genArticleNum()
					)
				),
				new DOM(
					'div',
					array(
						'id' => 'below-below-email'
					),
					NULL,
					array(
						$this -> genButtomImg()
					)
				)
			)
		);
		return $right;
	}

	public function genControl(){
		global $getState, $user;
		$control = new DOM(
			'div',
			array(
				'id' => 'control-panel'
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'id' => 'close',
						'src' => $getState -> genNextURL(NULL, 0, 'image/switch.png')
					)
				),
				$user -> userName == $this -> inner['userName'] ? new DOM(
					'img',
					array(
						'id' => 'edit',
						'src' => $getState -> genNextURL(NULL, 0, 'image/pencil.png')
					)
				) : NULL
			)
		);
		return $control;
	}

	public function genProfile(){
		$dom = new DOM(
			'div',
			array(
				'class' => 'profile-background'
			),
			NULL,
			array(
				$this -> genLeft(),
				$this -> genRight(),
				$this -> genControl()
			)
		);
		return $dom;
	}


	private function deal($str){
		$ret = strlen($str) == 0 ? 'NULL' : "\"$str\"";
		return $ret;
	}

	private function end_with_error($str){
		ob_end_clean();
		header('Location: ./sad-panda.php?sentence=' . $str);
		exit('end_with_erro');
	}

	private function nick_name_valid_check(){
		if(strlen($_POST['nickName']) > 20){
			$this -> end_with_error('昵称过长');
			return false;
		}
		return true;
	}

	private function email_valid_check(){
		if(strlen($_POST['email']) > 255){
			$this -> end_with_error("邮箱不能超过255");
			return false;
		}
		if(!preg_match("/^[_0-9a-zA-Z]+@[_0-9a-zA-Z]+\.[a-zA-Z]+$/", $_POST['email'])){
			$this -> end_with_error("您的邮箱的格式不正确");
			return false;
		}

		global $db;
		$info = $db -> query(
			"select email " .
			"from UserMeta " .
			"where email = '" . $_POST['email'] . "'
			and userName <> '". $this -> inner['userName'] . "'"
		);
		if($info -> num_rows != 0){
			$this -> end_with_error("这个邮箱已经被别人使用过了");
			return false;
		}

		return true;
	}

	private function sex_valid_check(){
		if(strlen($_POST['sex']) > 1){
			$this -> end_with_error('性别字符串长度不合适');
			return false;
		}
		return true;
	}

	private function check_info_valid(){
		if(!$this -> nick_name_valid_check()) return false;
		if(!$this -> email_valid_check()) return false;
		if(!$this -> sex_valid_check()) return false;
		return true;
	}

	public function modifyProfile(){
		global $db;
		if(!$this -> check_info_valid()) {
			exit('check_info_valid');
		}
		$info = $db -> query(
			"select password from User
			where userName = '" . $this -> inner['userName'] . "'"
		);
		$info -> data_seek(0);
		$row = $info -> fetch_assoc();
		if(!password_verify($_POST['password'], $row['password'])){
			ob_end_clean();
			header('Location: ./sad-panda.php?sentence=密码错误');
			return; 
		}

		if(!$db -> query(
			"update UserMeta set
			nickName = " . $this -> deal($_POST['nickName']) . ",
			photo = " . $this -> deal($_POST['photo']) . ",
			email = " . $this -> deal($_POST['email']) . ",
			sex = " . $this -> deal($_POST['sex']) . "
			where userName = '" . $this -> inner['userName'] . "'"
		)){
			exit('mysql dump');
		}
		ob_end_clean();
		header('Location: ./profile.php');
	}
}
