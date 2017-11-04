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
                <!--<ul>
                    <li>
                        <?php if($view->current_member->isConnected()): ?>
                            <?= Library_i18n::get('index.header.welcome_name', $view->current_member->prop('username')); ?> &bull;
                            <a href="<?= $view->base_url; ?>profile" title="<?= Library_i18n::get('index.header.my_profile'); ?>">
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
                    <li>
                        <form action="<?= $view->base_url; ?>search" method="post">
                            <input type="search" name="search" id="nav-search"/>
                            <input type="hidden" name="search_files" value="on" />
                            <input type="hidden" name="search_dirs" value="on" />
                            <input type="hidden" name="search_users" value="on" /> 
                        </form>
                    </li>
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
                </ul>-->
            </div>
        </nav>
		<!--<nav>
			<ul>
				<?php if($view->current_member->isConnected()): ?>
					<li>
						<a href="<?= $view->base_url; ?>spritecomics/gallery" class="leftnav_button" title="<?= Library_i18n::get('index.header.navigation.helpers.gallery'); ?>">
							<i class="fa fa-picture-o" aria-hidden="true"></i>
						</a>
					</li>
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
				<?php if($view->current_member->can(Model_UsersGroups::PERM_ACCESS_ADMIN_PANEL)) : ?>
					<li>
						<hr />
						<a href="<?= $view->base_url; ?>admin" class="leftnav_button" title="<?= Library_i18n::get('index.header.navigation.helpers.admin'); ?>">
							<i class="fa fa-desktop"></i>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>-->
		<header>
			<div>
                <!--<?php if(! $view->current_member->isConnected()): ?>
                    <div>
                        <a href="<?= $view->base_url; ?>login/register">
                            <?= Library_i18n::get('index.header.register_yourself') ;?>
                        </a>
                    </div>
                <?php endif; ?>-->
                Bandeau
            </div>
		</header>
		<section>
			<div class="main-container">
				<?= Library_Messages::display(); ?>