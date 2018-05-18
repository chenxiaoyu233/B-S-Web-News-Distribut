<?php
require_once('setting.php');
define('TITLE', 'Chenxiaoyu\'s Web News -- 注册');
include('header.php');
?>

<link rel="stylesheet" href="./css/login.css">
<div class="content">

<?php
//处理验证邮件 
if($_SERVER['REQUEST_METHOD'] == "GET"){
   if(!isset($_GET['activeKey'])){
	  $user -> active();
   }
}

//处理注册
$user -> register();
?>

    <form action="./signup.php" method="post" class="signup">
		<div class="form-content">
		   电子邮箱
		</div>
   		<div class="form-content">
   		   <input type="text" name="email" id="email">
   		</div>
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
		   确认密码
   		</div>
   		<div class="form-content">
   		   <input type="password" name="confirm-password" id="confirm-password">
   		</div>
		<div class="form-content">
		   <input type="submit" name="submit" value="Sign Up" id="submit-button" style="width:60px;height:60px;">
   		</div>
    </form>
</div>

<?php
include('footer.php');
?>
