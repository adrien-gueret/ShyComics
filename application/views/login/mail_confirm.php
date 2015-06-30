<p><?= Library_i18n::get('login.mail_confirm.message', ['pseudo' => $view->pseudo, 'password' => $view->password]); ?></p>
<p>
	<a href="<?= $view->url_confirm; ?>"><?= $view->url_confirm; ?></a>
</p>