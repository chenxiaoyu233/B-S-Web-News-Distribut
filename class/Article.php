<?php

class Article {
   public $articleID;
   public $type;
   public $articleStatus;
   public $title;
   public $time;

   public $articleContent;
   public $userName; //author

   public function __construct () {
	  $this -> articleID = NULL;
	  $this -> type = NULL;
	  $this -> articleStatus = NULL;
	  $this -> title = NULL;
	  $this -> time = NULL;

	  $this -> articleContent = NULL;
	  $this -> userName = NULL; //author
   }

   private function loadValues () {
	  $this -> title = $_POST['article-title'];
	  $this -> articleContent = $_POST['article-content'];
	  global $user;
	  $this -> userName = $user -> userName;
   }

   private function genArticleID () {
	  global $db;
	  $info = $db -> query(
		 'select UUID()'
	  );
	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();
	  $this -> articleID = $row['UUID()'];
   }

   public function newArticle() {
	  $this -> loadValues();
	  $this -> genArticleID();
	  global $db;
	  $db -> query(
	     'insert into Article values( ' . 
	     "\"{$this -> articleID}\", " . 
	     '"news", "verify", ' .
	     "\"{$this -> title}\", now())"
	  );
	  $db -> query(
		 'insert into ArticleMeta values( ' .
		 "\"{$this -> articleID}\", " . 
		 "\"" . addslashes($this -> articleContent) . "\" )"
	  );
	  $db -> query(
	     'insert into Manuscript values( ' .
	     "\"{$this -> userName}\", " . 
	     "\"{$this -> articleID}\" )"
	  );
	  ob_end_clean();
	  header('Location: ./write-article.php?action=edit&articleID=' . $this -> articleID);
   }

   public function get_articleID_from_GET() {
	  if(!isset($_GET['articleID']) || empty($_GET['articleID'])) {
		 ob_end_clean();
		 header('Location: ./sad-panda.php?sentence=没有提供文章编号');
		 return false;
	  }
	  $this -> articleID = $_GET['articleID'];
	  return true;
   }

   public function get_info_from_table_Article() {
	  global $db;
	  $info = $db -> query(
		 "select * from Article ".
		 "where articleID = \"" . $this -> articleID . "\""
	  );

	  if($info -> num_rows == 0) {
		 ob_end_clean();
		 header('Location: ./sad-panda.php?sentence=文章不存在');
		 return false; 
	  }

	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();

	  $this -> articleID = $row['articleID'];
	  $this -> type = $row['type'];
	  $this -> articleStatus = $row['articleStatus'];
	  $this -> title = $row['title'];
	  $this -> time = $row['time'];
	  return true;
   }

   public function get_info_from_table_ArticleMeta() {
	  global $db;
	  $info = $db -> query(
		 "select articleContent from ArticleMeta " .
		 "where articleID = \"" . $this -> articleID . "\""
	  );
	  if( $info -> num_rows == 0 ){
		 ob_end_clean();
		 header('Location: ./sad-panda.php?sentence=文章内容丢失');
		 return false;
	  }

	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();

	  $this -> articleContent = $row['articleContent'];
	  return true;
   }

   public function get_info_from_table_Manuscript() {
	  global $db;
	  $info = $db -> query(
		 "select userName from Manuscript " . 
		 "where articleID = \"" . $this -> articleID . "\""
	  );
	  if($info -> num_rows == 0){
		 ob_end_clean();
		 header('Location: ./sad-panda.php?sentence=文章作者信息丢失');
		 return false;
	  }
	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();
	  global $user;
	  if(isset($_GET['action']) && $_GET['action'] == 'edit' && $row['userName'] != $user -> userName && $user -> permission != 'root') {
		 ob_end_clean();
		 header('Location: ./sad-panda.php?sentence=这不是您的文章');
		 return false;
	  }

	  $this -> userName = $row['userName'];
	  return true;
   }

   public function complete_info_from_database() {
	  if(!$this -> get_info_from_table_Article()) return false;
	  if(!$this -> get_info_from_table_ArticleMeta()) return false;
	  if(!$this -> get_info_from_table_Manuscript()) return false;

	  return true;
   }

   public function openArticle() {
	  if(!$this -> get_articleID_from_GET()) return false;
	  if(!$this -> complete_info_from_database()) return false; // 获取文章信息失败
   }

   public function addBackSlash($str) {
	  $ret = '';
	  for($i = 0; $i < strlen($str); $i++) {
		 $ret = $ret . $str[$i];
		 if($str[$i] == '\\') {
		    $ret = $ret . $str[$i];
		 }
	  }
	  return $ret;
   }

   public function saveArticle() {
	  if(!$this -> get_articleID_from_GET()) return false;
	  if(!$this -> complete_info_from_database()) return false; // 获取文章信息失败
	  $this -> loadValues(); // 从post中获取当前的文章信息
	  global $db;
	  $db -> query(
		 'update Article ' .
		 'set ' .
		 'articleStatus = "verify", ' .
		 'title = "' . $this -> title . '", ' .
		 'time = now() ' .
		 'where articleID = "' . $this -> articleID . '"'
	  );

	  $db -> query(
	     'update ArticleMeta ' .
	     'set ' .
	     'articleContent = "' . addslashes($this -> articleContent) . '" ' .
	     'where articleID = "' . $this -> articleID . '"'
	  );
   }

   public function getUpVoteCount(){
	   global $db;
	   $info = $db -> query(
		   "select count(*) as tot from Collection
		   where articleID = '" . $this -> articleID . "'"
	   );
	   $info -> data_seek(0);
	   $row = $info -> fetch_assoc();
	   return $row['tot'];
   }
}

