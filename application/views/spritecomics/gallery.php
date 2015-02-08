<?php if(isset($view->infos_message)): ?>
	<?= $view->infos_message; ?>
<?php endif; ?>
Bienvenue sur la galerie de <b><?= $view->user_name; ?></b>.
<?php if(!empty($view->current_member) && $view->current_member->prop('id') == $view->user_id): ?>
	<br />Vous êtes de plus sur votre galerie !<br />
	Utilisez le formulaire ci dessous pour rajouter un document à votre galerie :
	<form action="<?= $view->base_url; ?>spritecomics/add" method="post" enctype="multipart/form-data">
		<input type="file" name="file" required/><br />
		<input type="text" name="name" /> Nom du document (facultatif)<br />
		<textarea name="description"></textarea> Description du document (facultatif)<br />
		Sélectionnez le dossier parent :
		<select name="parent_file">
			<option value="" selected>Aucun</option>
			<?php if(!empty($view->user_dirs_all)): ?>
				<?php foreach($view->user_dirs_all as $key => $dir) : ?>
				<option value="<?= $dir->prop('id'); ?>"><?= $dir->prop('name'); ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<input type="submit" value="Envoyer le document" />
	</form>
	<br />
	<form action="<?= $view->base_url; ?>spritecomics/addDir" method="post">
		<input type="text" name="name" required/> Nom du dossier<br />
		<textarea name="description"></textarea> Description du dossier (facultatif)<br />
		Sélectionnez le dossier parent :
		<select name="parent_file">
			<option value="" selected>Aucun</option>
			<?php if(!empty($view->user_dirs_all)): ?>
				<?php foreach($view->user_dirs_all as $key => $dir) : ?>
				<option value="<?= $dir->prop('id'); ?>"><?= $dir->prop('name'); ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<input type="submit" value="Envoyer le dossier" />
	</form>
<?php endif; ?>
<?php if(!empty($view->user_files)): ?>
	<?php foreach($view->user_files as $key => $file) : ?>
		<?php if($file->prop('is_dir') == 1): ?>
		<br /><a href="<?= $view->base_url . 'spritecomics/gallery/file/' . $file->prop('id') ?>"><img src="<?= $view->base_url; ?>public/images/file.png" class="galleryFile" alt="Dossier" /></a>
		<?= $file->prop('name'); ?>
		<?php else: ?>
		<br /><a href="<?= $view->base_url . 'spritecomics/gallery/file/' . $file->prop('id') ?>"><img src="<?= $view->base_url . Model_Files::getPath($view->user_id, $file->prop('id')); ?>" alt="<?= $file->prop('name'); ?>" title="<?= $file->prop('name'); ?>" /></a>
		<?php endif; ?>
	<?php endforeach; ?>
<?php else: ?>
<br />Cette galerie est vide.
<?php endif; ?>