<h2><?= Library_i18n::get('spritecomics.gallery.add.title'); ?></h2>
<p><?= Library_i18n::get('spritecomics.gallery.add.desc'); ?></p>

<form id="form_add_content"
	  class="form-line"
	  action="<?= $view->base_url; ?>spritecomics/gallery"
	  method="post"
	  enctype="multipart/form-data">
	<fieldset>
		<legend><i class="fa fa-question"></i></legend>
		<p><?= Library_i18n::get('spritecomics.gallery.add.type_of_doc.title'); ?></p>

		<label for="form_type_file" class="label-text"><?= Library_i18n::get('spritecomics.gallery.add.type_of_doc.image'); ?></label>
		<input id="form_type_file" type="radio" name="is_dir" checked value="0" />
		<br />
		<label for="form_type_folder" class="label-text"><?= Library_i18n::get('spritecomics.gallery.add.type_of_doc.folder'); ?></label>
		<input id="form_type_folder" type="radio" name="is_dir" value="1" />
	</fieldset>

	<fieldset>
		<legend><i class="fa fa-comment"></i></legend>

		<div class="group-inputs">
			<input placeholder="<?= Library_i18n::get('spritecomics.gallery.add.helpers.doc_name'); ?>"
				   type="text"
				   required
				   id="form-name"
				   name="name" />
			<label for="form-name"><i class="fa fa-pencil"></i></label>

			<span class="separator"></span>

			<textarea	placeholder="<?= Library_i18n::get('spritecomics.gallery.add.helpers.description'); ?>"
						id="form-description"
						name="description"></textarea>
			<label for="form-description"><i class="fa fa-quote-left"></i></label>
		</div>
	</fieldset>
	<br />
	<fieldset id="form_file_part">
		<legend><i class="fa fa-file-image-o"></i></legend>
		<label for="form_file"><?= Library_i18n::get('spritecomics.gallery.add.file_selection'); ?></label>
		<input id="form_file" type="file" name="file" />
	</fieldset>
	<p>
		<?php if( ! empty($view->parent_file_id)) :?>
			<input type="hidden" name="parent_file_id" value="<?= $view->parent_file_id; ?>" />
		<?php endif; ?>
		<button class="orange"><?= Library_i18n::get('spritecomics.gallery.add.submit'); ?></button>
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
			form_file_part.className	=	this.value == 1 ? 'inactive' : '';
		}
	})(document);
</script>