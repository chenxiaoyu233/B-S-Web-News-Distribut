<?php

// 对 $_GET 中的值进行状态机建模
class GETstate {
   public $nextBaseState;
   public $curState;
   public $curUrl;
   public $siteRoot;

   public function __construct() {
	  $this -> curState = isset($_GET) ? $_GET : NULL;
	  $this -> nextBaseState = array();
	  $this -> curUrl = $_SERVER['SCRIPT_NAME'];
	  $this -> siteRoot = '/';
	  if(defined('SITE_ROOT') && defined('SERVER_URL')){
		  $this -> siteRoot = 'http://' . SERVER_URL . SITE_ROOT;
	  }
   }

   public function addBaseState($key, $val) {
	  $this -> nextBaseState[$key] = $val;
   }

   public function genNextURL($newState = NULL, $mergeFlag = 0, $newUrl = NULL) {
	  $submitState = $this -> nextBaseState;
	  if($mergeFlag) foreach($this -> curState as $key => $val) $submitState[$key] = $val;
	  if($newState != NULL) foreach($newState as $key => $val) $submitState[$key] = $val;
	  $ret = $newUrl != NULL ? $this -> siteRoot . $newUrl : $this -> curUrl;
	  $ret = $ret . '?';
	  foreach($submitState as $key => $val){
		  $ret = $ret . '&' . $key . '=' . $val;
	  }
	  return $ret;
   }
}

