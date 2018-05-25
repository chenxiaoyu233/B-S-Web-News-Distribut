<?php

require_once('setting.php');

class Pusher {
   public $articleNum;  // 该页面摆放的文章数量
   public $article; //用来加载文章
   public $subpage; //表示现在处在第几个子页面
   public $page; //页面生成

   public function __construct() {
	  $this -> articleNum = 10; // 默认一个页面上面放置10篇文章
	  $this -> article = new Article();
	  $this -> subpage = 1; // 默认在第一页
	  $this -> page = new Page();
   }

   public function genPreviewTitle(){
	  global $page;
	  $title = new DOM(
		 'h2', 
		 array(
			'class' => 'tag-title'
		 ),
		 $this -> article -> title
	  );
	  return $title;
   }

   public function genPreviewContent(){
	  $content= new DOM(
		 'p',
		 array(
			'class' => 'content'
		 ),
		 $this -> article -> articleContent
	  );
	  return $content;
   }

   public function genPreviewFooter(){
	  global $page, $user, $getState;
	  $footer = new DOM(
		 'div',
		 array(
			'class' => 'tag-info'
		 ),
		 NULL,
		 array(
			new DOM (
			   'a',
			   array(
				  'class' => 'tag-link'
			   ),
			   $this -> article -> userName
			),
			new DOM (
			   'a',
			   array(
				  'class' => 'tag-link'
			   ),
			   $this -> article -> time
			),
			new DOM (
			   'a',
			   array(
				  'class' => 'tag-link'
			   ),
			   $this -> article -> upVoteCount
		   ),
			$this -> article -> userName != $user -> userName ? NULL :
			new DOM (
				'a',
				array (
					'class' => 'tag-link',
					'href' => $getState -> genNextURL(
						array(
							'action' => 'edit',
							'articleID' => $this -> article -> articleID
						),
						0,
						'write-article.php'
					)
				),
				'edit'
			)
		 )
	  );
	  return $footer;
   }

   public function genPreviewOfPage($articleID) {
	  // get article info
	  $this -> article = new Article();
	  $this -> article -> articleID = $articleID;
	  $this -> article -> complete_info_from_database();
	  global $page;

	  $tag = new DOM(
		 'div',
		 array(
			'class' => 'tag-background'
		 ),
		 NULL,
		 array(
			$this -> genPreviewTitle(),
			$this -> genPreviewContent(),
			$this -> genPreviewFooter()
		 )
	  );

	  return $tag;
   }

   public function set_info_from_GET() {
	  //TODO :: 封装一个Geter类用于传递GET信息
   }

   public function genPush($query = 
		 "select articleID from Article " .
		 "where type = 'news' " .
		 "order by time desc"
   ) {
	  //$this -> set_info_from_GET();
	  echo <<<'TAG'
	  <link rel="stylesheet" href="./css/pusher.css">
TAG;
	  $dom = new DOM('div', array('class' => 'pusher-background'));

	  $startPos = ($this -> subpage - 1) * ($this -> articleNum);
	  global $db;
	  $info = $db -> query($query);

	  for($i = $startPos; $i < $info -> num_rows; $i++){
		 $info -> data_seek($i);
		 $row = $info -> fetch_assoc();
		 $dom -> appendChildNode($this -> genPreviewOfPage($row['articleID']));
	  }

	  return $dom;
   }
}

