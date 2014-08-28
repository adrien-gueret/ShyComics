Formulaire pour s'inscrire :
<form action="<?= $view->base_url; ?>login/register" method="post">
	Votre pseudo : <input type="text" name="username" /><br />
	Votre mot de passe : <input type="password" name="password" /><br />
	Votre adresse email : <input type="mail" name="email" /><br />
	<br />
	<input type="submit" value="M'inscrire !" />
</form>
<a href="<?= $view->base_url; ?>login">Se connecter</a>