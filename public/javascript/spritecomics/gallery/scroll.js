var detailImage = document.getElementById('detail-image'),
	onDrag = false,
	Xpos = 0;

detailImage.draggable = false;

detailImage.addEventListener('mousedown', function(e) {
	if(!onDrag) {
		e.preventDefault();
		document.body.style.cursor = 'ew-resize';
		clientXInit = e.clientX;
		onDrag = true;
	}
}, false);
document.body.addEventListener('mousemove', function(e) {
	if(onDrag) {
		detailImage.style.left = Xpos + (e.clientX-clientXInit) + "px";
	}
}, false);
document.body.addEventListener('mouseup', function(e) {
	if(onDrag) {
		document.body.style.cursor = 'auto';
		Xpos = parseInt(detailImage.style.left);
		onDrag = false;
	}
}, false);
