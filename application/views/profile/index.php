<h2><?= Library_i18n::get('profile.index.title', $view->user_name); ?></h2>
<p>
	<img src="<?= $view->user_avatar; ?>" alt="<?= $view->user_name; ?>" /><br />
	<?= Library_i18n::get('profile.index.sub_date') . " " . $view->user_sub_date; ?><br />
	<em><?= $view->user_about; ?></em><br />
	<a href="<?= $view->base_url; ?>spritecomics/gallery/<?= $view->user_id ?>">
		<?= Library_i18n::get('profile.index.go_to_gallery'); ?>
	</a><br />
	<?= $view->tpl_follow; ?>
	
	<?= Library_i18n::get('profile.index.follows'); ?>
	<?php foreach($view->user_follows as $key=>$followed): ?>
		<?= '<br /><img src="' . $followed->getAvatarURL() . '" alt="' . $followed->prop('username') . '" /><b>' . $followed->prop('username') . '</b> '?>
	<?php endforeach; ?>
</p>