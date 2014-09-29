<?php if(!empty($view->user_id)): ?>
Bienvenue sur la galerie de <b><?= $view->user_name ?></b>.
	<?php if(!empty($view->connected_user_id) && $view->connected_user_id == $view->user_id): ?>
	<br />Vous êtes de plus sur votre galerie !
	<?php endif; ?>
	<?php if(!empty($view->user_files)): ?>
		<?php foreach($view->user_files as $key => $file) : ?>
		<br /><?= $view->base_url . Model_Files::getPath($view->user_id, $file->prop('id')); ?>
		<?php endforeach; ?>
	<?php else: ?>
	<br />Cette galerie est vide.
	<?php endif; ?>
<?php else: ?>
Le membre demandé n'existe pas.
<?php endif; ?>