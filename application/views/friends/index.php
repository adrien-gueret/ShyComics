<p>
	Bienvenue sur la page de gestion des amis.<br />
	Liste de vos amis :
</p>
<ul>
	<?php foreach($view->current_member->prop('friends') as $key => $friend) : ?>
		<li><?= $friend->prop('username') ?></li>
	<?php endforeach; ?>
</ul>