<form action="<?= $view->base_url; ?>spritecomics/delete/file" method="post">
	<input type="hidden" name="__method__" value="delete" />
	<input type="hidden" name="id" value="<?= $view->id_to_delete; ?>" />
	<button onclick="if(confirm('<?= $view->message; ?>') == false){return false;}"><i class="fa fa-trash"></i></button>
</form>