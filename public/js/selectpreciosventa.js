$("#pidarticulo").change(event => {
	$.get(`dsp/${event.target.value}`, function(res, sta){
		$("#pprecio_venta").empty();
		res.forEach(element => {
			$("#pprecio_venta").append(`<option value disabled selected> Seleccione el precio </option>`);
			$("#pprecio_venta").append(`<option value=${element.pvp}> ${element.pvp} </option>`);
			$("#pprecio_venta").append(`<option value=${element.pvp1}> ${element.pvp1} </option>`);
			$("#pprecio_venta").append(`<option value=${element.pvp2}> ${element.pvp2} </option>`);
			$("#pstock").val(element.stock);
			$("#piva").val(element.iva);
		});

	});
});