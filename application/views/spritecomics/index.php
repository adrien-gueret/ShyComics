<h2><?= Library_i18n::get('spritecomics.index.title'); ?></h2>
<p><?= Library_i18n::get('spritecomics.index.desc'); ?></p>
<form action="<?= $view->base_url; ?>search" method="post">
	<fieldset>
		<legend><i class="fa fa-search"></i></legend>
		<div  class="group-inputs">
			<input type="search" name="search" id="nav-search"/>
			<input type="submit" value="<?= Library_i18n::get('spritecomics.index.submit'); ?>" />
		</div>
	</fieldset>
</form>