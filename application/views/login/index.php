<h2><?= Library_i18n::get('login.index.title'); ?></h2>
<p><?= Library_i18n::get('login.index.desc'); ?></p>

<form action="<?= $view->base_url; ?>login" method="post">

	<fieldset>
		<legend>
			<i class="fa fa-key"></i>
		</legend>

		<div class="group-inputs">
			<input placeholder="<?= Library_i18n::get('login.index.helpers.username'); ?>"
				   type="text"
				   required
				   id="form-username"
				   name="username" />
			<label for="form-username"><i class="fa fa-user"></i></label>

			<span class="separator"></span>

			<input placeholder="<?= Library_i18n::get('login.index.helpers.password'); ?>"
				   type="password"
				   required
				   id="form-pass"
				   name="password" />
			<label for="form-pass"><i class="fa fa-lock"></i></label>
		</div>
	</fieldset>

	<button class="orange" type="submit"><?= Library_i18n::get('login.index.submit'); ?></button>
</form>

<p><?= Library_i18n::get('login.index.no_account', ['base_url' => $view->base_url]); ?></p>