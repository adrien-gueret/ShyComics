<?php if( ! $view->has_followed): ?>
	<a href="<?= $view->base_url; ?>profile/follow/<?= $view->user_id; ?>"><button class="orange"><?= Library_i18n::get('profile.follow.buttonFollow'); ?></button></a>
<?php else: ?>
	<a href="<?= $view->base_url; ?>profile/follow/unfollow<?= $view->user_id; ?>"><button class="orange"><?= Library_i18n::get('profile.follow.buttonUnfollow'); ?></button></a>
<?php endif; ?>