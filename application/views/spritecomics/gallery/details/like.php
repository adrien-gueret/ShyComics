<?php if( ! $view->has_liked): ?>
	<form action="<?= $view->base_url; ?>spritecomics/like" method="post">
		<input type="hidden" name="id_file" value="<?= $view->id_file; ?>" />
		<button><i class="fa fa-thumbs-o-up"></i> <?= Library_i18n::get('spritecomics.like.like'); ?></button> <?= $view->nbr_likes; ?>
	</form>
<?php else: ?>
	<form action="<?= $view->base_url; ?>spritecomics/unlike" method="post">
		<input type="hidden" name="id_file" value="<?= $view->id_file; ?>" />
		<input type="hidden" name="__method__" value="DELETE" />
		<button><i class="fa fa-thumbs-up" aria-hidden="true"></i> <?= Library_i18n::get('spritecomics.like.unlike.unlike'); ?></button> <?= $view->nbr_likes; ?>
	</form>
<?php endif; ?>