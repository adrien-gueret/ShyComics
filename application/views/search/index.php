<?= Library_i18n::get('search.index'); ?><hr />
<?php if(is_array($view->searchArray)): ?>
	<?php foreach($view->searchArray as $result): ?>
		<a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $result->id; ?>"><?= $result->name; ?></a><br />
	<?php endforeach; ?>
<?php else: ?>
	<?= Library_i18n::get('search.none'); ?>
<?php endif; ?>