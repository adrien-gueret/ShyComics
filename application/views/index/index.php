<h2><?= Library_i18n::get('index.index.title'); ?></h2>
<p>
	<?= Library_i18n::get('index.index.presentation'); ?><br /><br />
	<?= Library_i18n::get('index.index.update'); ?>
</p>
<h2><?= Library_i18n::get('index.index.title_last_uploads'); ?></h2>
<p><?= $view->tpl_last_boards; ?></p>
<h2><?= Library_i18n::get('index.index.title_random'); ?></h2>
<p><?= $view->tpl_random; ?></p>
<h2><?= Library_i18n::get('index.index.title_last_comments'); ?></h2>
<p><?= $view->tpl_last_comments; ?></p>
<h2><?= Library_i18n::get('index.index.title_lost'); ?></h2>
<p><?= Library_i18n::get('index.index.desc_lost_1'); ?></p>
<p><?= Library_i18n::get('index.index.desc_lost_2', ['base_url' => $view->base_url]); ?></p>