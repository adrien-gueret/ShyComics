<h1>
	<?php if($view->on_own_gallery) :?>
		<?= Library_i18n::get('spritecomics.gallery.own_gallery_title'); ?>
	<?php else: ?>
		<?= Library_i18n::get('spritecomics.gallery.other_gallery_title', $view->owner->prop('username')); ?>
	<?php endif; ?>
</h1>

<p class="folder-name">
	<h2><?php if(empty($view->folder_name)) : ?>
		Racine de la galerie
	<?php else : ?>
		<?= $view->folder_name; ?>
	<?php endif; ?></h2>
</p>

<div class="gallery"><?= $view->tpl_gallery; ?></div>
<?= $view->tpl_delete; ?>
<?= $view->tpl_adding_form; ?>