<!-- @TODO: improve this file -->
<div id="gallery_main">
	<img src="<?= $view->base_url . $view->file->getPath(); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?php if($view->is_own_gallery || ( ! empty($view->current_member) && $view->current_member->prop('user_group') === 2)): ?>
		<form action="<?= $view->base_url; ?>spritecomics/delete" method="post">
			<input type="hidden" name="__method__" value="delete" />
			<input type="hidden" name="id" value="<?= $view->file->prop('id'); ?>" />
			<button>Supprimer cette image</button>
		</form>
	<?php endif; ?><br />
	<?php if(!empty($view->current_member)): ?>
		<?php if( ! $view->has_liked): ?>
			<form action="<?= $view->base_url; ?>spritecomics/like" method="post">
				<input type="hidden" name="id_file" value="<?= $view->file->prop('id'); ?>" />
				<button>Liker cette image</button>
			</form>
		<?php else: ?>
			<button disabled>Image déjà likée</button>
		<?php endif; ?>
	<?php endif; ?>
</div>