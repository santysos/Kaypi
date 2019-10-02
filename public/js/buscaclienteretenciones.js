$("#Cliente").keyup(event => {
    $.get(`bcli/${event.target.value}`, function(res) {
        $("#razon_social").val("");
        $("#razon_social_comercial").val("");
        $("#tb_cliente_idtb_cliente").val("");
        $("#documento").val("");
        $("#Telefono").val("");
        $("#Email").val("");
        $("#direccion_establecimiento").val("");

        $(res).each(function(key, value) {
            $("#razon_social").val(res.razon_social);
            $("#razon_social_comercial").val(res.nombre_comercial + " - " + res.razon_social);
            $("#tb_cliente_idtb_cliente").val(res.idtb_proveedor);
            $("#documento").val(res.cedula_ruc);
            $("#Telefono").val(res.telefono);
            $("#Email").val(res.email);
            $("#direccion_establecimiento").val(res.direccion);
        });
    });
});