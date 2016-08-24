<input type="button" value="<?= Library_i18n::get('parser.buttons.bold'); ?>" onclick="insertTag('[b]','[/b]','<?= $view->textareaId; ?>');" />
<input type="button" value="<?= Library_i18n::get('parser.buttons.italic'); ?>" onclick="insertTag('[i]','[/i]','<?= $view->textareaId; ?>');" />
<input type="button" value="<?= Library_i18n::get('parser.buttons.underlined'); ?>" onclick="insertTag('[u]','[/u]','<?= $view->textareaId; ?>');" />
<input type="button" value="<?= Library_i18n::get('parser.buttons.quote'); ?>" onclick="insertTag('[quote]','[/quote]','<?= $view->textareaId; ?>');" /><br /><br />
<?= $view->tpl_smileys; ?>