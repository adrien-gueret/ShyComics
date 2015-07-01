<?php
	// Require framework core
	require_once '../system/Core.class.php';

	// Init core
	\Eliya\Core::init();

	// Init DB
	require_once 'vendors/EntityPHP/EntityPHP.php';

	$sql	=	\Eliya\Config('main')->SQL;

	\EntityPHP\Core::connectToDB($sql['HOST'], $sql['USER'], $sql['PASSWORD'], $sql['DATABASE']);

	// Include all models files
	\Eliya\Core::requireDirContent('models');

	// Can't use \EntityPHP\Core::generateDatabase() because of foreign keys constrains...
	Model_Locales::createTable();
	Model_UsersGroups::createTable();
	Model_Users::createTable();
	Model_Files::createTable();
	Model_Comments::createTable();
	Model_Universes::createTable();
	Model_Genres::createTable();

	/*== Create data ==*/

	// Locales
	$locales	=	[
		new Model_Locales('fr_FR'),
		new Model_Locales('en_US')
	];
	Model_Locales::addMultiple($locales);

	// Users groups
	$groups	=	[
		new Model_UsersGroups('Anonyme', [
			Model_UsersGroups::PERM_REMOVE_OTHERS_FILES	=>	0,
		]),
		new Model_UsersGroups('Membre simple', [
			Model_UsersGroups::PERM_REMOVE_OTHERS_FILES	=>	0,
		]),
		new Model_UsersGroups('Admin', [
			Model_UsersGroups::PERM_REMOVE_OTHERS_FILES	=>	1,
		]),
	];

	Model_UsersGroups::addMultiple($groups);