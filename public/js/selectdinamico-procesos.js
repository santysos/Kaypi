moment.locale('es');
$("#departamentos").change(event => {
    $.get(`procesos/dp/${event.target.value}`, function(res, sta) {
        $("#descripcionprocesos").empty('');
        $("#tablaprocesos").empty('');
        $("#descripcionprocesos").append(`<option>Selecciona el Proceso</option>`);
        res.forEach(element => {
            $("#descripcionprocesos").append(`<option value=${element.idtb_descripcion_procesos}> ${element.descripcion_procesos} </option>`);
        });
    });
});
$("#descripcionprocesos").change(event => {
    $.get(`procesos/pro/${event.target.value}`, function(res, sta) {
        $("#tablaprocesos").empty('');
        $("#tablaprocesos").append("<thead ><th>" + '# Orden' + "</th><th>" + 'Proceso' + "</th><th>" + 'Fecha Hora' + "</th><th>" + 'Empleado' + "</th><th>" + 'Asignado por' + "</th><th>" + 'Opciones' + "</th></thead>");
        $("#tablaprocesos").append("<tbody>");
        res.forEach(element => {
            /* Vamos agregando a nuestra tabla las filas necesarias */
            $("#tablaprocesos").append("<tr><td><a target='_blank' href=/ventas/ordenes/" + element.tb_ordenes_idtb_ordenes + ">" + element.tb_ordenes_idtb_ordenes + "</td><td>" + element.descripcion_procesos + "</td><td id='fechas'>" + moment(element.created_at).format('LLLL') + "</td><td>" + element.asignado + "</td><td>" + element.asignador + "</td><td><a href=/ventas/procesos/" + element.tb_ordenes_idtb_ordenes + "><button class='btn btn-success btn-xs' type='button'><span aria-hidden='true' class='glyphicon glyphicon-pencil'></span></button></a></td></tr>");
        });
        $("#tablaprocesos").append("</tbody>");
    });
});