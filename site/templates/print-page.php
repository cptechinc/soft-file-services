<?php include('./_head-blank.php'); ?>
	<div class="container page print">
		<?php 
			if ($page->include)	{
				
			} else {
				echo $page->body;
			}
		?>
	</div>
<?php include('./_foot-blank.php'); // include footer markup ?>
