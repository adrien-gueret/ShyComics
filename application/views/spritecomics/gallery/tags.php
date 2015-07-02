<div>
	<legend><i class="fa fa-tags"></i></legend>
	<?php foreach($view->tags as $tag) : ?>
		<?= $tag->prop('name'); ?> 
	<?php endforeach; ?>
</div>