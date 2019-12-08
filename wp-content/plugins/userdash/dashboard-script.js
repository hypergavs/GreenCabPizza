// JavaScript Document
$(document).ready(function(e) {
	$("#dashboard").load($("#dashboard-link").attr("href") + '.php');
    $("#dash-side-nav a").click(function(e){
		e.preventDefault();
		var url = $(this).attr("href") + '.php';
		$("#dashboard").load(url);
	});
	$("#logout-btn").click(function(e){
		e.preventDefault();
		window.location=$(this).attr("href");	
	});
});