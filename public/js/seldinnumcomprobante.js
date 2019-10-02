$("#selectsucursal").change(event => {
	$.get(`numComp/${event.target.value}`, function(res, sta){
        $("#num_comprobante").empty();
        $("#num_comprobante").val(res.num_comprobante+1);
        /* Comprueba que la sucursal seleccionada*/
        if(event.target.value==1)
        document.getElementById('num_comprobante').readOnly = true;
        else
        document.getElementById('num_comprobante').readOnly = false;
        });
});