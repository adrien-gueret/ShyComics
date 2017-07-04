<?php
    require_once 'vendor/entityphp/entityphp/src/EntityPHP.php';

	//Require framework core
	require_once 'system/Core.class.php';
	
	//Init core
	\Eliya\Core::init();
	
	//Activate the session
	session_start();

	$sql	=	\Eliya\Config('main')->SQL;

	//Handle received request
	$request		=	new \Eliya\Request($_SERVER['REQUEST_URI']);
	$current_url	=	$request->getProtocol().'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	if(substr($current_url, -1) !== '/')
		$current_url	.=	'/';

	\Eliya\Tpl::set([
		'page_title'				=>	Library_i18n::get('global.default_page_title'),
		'page_description'			=>	Library_i18n::get('global.default_page_description'),
		'base_url'					=>	$request->getBaseURL(),
		'current_url'				=>	$current_url,
	]);

	$response	=	$request->response();

	try
	{
		if( ! empty($sql))
			\EntityPHP\Core::connectToDB($sql['HOST'], $sql['USER'], $sql['PASSWORD'], $sql['DATABASE']);
		else
			throw new Exception(Library_i18n::get('global.db_connection_error'));

		$request->exec();
	}
	catch(Exception $e)
	{
		ob_clean();
		$response->set(null)->error($e->getMessage(), 500);
	}

	$response->render();