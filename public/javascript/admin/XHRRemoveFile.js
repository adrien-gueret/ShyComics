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
	var divInfos = document.getElementById('infos_message'),
	divMain = document.getElementById('gallery_main'),
	dataJSON = JSON.parse(data);
	
	divInfos.innerHTML = dataJSON.infosMessage;
	divMain.innerText = '';
}

function removeFile(fileId, dir) {
	if(confirm('Etes-vous sûr de vouloir supprimer cette image ?') == true) {
		requestRemoveFile(readDataRemoveFile, fileId, dir);
	}
}