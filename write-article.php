<?php
define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');
?>

<?php

//判断权限
if($user -> permission == 'other') {
   ob_end_clean();
   header('Location: ./sad-panda.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if(!empty($_POST['article-title']) && !empty($_POST['article-content'])) {
   }
}

?>

<link rel="stylesheet" href="./css/write-article.css">
<div class="background">
   <div class="main-content">
		 <form action="./write-article.php" method="post">
	        <h2>Title</h2>
			<p> <input id="article-title" name="article-title" ></input> </p>
	        <h2>Content</h2>
			<textarea id="article-content" name="article-content" cols="30" rows="50"></textarea>
			<input type="submit" name="submit" value="Submit" id="submit-button"> 
	     </form>
   </div>
   <div class="fill-space"> </div>
</div>

<link rel="stylesheet" href="node_modules/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="node_modules/codemirror/addon/dialog/dialog.css">
<link rel="stylesheet" href="node_modules/codemirror/theme/solarized.css">

<script src="node_modules/codemirror/lib/codemirror.js"></script>
<script src="node_modules/codemirror/addon/dialog/dialog.js"></script>
<script src="node_modules/codemirror/addon/search/searchcursor.js"></script>
<script src="node_modules/codemirror/mode/clike/clike.js"></script>
<script src="node_modules/codemirror/addon/edit/matchbrackets.js"></script>
<script src="node_modules/codemirror/keymap/vim.js"></script>
<script src="script/editor.js"> </script>



<?php
include('footer.php');
?>
