<?php include('./_head.php'); ?>
	<main role="main">
		<div class="jumbotron bg-dark text-light">
			<div class="container">
				<h1 class="display-3"><?= $page->get('pagetitle|headline|title') ; ?></h1>
			</div>
		</div>
		<div class="container page">
			<?php foreach ($page->children as $section) : ?>
	            <h3 id="<?= $section->name; ?>"><?= $section->title; ?> </h3>
	            <div class="list-group">
	                <?php foreach ($section->children as $formatter) : ?>
	                    <a href="<?= $formatter->url; ?>" class="list-group-item"><?= $formatter->title; ?></a>
	                <?php endforeach; ?>
	            </div>
	        <?php endforeach; ?>
		</div>
	</main>
<?php include('./_foot.php'); // include footer markup ?>
