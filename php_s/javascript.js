//To make confirm an action (delete, drop, etc.)
function confirmAction(texte, url) {
	if (confirm ("Are you sur you want to to :\n\n" + texte)) {
		document.location = url;
	}
}

//On a change of selected db in the menu
function change_db() {
	if (document.frm_db_list.base.selectedIndex > 0) {
		document.frm_db_list.submit()
	}
}