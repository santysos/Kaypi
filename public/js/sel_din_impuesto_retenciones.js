$("#impuesto").change(event => {
	$.get(`impret/${event.target.value}`, function(res, sta){
		$("#porcentaje").empty();
		$("#porcentaje").append(`<option disabled selected> Seleccione % </option>`);
		res.forEach(element => {
			
			$("#porcentaje").append(`<option value=${element.codigo_sri}> ${element.porcentaje+"% - "+element.descripcion_retencion} </option>`);
		});
	});
});