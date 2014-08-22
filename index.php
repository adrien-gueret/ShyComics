<?php
	//Require framework core
	require_once 'system/Core.class.php';
	
	//Init core
	\Eliya\Core::init();
	
	//Activate the session
	session_start();

	//Init DB
	require_once 'application/vendors/EntityPHP/EntityPHP.php';

	$sql	=	\Eliya\Config('main')->SQL;

	try
	{
		if( ! empty($sql))
			\EntityPHP\Core::connectToDB($sql['HOST'], $sql['USER'], $sql['PASSWORD'], $sql['DATABASE']);
		else
			throw new Exception('Impossible de se connecter à la base de données : informations introuvables.');
	}
	catch(Exception $e)
	{
		$response	=	new \Eliya\Response();
		new Error_500($response->error($e->getMessage()));
		$response->render();
		exit;
	}

	//Handle received request
	$request	=	new \Eliya\Request($_SERVER['REQUEST_URI']);
	$request->exec()->response()->render();