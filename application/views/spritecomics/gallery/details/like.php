<br />
<?php if( ! $view->has_liked): ?>
	<form action="<?= $view->base_url; ?>spritecomics/like" method="post">
		<input type="hidden" name="id_file" value="<?= $view->file->prop('id'); ?>" />
		<button>Liker cette image</button>
	</form>
<?php else: ?>
	<button disabled>Image déjà likée</button>
<?php endif; ?>