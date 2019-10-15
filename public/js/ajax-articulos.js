$(document).ready(function(){
$('#articulos').select2({
    ajax:{
        url : '/art/venta/articulo',
        dataType : 'json',
        delay : 200,
        data: function(params){
            return{
                q :params.term,
                page : params.page
            };
        },
        processResults : function(data,params){
            params.page = params.page || 1;

            return{
                results : data.data,
                paginations : {
                    more : (params.page * 10)< data.total
                }
            };
        }
    },
    minimumInputLength : 1,
    templateResult : function(repo){
        if(repo.loading) return repo.nombre;

        var markup = repo.nombre;

        return markup;
    },
    templateSelection : function(repo)
    {
        return repo.nombre;
    },
    escapeMarkup : function(markup){return markup;}
});
});