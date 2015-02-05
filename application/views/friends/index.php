Bienvenue sur la page de gestion des amis.<br />
<?php if(!empty($view->connected_user_id)): ?>
	<?php if(!empty($view->user_friends->getArray())): ?>
		Liste de vos amis :
		<ul>
			<?php foreach($view->user_friends as $key => $friend) : ?>
				<li><?= $friend->prop('username') ?></li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<?= $view->infos_message_lack_friends; ?>
	<?php endif; ?>
<?php else: ?>
	<?= $view->infos_message_login; ?>
<?php endif; ?>