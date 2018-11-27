<?php
	session_start();
	
	if( isset($_GET['c']) )
		$controller_name = $_GET['c'];
	else
		$controller_name = 'home';
	
	$file = 'controllers/'.strtolower($controller_name).'.php';
	if ( !file_exists($file) )
		exit('Invalid controller.');
	
	include_once $file;
	
	if ( isset($_GET['e']) )
		$event = $_GET['e'];
	else
		$event = 'start';
	
	$controller = new $controller_name();
	
	if ( !method_exists($controller, $event) )
		exit('Invalid event.');
	
	$controller->$event();
?>
