<h2>Rejoignez-nous !</h2>
<p>
	Pour vous inscrire sur Shy'Comics, c'est <strong>simple et rapide</strong> :
	remplissez simplement le formulaire ci-dessous et le tour est joué !
</p>

<form action="<?= $view->base_url; ?>login/register" method="post" autocomplete="off">

	<fieldset>
		<legend>
			<i class="fa fa-user-plus"></i>
		</legend>

		<div class="group-inputs">
			<input placeholder="Quel est votre e-mail ?"
				   type="email"
				   required
				   id="form-email"
				   name="email" />
			<label for="form-email"><i class="fa fa-envelope"></i></label>

			<span class="separator"></span>

			<input placeholder="Et votre pseudo ?"
				   type="text"
				   required
				   id="form-username"
				   name="username" />
			<label for="form-username"><i class="fa fa-user"></i></label>

			<span class="separator"></span>

			<input placeholder="Choisissez un mot de passe"
				   type="password"
				   required
				   id="form-pass"
				   name="password" />
			<label for="form-pass"><i class="fa fa-lock"></i></label>
		</div>
	</fieldset>

	<button class="orange" type="submit">M'inscrire !</button>
</form>

<p>
	Déjà inscrit ? <a href="<?= $view->base_url; ?>login">Connectez-vous !</a>
</p>