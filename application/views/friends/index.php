Bienvenue sur la page de gestion des amis.<br />
Liste de vos amis :
<ul>
	<?php foreach($view->user_friends as $key => $friend) : ?>
		<li><?= $friend->prop('username') ?></li>
	<?php endforeach; ?>
</ul>