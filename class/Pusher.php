<?php

require_once('setting.php');

class Pusher {
	public $articleNum;  // 该页面摆放的文章数量
	public $article; //用来加载文章
	public $subpage; //表示现在处在第几个子页面
	public $genShort;
	public $genShortLength;

	public function __construct($articleNum = 10, $subpage = 1, $genShort = true, $genShortLength = 500) {
		$this -> articleNum = $articleNum; // 默认一个页面上面放置10篇文章
		$this -> article = new Article();
		$this -> subpage = $subpage; // 默认在第一页
		$this -> genShort = $genShort;
		$this -> genShortLength = $genShortLength;
	}

	public function genPreviewTitle(){
		global $getState;
		$title = new DOM(
			'h2', 
			array(
				'class' => 'tag-title'
			),
			NULL,
			array(
				new DOM(
					'a',
					array(
						'href' => $getState -> genNextURL(
							array(
								'articleID' => $this -> article -> articleID
							),
							0,
							'index.php'
						)
					),
					$this -> article -> title
				)
			)
		);
		return $title;
	}

	public function genPreviewContent(){
		$tail = '';
		if(strlen($this -> article -> articleContent) > $this -> genShortLength) 
			$tail = " \n### ......";
		$target = substr($this -> article -> articleContent, 0, $this -> genShortLength) . $tail;
		$content= new DOM(
			'p',
			array(
				'class' => 'content'
			),
			$this -> genShort ? $target : $this -> article -> articleContent
		);
		return $content;
	}

	public function genFollow(){
		global $db, $user, $getState;
		$info = $db -> query(
			"select * from Follow
			 where followerID = '" . $user -> userName . "'
		     and beFollowerID = '" . $this -> article -> userName . "'"
		);
		$target = 'image/follow.png';
		if($info -> num_rows == 0) {
			$target = 'image/follow2.png';
		}
		$follow = new DOM(
			'table',
			array(
				'class' => 'tag-panel'
			),
			NULL,
			array(
				new DOM(
					'tr',
					NULL,
					NULL,
					array(
						new DOM(
							'td',
							NULL,
							NULL,
							array(
								new DOM (
									'img',
									array(
										'class' => 'follow-pic',
										'alt' => $this -> article -> userName,
										'src' => $getState -> genNextURL(NULL, 0, $target)
									),
									NULL
								)
							)
						),
						new DOM(
							'td',
							NULL,
							NULL,
							array(
								new DOM (
									'a',
									array(
										'class' => 'tag-link'
									),
									$this -> article -> userName
								)
							)
						)
					)
				)
			)
		);
		return $follow;
	}

	public function genVote(){
		global $db, $user, $getState;
		$info = $db -> query(
			"select * from Collection
			where userName = '" . $user -> userName ."'
			and articleID = '" . $this -> article -> articleID . "'"
		);
		$target = 'image/upvote.png';
		if($info -> num_rows == 0){
			$target = 'image/upvote2.png';
		}
		$vote = new DOM(
			'table',
			array(
				'class' => 'tag-panel'
			),
			NULL,
			array(
				new DOM(
					'tr',
					NULL,
					NULL,
					array(
						new DOM(
							'td',
							NULL,
							NULL,
							array(
								new DOM(
									'img',
									array(
										'class' => 'vote-pic',
										'alt' => $this -> article -> articleID,
										'src' => $getState -> genNextURL(NULL, 0, $target)
									)
								)
							)
						),
						new DOM(
							'td',
							NULL,
							NULL,
							array(
								new DOM(
									'a',
									array(
										'class' => 'up-vote-count'
									),
									$this -> article -> getUpVoteCount()
								)
							)
						)
					)
				)
			)
		);
		return $vote;
	}

	public function genPreviewFooter(){
		global $user, $getState;
		$footer = new DOM(
			'div',
			array(
				'class' => 'tag-info'
			),
			NULL,
			array(
				$this -> genFollow(),
				new DOM (
					'a',
					array(
						'class' => 'tag-link'
					),
					$this -> article -> time
				),
				$this -> genVote(),
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

	public function genPush($query = 
		"select articleID from Article " .
		"where type = 'news' " .
		"order by time desc",
		$title = NULL,
		$dmclass = 'pusher-background',
		$dmid = 'pusher-background'
	) {
		//$this -> set_info_from_GET();
		echo <<<'TAG'
	  <link rel="stylesheet" href="./css/pusher.css">
TAG;
		$dom = new DOM('div', array(
			'class' => $dmclass,
			'id' => $dmid

		), $title);

		$startPos = ($this -> subpage - 1) * ($this -> articleNum);
		global $db;
		$info = $db -> query($query);

		for($i = 0; $i < $this -> articleNum; $i++){
			$cur = $i + $startPos;
			if($cur >= $info -> num_rows) break;

			$info -> data_seek($cur);
			$row = $info -> fetch_assoc();
			$dom -> appendChildNode($this -> genPreviewOfPage($row['articleID']));
		}
		// 给每个push都添加一段js代码, 用于点赞/关注
		$dom -> appendChildNode(new DOM(
			'script',
			array(
				'src' => 'script/upvote-follow.js'
			)
		));
		return $dom;
	}
}

