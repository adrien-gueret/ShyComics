<h2><?= Library_i18n::get('admin.users.title'); ?></h2>
<p>
	<?php foreach($view->users as $user): ?>
		<a href="<?= $view->base_url; ?>admin/users/<?= $user->getId(); ?>"><?= $user->prop('username'); ?></a><br />
	<?php endforeach; ?>
</p>