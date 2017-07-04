<?= Library_i18n::get('search.index'); ?>
<?php if(is_array($view->resultsUsers) || is_array($view->resultsFiles) || is_array($view->resultsDirs)): ?>
    <?php if(is_array($view->resultsUsers)): ?>
        <hr />
        <h2><?= Library_i18n::get('search.users'); ?></h2>
        <?php foreach($view->resultsUsers as $result): ?>
            <a href="<?= $view->base_url . 'spritecomics/gallery/' . $result->id; ?>"><?= $result->username; ?></a><br />
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if(is_array($view->resultsDirs)): ?>
        <hr />
        <h2><?= Library_i18n::get('search.dirs'); ?></h2>
        <?php foreach($view->resultsDirs as $result): ?>
            <a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $result->id; ?>"><?= $result->name; ?></a><br />
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if(is_array($view->resultsFiles)): ?>
        <hr />
        <h2><?= Library_i18n::get('search.pages'); ?></h2>
        <?php foreach($view->resultsFiles as $result): ?>
            <a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $result->id; ?>"><?= $result->name; ?></a><br />
        <?php endforeach; ?>
    <?php endif; ?>
<?php else: ?>
    <hr />
	<?= Library_i18n::get('search.none'); ?>
<?php endif; ?>