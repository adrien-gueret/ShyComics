<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title><?= Library_i18n::get('errors.title', $view->error_number); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?= $view->base_url; ?>public/css/errors.css" />
		<link rel="shortcut icon" type="image/x-icon" href="<?= $view->base_url; ?>public/favicon.ico" />
	</head>
	<body class="error_<?= $view->error_number; ?>">
		<figure class="main">
			<img src="<?= $view->base_url; ?>public/images/style/errors/error_screen.png" alt="" />
			<figcaption id="caption">
				<div id="firstStep">
					<?= Library_i18n::get('errors.wild_error_desc', $view->error_number); ?>
					<span id="dialog_arrow" class="arrow"></span>
				</div>
				<div id="secondStep" style="display: none;">
					<?= Library_i18n::get('errors.escape'); ?>
					<a class="firstLink" href="http://shycomics-forum.fr"><?= Library_i18n::get('errors.forum'); ?></a>
					<a href="<?= $view->base_url; ?>"><?= Library_i18n::get('errors.site'); ?></a>
				</div>
			</figcaption>
		</figure>
		<hr />
		<div class="oak_container">
			<p class="bubble">
				<?= $view->message; ?>
				<span class="arrow"></span>
			</p>
		</div>

		<script>
			(function() {
				'use strict';

				function clickHandler()
				{
					if( ! hasClicked)
					{
						hasClicked	=	true;
						window.clearTimeout(timeout);
						window.clearInterval(arrowInterval);
						figcaption.removeChild(document.getElementById('firstStep'));
						document.getElementById('secondStep').style.display	=	'block';
						figcaption.className	=	'active';
						figcaption.removeEventListener('click', clickHandler);
					}
				}

				var hasClicked		=	false,
					figcaption		=	document.getElementById('caption'),
					dialog_arrow	=	document.getElementById('dialog_arrow'),
					timeout			=	window.setTimeout(clickHandler, 5000),
					arrowInterval	=	window.setInterval(function() {
						if(dialog_arrow.style.opacity == 0)
							dialog_arrow.style.opacity	=	1;
						else
							dialog_arrow.style.opacity	=	0;
					}, 500);

				figcaption.addEventListener('click', clickHandler);
			})();
		</script>
	</body>
</html>