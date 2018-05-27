<?php

class Comment{
	public $article;
	public function __construct($articleID){
		$this -> article = new Article();
		$this -> article -> articleID = $articleID;
		$this -> article -> complete_info_from_database();
	}
	public function genComment($isRoot, $fatherTitle = NULL){
		global $db;
		$pusher = new Pusher(1, 1, false);
		$title = $fatherTitle == NULL ? NULL : '<h2 class="commentHeader">RE: ' . $fatherTitle . "</h2>";
		$dmclass = 'pusher-background';
		$dmid = $isRoot ? 'pusher-background' : NULL;
		$dom = $pusher -> genPush(
			"select '" . $this -> article -> articleID . "' as articleID",
			$title,
			$dmclass,
			$dmid
		);
		global $getState;
		$subCommentStarter = new DOM(
			'h2',
			array(
				'class' => 'subCommentStarter'
			),
			NULL,
			array(
				new DOM(
					'a',
					array(
						'class' => 'add-comment-link',
						'href' => $getState -> genNextURL(
							array(
								'type' => 'comment',
								'target' => $this -> article -> articleID,
								'action' => 'comment'
							),
							0,
							'write-article.php'
						)
					),
					'add a comment'
				)
			)
		);
		$info = $db -> query(
			"select commentID
			from Comment natural join Article
			where articleID = '" . $this -> article -> articleID . "'
			order by time asc" 
		);
		$dom -> appendChildNode($subCommentStarter);
		for($i = 0; $i < $info -> num_rows; $i++){
			$info -> data_seek(i);
			$row = $info -> fetch_assoc();
			$newComment = new Comment($row['commentID']);
			$dom -> appendChildNode($newComment -> genComment(false, $this -> article -> title));
		}
		return $dom;
	}
}
