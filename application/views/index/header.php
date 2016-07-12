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
		<link rel="shortcut icon" type="image/x-icon" href="<?= $view->base_url; ?>public/favicon.ico" />
	</head>
	<body>
		<nav>
			<a href="<?= $view->base_url; ?>"><img src="<?= $view->base_url; ?>public/images/logo_menu.png" title="<?= Library_i18n::get('index.header.navigation.helpers.home'); ?>" /></a>
			<ul>
				<li>
					<?php if($view->current_member->isConnected()): ?>
						<?= Library_i18n::get('index.header.welcome_name', $view->current_member->prop('username')); ?> &bull;
						<a href="<?= $view->base_url; ?>profile" title="Mon profil">
							<?= Library_i18n::get('index.header.my_profile'); ?>
						</a> &bull;
						<a href="<?= $view->base_url; ?>logout?token=<?= $_SESSION['token_logout']; ?>">
							<?= Library_i18n::get('index.header.logout'); ?>
						</a>
					<?php else: ?>
						<a href="<?= $view->base_url; ?>login/register">
							<?= Library_i18n::get('index.header.register'); ?>
						</a> |
						<a href="<?= $view->base_url; ?>login">
							<?= Library_i18n::get('index.header.connect'); ?>
						</a>
					<?php endif; ?>
				</li>
				<li><form action="<?= $view->base_url; ?>search" method="post"><input type="search" name="search" id="nav-search"/></form></li>
				<li>
					<a href="<?= $view->base_url; ?>spritecomics">
						<?= Library_i18n::get('index.header.navigation.spritecomics'); ?>
					</a>
				</li>
				<li>
					<a href="http://shycomics-forum.fr">
						<?= Library_i18n::get('index.header.navigation.forum'); ?>
					</a>
				</li>
				<li>
					<a href="http://shyressources.shycomics.fr/">
						<?= Library_i18n::get('index.header.navigation.shyresources'); ?>
					</a>
				</li>
				<li>
					<a href="https://www.facebook.com/pages/ShyComics/81657339196" class="fa-stack" title="<?= Library_i18n::get('index.header.navigation.helpers.facebook'); ?>">
						<i class="fa fa-square-o fa-stack-2x"></i>
						<i class="fa fa-facebook fa-stack-1x"></i>
					</a>
				</li>
				<li>
					<a href="https://twitter.com/ShyCoOfficiel" class="fa-stack" title="<?= Library_i18n::get('index.header.navigation.helpers.twitter'); ?>">
						<i class="fa fa-square-o fa-stack-2x"></i>
						<i class="fa fa-twitter fa-stack-1x"></i>
					</a>
				</li>
			</ul>
		</nav>
		<nav>
			<ul>
				<?php if($view->current_member->isConnected()): ?>
					<li>
						<a href="<?= $view->base_url; ?>follows" class="leftnav_button" title="<?= Library_i18n::get('index.header.navigation.helpers.follows'); ?>">
							<i class="fa fa-users"></i>
						</a>
					</li>
					<li>
						<a href="<?= $view->base_url; ?>profile/modify" class="leftnav_button" title="<?= Library_i18n::get('index.header.navigation.helpers.modify'); ?>">
							<i class="fa fa-wrench"></i>
						</a>
					</li>
				<?php endif; ?>
				<li>
					<a href="<?= $view->base_url; ?>about" class="leftnav_button" title="<?= Library_i18n::get('index.header.navigation.helpers.about'); ?>">
						<i class="fa fa-question"></i>
					</a>
				</li>
			</ul>
		</nav>
		<header>
			<img src="<?= $view->base_url; ?>public/images/logo_header.png" alt="Shy'Comics" />
			<?php if(! $view->current_member->isConnected()): ?>
				<div>
					<a href="<?= $view->base_url; ?>login/register">
						<?= Library_i18n::get('index.header.register_yourself') ;?>
					</a>
				</div>
			<?php endif; ?>
		</header>
		<section>
			<div class="main-container">
				<?= Library_Messages::display(); ?>