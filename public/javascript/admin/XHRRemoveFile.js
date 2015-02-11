function requestRemoveFile(callback, fileId, dir) {
	var xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};
	
	xhr.open("GET", dir + "?id=" + fileId, true);
	xhr.send(null);
}

function readDataRemoveFile(data) {
	var divMain = document.getElementById('gallery_main'),
	dataJSON = JSON.parse(data);
	
	divMain.innerHTML = dataJSON.infosMessage;
}

function removeFile(fileId, dir) {
	if(confirm('Etes-vous sûr de vouloir supprimer cette image ?') == true) {
		requestRemoveFile(readDataRemoveFile, fileId, dir);
	}
}