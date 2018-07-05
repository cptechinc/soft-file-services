<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<title><?= strip_tags(html_entity_decode($page->get('pagetitle|headline|title'))); ?></title>
        <link rel="shortcut icon" href="<?php //echo $config->urls->files."images/ddplus.ico"; ?>">

		<meta name="description" content="<?= $page->summary; ?>" />
        <?php foreach($config->styles->unique() as $css) : ?>
        	<link rel="stylesheet" type="text/css" href="<?= $css; ?>" />
        <?php endforeach; ?>
        <script src="<?= hashtemplatefile('scripts/libs/jquery.js'); ?>"></script>
	</head>
    <body class="fuelux">
		<?php include ($config->paths->content.'nav/navbar-yt.php'); ?>
        <div class="container"><?php include $config->paths->content.'nav/yt-navigation.php';?></div>

        <br>
