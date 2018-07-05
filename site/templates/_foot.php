	<br>
	<div class="container hidden-print">
		<div class="row">
			<div class="col-xs-12">
				<a id="back-to-top" href="#" class="btn btn-success back-to-top" role="button"><span class="glyphicon glyphicon-chevron-up"></span></a>
			</div>
		</div>
	</div>
	<footer class="hidden-print">
		<div class="container">
			<p> Web Development by CPTech &copy; <?= date('Y'); ?> --------- <?= session_id(); ?> --- </p>
			<p class="visible-xs-inline-block"> XS </p> <p class="visible-sm-inline-block"> SM </p>
			<p class="visible-md-inline-block"> MD </p> <p class="visible-lg-inline-block"> LG </p>
		</div>
	</footer>
	<?php foreach($config->scripts->unique() as $script) : ?>
		<script src="<?= $script; ?>"></script>
	<?php endforeach; ?>
	</body>
</html>
