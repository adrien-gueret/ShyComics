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
	var formDesc = "<form action=\"" + baseURL + "spritecomics/edit/description\" method=\"post\" class=\"moderation\">";
	formDesc += "	<fieldset>";
	formDesc += "		<input type=\"hidden\" name=\"__method__\" value=\"update\" /><input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
	formDesc += "		<textarea name=\"content\">" + content + "</textarea>";
	formDesc += "		<button><i class=\"fa fa-check-square-o\"></i></button>";
	formDesc += "	</fieldset>";
	formDesc += "</form>";
	document.getElementById('descDIV').innerHTML = formDesc;
}

function turnTagsIntoForm(id, baseURL, empty)
{
	if(!empty)
		var tags = document.getElementById('tagsDIV').innerText;
	else
		var tags = '';
	
	var formTags = "<form action=\"" + baseURL + "spritecomics/edit/tags\" method=\"post\" class=\"moderation\">";
	formTags += "	<fieldset>";
	formTags += "		<input type=\"hidden\" name=\"__method__\" value=\"update\" /><input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
	formTags += "		<textarea name=\"content\">" + tags + "</textarea>";
	formTags += "		<button><i class=\"fa fa-check-square-o\"></i></button>";
	formTags += "	</fieldset>";
	formTags += "</form>";
	document.getElementById('tagsDIV').innerHTML = formTags;
}