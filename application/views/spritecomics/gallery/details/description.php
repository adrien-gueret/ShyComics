<div>
	<div class="file-description">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        <div id="descDIV">
            <em><?= $view->description; ?></em>
        </div>
	</div>
	<?php if($view->can_edit): ?>
		<button onclick="turnDescIntoForm(<?= $view->id; ?>, '<?= $view->base_url; ?>', '<?= htmlspecialchars($view->description, ENT_QUOTES); ?>'); return false;"><i class="fa fa-pencil"></i></button>
	<?php endif; ?>
</div>