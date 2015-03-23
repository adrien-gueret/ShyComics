<h2><?= Library_i18n::get('profile.modify.title'); ?></h2>
<p>
	<?= Library_i18n::get('profile.modify.page_description'); ?><hr /><br />
	<?= Library_i18n::get('profile.modify.avatar_actual'); ?> <img src="<?= $view->avatarURL; ?>" alt="<?= Library_i18n::get('profile.modify.avatar_actual'); ?>" /><br />
	<?= $view->tpl_form_avatar; ?>
</p>