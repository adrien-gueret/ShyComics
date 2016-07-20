<?= Library_i18n::get('profile.modify.avatar_change'); ?><br />
<form id="form_avatar"
	  class="form-line"
	  action="<?= $view->base_url; ?>profile/modify/avatar"
	  method="post"
	  enctype="multipart/form-data">
	<fieldset id="form_file_part">
		<legend><i class="fa fa-file-image-o"></i></legend>
		<label for="form-file"><?= Library_i18n::get('spritecomics.gallery.add.file_selection'); ?></label>
		<input id="form-file" type="file" name="avatar" />
		Largeur maximal : 130px<br />
		Hauteur maximale : 150px
		<p id="preview-container" class="preview-container" style="height: 0;">
			<canvas id="preview-thumbnail"></canvas>
			<input type="hidden" name="thumbnail_data_url" id="thumbnail-data-url" value="" />
		</p>
	</fieldset>
	<p>
		<?php if( ! empty($view->parent_file_id)) :?>
			<input type="hidden" name="parent_file_id" value="<?= $view->parent_file_id; ?>" />
		<?php endif; ?>
		<button class="orange"><?= Library_i18n::get('profile.submit'); ?></button>
	</p>
</form>