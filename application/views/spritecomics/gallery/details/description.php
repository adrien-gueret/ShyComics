<div>
	<div class="file-description">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        <div id="descDIV">
            <em><?= Library_Parser::parse($view->description, $view->base_url); ?></em>
        </div>
	</div>
	<?php if($view->can_edit): ?>
		<button onclick="turnDescIntoForm(<?= $view->id; ?>, '<?= $view->base_url; ?>', '<?= str_replace(CHR(13).CHR(10), "\\n", htmlspecialchars($view->description, ENT_QUOTES)); ?>'); return false;"><i class="fa fa-pencil"></i></button>
	<?php endif; ?>
</div>