$("#Cliente").keyup(event => {
    $.get(`bcli/${event.target.value}`, function(res) {
        $("#NombreComercial").val("");
        $("#tb_cliente_idtb_cliente").val("");
        $("#Cedula_Ruc").val("");
        $("#Telefono").val("");
        $("#Email").val("");
        $(res).each(function(key, value) {
            $("#NombreComercial").val(res.nombre_comercial + " - " + res.razon_social);
            $("#tb_cliente_idtb_cliente").val(res.idtb_cliente);
            $("#Cedula_Ruc").val(res.cedula_ruc);
            $("#Telefono").val(res.telefono);
            $("#Email").val(res.email);
        });
    });
});
/*
$("#Cliente").keyup(event => {
    $.get(`bcli/${event.target.value}`, function(res) {
        $("#NombreComercial").val("");
        $("#tb_cliente_idtb_cliente").val("");
        $("#Cedula_Ruc").val("");
        $("#Telefono").val("");
        $("#Email").val("");
        $(res).each(function(key, value) {
            $("#NombreComercial").val(res[0].Cliente_Nombre_Comercial + " - " + res[0].Contacto_Razon_Social);
            $("#tb_cliente_idtb_cliente").val(res[0].id_tb_cliente);
            $("#Cedula_Ruc").val(res[0].Cedula_Ruc);
            $("#Telefono").val(res[0].Telefono);
            $("#Email").val(res[0].Email);
        });
    });
});
*/