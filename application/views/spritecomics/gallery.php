<?php if(!empty($view->user_id)): ?>
Bienvenue sur la galerie de <b><?= $view->user_name ?></b>.
	<?php if(!empty($view->connected_user_id) && $view->connected_user_id == $view->user_id): ?>
	<br />Vous êtes de plus sur votre galerie !<br />
	Utilisez le formulaire ci dessous pour rajouter un document à votre galerie :
	<form action="<?= $view->base_url; ?>spritecomics/add" method="post" enctype="multipart/form-data">
		<input type="file" name="file" /><br />
		<input type="text" name="name" /> Nom du document (facultatif)<br />
		<textarea name="description"></textarea> Description du document (facultatif)<br />
		Sélectionnez le dossier parent :
		<select name="parent_file">
			<option value="">Aucun</option>
		</select>
		<input type="submit" value="Envoyer le document" />
	</form>
	<?php endif; ?>
	<?php if(!empty($view->user_files)): ?>
		<?php foreach($view->user_files as $key => $file) : ?>
		<br /><img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $file->prop('id')); ?>" alt="<?= $file->prop('name') ?>" title="<?= $file->prop('name') ?>" />
		<?php endforeach; ?>
	<?php else: ?>
	<br />Cette galerie est vide.
	<?php endif; ?>
<?php else: ?>
Le membre demandé n'existe pas.
<?php endif; ?>