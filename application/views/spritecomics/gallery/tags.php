<div>
	<?php if(!$view->is_index): ?>
		<legend><i class="fa fa-tags"></i></legend>
		<?php if(!empty($view->tags[0])): ?>
			<?php foreach($view->tags as $tag) : ?>
				<?= $tag->prop('name'); ?> 
			<?php endforeach; ?>
		<?php else: ?>
			<?= Library_i18n::get('spritecomics.gallery.details.no_tag'); ?>
		<?php endif; ?>
	<?php endif; ?>
</div>