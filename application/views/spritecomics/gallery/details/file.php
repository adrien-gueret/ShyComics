<!-- @TODO: improve this file -->
<div>
	<img src="<?= $view->base_url . $view->file->getPath(); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?= $view->tpl_delete; ?>
</div>