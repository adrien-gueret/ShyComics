<?php if( ! $view->has_liked): ?>
	<form action="<?= $view->base_url; ?>spritecomics/like" method="post">
		<input type="hidden" name="id_file" value="<?= $view->id_file; ?>" />
		<button><i class="fa fa-thumbs-o-up"></i></button>
	</form>
<?php endif; ?>