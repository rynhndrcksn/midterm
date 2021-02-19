<?php
// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require autoload file
require_once ('vendor/autoload.php');

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// define a default route (home page)
$f3->route('GET /', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/home.html');
});

// define a default route (home page)
$f3->route('GET|POST /survey', function($f3) {
	
	$f3->set('choices', getChoices());

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/survey.html');
});
