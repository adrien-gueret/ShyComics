<?= Library_i18n::get('spritecomics.gallery.comments.helpers.description') ?>
<form action="<?= $view->base_url; ?>spritecomics/comment" method="post">
	<input type="hidden" name="id_file" value="<?= $view->id_file; ?>" />
	<fieldset id="form_comment_part">
		<textarea id="content-comment" name="content"></textarea>
		<p><?= $view->tpl_buttons; ?></p>
	</fieldset>
	<p><button class="orange"><?= Library_i18n::get('spritecomics.gallery.comments.send'); ?></button></p>
</form>
<script src="<?= $view->base_url; ?>public/javascript/parser.js"></script>
<?php if(empty($view->comments)): ?>
	<?= Library_i18n::get('spritecomics.gallery.comments.none') ?>
<?php else: ?>
	<?php foreach($view->comments as $key=>$comment): ?>
	<?= '<br />Par <b><a href="' . $view->base_url . 'profile/' . $comment->getUser()->getId() . '">' . $comment->getUser()->prop('username') . '</a></b> : ' . Library_Parser::parse($comment->prop('content'), $view->base_url); ?>
	<?php endforeach; ?>
<?php endif; ?>