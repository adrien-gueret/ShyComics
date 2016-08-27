function turnCommentIntoForm(id, baseURL, content)
{
	var formComment = "<form action=\"" + baseURL + "spritecomics/edit/comment\" method=\"post\" class=\"moderation\">";
	formComment += "	<fieldset>";
	formComment += "		<input type=\"hidden\" name=\"__method__\" value=\"update\" /><input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
	formComment += "		<textarea name=\"content\" maxlength=\"255\">" + content + "</textarea>";
	formComment += "		<button><i class=\"fa fa-check-square-o\"></i></button>";
	formComment += "	</fieldset>";
	formComment += "</form>";
	document.getElementById('comment' + id).innerHTML = formComment;
}

function turnDescIntoForm(id, baseURL, content)
{
	var formComment = "<form action=\"" + baseURL + "spritecomics/edit/description\" method=\"post\" class=\"moderation\">";
	formComment += "	<fieldset>";
	formComment += "		<input type=\"hidden\" name=\"__method__\" value=\"update\" /><input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
	formComment += "		<textarea name=\"content\">" + content + "</textarea>";
	formComment += "		<button><i class=\"fa fa-check-square-o\"></i></button>";
	formComment += "	</fieldset>";
	formComment += "</form>";
	document.getElementById('descDIV').innerHTML = formComment;
}