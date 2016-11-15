<form id="form_pass"
	  action="<?= $view->base_url; ?>profile/modify/pass"
	  method="post">
	<fieldset id="form_pass_part">
		<label class="label-full-line" for="pass_actual"><i class="fa fa-lock" aria-hidden="true"></i>  <?= Library_i18n::get('profile.modify.pass.help'); ?></label>
        <p>
            <?= Library_i18n::get('profile.modify.pass.enter_actual'); ?>
            <input type="password" name="pass_actual" id="pass_actual" /><br /><br />
            <?= Library_i18n::get('profile.modify.pass.enter_new'); ?>
            <input type="password" name="pass_new" /><br />
            <?= Library_i18n::get('profile.modify.pass.enter_confirm'); ?>
            <input type="password" name="pass_confirm" />
        </p>
	</fieldset>
	<p><button class="orange"><?= Library_i18n::get('profile.submit'); ?></button></p>
</form>
