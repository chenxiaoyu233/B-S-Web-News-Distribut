<!DOCTYPE html>
<html lang="en">

   <head>
	  <meta charset="UTF-8">
	  <title><?php print TITLE; ?></title>
	  <link rel="stylesheet" href="./css/style.css">
   </head>

   <body>
	  <div class="author-mark">
		 <img src="./image/welcome.png" alt="" srcset="" width="60px" height="60px" id="welcome-pic">
	  </div>

	  <nav class="head">
		 <div class="head-function">
			<a href="./login.php" class="login">登陆</a>
			<a href="./signup.php" class="login">注册</a>
			<a href="" class="login">撰写</a>

			<!-- 用户相关下拉菜单 -->
			<?php if ($user -> userName != NULL): ?>
			<a href="./profile.php" class="profile">
			   嗨, <?php echo $user -> userName; ?> 
			</a> 
			<div class="profile-hover-down">
			   <img src="./image/welcome.png" alt="" srcset="" width="60px" height="60px" id="user-photo">
			   <ul>
				  <li> <a href="./profile.php"> 个人中心 </a> </li>
				  <li> <a href="./login.php?action=logout"> 登出 </a> </li>
			   </ul>
			</div>
			<?php endif; ?>

		 </div>

		 <!-- 标题-->
		 <div id = "h2" >
			<h2>Chenxiaoyu's News Distribution</h2>
		 </div>
		 <script src="./script/adjust-head.js"></script>

		 <!-- -->
		 <div id="links">
			<a class="title-content">主页</a>
			<a class="title-content">目录</a>
		 </div>
	  </nav>
	  <script src="./script/author.js"></script>
