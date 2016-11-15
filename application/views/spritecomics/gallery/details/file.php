<h1>
	<?php if($view->on_own_gallery) :?>
		<?= Library_i18n::get('spritecomics.gallery.own_gallery_title'); ?>
	<?php else: ?>
		<?= Library_i18n::get('spritecomics.gallery.other_gallery_title', $view->owner->prop('username')); ?>
	<?php endif; ?>
</h1>
<div>
	<h2><?= $view->file->prop('name'); ?></h2>
	<div><?= $view->hierarchy; ?></div><br />
	<div class="nav-arrows"><?= $view->tpl_arrows; ?></div><br /><br />
	<div id="detail-image-div"><img id="detail-image" src="<?= $view->imagePath; ?>" alt="<?= $view->file->prop('name'); ?>" title="<?= $view->file->prop('name'); ?>" /></div><br />
	<div class="nav-arrows"><?= $view->tpl_arrows; ?></div><br />
    <div><?= $view->hierarchy; ?></div><br />
	<?= $view->tpl_description; ?><br />
	<?= $view->tpl_delete; ?><br />
	<div class="file-infos">
        <div><?= $view->tpl_nbr_views; ?></div>
        <div><?= $view->tpl_social_NW; ?></div>
        <div class="likes">
            <?= $view->tpl_like; ?>
            <br /><?= $view->nbr_likes; ?>  <i class="fa fa-thumbs-up" aria-hidden="true"></i>
        </div>
        <div><?= $view->tpl_tags; ?></div>
    </div>
    <hr />
	<?= $view->tpl_comment; ?>
	<script src="<?= $view->base_url; ?>public/javascript/spritecomics/gallery/moderation.js"></script>
</div>