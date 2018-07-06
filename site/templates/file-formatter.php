<?php 
	$requestmethod = strtolower($input->requestMethod()); // get | post
	$formatter = $page->formatterfactory->generate_formatter($page->name);
	
	include $config->paths->templates.'_head-blank.php';
	echo $page->htmlwriter->open('div', 'class=container page print');
	
	if ($input->$requestmethod->debug || $input->$requestmethod->text('action') == 'preview') {
		$formatter->set_debug(true);
	}

	if ($config->ajax && $input->$requestmethod->text('action') != 'preview') {
		$url = new Purl\Url($page->fullURL->getUrl());
		$url->query->set('view', 'print');
		echo $page->htmlwriter->openandclose('p', '', $page->htmlwriter->makeprintlink($url->getUrl(), 'View Printable Version'));
	}
	echo $formatter->fullfilepath;
	if (file_exists($formatter->fullfilepath)) {
		$formatter->process_json();
		
		if ($formatter->json['error']) {
			echo $page->htmlwriter->alertpanel('warning', $formatter->json['errormsg']);
		} else {
			echo $formatter->generate_screen();
			echo $formatter->generate_javascript();
		}
	} else {
		echo $page->htmlwriter->alertpanel('warning', 'Requested data does not exist');
	}
	echo $page->htmlwriter->close('div');
	include $config->paths->templates.'_foot-blank.php';
