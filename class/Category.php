<?php

class Category{
	public $categoryName;
	public $article;
	public function __construct($categoryName){
		$this -> categoryName = $categoryName;
		$this -> article = NULL;
	}

	//在生成分类目录的时候为特定的文章属于的目录添加新的class属性
	public function setArticleConstraint($articleID){
		$this -> article = new Article();
		$this -> article -> articleID = $articleID;
		$this -> article -> complete_info_from_database();
	}

	private function isSatisfyArticleConstraint($categoryName){
		if($categoryName == 'NULL' || $categoryName == 'null') return false;
		global $db;
		$info = $db -> query(
			"select * from Belong
			 where articleID = '" . $this -> article -> articleID . "'
			 and categoryName = '" . $categoryName . "'"
		);

		if($info -> num_rows == 0) return false;
		else return true;
	}

	public function genThisCategory($mainCssClass, $needAddButton, $categoryName){
		global $getState, $user;
		$dom = new DOM(
			'div',
			array(
				'class' => $mainCssClass . ($this -> isSatisfyArticleConstraint($categoryName) ? ' marked-category' : NULL)
			),
			NULL,
			array(
				new DOM(
					'img',
					array(
						'class' => 'fold-img',
						'src' => $getState -> genNextURL(NULL, 0, 'image/fold.png')
					)
				),
				new DOM(
					'a',
					array(
						'class' => 'category-link',
						 'href' => $getState -> genNextURL(array('categoryName' => $categoryName), 0, 'index.php')
					),
					$categoryName == 'NULL' ? '目录' : $categoryName
				),
				$needAddButton && ($user -> permission == 'root' || $user -> permission == 'admin') ? new DOM(
					'img',
					array(
						'class' => 'add-category-button',
						'src' => $getState -> genNextURL(NULL, 0, 'image/add.png')
					)
				) : NULL,
				$needAddButton && ($user -> permission == 'root' || $user -> permission == 'admin') ? new DOM(
					'img',
					array(
						'class' => 'remove-category-button',
						'src' => $getState -> genNextURL(NULL, 0, 'image/remove.png')
					)
				) : NULL
			)
		);
		return $dom;
	}


	private function deal($str){
		$ret = 'is NULL';
		if($str != 'NULL' && $str != 'null'){
			$ret = " = '" . $str . "'";
		}
		return $ret;
	}

	public function genCategoryPanel($mainCssClass = 'category-card', $needAddButton = 1, $categoryName = 'NULL', $isRoot = true){
		global $db, $getState;
		$info = $db -> query(
			"select categoryName from Category
			 where fatherCategory " . $this -> deal($categoryName)
		);
		$dom = new DOM(
			'div',
			array(
				'class' => 'category-container' . ($isRoot ? '-root' : ''),
				'data-cur-height' => "0",
				'data-fold' => 'fold'
			),
			NULL,
			array(
				$this -> genThisCategory($mainCssClass, $needAddButton, $categoryName)
			)
		);
		for($i = 0; $i < $info -> num_rows; $i++){
			$info -> data_seek($i);
			$row = $info -> fetch_assoc();
			$dom -> appendChildNode(
				$this -> genCategoryPanel($mainCssClass, $needAddButton, $row['categoryName'], false)
			);
		}
		return $dom;
	}

	private function addQuotes($str){
		if($str != 'NULL' && $str != 'null'){
			$str = "'" . $str . "'";
		}
		return $str;
	}

	public function addCategory($categoryName, $fatherCategory){
		global $db;
		$db -> query(
			"insert into Category values (
			'" . $categoryName . "', " . $this -> addQuotes($fatherCategory) . ")"
		);
	}

	public function removeCategory($categoryName){
		global $db;
		$info = $db -> query(
			"delete from Category
			 where categoryName = '" . $categoryName . "'"
		); // 这里$categoryName 显然不可能是NULL.
	}

}
