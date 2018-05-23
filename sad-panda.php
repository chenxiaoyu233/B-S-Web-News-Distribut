<?php
define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');
?>

<div class="sadpanda">
   <img src="./image/sadpanda.jpg" alt="sadpanda" id="sadpanda">
   <?php if(isset($_GET['sentence'])): ?>
	  <p> <?php echo $_GET['sentence']; ?> </p>
   <?php endif; ?>
</div>
<style>
   div.sadpanda {
		 position: absolute;
		 top: 30%;
		 left: 0px;
		 right: 0px;
		 margin-left: auto;
		 margin-right: auto;
		 text-align: center;
		 background-color: rgba(0, 0, 0, 50%);
		 color: white;
		 padding: 30px;
   }
   img#sadpanda {
		 left: auto;
		 right: auto;
   }
</style>

<?php
include('footer.php');
?>
