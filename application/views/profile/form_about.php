<?= Library_i18n::get('profile.modify.about_change'); ?><br />
<form id="form_about"
	  class="form-line"
	  action="<?= $view->base_url; ?>profile/modify/about"
	  method="post">
	<fieldset id="form_about_part">
		<legend><i class="fa fa-commenting-o" aria-hidden="true"></i></legend>
		<textarea id="content-about" name="content"><?= $view->user_about; ?></textarea>
		<p><?= $view->tpl_buttons; ?></p>
	</fieldset>
	<p><button class="orange"><?= Library_i18n::get('profile.submit'); ?></button></p>
</form>
<script src="<?= $view->base_url; ?>public/javascript/parser.js"></script>