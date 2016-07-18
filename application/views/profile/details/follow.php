<?php if( ! $view->has_followed): ?>
	<form action="<?= $view->base_url; ?>profile/follow/<?= $view->user_id; ?>" method="post"><button type="submit" class="orange"><?= Library_i18n::get('profile.follow.buttonFollow'); ?></button></form>
<?php else: ?>
	<form action="<?= $view->base_url; ?>profile/follow/unfollow/<?= $view->user_id; ?>" method="post">
		<input type="hidden" name="__method__" value="DELETE" />
		<button type="submit" class="orange"><?= Library_i18n::get('profile.follow.buttonUnfollow'); ?></button>
	</form>
<?php endif; ?>