Formulaire pour se connecter :
<form action="<?= $view->base_url; ?>login" method="post">
	Votre pseudo : <input type="text" name="pseudo" /><br />
	Votre mot de passe : <input type="password" name="password" />
</form>
<a href="<?= $view->base_url; ?>login/register">S'inscrire</a>