<!-- @TODO: improve this file -->
<div id="gallery_main">
	<img src="<?= $view->base_url . $view->file->getPath(); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?php if($view->is_own_gallery || ( ! empty($view->current_member) && $view->current_member->prop('user_group') === 2)): ?>
		<form action="<?= $view->base_url; ?>/spritecomics/delete" method="post">
			<input type="hidden" name="__method__" value="delete" />
			<input type="hidden" name="id" value="<?= $view->file->prop('id'); ?>" />
			<button>Supprimer cette image</button>
		</form>
	<?php endif; ?>
</div>