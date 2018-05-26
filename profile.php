<?php
require_once('setting.php');
define('TITLE', 'Chenxiaoyu\'s Web News -- profile');
include('header.php');

$userMeta = new UserMeta($user -> userName);
?>
<link rel="stylesheet" href="./css/profile.css">
<?php

echo $userMeta -> genProfile() -> toString();
include('footer.php');

?>
