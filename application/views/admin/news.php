<h2><?= Library_i18n::get('admin.index.news'); ?></h2>
<a href="<?= $view->base_url; ?>admin/users"><?= Library_i18n::get('admin.users.return'); ?></a>
<p>
	<form action="<?= $view->base_url; ?>admin/news" method="post">
		<fieldset>
			<p>
				<input type="hidden" name="__method__" value="update" />
				<textarea name="news"><?= $view->news; ?></textarea>
			</p>
			<button><i class="fa fa-check"></i></button>
		</fieldset>
	</form>
</p>