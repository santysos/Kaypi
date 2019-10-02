$("#servicios").change(event => {
	$.get(`ds/${event.target.value}`, function(res, sta){
		$("#descripcionservicios").empty();
		res.forEach(element => {
			$("#descripcionservicios").append(`<option value=${element.idtb_descripcion_servicios}> ${element.productos} </option>`);
		});
	});
});