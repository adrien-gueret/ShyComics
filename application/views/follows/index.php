<h2><?= Library_i18n::get('follows.title'); ?></h2>
<ul>
	<?php foreach($view->current_member->prop('follows') as $key => $follow): ?>
		<li><?= $follow->prop('username') ?></li>
	<?php endforeach; ?>
</ul>
<br />
<h2><i class="fa fa-paper-plane" aria-hidden="true"></i> <?= Library_i18n::get('feed.title'); ?></h2>
<ul>
	<?php if(empty($view->current_member->getFeed())): ?>
		<?= Library_i18n::get('feed.empty'); ?>
	<?php else: ?>
		<?php foreach($view->current_member->getFeed() as $feed): ?>
			<li>
				<?php if($feed->type == Model_Feed::OBJECT_IS_A_SENT_FILE): ?>
					<?= $feed->username . Library_i18n::get('feed.sendFile'); ?>
				<?php elseif($feed->type == Model_Feed::OBJECT_IS_A_LIKED_FILE): ?>
					<?= $feed->username . Library_i18n::get('feed.likedFile'); ?>
				<?php elseif($feed->type == Model_Feed::OBJECT_IS_A_COMMENTARY): ?>
					<?= $feed->username . Library_i18n::get('feed.comment'); ?>
				<?php endif; ?>
				&nbsp;<a href="<?=$view->base_url; ?>spritecomics/gallery/details/<?= $feed->object; ?>"><?= Library_i18n::get('feed.see') ?></a>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>