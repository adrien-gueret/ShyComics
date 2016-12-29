<div>
    <div class="sub-container sub-container-a">
        <h2><?= Library_i18n::get('index.index.title'); ?></h2>
        <p>
            <?= Library_i18n::get('index.index.presentation'); ?><br /><br />
            <?= Library_i18n::get('index.index.update'); ?> <?= $view->news; ?>
        </p>
    </div>

    <div class="sub-container sub-container-b">
        <h2><?= Library_i18n::get('index.index.title_random'); ?></h2>
        <div class="gallery"><?= $view->tpl_random; ?></div>
    </div>
</div>
<div>
    <div class="sub-container sub-container-c">
        <h2><?= Library_i18n::get('index.index.title_last_uploads'); ?></h2>
        <div class="gallery"><?= $view->tpl_last_boards; ?></div>
    </div>

    <div class="sub-container sub-container-d">
        <h2><?= Library_i18n::get('index.index.title_last_comments'); ?></h2>
        <p><?= $view->tpl_last_comments; ?></p>
    </div>
</div>
<div>
    <div class="sub-container">
        <h2><?= Library_i18n::get('index.index.title_populars'); ?></h2>
        <div class="gallery"><?= $view->tpl_populars; ?></div>
    </div>
</div>
<div>
    <div class="sub-container">
        <h2><?= Library_i18n::get('index.index.title_lost'); ?></h2>
        <p><?= Library_i18n::get('index.index.desc_lost_1'); ?></p>
        <p><?= Library_i18n::get('index.index.desc_lost_2', ['base_url' => $view->base_url]); ?></p>
    </div>
</div>
