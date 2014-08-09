<?php
	//Require framework core
	require_once 'system/Core.class.php';
	
	//Init core
	//\Eliya\Core::init();

	define('PROJECT_ROOT', __DIR__.DIRECTORY_SEPARATOR);

	$system_path	=	PROJECT_ROOT.'system';

	foreach(new \DirectoryIterator($system_path) as $file)
	{
		if( ! $file->isDot() && ! $file->isDir() && $file->getExtension() === 'php')
			echo '<p>',$file->getPathname(),'</p>';
	}

	//Handle received request
	//$request	=	new \Eliya\Request($_SERVER['REQUEST_URI']);
	//$request->exec()->response()->render();