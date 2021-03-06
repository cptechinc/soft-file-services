<?php
	// Create and setup formatter
	$requestmethod = strtolower($input->requestMethod()); // get | post
	$formatter = $page->formatterfactory->get_formatter($page->name);
	$formatter->set('sessionID', $input->get->text('fileID'));
	$formatter->set_userid($user->name);
	
	if ($input->get->text('preview') == 'preview') {
		$formatter->set_userid('preview');
	}
	
	// Set debug if needed
	if ($input->$requestmethod->debug || $input->$requestmethod->text('preview') == 'preview') {
		$formatter->set_debug(true);
	}
	// Get document title for page
	$page->title = $formatter->get_doctitle();
	
	// Add Print Page link if needed
	if ($config->ajax && $input->$requestmethod->text('preview') != 'preview') {
		$url = new Purl\Url($page->fullURL->getUrl());
		$url->query->set('view', 'print');
		$page->body .= $page->htmlwriter->openandclose('p', '', $page->htmlwriter->makeprintlink($url->getUrl(), 'View Printable Version'));
	}
	
	if (file_exists($formatter->fullfilepath)) {
		$formatter->process_json();
		
		if ($formatter->json['error']) {
			$page->body .= $page->htmlwriter->alertpanel('warning', $formatter->json['errormsg']);
		} else {
			$page->body .= $formatter->generate_screen();
			$page->body .= $formatter->generate_javascript();
		}
	} else {
		$page->body .= $page->htmlwriter->alertpanel('warning', 'Requested data does not exist');
	}
	
	if (!$input->get->text('view') == 'pdf') {
		$url = new Purl\Url($page->fullURL->getUrl());
		$url->query->set('view', 'pdf');
		$pdfmaker = new PDFMaker($input->get->text('fileID'), $page->name, $url->getUrl());
		$pdfmaker->add_pagenumber();
		$pdfmaker->process();
	}
?>
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
