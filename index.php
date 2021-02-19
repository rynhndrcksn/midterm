<?php
// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// session start
session_start();

// require autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// define a default route (home page)
$f3->route('GET /', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/home.html');
});

// define a survey route
$f3->route('GET|POST /survey', function($f3) {

	// if the form has been submitted
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// gather info from order and validate it
		if (!empty($_POST['name'])) {
			$_SESSION['name'] = $_POST['name'];
		} else {
			$f3->set('errors["name"]', 'Name cannot be blank');
		}

		if (isset($_POST['choices'])) {
			// since our object is stored in $_SESSION, we can just set the condiments with implode
			$_SESSION['choices'] = implode(', ', $_POST['choices']);
		} else {
			// if this isn't here it keeps trying to check a box the user unchecked???
			$_SESSION['choices'] = null;
		}

		// if there are no errors, redirect to summary
		if (empty($f3->get('errors'))) {
			$f3->reroute('/summary');
		}

	}

	$f3->set('choices', getChoices());

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/survey.html');
});

// define a summary route
$f3->route('GET|POST /summary', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/summary.html');

	session_destroy();
});

$f3->run();