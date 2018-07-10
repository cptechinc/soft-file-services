<?php

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

include_once($config->paths->vendor."cptechinc/dplus-base/vendor/autoload.php");
include_once($config->paths->vendor."cptechinc/dplus-processwire/vendor/autoload.php");
include_once($config->paths->vendor."cptechinc/dplus-content/vendor/autoload.php");
include_once($config->paths->vendor."cptechinc/dplus-order-classes/vendor/autoload.php");
include_once($config->paths->vendor."cptechinc/dplus-print-screen-formatters/vendor/autoload.php");

$page->stringerbell = new StringerBell();
$page->htmlwriter = new HTMLWriter();

$config->styles->append(hashtemplatefile('styles/bootstrap.min.css'));
$config->styles->append(hashtemplatefile('styles/libs/libraries.css'));
$config->styles->append(hashtemplatefile('styles/styles.css'));

$config->scripts->append(hashtemplatefile('scripts/libs/libraries.js'));
$config->scripts->append(hashtemplatefile('scripts/scripts.js'));

$appconfig = $pages->get('/config/');

$page->formatterfactory = new PrintFormatterFactory(session_id());
TableScreenMaker::set_filedirectory($config->jsonfilepath);
TableScreenMaker::set_testdatafiledirectory($config->paths->vendor."cptechinc/dplus-print-screen-formatters/examples/");
TableScreenMaker::set_fieldfiledirectory($config->paths->vendor."cptechinc/dplus-print-screen-formatters/field-definition/");
TableScreenFormatter::set_defaultformatterfiledirectory($config->paths->vendor."cptechinc/dplus-print-screen-formatters/default/");

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
