<div>
	<div id="descDIV">
		<legend><i class="fa fa-sticky-note-o" aria-hidden="true"></i></legend>
		<em><?= $view->description; ?></em>
	</div>
	<?php if($view->can_edit): ?>
		<button onclick="turnDescIntoForm(<?= $view->id; ?>, '<?= $view->base_url; ?>', '<?= $view->description; ?>'); return false;"><i class="fa fa-pencil-square-o"></i></button>
	<?php endif; ?>
</div>