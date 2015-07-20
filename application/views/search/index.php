<?= Library_i18n::get('search.index'); ?><hr />
<?php foreach($view->searchArray as $result): ?>
    <a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $result->id; ?>"><?= $result->name; ?></a><br />
<?php endforeach; ?>