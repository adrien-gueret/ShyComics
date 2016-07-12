<!-- @TODO: improve this file -->
<div>
	<img src="<?= $view->imagePath; ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?= $view->tpl_nbr_views; ?>
	<?= $view->tpl_social_NW; ?>
	<?= $view->tpl_tags; ?>
	<?= $view->tpl_delete; ?>
	<?= $view->tpl_like; ?>
	<?= $view->tpl_comment; ?>
</div>
