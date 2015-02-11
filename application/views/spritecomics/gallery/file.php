<a href="<?= $view->base_url . 'spritecomics/gallery/' . $view->parent_url ?>">Remonter la galerie</a><br />
<div id="gallery_main">
	<img src="<?= $view->base_url . $view->file->getPath(); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?php if(!empty($view->current_member) && ($view->current_member->prop('id') == $view->user_id || $view->current_member->prop('user_group') === 2)): ?>
		<br /><button onclick="removeFile(<?= $view->file->prop('id'); ?>, '<?= $view->base_url; ?>ajax/admin/removeFile');">Supprimer cette image</button>
	<?php endif; ?>
</div>
<script src="<?= $view->base_url; ?>public/javascript/XHRRequest.js"></script>
<script src="<?= $view->base_url; ?>public/javascript/admin/XHRRemoveFile.js"></script>