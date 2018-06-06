<?php
require_once('setting.php');
define('TITLE', 'Chenxiaoyu\'s Web News -- profile');
include('header.php');

//$userMeta = new UserMeta($user -> userName);
$userName = $user -> userName;
if(isset($_GET['userName'])){
	$userName = $_GET['userName'];
}
$userMeta = new UserMeta($userName);

?>
<link rel="stylesheet" href="./css/profile.css">
<link rel="stylesheet" href="./css/modify-profile.css">
<?php

if($_GET['action'] == 'modify'){
	$userMeta -> modifyProfile();
}

echo $userMeta -> genProfile() -> toString();
?>

<div id="modify-panel">
	<?php echo $userMeta -> genPhoto('modify-photo-panel', 'modify-photo') -> toString(); ?>
	<form action="profile.php?action=modify" method="POST">
		<input type="text" name='photo' id="m-materialID">
		<input type="text" name='nickName' id="m-nickName">
		<input type="text" name='sex' id="m-sex" maxlength="1">
		<input type="text" name='email' id="m-email">
		<input type="password" name='password' id="password">
		<input type="submit" name='submit' id="submit">
	</form>
</div>

<?php
if(!isset($_GET['page'])){
	$_GET['page'] = 1;
}
$subpage = $_GET['page'];

$page = new Page();
echo $page -> genPageController() -> toString();

$pusher = new Pusher($subpage);
echo $pusher -> genPush(
	"select articleID
	 from Article natural join Manuscript
	 where userName = '" . $userName . "'",
	"<p>他的投稿</p>"
) -> toString();

?>




<script src="script/profile-control.js"> </script>
<script src="script/modify-photo.js"> </script>
<?php
include('footer.php');
?>
