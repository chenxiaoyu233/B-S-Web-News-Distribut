<?php
define('TITLE', 'Chenxiaoyu\'s Web News -- 登陆');
include('header.php');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}
?>

<link rel="stylesheet" href="./css/login.css">
<div class = "content">
    <form action="login.php" method="post">
        用户名: <input type="text" name="user-name" id="user-name">
    </form>
</div>

<?php
include('footer.php');
?>
