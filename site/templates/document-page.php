<?php
    use Dplus\FileServices\UploadedFile;
    use Dplus\FileServices\PDFMaker;
    
    $config->styles->remove(hash_templatefile('styles/bootstrap.min.css'));
    $config->styles->append(hash_templatefile('styles/bootstrap3.min.css'));
    
    $requestmethod = strtolower($input->requestMethod()); // get | post
    $filename = $input->$requestmethod->text('file');
    
    if (UploadedFile::json_exists($filename) || $input->$requestmethod->debug) {
        $uploadedfile = UploadedFile::create_fromuploadedfile($filename);
        $formatter = $page->formatterfactory->get_formatter_from_filename($filename);
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
    		$page->body .= $page->htmlwriter->openandclose('p', '', $page->htmlwriter->generate_printlink($url->getUrl(), 'View Printable Version'));
    	}
    	
    	if (file_exists($formatter->get_filepath())) {
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
    		$pdfmaker = new PDFMaker($uploadedfile->filename, $formatter->datafilename, $url->getUrl());
    		$pdfmaker->add_pagenumber();
    		$pdfmaker->process();
    	}
    } else {
        $page->body = "File Does Not Exist";
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
