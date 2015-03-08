<h2><?= Library_i18n::get('friends.title'); ?></h2>
<ul>
	<?php foreach($view->current_member->prop('friends') as $key => $friend) : ?>
		<li><?= $friend->prop('username') ?></li>
	<?php endforeach; ?>
</ul>