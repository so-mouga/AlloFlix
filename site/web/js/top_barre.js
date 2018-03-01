$(function ()
{
    $('#find_film').autocomplete({
        source: function(request, response){
            $.ajax({
                type : "get",
                url:$('#path_film_search').text(),
                data : {
                    'search' : $('#find_film').val()
                },
                success : function(data){
                    response($.map(data.films,function(item){
                        //console.log(item.name);
                        return item.name;
                    }));

                }
            });
        }
    });
});
