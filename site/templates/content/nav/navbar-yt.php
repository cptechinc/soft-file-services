<?php
	// top navigation consists of homepage and its visible children
	$homepage = $pages->get('/');
	$children = $homepage->children();

	// make 'home' the first item in the navigation
	$children->prepend($homepage);
?>
<nav class="navbar navbar-inverse navbar-fixed-top" id="nav-yt">
	<div class="container">
		<div class="navbar-header">
			<a href="#" class=" navbar-brand yt-menu-open">
				<i class="fa fa-bars" aria-hidden="true"></i>
            </a>
			<img class="header-logo hidden-xs" id="header-logo" src="<?= $config->urls->files; ?>images/dplus.png" height="50">
			<img class="header-logo hidden-sm hidden-md hidden-lg" id="header-logo" src="<?= $config->urls->files; ?>images/dplus-short.png" height="50">
			<img src="<?= $appconfig->company_logo->url; ?>" alt="<?= $appconfig->company_displayname.' logo'; ?>" height="60" class="hidden-sm hidden-md hidden-lg pull-right">
		</div>


		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php foreach($homepage->and($homepage->children) as $item) : ?>
                	<?php if ($item->show_in_main_nav == 1) : ?>
						<?php if ($item->id == $page->rootParent->id) : ?>
                            <li class="active"><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
                        <?php else : ?>
                            <li><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
				<?php endforeach; ?>
			</ul>
            <ul class="nav navbar-nav navbar-right visible-sm-block">
				<li><img src="<?= $appconfig->company_logo->url; ?>" alt="<?= $appconfig->company_displayname.' logo'; ?>" height="60"></li>
                <li>
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    	My Account <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="separator" class="divider"></li>
						<?php if ($user->loggedin) : ?>
                            <li><a>Welcome, <?php echo $user->username; ?></a> </li>
                            <li>
                            	<a href="<?php echo $config->pages->account; ?>redir/?action=logout" class="logout"> <span class="glyphicon glyphicon-log-out"></span> Logout</a>
                            </li>
                        <?php else : ?>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right hidden-sm">
				<li><img src="<?= $appconfig->companylogo->url; ?>" alt="<?= $appconfig->company_displayname.' logo'; ?>" height="60"></li>
                <?php if ($user->loggedin) : ?>
                    <li><a>Welcome, <?php echo $user->fullname; ?></a> </li>
                    <li>
                    	<a href="<?php echo $config->pages->account; ?>redir/?action=logout" class="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                <?php endif; ?>
          	</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
