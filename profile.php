<?php
require_once('setting.php');
define('TITLE', 'Chenxiaoyu\'s Web News -- profile');
include('header.php');

$userMeta = new UserMeta($user -> userName);
?>
<link rel="stylesheet" href="./css/profile.css">
<?php

echo $userMeta -> genProfile() -> toString();

$pusher = new Pusher();
echo $pusher -> genPush(
	"select articleID
	 from Article natural join Manuscript
	 where userName = '" . $user -> userName . "'",
	"<p>他的投稿</p>"
) -> toString();

?>
<script src="script/profile-control.js"> </script>
<?php
include('footer.php');
?>
