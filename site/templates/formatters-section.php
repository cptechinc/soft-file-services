<?php include('./_head.php'); ?>
	<main role="main">
		<div class="jumbotron bg-dark text-light">
			<div class="container">
				<h1 class="display-3"><?= $page->get('pagetitle|headline|title') ; ?></h1>
			</div>
		</div>
		<div class="container page">
			<div class="list-group">
				<?php foreach ($page->children as $formatter) : ?>
					<a href="<?= $formatter->url; ?>" class="list-group-item list-group-item-action flex-column align-items-start" id="<?= $formatter->name; ?>">
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1"><?= $formatter->title; ?></h5>
							<small>3 days ago</small>
						</div>
						<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
						<small>Donec id elit non mi porta.</small>
					</a>
		        <?php endforeach; ?>
			</div>
		</div>
	</main>
<?php include('./_foot.php'); // include footer markup ?>
