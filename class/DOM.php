<?php

class DOM {
	public $tag; // string
	public $property; // array
	public $content; // string
	public $son; // array
	public $indent;

	public function __construct($tag = NULL, $property = NULL, $content = NULL, $son = NULL,  $indent = '    ') {
		$this -> tag = $tag;
		$this -> property = $property;
		$this -> content = $content;
		$this -> son = $son;
		$this -> indent = $indent;
	}

	public function setTag($tag) {
		$this -> tag = $tag;
	}

	public function setProperty($property) {
		$this -> property = $property;
	}

	public function appendProperty($key, $val) { // 如果本来就有key的话, 就变成了修改
		if($this -> property == NULL) {
			$this -> property = array($key => $val);
			return;
		}
		$this -> property[$key] = $val;
	}

	public function genFullTag() {
		$tag = $this -> tag;
		$prop = $this -> property;

		$ret = "<$tag";
		if($prop != NULL) {
			foreach($prop as $key => $val){
				$ret = $ret . ' ' . $key . '="' . $val . '"';
			}
		}
		$ret = $ret . ">";
		return $ret;
	}

	public function addFather($tag = NULL, $property = NULL) {
		$father = new DOM($tag, $property);
		$father -> son[] = $this;
		return $father;
	}

	public function appendChildNode($node) {
		$this -> son[] = $node;
	}

	public function nodeCatChild($other) {
		if($this -> tag != NULL || $other -> tag != NULL) return false;
		foreach($other -> son as $key => $value){
			$this -> son[] = $value;
		}
	}

	public function toString($indent = '') {
		$ret = '';
		if($this -> tag != NULL || $this -> content != NULL){
			$ret = $ret . $indent .  $this -> genFullTag() . $this -> content . "\n";
		}
		if($this-> son != NULL){
			foreach($this -> son as $key => $val){
				if($val == NULL) continue;
				$ret = $ret . $val -> toString($indent . $this -> indent);
			}
		}
		if($this -> tag != NULL){
			$ret = $ret . $indent . "</{$this -> tag}>\n";
		}
		return $ret;
	}

}

