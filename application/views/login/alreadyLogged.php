Vous êtes connecté <?= $_SESSION['connected_user_username']; ?> !
<a href="<?= $view->base_url; ?>logout?token=<?= $_SESSION['token_logout'] ?>">Se déconnecter</a>