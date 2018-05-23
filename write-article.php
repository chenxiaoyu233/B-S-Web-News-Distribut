<?php
define('TITLE', 'Chenxiaoyu\'s Web News');
require('setting.php');
include('header.php');
?>

<?php

//判断权限
if($user -> permission == 'other') {
   ob_end_clean();
   header('Location: ./sad-panda.php?sentence=你可能忘记了登陆');
}

// 获取用户操作类型
$action = 'new'; // default
if(!empty($_GET['action'])) {
   $action = $_GET['action'];
}

if($action == 'edit') {
   $article -> openArticle();
}

// save article
if(!empty($_POST['article-title']) && !empty($_POST['article-content'])) {
   if($action == 'edit') {
	  $article -> saveArticle();
   }
}

// new article
if(!empty($_POST['article-title']) && !empty($_POST['article-content'])) {
   if($action == 'new') {
	  $article -> newArticle();
   }
}

?>

<link rel="stylesheet" href="./css/write-article.css">
<div class="background">
   <div class="main-content">
	  	<?php if($action == 'new'): ?>
		 <form action="./write-article.php<?php echo '?action=new'; ?>" method="post">
		 <?php elseif ($action == 'edit'): ?>
		<form action="./write-article.php<?php echo '?action=edit&articleID=' . $article -> articleID; ?>" method="post">
		<?php endif; ?>
	        <h2>Title</h2>
			<p> <input id="article-title" name="article-title" value="<?php echo $article -> title; ?>"></input> </p>
	        <h2>Content</h2>
			<textarea id="article-content" name="article-content"><?php echo $article -> articleContent; ?> </textarea>
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
<!-- <script src="node_modules/codemirror/mode/clike/clike.js"></script> -->
<script src="node_modules/codemirror/mode/markdown/markdown.js"></script>
<script src="node_modules/codemirror/addon/edit/matchbrackets.js"></script>
<script src="node_modules/codemirror/keymap/vim.js"></script>
<script src="script/editor.js"> </script>

<!-- 当没有初始类容的时候,为了美观,在编辑器内添加一些空行 -->
<?php if ($article -> articleContent == NULL): ?>
   <script>
      for( var i = 1; i <= 19; i ++ ) {
      myArticleContentCode.execCommand('newlineAndIndent');
      myArticleContentCode.execCommand('goDocStart');
      }
   </script>
<?php endif; ?>


<?php
include('footer.php');
?>
