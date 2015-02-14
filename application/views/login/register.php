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
		<!--
			Fix Chrome issue
			Add hidden pass input in order force auto-completion on this one.
			This dumb browser pre-fill fields in a bad way!
		-->
		<input type="password" name="fake" class="hidden" />

		<div class="group-buttons">
			<input autofocus
				   placeholder="Quel est votre pseudo ?"
				   type="text"
				   required
				   name="username" />

			<span class="separator"></span>

			<input placeholder="Et votre e-mail ?"
				   type="email"
				   required
				   name="email" />

			<span class="separator"></span>

			<input placeholder="Choisissez un mot de passe"
				   type="password"
				   required
				   name="password" />
		</div>
	</fieldset>

	<button class="orange" type="submit">M'inscrire !</button>
</form>

<p>
	Déjà inscrit ? <a href="<?= $view->base_url; ?>login">Connectez-vous !</a>
</p>