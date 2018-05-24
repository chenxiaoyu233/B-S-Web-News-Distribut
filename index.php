<?php

define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');

$pusher = new Pusher();
$pusher -> genPush();

include('footer.php');
