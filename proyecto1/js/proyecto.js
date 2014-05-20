$(document).ready(function() {

	$("#itemBusqueda #verDescripcion").click(function() {
		$("#itemBusqueda ul li.resumen").hide();
		$("#itemBusqueda ul li.detallado").show();
		return false;
	});
        $("#detallado #archivoAdjunto").click(function() {
		$("center.visualizar").show();
		return false;
	});
});