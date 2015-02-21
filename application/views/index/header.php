<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title><?= $view->page_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?= $view->page_description; ?>" />
		<link rel="stylesheet" type="text/css" href="<?= $view->base_url; ?>public/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?= $view->base_url; ?>public/css/font-awesome.min.css" />
		<link rel="shortcut icon" type="image/x-icon" href="<?= $view->base_url; ?>public/favicon.ico" />
	</head>
	<body>
		<nav>
			<a href="<?= $view->base_url; ?>"><img src="<?= $view->base_url; ?>public/images/logo_menu.png" alt="Accueil" title="Shy'Comics" /></a>
			<ul>
				<li>
					<?php if(empty($view->current_member)): ?>
						<a href="<?= $view->base_url; ?>login/register">Inscription</a> | <a href="<?= $view->base_url; ?>login">Connexion</a>
					<?php else: ?>
						Bienvenue <?= $view->current_member->prop('username'); ?> &bull; <a href="<?= $view->base_url; ?>profile" title="Mon profil">Mon profil</a> &bull; <a href="<?= $view->base_url; ?>logout?token=<?= $_SESSION['token_logout']; ?>">Me déconnecter</a>
					<?php endif; ?>
				</li>
				<li><input type="search" name="search" id="nav-search"/></li>
				<li><a href="<?= $view->base_url; ?>spritecomics">Sprites Comics</a></li>
				<li><a href="http://shycomics-forum.fr">Forum</a></li>
				<li><a href="http://shyressources.shycomics.fr/">Shy'Ressources</a></li>
				<li>
					<a href="https://www.facebook.com/pages/ShyComics/81657339196" class="fa-stack" title="Devenez fans sur Facebook !">
						<i class="fa fa-square-o fa-stack-2x"></i>
						<i class="fa fa-facebook fa-stack-1x"></i>
					</a>
				</li>
				<li>
					<a href="https://twitter.com/ShyCoOfficiel" class="fa-stack" title="Suivez-nous sur Twitter !">
						<i class="fa fa-square-o fa-stack-2x"></i>
						<i class="fa fa-twitter fa-stack-1x"></i>
					</a>
				</li>
			</ul>
		</nav>
		<nav>
			<ul>
				<?php if( ! empty($view->current_member)): ?>
					<li>
						<a href="<?= $view->base_url; ?>friends" class="leftnav_button" title="Gérer votre liste d'amis">
							<i class="fa fa-users"></i>
						</a>
					</li>
				<?php endif; ?>
				<li>
					<a href="<?= $view->base_url; ?>about" class="leftnav_button" title="A propos">
						<i class="fa fa-question"></i>
					</a>
				</li>

			</ul>
		</nav>
		<header>
			<img src="<?= $view->base_url; ?>public/images/logo_header.png" alt="Shy'Comics" />
			<?php if(empty($view->current_member)): ?>
				<div><a href="<?= $view->base_url; ?>login/register">Inscrivez-vous !</a></div>
			<?php endif; ?>
		</header>
		<section>
			<div class="main-container">
				<?= Library_Messages::display(); ?>