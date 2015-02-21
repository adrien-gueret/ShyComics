<a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $view->document->getId() ?>" class="gallery-link file">
	<figure class="gallery-document"
			style="background-image: url(<?= $view->base_url.$view->document->getPath(); ?>);">
		<figcaption><?= $view->document->prop('name'); ?></figcaption>
	</figure>
</a>