<h2><?= Library_i18n::get('spritecomics.index.title'); ?></h2>
<p><?= Library_i18n::get('spritecomics.index.desc'); ?></p>
<form action="<?= $view->base_url; ?>search" method="post">
	<fieldset>
		<legend><i class="fa fa-search"></i></legend>
		<div  class="group-inputs">
			<input type="search" name="search" id="nav-search"/>
			<input type="submit" value="<?= Library_i18n::get('spritecomics.index.submit'); ?>" /><hr />
            <?= Library_i18n::get('search.pages'); ?><input type="checkbox" name="search_files" checked="checked" />
            <?= Library_i18n::get('search.dirs'); ?><input type="checkbox" name="search_dirs" checked="checked" />
            <?= Library_i18n::get('search.users'); ?><input type="checkbox" name="search_users" checked="checked" />
		</div>
	</fieldset>
</form>