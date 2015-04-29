<h2><?= Library_i18n::get('profile.index.title', $view->user_name); ?></h2>
<p>
	<a href="<?= $view->base_url; ?>spritecomics/gallery/<?= $view->user_id ?>">
		<?= Library_i18n::get('profile.index.go_to_gallery'); ?>
	</a><br />
	<?= $view->tpl_follow; ?>
</p>