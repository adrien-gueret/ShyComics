<h2><?= Library_i18n::get('follows.title'); ?></h2>
<ul>
	<?php foreach($view->current_member->prop('follows') as $key => $follow) : ?>
		<li><?= $follow->prop('username') ?></li>
	<?php endforeach; ?>
</ul>