<?= Library_i18n::get('spritecomics.gallery.comments.helpers.description') ?>
<form action="<?= $view->base_url; ?>spritecomics/comment" method="post">
	<input type="hidden" name="id_file" value="<?= $view->id_file; ?>" />
	<textarea name="content"></textarea>
	<input type="submit" value="<?= Library_i18n::get('spritecomics.gallery.comments.send') ?>" />
</form>
<?php if(empty($view->comments)): ?>
	<?= Library_i18n::get('spritecomics.gallery.comments.none') ?>
<?php else: ?>
	<?php foreach($view->comments as $key=>$comment): ?>
		<br />
		<?php if($view->can_remove || $view->current_member->equals($comment->getUser())): ?>
			<form action="<?= $view->base_url; ?>spritecomics/delete/comment" method="post" class="delete">
				<input type="hidden" name="__method__" value="delete" />
				<input type="hidden" name="id" value="<?= $comment->getId(); ?>" />
				<button onclick="return confirm('<?= Library_i18n::get('spritecomics.delete.comment.confirm'); ?>');"><i class="fa fa-trash"></i></button>
			</form> | 
		<?php endif; ?>
		<?= Library_i18n::get('spritecomics.gallery.comments.by') . ' <b><a href="' . $view->base_url . 'profile/' . $comment->getUser()->getId() . '">' . $comment->getUser()->prop('username') . '</a></b> : ' . $comment->prop('content') ?>
	<?php endforeach; ?>
<?php endif; ?>