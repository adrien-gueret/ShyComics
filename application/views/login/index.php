<h2>Connectez-vous !</h2>
<p>
	Vous possédez un compte Shy'Comics ? Alors connectez-vous et publiez vos <em>sprite comics</em> !
</p>

<form action="<?= $view->base_url; ?>login" method="post">

	<fieldset>
		<legend>
			<i class="fa fa-key"></i>
		</legend>

		<div class="group-inputs">
			<input placeholder="Quel est votre pseudo ?"
				   type="text"
				   required
				   id="form-username"
				   name="username" />
			<label for="form-username"><i class="fa fa-user"></i></label>

			<span class="separator"></span>

			<input placeholder="Et votre mot de passe ?"
				   type="password"
				   required
				   id="form-pass"
				   name="password" />
			<label for="form-pass"><i class="fa fa-lock"></i></label>
		</div>
	</fieldset>

	<button class="orange" type="submit">Me connecter !</button>
</form>

<p>
	Pas de compte ? <a href="<?= $view->base_url; ?>login/register">Inscrivez-vous !</a>
</p>