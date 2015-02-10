<a href="<?= $view->base_url . 'spritecomics/gallery/' . $view->parent_url ?>">Remonter la galerie</a><br />
<?php foreach($view->user_files as $key => $file) : ?>
	<br />
	<a href="<?= $view->base_url . 'spritecomics/gallery/file/' . $file->prop('id') ?>">
		<?php if($file->prop('is_dir') == 1): ?>
		<img src="<?= $view->base_url; ?>public/images/file.png" class="galleryFile" alt="Dossier" />
		<?= $file->prop('name'); ?>
		<?php else: ?>
		<img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $file->prop('id')); ?>" alt="<?= $file->prop('name'); ?>" title="<?= $file->prop('name'); ?>" />
		<?php endif; ?>
	</a>
<?php endforeach; ?>