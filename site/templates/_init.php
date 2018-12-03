<?php
	use Dplus\Base\ScreenMaker;
	use Dplus\Base\ScreenMakerFormatter;
	use Dplus\Base\StringerBell;
	use Dplus\Content\HTMLWriter;
	use Dplus\PrintFormatters\PrintFormatterFactory;
	
	/**
	 * Initialization file for template files 
	 * 
	 * This file is automatically included as a result of $config->prependTemplateFile
	 * option specified in your /site/config.php. 
	 * 
	 * You can initialize anything you want to here. In the case of this beginner profile,
	 * we are using it just to include another file with shared functions.
	 *
	 */

	include_once("./_func.php"); // include our shared functions
	include_once("./_dbfunc.php"); // include our shared functions

	// include_once($config->paths->vendor."cptechinc/dplus-base/vendor/autoload.php");
	// include_once($config->paths->vendor."cptechinc/dplus-processwire/vendor/autoload.php");
	// include_once($config->paths->vendor."cptechinc/dplus-content/vendor/autoload.php");
	// 
	// include_once($config->paths->vendor."cptechinc/dplus-file-services/vendor/autoload.php");

	//include_once($config->paths->vendor."cptechinc/dplus-print-screen-formatters/vendor/autoload.php");

	$page->stringerbell = new StringerBell();
	$page->htmlwriter = new HTMLWriter();

	$config->styles->append(hash_templatefile('styles/bootstrap.min.css'));
	$config->styles->append(hash_templatefile('styles/libs/font-awesome.min.css'));
	$config->styles->append(hash_templatefile('styles/styles.css'));

	$config->scripts->append(hash_templatefile('scripts/libs/jquery.js'));
	$config->scripts->append(hash_templatefile('scripts/libs/popper.js'));
	$config->scripts->append(hash_templatefile('scripts/libs/bootstrap.min.js'));
	$config->scripts->append(hash_templatefile('scripts/libs/bootstrap-notify.min.js'));
	$config->scripts->append(hash_templatefile('scripts/scripts.js'));

	$appconfig = $pages->get('/config/');

	$config->COMPANYNBR = $input->get->company ? $input->get->int('company') : $config->COMPANYNBR;
	$config->companyfiles = "/var/www/html/data$config->COMPANYNBR/";
	$config->jsonfilepath = "/var/www/html/files/json$config->COMPANYNBR/";

	$page->formatterfactory = new PrintFormatterFactory(session_id());
	ScreenMaker::set_filedirectory($config->jsonfilepath);
	ScreenMaker::set_testdatafiledirectory($config->paths->vendor."cptechinc/dplus-print-screen-formatters/examples/");
	ScreenMaker::set_fieldfiledirectory($config->paths->vendor."cptechinc/dplus-print-screen-formatters/field-definition/");
	ScreenMakerFormatter::set_defaultformatterfiledirectory($config->paths->vendor."cptechinc/dplus-print-screen-formatters/default/");

	$page->fullURL = new \Purl\Url($page->httpUrl);
	$page->fullURL->path = '';

	if (!empty($config->filename) && $config->filename != '/') {
		$page->fullURL->join($config->filename);
	}

	if ($input->get->modal) {
		$config->modal = true;
	}

	if ($input->get->json) {
		$config->json = true;
	}
