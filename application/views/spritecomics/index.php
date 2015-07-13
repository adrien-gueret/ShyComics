<h2><?= Library_i18n::get('spritecomics.index.title'); ?></h2>
<p><?= Library_i18n::get('spritecomics.index.desc'); ?></p>
<form action="<?= $view->base_url; ?>search" method="post">
	<input type="search" name="search" id="nav-search"/>
	<input type="submit" value="<?= Library_i18n::get('spritecomics.index.submit'); ?>" />
</form>