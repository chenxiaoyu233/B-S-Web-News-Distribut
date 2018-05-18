<?php
    define('TITLE', 'Chenxiaoyu\'s Web News');
	require('setting.php');
    include('header.php');
?>
<script>
   console.log('<?php 
	  session_start();
	  echo $user -> permission;
	  session_write_close();
   ?>');
</script>
<?php
    include('footer.php');
?>
