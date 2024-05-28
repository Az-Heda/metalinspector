/*
	Apre e chiude il menu di navigazione del sito
	idea presa da www.sololearning.com
*/
$(document).ready(function(){
	$("#open_menu").click(function(){
		$("body").attr("class", "menu-visibile");
	});
	$("#menu").mouseleave(function(){
		$("body").removeAttr("class");
	});
});