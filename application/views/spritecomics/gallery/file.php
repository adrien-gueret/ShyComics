<a href="<?= $view->base_url . 'spritecomics/gallery/' . $view->parent_file ?>">Remonter la galerie</a><br />
<img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $view->file->prop('id')); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
<script src="<?= $view->base_url; ?>public/javascript/XHRRequest.js"></script>
<script src="<?= $view->base_url; ?>public/javascript/admin/XHRRemoveFile.js"></script>
<?php if(!empty($view->current_member) && ($view->current_member->prop('id') == $view->user_id || $view->current_member->prop('user_group') === 2)): ?>
	<br /><button onclick="removeFile(<?= $view->file->prop('id'); ?>, '<?= $view->base_url; ?>ajax/admin/removeFile');">Supprimer cette image</button>
<?php endif; ?>
