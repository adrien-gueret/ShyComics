<?php
	//Require framework core
	require_once 'system/Core.class.php';
	
	//Init core
	\Eliya\Core::init();

	echo PROJECT_ROOT;

	//Handle received request
	$request	=	new \Eliya\Request($_SERVER['REQUEST_URI']);
	$request->exec()->response()->render();