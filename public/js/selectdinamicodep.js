$("#idtb_departamentos").change(event => {
    $.get(`tm/${event.target.value}`, function(res, sta) {
        $("#idtb_tipo_empleados").empty();
        res.forEach(element => {
            $("#idtb_tipo_empleados").append(`<option value=${element.idtb_tipo_usuario}> ${element.nombre} </option>`);
        });
    });
});