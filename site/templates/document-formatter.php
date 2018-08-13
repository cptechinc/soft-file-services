<?php
	// Create and setup formatter
	$requestmethod = strtolower($input->requestMethod()); // get | post
	$formatter = $page->formatterfactory->generate_formatter($page->name);
    
    if ($requestmethod == 'post') {
        $formatter->generate_formatterfrominput($input);
        $action = $input->post->text('action');
        
        switch ($action) {
            case 'save-formatter':
				$maxid = get_maxtableformatterid($user->loginid, $formatter->type);
				$page->body = $formatter->save_andrespond();
				include ("./_json.php");
				break;
			case 'preview':
				$formatter->set_userid('preview');
				$page->body = $formatter->save_andrespond();
				include ("./_json.php");
				break;
        }
    } else {
		$page->body = $config->paths->content."formatters/forms/edit-formatter.php";
        include ("./_include-page.php");
    }
