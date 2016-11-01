<h2><?= Library_i18n::get('profile.index.title', $view->user_name); ?></h2>
<p>
	<img src="<?= $view->user_avatar; ?>" alt="<?= $view->user_name; ?>" /><br />
	<?= Library_i18n::get('profile.index.sub_date') . " " . $view->user_sub_date; ?><br />
	<em><?= $view->user_about; ?></em><br />
	<a href="<?= $view->base_url; ?>spritecomics/gallery/<?= $view->user_id ?>">
		<?= Library_i18n::get('profile.index.go_to_gallery'); ?>
	</a><br />
	<?= $view->tpl_follow; ?>
	
	<?php if(!$view->user_follows->isEmpty()): ?>
		<?= Library_i18n::get('profile.index.follows'); ?>
		<?php foreach($view->user_follows as $followed): ?>
			<?= '<a href="' . $followed->getId() . '"><img width="40px" height="40px" src="' . $followed->getAvatarURL() . '" alt="' . $followed->prop('username') . '" title="' . $followed->prop('username') . '" alt="' . $followed->prop('username') . '" /></a> '?>
		<?php endforeach; ?>
	<?php else: ?>
		<?= Library_i18n::get('profile.index.no_follows'); ?>
	<?php endif; ?>
</p>