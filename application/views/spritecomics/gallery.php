<h2>
	<?php if($view->on_own_gallery) :?>
		Votre galerie
	<?php else: ?>
		Galerie de <?= $view->owner->prop('username'); ?>
	<?php endif; ?>
</h2>

<!-- @TODO
<p class="folder-name">
	<?php if(empty($view->folder_name)) : ?>
		Racine de la galerie
	<?php else : ?>
		<?= $view->folder_name; ?>
	<?php endif; ?>
</p>
-->

<div class="gallery"><?= $view->tpl_gallery; ?></div>
<?= $view->tpl_delete; ?>
<?= $view->tpl_adding_form; ?>