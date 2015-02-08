<?php if(!empty($view->user_id)): ?>
	<?php if(isset($view->file)): ?>
		<div id="gallery_main">
			<img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $view->file->prop('id')); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
			<script src="<?= $view->base_url; ?>public/javascript/XHRRequest.js"></script>
			<script src="<?= $view->base_url; ?>public/javascript/admin/XHRRemoveFile.js"></script>
			<?php if(!empty($view->current_member) && ($view->current_member->prop('id') == $view->user_id || $view->current_member->prop('user_group') === 2)): ?>
				<br /><button onclick="removeFile(<?= $view->file->prop('id'); ?>, '<?= $view->base_url; ?>ajax/admin/removeFile');">Supprimer cette image</button>
			<?php endif; ?>
		</div>
	<?php elseif(isset($view->user_files)): ?>
		<?php if(!empty($view->user_files)): ?>
			<?php foreach($view->user_files as $key => $file) : ?>
				<?php if($file->prop('is_dir') == 1): ?>
				<br /><a href="<?= $view->base_url . 'spritecomics/gallery/file/' . $file->prop('id') ?>"><img src="<?= $view->base_url; ?>public/images/file.png" class="galleryFile" alt="Dossier" /></a>
				<?= $file->prop('name'); ?>
				<?php else: ?>
				<br /><a href="<?= $view->base_url . 'spritecomics/gallery/file/' . $file->prop('id') ?>"><img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $file->prop('id')); ?>" alt="<?= $file->prop('name'); ?>" title="<?= $file->prop('name'); ?>" /></a>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else: ?>
			Ce dossier ne contient aucun fichier.
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
<div id="infos_message">
	<?php if(isset($view->infos_message)): ?>
		<?= $view->infos_message; ?>
	<?php endif; ?>
</div>
