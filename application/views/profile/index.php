<h2><?= Library_i18n::get('profile.index.title', $view->user_name); ?></h2>
<p>
	<div class="profile">
        <div><img src="<?= $view->user_avatar; ?>" alt="<?= $view->user_name; ?>" style="float: left;"/></div>
        <div class="details">
            <?= Library_i18n::get('profile.index.sub_date') . " " . $view->user_sub_date; ?><br />
            <?= Library_i18n::get('profile.index.last_login') . " " . $view->user_last_login; ?><br />
            <i class="fa fa-birthday-cake" aria-hidden="true"></i>  <?= Library_i18n::get('profile.index.age', $view->user_age); ?>&nbsp;
            <i class="fa fa-venus-mars" aria-hidden="true"></i>  <?= $view->user_sexe; ?>&nbsp;
            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>  <?= $view->user_interest; ?><br />
            <q><?= $view->user_about; ?></q>
        </div>
    </div><br />
	<a href="<?= $view->base_url; ?>spritecomics/gallery/<?= $view->user_id ?>">
		<button class="orange">
            <i class="fa fa-picture-o" aria-hidden="true"></i>  <?= Library_i18n::get('profile.index.go_to_gallery'); ?>
        </button>
	</a><br /><br />
	<?= $view->tpl_follow; ?>
	
	<?php if(!$view->user_follows->isEmpty()): ?>
		<?= Library_i18n::get('profile.index.follows'); ?><br />
		<?php foreach($view->user_follows as $followed): ?>
			<?= '<a href="' . $followed->getId() . '"><img class="mini_avatar" src="' . $followed->getAvatarURL() . '" alt="' . $followed->prop('username') . '" title="' . $followed->prop('username') . '" alt="' . $followed->prop('username') . '" /></a> '?>
		<?php endforeach; ?>
	<?php else: ?>
		<?= Library_i18n::get('profile.index.no_follows'); ?>
	<?php endif; ?>
</p>