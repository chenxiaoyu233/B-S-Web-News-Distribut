<?php
   require('config.php');
   //dataBase
   $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   if($db -> connect_errno){
	  $status = "Fail to connect to MySQL: (" . $db -> connect_errno . ") " . $db -> connect_error;
	  exit($status);
   } 

   //class_autoload_register
   spl_autoload_register(function ($class_name) {
	  require_once("./class/" . $class_name . '.php');
   });

   //set User;
   $user = new User();
?>
