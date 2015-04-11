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
	<?= '<br />Par <b>' . $comment->getUser()->prop('username') . '</b> : ' . $comment->prop('content') ?>
	<?php endforeach; ?>
<?php endif; ?>