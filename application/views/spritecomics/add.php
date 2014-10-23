Utilisez le formulaire ci dessous pour rajouter un document à votre galerie :
<form action="<?= $view->base_url; ?>spritecomis/addFile" method="post" enctype="multipart/form-data">
	<input type="file" name="file" /><br />
	<input type="text" name="name" /> Nom du document (facultatif)<br />
	<textarea></textarea> Description du document (facultatif)<br />
	Sélectionnez le dossier parent :
	<select name="parent_file">
		<option value="">Aucun</option>
	</select>
	<input type="submit" value="Envoyer le document" />
</form>