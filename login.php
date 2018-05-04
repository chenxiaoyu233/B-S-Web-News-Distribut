<?php ob_start(); //输出缓冲?>

<?php
   define('TITLE', 'Chenxiaoyu\'s Web News -- 登陆');
   include('header.php');
?>


<link rel="stylesheet" href="./css/login.css">
<div class = "content">

<?php
   function check(){
	  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		 if(empty($_POST['user-name'])){
			print "<p class=\"error\">请输入账号</p>\n";
			return;
		 }
		 if(empty($_POST['password'])){
			print "<p class=\"error\">请输入密码</p>\n";
			return;
		 }
		 //检查是否登陆成功 -> 需要和数据库交互 -> TODO : 需要实现一个判断的接口 
		 ob_end_clean();
		 //登陆之后记录信息 -> TODO : 需要实现一个接口用于发送cookie之类的东西
		 header('Location: ./index.php');
	  }
   }
   check();
?>

<div class="form">
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
   		   <input type="submit" name="submit" value="Login">
   		</div>
   </form>
</div>


</div>
	
<?php
include('footer.php');
?>

<?php ob_end_flush(); //将缓冲类容发送至浏览器并关闭缓冲?>
