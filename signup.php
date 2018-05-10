<?php
    define(TITLE, 'Chenxiaoyu\'s Web News -- 注册');
    include('header.php');
?>

<link rel="stylesheet" href="./css/login.css">
<div class="content">
    <form action="./signup.php" method="post" class="signup">
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
   		   <input type="password" name="confirm-password" id="password">
   		</div>
		<div class="form-content">
		   <input type="submit" name="submit" value="Login" id="submit-button">
   		</div>
    </form>
</div>

<?php
    include('footer.php');
?>