<form action="<?= $view->base_url; ?>spritecomics/delete" method="post">
	<input type="hidden" name="__method__" value="delete" />
	<input type="hidden" name="id" value="<?= $view->id_to_delete; ?>" />
	<button onclick="if(confirm('<?= Library_i18n::get('spritecomics.gallery.details.delete'); ?>') == false){return false;}"><i class="fa fa-trash"></i></button>
</form>