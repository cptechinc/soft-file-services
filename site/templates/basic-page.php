<?php include('./_head.php'); ?>
	<div class="jumbotron pagetitle">
		<div class="container">
			<h1><?= $page->get('pagetitle|headline|title') ; ?></h1>
		</div>
	</div>
	<div class="container page">
		<?php echo $page->body; ?>
	</div>
<?php include('./_foot.php'); // include footer markup ?>
