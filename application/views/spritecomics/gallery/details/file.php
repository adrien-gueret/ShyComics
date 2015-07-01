<!-- @TODO: improve this file -->
<div>
	<img src="<?= $view->base_url . $view->file->getPath(); ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<div>
		<legend><i class="fa fa-tags"></i></legend>
		Univers : <b><em><?= $view->universe; ?></b></em><br />
		Genre : <b><em><?= $view->genre; ?></b></em>
	</div>
	<?= $view->tpl_delete; ?>
	<?= $view->tpl_like; ?>
	<?= $view->tpl_comment; ?>
</div>
