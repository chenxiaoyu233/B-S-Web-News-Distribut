<?php

class User {
   public $userName;
   public $permission;
   public $status; // {online, offline} -> offline 需要重新登陆

   function __construct() {
	  $this -> userName = NULL;
	  $this -> permission = 'other';
	  $this -> status = 'offline';
   }
   //从$_POST设定User类型的userName和password
   private function set_userName_from_post(){
	  if($_SERVER['REQUEST_METHOD'] != 'POST') return;
	  if(!empty($_POST['user-name'])) $this -> userName = $_POST['user-name'];
   }
   private function add_session(){
	  session_start();
	  $_SESSION['user-name'] = $this -> userName;
	  session_write_close();
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
		 "select * from User " .
		 "where userName = \"" . $_POST['user-name'] . "\""
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
   public function login_with_session(){ // todo -> 给session 加上时间限制
	  session_start();
	  global $db;
	  if(!isset($_SESSION['user-name'])) {
		 session_write_close(); // 记得关闭session文件占用
		 return false;
	  }

	  $info = $db -> query(
		 "select userName, permission " .
		 "from User " . 
		 "where userName = \"" . $_SESSION['user-name'] . "\""
	  );
	  session_write_close();

	  if($info -> num_rows == 0) {
		 return false; // 用户不存在
	  }

	  //成功登陆
	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();
	  $this -> userName = $row['userName'];
	  $this -> permission = $row['permission'];
	  $this -> status = "online";
	  return true;
   }
   public function login(){
	  if( $this -> status == 'online'){
		 ob_end_clean();
		 header('Location: ./index.php');
	  }
	  if( !$this -> login_with_session() && //使用session登陆失败
		  !$this -> check_login_info() ) {  //使用账号密码登陆失败
			return; //登陆失败
		 }

	  //登陆成功(使用账号密码登陆)
	  $this -> set_userName_from_post();
	  $this -> add_session(); //登陆之后记录信息
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
		 "select email " .
		 "from UserMeta " .
		 "where email = \"" . $_POST['email'] . "\""
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
		 "select userName " . 
		 "from User " . 
		 "where userName = \"" . $_POST['user-name'] . "\""
	  ); if($info -> num_rows != 0) {
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

   private function send_verify_email($activeKey){
	  $message = "    Dear " . $this -> userName . 
	  ", you need to verify your account by clicking the " . 
	  "<a href=\"". 
	  $_SERVER['SERVER_NAME'] . "/" . SITE_ROOT .
	  "signup.php?activeKey=" . $activeKey .
	  "\">link</a>. " . "</br>\n" .
	  "Or your account will be delete within a minute.";
	  $subject = "Verify Your Account";
	  //mail($_POST['email'], $subject, $message);
	  global $mail;
	  $mail -> Subject = $subject;
	  $mail -> Body = $message;
	  $mail -> addAddress($_POST['email']);
	  $mail -> send();
   }
   public function register(){
	  if( $this -> status == 'online') {
		 ob_end_clean();
		 header('Location: ./index.php');
	  }
	  if( !$this -> check_register_info()){
		 return; //注册失败
	  }

	  //需要给用户发送cookie, 用于之后的验证 -> TODO
	  //activeKey没有和数据库中的数据判重复 -> TODO
	  $activeKey = bin2hex(random_bytes(100));
	  $this -> set_userName_from_post();
	  $this -> send_verify_email($activeKey); //先发邮件, 免得有时间问题
	  global $db;
	  $db -> query(
		 "insert into User(userName, password, permission) values " .
		 "(\"" . $_POST['user-name'] . "\", \"" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "\", \"user\")"
	  );
	  $db -> query(
		 "insert into UnActiveUser(userName, activeCode, addTime) values " . 
		 "(\"" . $_POST['user-name'] . "\", \"" . $activeKey . "\", now())"
	  );
	  $db -> query(
		 "insert into UserMeta(userName, email) values " .
		 "(\"" . $_POST['user-name'] . "\", \"" . $_POST['email'] . "\")"
	  );
	  $this -> add_session(); // 向用户发送session
	  ob_end_clean();
	  header('Location: ./index.php');
   }

   // 验证网页使用GET方法
   public function active(){ 
	  global $db;
	  $info = $db -> query(
		 "select userName " .
		 "from UnActiveUser " .
		 "where activeCode = \"" . $_GET['activeKey'] . "\""
	  );
	  if($info -> num_rows == 0){ // 不存在这个激活码(防止搞事)
		 return false;
	  }
	  $info -> data_seek(0);
	  $row = $info -> fetch_assoc();
	  $this -> userName = row['userName'];
	  $this -> add_session(); // 验证完成后保持在线

	  $db -> query(
		 "delete from UnActiveUser " . 
		 "where userName = \"" . $row['userName'] . "\""
	  );

	  ob_end_clean();
	  header('Location: ./index.php');
   }
}
