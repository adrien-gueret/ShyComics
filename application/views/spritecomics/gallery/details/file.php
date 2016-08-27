<div>
	<h1><?= $view->file->prop('name'); ?></h1>
	<div><?= $view->hierarchy; ?></div>
	<div>
		<?php if(!empty($view->previous)): ?>
			<a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $view->previous->getId();?>"><?= Library_i18n::get('spritecomics.gallery.details.previous'); ?></a><br />
		<?php endif; ?>
		<?php if(!empty($view->next)): ?>
			<a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $view->next->getId();?>"><?= Library_i18n::get('spritecomics.gallery.details.next'); ?></a><br />
		<?php endif; ?>
	</div>
	<img src="<?= $view->imagePath; ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?= $view->tpl_description; ?>
	<?= $view->tpl_delete; ?>
	<?= $view->tpl_nbr_views; ?>
	<?= $view->tpl_social_NW; ?>
	<?= $view->tpl_tags; ?>
	<?= $view->tpl_like; ?>
	<?= $view->tpl_comment; ?>
	<script src="<?= $view->base_url; ?>public/javascript/spritecomics/gallery/moderation.js"></script>
</div>
