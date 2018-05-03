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

<form action="./login.php" method="post" class="login">
<ul class="row1">
	<li class="col1">
		用户名
	</li>
	<li class="col2">
		<input type="text" name="user-name" id="user-name">
	</li>
	<li class="col1">
		密码
	</li>
	<li class="col2">
		<input type="password" name="password" id="password">
	</li>
</ul>

<ul class="row2">
	<li class="submit">
		<input type="submit" name="submit" value="Login">
	</li>
</ul>
</form>
</div>
	
<?php
include('footer.php');
?>

<?php ob_end_flush(); //将缓冲类容发送至浏览器并关闭缓冲?>