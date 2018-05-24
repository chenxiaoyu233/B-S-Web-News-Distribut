<?php

define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');

$pusher = new Pusher();
echo $pusher -> genPush() -> toString();

include('footer.php');
?>
