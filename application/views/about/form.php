<form method="post">					
	<fieldset>
		<label for="contact_list"><?= Library_i18n::get('about.form.general_topic'); ?></label>
		<select id="contact_list" name="contact_list">
			<option value="Bug"><?= Library_i18n::get('about.form.bug'); ?></option>
			<option value="Suggestion"><?= Library_i18n::get('about.form.suggestion'); ?></option>
			<option value="Partnership"><?= Library_i18n::get('about.form.partnership'); ?></option>
			<option value="Other"><?= Library_i18n::get('about.form.other'); ?></option>
		</select><br><br>

		<label for="contact_username"><?= Library_i18n::get('about.form.username'); ?></label>
		<input name="contact_username" id="contact_username" type="text" required=""><br><br>
		
		<label for="contact_email">E-Mail :</label>
		<input name="contact_email" id="contact_email" type="email" required=""><br><br>
		
		<label for="contact_subject"><?= Library_i18n::get('about.form.topic'); ?></label>
		<input name="contact_subject" id="contact_subject" type="text" required=""><br><br>
		
		<label for="contact_message"><?= Library_i18n::get('about.form.message'); ?></label>
		<textarea name="contact_message" id="contact_message" required=""></textarea><br>
	</fieldset>
	
	<button class="orange" type="submit"><?= Library_i18n::get('about.form.submit'); ?></button>
	<button class="orange" type="reset"><?= Library_i18n::get('about.form.reset'); ?></button>
</form>