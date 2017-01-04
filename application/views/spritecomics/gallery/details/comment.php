<?php if($view->can_post): ?>
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
<?php endif; ?>
<?php if(empty($view->comments)): ?>
	<?= Library_i18n::get('spritecomics.gallery.comments.none') ?>
<?php else: ?>
	<?php foreach($view->comments as $key=>$comment): ?>
		<br />
		<?php if($view->can_remove || $view->current_member->equals($comment->getUser())): ?>
			<form action="<?= $view->base_url; ?>spritecomics/delete/comment" method="post" class="moderation">
				<input type="hidden" name="__method__" value="delete" />
				<input type="hidden" name="id" value="<?= $comment->getId(); ?>" />
				<button onclick="return confirm('<?= Library_i18n::get('spritecomics.delete.comment.confirm'); ?>');"><i class="fa fa-trash"></i></button>
				<button onclick="turnCommentIntoForm(<?= $comment->getId(); ?>, '<?= $view->base_url; ?>', '<?= htmlspecialchars($comment->prop('content'), ENT_QUOTES); ?>'); return false;"><i class="fa fa-pencil-square-o"></i></button>
			</form> | 
		<?php endif; ?>
		<?= Library_i18n::get('spritecomics.gallery.comments.by') . ' <b><a href="' . $view->base_url . 'profile/' . $comment->getUser()->getId() . '">' . $comment->getUser()->prop('username') . '</a></b> : <div id="comment' . $comment->getId() . '" class="commentDiv">' . $comment->prop('content'); ?></div>
	<?php endforeach; ?>
<?php endif; ?>