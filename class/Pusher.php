<?php

class Pusher {
   public $articleNum;  // 该页面摆放的文章数量
   public $article; //用来加载文章
   public $subpage; //表示现在处在第几个子页面

   public function __construct() {
	  $this -> articleNum = 10; // 默认一个页面上面放置10篇文章
	  $this -> article = new Article();
	  $this -> subpage = 1; // 默认在第一页
   }

   public function genPreviewOfPage($articleID) {
	  // get article info
	  $this -> article = new Article();
	  $this -> article -> articleID = $articleID;
	  $this -> article -> complete_info_from_database();
	  global $page;

	  echo "\n"; // 断行
	  $title = $page -> genTagFromArray('h2', $this -> article -> title, array(
		 'class' => 'tag-title'
	  ), '    ');
	  $content = $this -> article -> articleContent;
	  $footer = $page -> genTagFromArray('div', 
		 $this -> article -> userName . ' ' . $this -> article -> time . ' ' . $this -> article -> upVoteCount,
		 array(
			'class' => 'tag-info'
		 ), '    '
	  );

	  $tag = $page -> genTagFromArray('div', $title . $content . $footer, array(
		 'class' => 'tab-background'
	  ), '       ');
	  echo $tag;
   }

   public function set_info_from_GET() {
	  //TODO :: 封装一个Geter类用于传递GET信息
   }

   public function genPush() {
	  //$this -> set_info_from_GET();
	  echo <<<'TAG'
	  <link rel="stylesheet" href="./css/pusher.css">
	  <div class="pusher-background">
TAG;

	  $startPos = ($this -> subpage - 1) * ($this -> articleNum);
	  global $db;
	  $info = $db -> query(
		 "select articleID from Article " .
		 "where type = 'news' " .
		 "order by time desc"
	  );

	  for($i = $startPos; $i < $info -> num_rows; $i++){
		 $info -> data_seek($i);
		 $row = $info -> fetch_assoc();
		 $this -> genPreviewOfPage($row['articleID']);
	  }
	  echo <<<'TAG'
	  </div>
TAG;
   }
}
