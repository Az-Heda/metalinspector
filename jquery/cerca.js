$(document).ready(function(){
	$("#ricerca").keyup(function() {
	var value = $(this).val().toLowerCase();
	$("#campi tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});