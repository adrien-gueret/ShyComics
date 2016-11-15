<form id="form_about"
	  action="<?= $view->base_url; ?>profile/modify/about"
	  method="post">
	<fieldset id="form_about_part">
		<label for="content-about" class="label-full-line"><i class="fa fa-pencil" aria-hidden="true"></i>  <?= Library_i18n::get('profile.modify.about_change'); ?></label>
		<textarea id="content-about" name="content" maxlength="255"><?= $view->user_about; ?></textarea>
		<p><?= $view->tpl_buttons; ?></p>
        
        <hr />
        
        <label class="label-full-line" for="form-DOB"><label for="form-DOB"><i class="fa fa-calendar"></i></label>  <?= Library_i18n::get('login.register.helpers.birthdate'); ?></label>
        <p>
            <select name="DOB" id="form-DOB" style="width: auto;">
                <?php for($i = 1; $i <= 31; $i++): ?>
                    <?php if($view->user_DOB == $i): ?>
                        <option value="<?= $i; ?>" selected><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php else: ?>
                        <option value="<?= $i; ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>/
            <select name="MOB" id="form-MOB" style="width: auto;">
                <?php for($i = 1; $i <= 12; $i++): ?>
                    <?php if($view->user_MOB == $i): ?>
                        <option value="<?= $i; ?>" selected><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php else: ?>
                        <option value="<?= $i; ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>/
            <select name="YOB" id="form-YOB" style="width: auto;">
                <?php for($i = $view->year_now; $i >= 1900; $i--): ?>
                    <?php if($view->user_YOB == $i): ?>
                        <option value="<?= $i; ?>" selected><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php else: ?>
                        <option value="<?= $i; ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>
        </p>

        <label class="label-full-line" for="form-sexe"><i class="fa fa-venus-mars" aria-hidden="true"></i>  <?= Library_i18n::get('login.register.helpers.sexe.sexe'); ?></label>
        <p>
            <?php if($view->user_sexe == 0): ?>
                <input type="radio" name="sexe" value="0" checked><?= Library_i18n::get('login.register.helpers.sexe.male'); ?><br />
                <input type="radio" name="sexe" value="1"><?= Library_i18n::get('login.register.helpers.sexe.female'); ?><br />
                <input type="radio" name="sexe" value="2"><?= Library_i18n::get('login.register.helpers.sexe.undefined'); ?><br />
            <?php elseif($view->user_sexe == 1): ?>
                <input type="radio" name="sexe" value="0"><?= Library_i18n::get('login.register.helpers.sexe.male'); ?><br />
                <input type="radio" name="sexe" value="1" checked><?= Library_i18n::get('login.register.helpers.sexe.female'); ?><br />
                <input type="radio" name="sexe" value="2"><?= Library_i18n::get('login.register.helpers.sexe.undefined'); ?><br />
            <?php else: ?>
                <input type="radio" name="sexe" value="0"><?= Library_i18n::get('login.register.helpers.sexe.male'); ?><br />
                <input type="radio" name="sexe" value="1"><?= Library_i18n::get('login.register.helpers.sexe.female'); ?><br />
                <input type="radio" name="sexe" value="2" checked><?= Library_i18n::get('login.register.helpers.sexe.undefined'); ?><br />
            <?php endif; ?>
        </p>

        <label class="label-full-line" for="form-interest"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>  <?= Library_i18n::get('profile.modify.interest'); ?></label>
        <p>
            <input type="text" name="interest" value="<?= $view->user_interest; ?>" />
        </p>
	</fieldset>
	<p><button class="orange"><?= Library_i18n::get('profile.submit'); ?></button></p>
</form>
<script src="<?= $view->base_url; ?>public/javascript/parser.js"></script>