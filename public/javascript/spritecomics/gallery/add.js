(function(document) {
	'use strict';

	// Disable file part of the form when adding folder
	var form_file_part	=	document.getElementById('form_file_part'),
		form			=	document.getElementById('form_add_content');

	for(var i = 0, l = form.elements.length; i < l; i++)
	{
		if(form.elements[i].name === 'is_dir')
			form.elements[i].addEventListener('click', toggleFilePart);
	}

	function toggleFilePart()
	{
		form_file_part.className	=	this.value == 1 ? 'inactive' : '';
	}

	// Generate thumbnail of the file
	var	form_file			=	document.getElementById('form-file'),
		canvas				=	document.getElementById('preview-thumbnail'),
		previewContainer	=	document.getElementById('preview-container'),
		thumbnailDataUrl	=	document.getElementById('thumbnail-data-url'),
		ctx					=	canvas.getContext('2d');

	canvas.width	=	150;
	canvas.height	=	250;
	ctx.fillStyle	=	'#fff';

	form_file.onchange	=	function()
	{
		if(form_file.files && form_file.files[0])
		{
			var reader = new FileReader();

			reader.onload = function(e) {
				var preview	=	new Image();
				preview.onload	=	drawCover;
				preview.src	=	e.target.result;
			};

			reader.readAsDataURL(form_file.files[0]);
		}
	};

	function drawCover()
	{
		var img			=	this,
			offsetX		=	0.5,
			minRatio	=	Math.min(canvas.width / img.naturalWidth, canvas.height / img.naturalHeight),
			newWidth	=	minRatio * img.naturalWidth,
			newHeight	=	minRatio * img.naturalHeight,
			aspectRatio	=	1;

		if(newWidth < canvas.width)
			aspectRatio	=	canvas.width / newWidth;
		else if(newHeight < canvas.height)
			aspectRatio	=	canvas.height / newHeight;

		newWidth	*=	aspectRatio;
		newHeight	*=	aspectRatio;

		var coverWidth	=	Math.min(img.naturalWidth, img.naturalWidth / (newWidth / canvas.width)),
			coverHeight	=	Math.min(img.naturalHeight, img.naturalHeight / (newHeight / canvas.height)),
			coverX		=	Math.max(0, (img.naturalWidth - coverWidth) * offsetX);

		ctx.fillRect(0, 0, canvas.width, canvas.height);
		ctx.drawImage(img, coverX, 0, coverWidth, coverHeight, 0, 0, canvas.width, canvas.height);

		thumbnailDataUrl.value	=	canvas.toDataURL();

		if( ! slideDown.launched)
			slideDown();
	}

	function slideDown()
	{
		var height	=	0;
		var clock	=	window.setInterval(function interval() {
			previewContainer.style.height	=	(++height) + 'px';
			++document.body.scrollTop;

			if(height >= 257)
				window.clearInterval(clock);
		}, 1);

		slideDown.launched	=	true;
	}

	slideDown.launched	=	false;
})(document);