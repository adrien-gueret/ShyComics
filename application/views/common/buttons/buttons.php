<input type="button" value="<?= Library_i18n::get('parser.buttons.bold'); ?>" onclick="insertTag('[b]','[/b]','<?= $view->textareaId; ?>');" />
<input type="button" value="<?= Library_i18n::get('parser.buttons.italic'); ?>" onclick="insertTag('[i]','[/i]','<?= $view->textareaId; ?>');" />
<input type="button" value="<?= Library_i18n::get('parser.buttons.underlined'); ?>" onclick="insertTag('[u]','[/u]','<?= $view->textareaId; ?>');" />
<select onchange="insertTag('[size=' + this.options[this.selectedIndex].value + ']','[/size]','<?= $view->textareaId; ?>'); this.options[2].selected = 'selected';">
	<option value="50"><?= Library_i18n::get('parser.buttons.size.50'); ?></option>
	<option value="85" ><?= Library_i18n::get('parser.buttons.size.85'); ?></option>
	<option selected="selected"><?= Library_i18n::get('parser.buttons.size.100'); ?></option>
	<option value="150" ><?= Library_i18n::get('parser.buttons.size.150'); ?></option>
	<option value="200" ><?= Library_i18n::get('parser.buttons.size.200'); ?></option>
</select>
<input type="button" value="<?= Library_i18n::get('parser.buttons.link'); ?>" onclick="insertTag('[url]','[/url]','<?= $view->textareaId; ?>');" />
<input type="button" value="<?= Library_i18n::get('parser.buttons.quote'); ?>" onclick="insertTag('[quote]','[/quote]','<?= $view->textareaId; ?>');" /><br /><br />
<?= $view->tpl_smileys; ?>