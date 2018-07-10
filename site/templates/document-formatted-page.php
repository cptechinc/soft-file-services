<?php
	// Create and setup formatter
	$requestmethod = strtolower($input->requestMethod()); // get | post
	$formatter = $page->formatterfactory->generate_formatter($page->name);
	$formatter->set('sessionID', session_id());
	
	// Set debug if needed
	if ($input->$requestmethod->debug || $input->$requestmethod->text('action') == 'preview') {
		$formatter->set_debug(true);
	}
	// Get document title for page
	$page->title = $formatter->get_doctitle();
	
	// Add Print Page link if needed
	if ($config->ajax && $input->$requestmethod->text('action') != 'preview') {
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
