<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title><?= strip_tags(html_entity_decode($page->get('pagetitle|headline|title'))); ?></title>
		<link rel="shortcut icon" href="<?php //echo $config->urls->files."images/ddplus.ico"; ?>">
		<meta name="description" content="<?= $page->summary; ?>" />
		<?php foreach($config->styles->unique() as $css) : ?>
			<link rel="stylesheet" type="text/css" href="<?= $css; ?>" />
		<?php endforeach; ?>
	</head>
	<body class="fuelux">
		<nav class="navbar navbar-expand-md navbar-light bg-light">
			<a class="navbar-brand" href="#">
				<img src="<?= $appconfig->dplusicon->url; ?>" width="30" height="30" class="d-inline-block align-top" alt="">
				File Services
			</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= $pages->get('/')->url; ?>"><?= $pages->get('/')->title; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
					<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="<?= $pages->get('/formatters/')->url; ?>" id="<?= $pages->get('/formatters/')->name; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $pages->get('/formatters/')->title; ?></a>
                        <div class="dropdown-menu" aria-labelledby="<?= $pages->get('/formatters/')->name; ?>">
							<?php foreach ($pages->get('/formatters/')->children() as $child) : ?>
								<a class="dropdown-item" href="<?= $child->url; ?>"><?= $child->title; ?></a>
							<?php endforeach; ?>
                        </div>
                    </li>
					<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="<?= $pages->get('/convert/')->url; ?>" id="<?= $pages->get('/convert/')->name; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $pages->get('/convert/')->title; ?></a>
                        <div class="dropdown-menu" aria-labelledby="<?= $pages->get('/convert/')->name; ?>">
							<?php foreach ($pages->get('/convert/')->children() as $child) : ?>
								<a class="dropdown-item" href="<?= $child->url; ?>"><?= $child->title; ?></a>
							<?php endforeach; ?>
                        </div>
                    </li>
                </ul>
                
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" placeholder="Search" aria-label="Search" type="text">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
