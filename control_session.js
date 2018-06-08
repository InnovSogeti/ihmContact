function getCookie(sName) {
	var cookContent = document.cookie, cookEnd, i, j;
	var sName = sName + "=";

	for (i=0, c=cookContent.length; i<c; i++) {
			j = i + sName.length;
			if (cookContent.substring(i, j) == sName) {
					cookEnd = cookContent.indexOf(";", j);
					if (cookEnd == -1) {
							cookEnd = cookContent.length;
					}
					return decodeURIComponent(cookContent.substring(j, cookEnd));
			}
	}       
	return null;
}
if (getCookie("token")) {
	token = getCookie("token");
}
else {
	alert("vous devez vous connecter");
}

