<?php
define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');
?>

<link rel="stylesheet" href="./css/write-article.css">
<div class="background">
   <div class="main-content">
	  <textarea id="code" name="" cols="30" rows="10"></textarea>
      <?php for($i = 1; $i <= 100; $i++): ?>
      <p> test content <?php echo $i; ?></p>
      <?php endfor; ?>
   </div>
   <div class="fill-space"> </div>
</div>

<?php
include('footer.php');
?>
