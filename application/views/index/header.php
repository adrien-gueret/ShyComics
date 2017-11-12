<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title><?= $view->page_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?= $view->page_description; ?>" />
		<?= isset($view->social_NW_meta) ? $view->social_NW_meta : ''; ?>
		<link rel="stylesheet" type="text/css" href="<?= $view->base_url; ?>public/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?= $view->base_url; ?>public/css/font-awesome.min.css" />
		<!--<?= isset($view->additional_style) ? $view->additional_style : ''; ?>-->
		<link rel="shortcut icon" type="image/x-icon" href="<?= $view->base_url; ?>public/favicon.ico" />
	</head>
	<body>
		<nav>
			<div>
                <a href="<?= $view->base_url; ?>"><img src="<?= $view->base_url; ?>public/images/logoWhite.svg" alt="Shy'Comics" title="<?= Library_i18n::get('index.header.navigation.helpers.home'); ?>" /></a>
            </div>
        </nav>
		<header>
			<div>
                Bandeau
            </div>
		</header>
		<section>
			<div class="main-container">
				<?= Library_Messages::display(); ?>