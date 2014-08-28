<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title><?= $view->page_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?= $view->page_description; ?>" />
		<link rel="stylesheet" type="text/css" href="<?= $view->base_url; ?>public/css/style.css" />
		<link rel="shortcut icon" type="image/x-icon" href="<?= $view->base_url; ?>public/favicon.ico" />
	</head>
	<body>
		<nav>
			<img src="" alt="Accueil" title="Retour à l'accueil" />
			<ul>
				<li>
					<?php
						if(!isset($view->connected_user_username) || empty($view->connected_user_username))
							echo '<a href="' . $view->base_url . 'login/register">Inscription</a> | <a href="' . $view->base_url . 'login">Connexion</a>';
						else
							echo 'Bienvenue ' . $view->connected_user_username;
					?>
				</li>
				<li><input type="search" name="search" id="nav-search"/></li>
				<li>Sprites Comics</li>
				<li>Jeux</li>
				<li>Tutoriaux</li>
				<li>Forums</li>
				<li>Shy'Ressources</li>
				<li><img src="" alt="Facebook" title="Suivez-nous sur Facebook !" /></li>
				<li><img src="" alt="Tweeter" title="Suivez-nous sur Tweeter !" /></li>
			</ul>
		</nav>
		<nav>
			<ul>
				<li></li>
			</ul>
		</nav>
		<header>
			<div>
				<?php
					if(!isset($view->connected_user_username) || empty($view->connected_user_username))
						echo '<a href="' . $view->base_url . 'login/register">Inscrivez-vous !</a>';
				?>
			</div>
		</header>
		<section>