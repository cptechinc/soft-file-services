<div id="yt-menu" class="row">
	<div class="col-xs-12">
		<?php if ($user->loggedin) : ?>

		<?php else : ?>
			<br>
		<?php endif; ?>
		<nav>
			<ul class="nav list-unstyled">
				<li> <a href="#"><?= $appconfig->company_displayname; ?></a> </li>
				<li> <a href="<?= $config->pages->index; ?>"><i class="glyphicon glyphicon-home"></i> Home</a> </li>

				<?php if ($user->loggedin) : ?>
					<li class="logout">
						<a href="<?= $config->pages->account; ?>redir/?action=logout" class="logout">
							<span class="glyphicon glyphicon-log-out"></span> Logout
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>
    </div>
</div>
