<form action="<?= $view->base_url; ?>/spritecomics/delete" method="post">
	<input type="hidden" name="__method__" value="delete" />
	<input type="hidden" name="id" value="<?= $view->id_to_delete; ?>" />
	<button><i class="fa fa-trash"></i></button>
</form>