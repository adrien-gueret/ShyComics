<div>
	<legend><i class="fa fa-tags"></i></legend>
	<div id="tagsDIV">
		<?php if(!$view->is_index && !$view->tags->isEmpty()): ?>
			<?php foreach($view->tags as $tag) : ?>
				<?= $tag->prop('name'); ?> 
			<?php endforeach; ?>
		<?php else: ?>
			<?= Library_i18n::get('spritecomics.gallery.details.no_tag'); ?>
		<?php endif; ?>
	</div>
	<?php if(!$view->is_index && $view->can_edit): ?>
		<?php if($view->tags->isEmpty()): ?>
			<button onclick="turnTagsIntoForm(<?= $view->id; ?>, '<?= $view->base_url; ?>', true); return false;"><i class="fa fa-pencil-square-o"></i></button>
		<?php else: ?>
			<button onclick="turnTagsIntoForm(<?= $view->id; ?>, '<?= $view->base_url; ?>', false); return false;"><i class="fa fa-pencil-square-o"></i></button>
		<?php endif; ?>
	<?php endif; ?>
</div>