<?php

class User {
   public $userName;
   public $permission;
   private $password;

   function __construct() {
	  $userName = NULL;
	  $permission = NULL;
	  $password = NULL;
   }

   private function print_error_message($message){
	  $head = <<<'HEAD'
	  <div class = "error">
	  <img src="./image/sadpanda.jpg" alt="sadpanda" class="sadpanda">
	  <p>
HEAD;
	  $tail = <<<'TAIL'
	  </p>
	  </div>
TAIL;
	  print $head . $message . $tail;
   }
   public function check_login_info(){
	  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		 return false;
	  }
	  if(empty($_POST['user-name'])){
		 $this -> print_error_message("请输入账号");
		 return false;
	  }
	  if(empty($_POST['password'])){
		 $this -> print_error_message("请输入密码");
		 return false;
	  }
	  //检验用户名和密码
	  global $db;
	  $info = $db -> query(
		 "select * from User" .
		 "where userName = " . $_POST['user-name']
	  );
	  if($info -> num_rows == 0){
		 $this -> print_error_message("用户不存在");
		 return false;
	  }
	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();
	  if(!password_verify($_POST['password'], $row['password'])) {
		 $this -> print_error_message("密码错误");
		 return false;
	  }
	  return true;
   }
   public function login(){
	  if( !$this -> check_login_info() ) {
		 return; //登陆失败
	  }

	  //登陆成功
	  //登陆之后记录信息 -> TODO : 需要实现一个接口用于发送cookie之类的东西
	  ob_end_clean();
	  header('Location: ./index.php');
   }

   private function checkEmailValid(){
	  if(strlen($_POST['email']) > 255){
		 $this -> print_error_message("邮箱不能超过255");
		 return false;
	  }
	  if(!preg_match("/^[_0-9a-zA-Z]+@[_0-9a-zA-Z]+\.[a-zA-Z]+$/", $_POST['email'])){
		 $this -> print_error_message("您的邮箱的格式不正确");
		 return false;
	  }

	  global $db;
	  $info = $db -> query(
		 "select email" .
		 "from UserMeta" .
		 "where email = " . $_POST['email']
	  );
	  if($info -> num_rows != 0){
		 $this -> print_error_message("这个邮箱已经被别人使用过了");
		 return false;
	  }

	  return true;
   }
   private function checkUserNameValid(){
	  if(strlen($_POST['user-name']) > 20){
		 $this -> print_error_message("用户名不能超过20个字符");
		 return false;
	  }
	  if(!preg_match("/^[_0-9a-zA-Z]{1,20}$/", $_POST['user-name'])){
		 $this -> print_error_message("您使用了非法的字符");
		 return false;
	  }
	  //判断用户名是否已经用过
	  global $db;
	  $info = $db -> query(
		 "select userName" . 
		 "from User" . 
		 "where userName = " . $_POST['user-name']
	  );
	  if($info -> num_rows != 0) {
		 $this -> print_error_message("用户名已存在");
		 return false;
	  }
	  return true;
   }
   private function checkPasswordValid(){
	  if(strlen($_POST['password']) > 50){
		 $this -> print_error_message("密码不能超过50个字符");
		 return false;
	  }
	  //密码中不需要判断非法字符, 因为密码中的非法字符不会对网页的运行有影响
	  return true;
   }

   private function check_register_info(){
	  if($_SERVER['REQUEST_METHOD'] != 'POST') {
		 return false;
	  }
	  if(empty($_POST['email'])){
		 $this -> print_error_message("请输入您的邮箱");
		 return false;
	  }
	  if(!$this -> checkEmailValid()){
		 return false;
	  }
	  if(empty($_POST['user-name'])){
		 $this -> print_error_message("请输入账号");
		 return false;
	  }
	  if(!$this -> checkUserNameValid()){
		 return false;
	  }
	  if(empty($_POST['password'])){
		 $this -> print_error_message("请输入密码");
		 return false;
	  }
	  if(empty($_POST['confirm-password'])){
		 $this -> print_error_message("请确认您的密码");
		 return false;
	  }
	  if(!$this -> checkPasswordValid()){
		 return false;
	  }
	  if($_POST['confirm-password'] != $_POST['password']){
		 $this -> print_error_message("两次密码不一致");
		 return false;
	  }
	  return true;
   }

   public function register(){
	  if( !$this -> check_register_info()){
		 return; //注册失败
	  }

	  //需要给用户发送cookie, 用于之后的验证 -> TODO
	  $activeKey = bin2hex(random_bytes(100));
	  ob_end_clean();
	  header('Location: ./index.php');
   }
}
