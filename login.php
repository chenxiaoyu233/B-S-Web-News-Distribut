<?php
require_once('setting.php');
define('TITLE', 'Chenxiaoyu\'s Web News -- 登陆');
include('header.php');

?>


<link rel="stylesheet" href="./css/login.css">
<div class = "content-login">

<?php

// 用户登出
if( $_SERVER['REQUEST_METHOD'] == 'GET') {
   if( $_GET['action'] == 'logout' ){
	  session_start();
	  $_SESSION['user-name'] = '';
	  session_write_close();
	  header('Location ./index.php');
   }
}

//用户登入
$user -> login();

?>

   <form action="./login.php" method="post" class="login">
		<div class="form-content">
		   用户名
		</div>
   		<div class="form-content">
   		   <input type="text" name="user-name" id="user-name">
   		</div>
   		<div class="form-content">
   		   密码
   		</div>
   		<div class="form-content">
   		   <input type="password" name="password" id="password">
   		</div>
		<div class="form-content">
		   <input type="submit" name="submit" value="Login" id="submit-button">
   		</div>
   </form>

</div>
	
<?php
include('footer.php');
?>

<?php ob_end_flush(); //将缓冲类容发送至浏览器并关闭缓冲?>
