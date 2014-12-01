<?php if(!empty($view->user_id)): ?>
	<?php if(isset($view->file)): ?>
		<img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $view->file->prop('id')); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?php elseif(isset($view->user_files)): ?>
		<?php foreach($view->user_files as $key => $file) : ?>
			<?php if($file->prop('is_dir') == 1): ?>
			<br /><a href="<?= $view->base_url . 'spritecomics/gallery/file?id_file=' . $file->prop('id') ?>"><img src="<?= $view->base_url; ?>public/images/file.png" class="galleryFile" alt="Dossier" /></a>
			<?= $file->prop('name'); ?>
			<?php else: ?>
			<br /><a href="<?= $view->base_url . 'spritecomics/gallery/file?id_file=' . $file->prop('id') ?>"><img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $file->prop('id')); ?>" alt="<?= $file->prop('name'); ?>" title="<?= $file->prop('name'); ?>" /></a>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>
<?php if(isset($view->infos_message)): ?>
	<?= $view->infos_message; ?>
<?php endif; ?>