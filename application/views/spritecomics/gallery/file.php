<div class="element" style="background-image: url(<?= $view->base_url.$view->document->getThumbPath(); ?>)" ;>
    <div></div><!--Necessary for puting the next div to the bottom-->
    <div>
        <div class="title">
            <div>
                <a href="<?= $view->base_url . 'spritecomics/gallery/details/' . $view->document->getId(); ?>">
                    <div><b><?= $view->document->getParentFileName(); ?></b></div>
                    <div><?= $view->document->prop('name'); ?></div>
                </a>
            </div>
            <div class="heart"><a href="rararar"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
        </div>
    </div>
</div>