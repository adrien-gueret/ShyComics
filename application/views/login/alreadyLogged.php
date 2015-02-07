Vous êtes connecté <?= $view->current_member->prop('username') ?> !
<a href="<?= $view->base_url; ?>logout?token=<?= $view->token_logout ?>">Se déconnecter</a>