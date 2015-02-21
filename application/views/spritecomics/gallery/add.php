<h2>Ajoutez un document dans ce dossier !</h2>
<p>
	Avec l'aide du formulaire ci-dessous, vous pouvez modifier ce dossier en créant un sous-dossier
	ou en y ajoutant une planche de <em>Sprite Comic</em>.
</p>

<form id="form_add_content"
	  class="form-line"
	  action="<?= $view->base_url; ?>spritecomics/gallery"
	  method="post"
	  enctype="multipart/form-data">
	<fieldset>
		<legend><i class="fa fa-question"></i></legend>
		<p>Que souhaitez-vous faire ?</p>

		<label for="form_type_file">Mettre en ligne planche de SC</label>
		<input id="form_type_file" type="radio" name="is_dir" checked value="0" />
		<label for="form_type_folder">Créer un sous-dossier</label>
		<input id="form_type_folder" type="radio" name="is_dir" value="1" />
	</fieldset>

	<fieldset>
		<legend><i class="fa fa-comment"></i></legend>

		<div class="group-inputs">
			<input placeholder="Nom du document"
				   type="text"
				   required
				   id="form-name"
				   name="name" />
			<label for="form-name"><i class="fa fa-pencil"></i></label>

			<span class="separator"></span>

			<textarea	placeholder="Une petite description ? (facultatif)"
						id="form-description"
						name="description"></textarea>
			<label for="form-description"><i class="fa fa-quote-left"></i></label>
		</div>
	</fieldset>

	<fieldset id="form_file_part">
		<legend><i class="fa fa-file-image-o"></i></legend>
		<label for="form_file">Sélectionnez votre fichier</label>
		<input id="form_file" type="file" name="file" />
	</fieldset>
	<p>
		<?php if( ! empty($view->parent_file_id)) :?>
			<input type="hidden" name="parent_file_id" value="<?= $view->parent_file_id; ?>" />
		<?php endif; ?>
		<button class="orange">Confirmer l'ajout</button>
	</p>
</form>
<script>
	(function(document) {
		'use strict';

		var form_file_part	=	document.getElementById('form_file_part'),
			form			=	document.getElementById('form_add_content');

		for(var i = 0, l = form.elements.length; i < l; i++)
		{
			if(form.elements[i].name === 'is_dir')
				form.elements[i].addEventListener('click', toggleFilePart);
		}

		function toggleFilePart()
		{
			form_file_part.style.display	=	this.value == 1 ? 'none' : 'inline-block';
		}
	})(document);
</script>