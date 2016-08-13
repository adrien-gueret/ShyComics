<!-- @TODO: improve this file -->
<div>
	<h1><?= $view->file->prop('name'); ?></h1>
	<img src="<?= $view->imagePath; ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" />
	<?= $view->tpl_description; ?>
	<?= $view->tpl_nbr_views; ?>
	<?= $view->tpl_social_NW; ?>
	<?= $view->tpl_tags; ?>
	<?= $view->tpl_delete; ?>
	<?= $view->tpl_like; ?>
	<?= $view->tpl_comment; ?>
</div>
