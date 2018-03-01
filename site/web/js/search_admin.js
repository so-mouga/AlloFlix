$(function ()
{
    $('#find_user').autocomplete({
        source: function(request, response){
            $.ajax({
                type : "get",
                url:$('#path_user_search').text(),
                data : {
                    'search' : $('#find_user').val()
                },
                success : function(data){
                    console.log(data);
                    response($.map(data.users,function(item){
                        //console.log(item.name);
                        return item.pseudo;
                    }));

                }
            });
        },
    });
});
