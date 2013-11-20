$.fx.speeds._default = 300;

$(function() {
	$( "#dialog" ).dialog({
		autoOpen: false,
		show: "blind",
		hide: "explode"
	});

	$( "#opener" ).click(function() {
		$( "#dialog" ).dialog( "open" );
		return false;

	});
	
	$( "#cancelButton" ).click(function() {
		$( "#dialog" ).dialog( "close" );
		return false;

	});
	
});