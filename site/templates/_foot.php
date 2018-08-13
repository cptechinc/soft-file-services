		<br>
		<div class="container hidden-print">
			<div class="float-right">
				<a id="back-to-top-button" href="#" class="btn btn-success float-right back-to-top" role="button">
					<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
					<span class="sr-only">Go back to the top</span>
				</a>
			</div>
		</div>
		<?php include ('./_ajax-modal.php'); ?>
		<footer class="hidden-print">
			<div class="container">
				<p> Web Development by CPTech &copy; <?= date('Y'); ?> --------- <?= session_id(); ?> --- </p>
				<p class="d-none d-sm-block d-md-none d-lg-none d-xl-none"> SM </p>
				<p class="d-none d-md-block d-lg-none d-xl-none"> MD </p> 
				<p class="d-none d-lg-block d-xl-none"> LG </p>
				<p class="d-none d-xl-block"> XL </p>
			</div>
		</footer>
		<?php foreach($config->scripts->unique() as $script) : ?>
			<script src="<?= $script; ?>"></script>
		<?php endforeach; ?>
	</body>
</html>
