<?= Library_i18n::get('search.index'); ?>
<?php if(is_array($view->resultsUsers) || is_array($view->resultsFiles)): ?>
    <?php if(is_array($view->resultsUsers)): ?>
        <hr />
        <?php foreach($view->resultsUsers as $result): ?>
            <a href="<?= $view->base_url . 'spritecomics/gallery/' . $result->id; ?>"><?= $result->username; ?></a><br />
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if(is_array($view->resultsFiles)): ?>
        <hr />
        <?php foreach($view->resultsFiles as $result): ?>
            <a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $result->id; ?>"><?= $result->name; ?></a><br />
        <?php endforeach; ?>
    <?php endif; ?>
<?php else: ?>
    <hr />
	<?= Library_i18n::get('search.none'); ?>
<?php endif; ?>