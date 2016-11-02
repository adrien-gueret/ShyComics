<h1>
	<?php if($view->on_own_gallery) :?>
		<?= Library_i18n::get('spritecomics.gallery.own_gallery_title'); ?>
	<?php else: ?>
		<?= Library_i18n::get('spritecomics.gallery.other_gallery_title', $view->owner->prop('username')); ?>
	<?php endif; ?>
</h1>

<p class="folder-name">
	<?php if(empty($view->folder_name)) : ?>
		<h2><?= Library_i18n::get('spritecomics.gallery.roost'); ?></h2>
        <a href="<?= $view->base_url; ?>profile<?= $view->owner->getId(); ?>"><?= Library_i18n::get('spritecomics.gallery.return_to_profile'); ?></a>
	<?php else : ?>
		<h2><?= $view->folder_name; ?></h2>
	<?php endif; ?></h2>
</p>
<div><?= $view->hierarchy; ?></div>
<div class="gallery"><?= $view->tpl_gallery; ?></div>
<div><?= $view->tpl_tags; ?></div>
<?= $view->tpl_delete; ?>
<?= $view->tpl_adding_form; ?>
<script src="<?= $view->base_url; ?>public/javascript/spritecomics/gallery/moderation.js"></script>