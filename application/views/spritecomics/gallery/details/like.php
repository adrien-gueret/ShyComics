<?php if( ! $view->has_liked): ?>
	<form action="<?= $view->base_url; ?>spritecomics/like" method="post">
		<input type="hidden" name="id_file" value="<?= $view->id_file; ?>" />
		<button>Aimer cette planche</button>
	</form>
<?php else: ?>
	<p>
		<button disabled>Planche déjà likée</button>
	</p>
<?php endif; ?>