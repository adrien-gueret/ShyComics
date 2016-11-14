<h2><?= Library_i18n::get('login.register.title'); ?></h2>
<p><?= Library_i18n::get('login.register.desc'); ?></p>

<form action="<?= $view->base_url; ?>login/register" method="post" autocomplete="off">

	<fieldset>
		<legend>
			<i class="fa fa-user-plus"></i>
		</legend>

		<div class="group-inputs">
			<input placeholder="<?= Library_i18n::get('login.register.helpers.email'); ?>"
				   type="email"
				   required
				   id="form-email"
				   name="email"
				   class="first" />
			<label for="form-email"><i class="fa fa-envelope"></i></label>

			<span class="separator"></span>

			<input placeholder="<?= Library_i18n::get('login.register.helpers.username'); ?>"
				   type="text"
				   required
				   id="form-username"
				   name="username" />
			<label for="form-username"><i class="fa fa-user"></i></label>

			<span class="separator"></span>

			<input placeholder="<?= Library_i18n::get('login.register.helpers.password'); ?>"
				   type="password"
				   required
				   id="form-pass"
				   name="password" />
			<label for="form-pass"><i class="fa fa-lock"></i></label>

			<span class="separator"></span>

			<input placeholder="<?= Library_i18n::get('login.register.helpers.passwordConfirm'); ?>"
				   type="password"
				   required
				   id="form-pass-conf"
				   name="passwordConfirm"
				   class="last" />
			<label for="form-pass-conf"><i class="fa fa-lock"></i></label>

			<span class="separator"></span>

            <label class="label-full-line" for="form-DOB"><?= Library_i18n::get('login.register.helpers.birthdate'); ?></label>
			<p>
                <select name="DOB" id="form-DOB" style="width: auto;">
                    <?php for($i = 1; $i <= 31; $i++): ?>
                        <option value="<?= $i; ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php endfor; ?>
                </select>/
                <select name="MOB" id="form-MOB" style="width: auto;">
                    <?php for($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i; ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php endfor; ?>
                </select>/
                <select name="YOB" id="form-YOB" style="width: auto;">
                    <?php for($i = $view->year_now; $i >= 1900; $i--): ?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
                    <?php endfor; ?>
                </select>
                <label for="form-DOB"><i class="fa fa-calendar"></i></label>
            </p>

            <label class="label-full-line" for="form-sexe"><i class="fa fa-venus-mars" aria-hidden="true"></i>  <?= Library_i18n::get('login.register.helpers.sexe.sexe'); ?></label>
			<p>
                <input type="radio" name="sexe" value="0"><?= Library_i18n::get('login.register.helpers.sexe.male'); ?><br />
                <input type="radio" name="sexe" value="1"><?= Library_i18n::get('login.register.helpers.sexe.female'); ?><br />
                <input type="radio" name="sexe" value="2"><?= Library_i18n::get('login.register.helpers.sexe.undefined'); ?><br />
            </p>
            
			<label class="label-full-line" for="form-locale"><?= Library_i18n::get('login.register.helpers.lang'); ?></label>
			<p>
				<select id="form-locale"
						name="id_locale"
						class="first last">
					<?= $view->tpl_locales_options; ?>
				</select>
				<label for="form-locale"><i class="fa fa-flag"></i></label>
			</p>
		</div>
	</fieldset>

	<button class="orange" type="submit"><?= Library_i18n::get('login.register.submit'); ?></button>
</form>

<p><?= Library_i18n::get('login.register.has_account', ['base_url' => $view->base_url]); ?></p>