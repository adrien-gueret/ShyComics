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
				<li><del>Jeux</del></li>
				<li><del>Tutoriaux</del></li>
				<li><del>Forums</del></li>
				<li><del>Shy'Ressources</del></li>
				<li><a href="#" class="social_button facebook" title="Devenez fans sur Facebook !"></a></li>
				<li><a href="#" class="social_button twitter" title="Suivez-nous sur Twitter !"></a></li>
			</ul>
		</nav>
		<nav>
			<ul>
				<li><a href="<?= $view->base_url; ?>friends" class="leftnav_button friends" title="Gérer votre liste d'amis"></a></li>
			</ul>
		</nav>
		<header>
			<img src="<?= $view->base_url; ?>public/images/logo_header.png" alt="Shy'Comics" />
			<div>
				<?php if(empty($view->current_member)): ?>
					<a href="<?= $view->base_url; ?>login/register">Inscrivez-vous !</a>
				<?php endif; ?>
			</div>
		</header>
		<section>
			<div>