<?php

class Page {
	public $curPage; //当前所在的页数
	public function __construct(){
		if(!isset($_GET['page'])) $this -> curPage = 1;
		$this -> curPage = $_GET['page'];
	}

	public function genController($kind, $at){
		if(at < 0) return NULL;
		global $getState;
		$dom = new DOM(
			'a',
			array(
				'class' => $kind . '-control',
				'href' => $getState -> genNextURL(
					array(
						'page' => $at
					),
					1
				)
			),
			NULL,
			array(
				new DOM(
					'div',
					array(
						'class' => 'control-button-' . $kind
					)
				)
			)
		);
		return $dom;
	}

	public function genPageController(){
		$dom = new DOM(
			'div',
			array(
				'class' => 'page-control-background'
			),
			NULL,
			array(
				$this -> curPage > 1 ? $this -> genController('left', $this -> curPage - 1) : NULL,
				$this -> genController('right', $this -> curPage + 1)
			)
		);
		return $dom;
	}
};
