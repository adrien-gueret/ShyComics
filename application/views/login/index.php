Formulaire pour se connecter :
<form action="<?= $view->base_url; ?>login" method="post">
	Votre pseudo : <input type="text" name="username" /><br />
	Votre mot de passe : <input type="password" name="password" /><br /><br />
	<input type="submit" value="Me connecter" />
</form>
<a href="<?= $view->base_url; ?>login/register">S'inscrire</a>