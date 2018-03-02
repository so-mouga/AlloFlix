var pathHeart = $("#data-film-js").attr("data-path-love");
var pathWatchLater = $("#data-film-js").attr("data-path-watch-later");
var filmId = $("#data-film-js").attr("data-film-id");

$( "#heart_action" ).click(function() {
    if ($(".love_film")[0]){
        dataLove = false;
    }
    else if ($(".not_love_film")[0]){
        dataLove = true;
    }

    $.ajax({
        url: pathHeart,
        dataType: "json",
        data: {
            "love" : dataLove,
            "filmId" : filmId
        },
        type: 'POST',
        success: function (data)
        {
           if (data.love == true){
               $(".not_love_film").replaceWith(" <img class='love_film' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIhSURBVFhH7Zg/SxxRFMVvupBYJB9Ao61RGwUx+8ci2MXagDaC+BHEIH4JQQhpFEkhtvoF7A1YCPnTiSaE2IgoItGZ/O5wkWX3vv3j7owLmQOHnXnv3nPOm3nMDCs5cuT4XxBPytPojYxFBZmOSlKOC9IXizyx6SC0JpqQV9qT9KKhWjbdPhB9HZdkJyrKJb9xJTH9zvhSPCrPrPwe0ZQ81zn4o6YPLbgNB628dSQrL8kqvKs2qCY13+KijFqrJFea8F5tJQl4C1eauRM1wGDdEw2R+ouoLMMYjnB85dWESP2a2TYHTOY8oUak70TpzTUiIWfNvj5s7/zyRNIkAX96e7kGhHvvCWRBQs5YjDAo2vKaM2FRNi1GGFzBfbc5A6q3xQiDwoPqxgx5YDHCYBV7TmMmZHvtWowwKFyubsyQyxYjDFYxwFX86zSnSvVUb4tRHxR/9ETSJOE+mX1j8LXxgoZjTygN4nXKI+al2TcHe6+eeYKdJOGu8Bk329agjazs3BPuBJNwZZkyu4cBgQmC/vYM2iHh/qBbMJv2gFgvYl88o4cQvUP2eb/Jdwb6pUHIz55hK0Rjm3A9Jtt5YDCve8czr0f6rtnPiyaTLqJJGSLkkRfEI+G+6lPB2rOB3fINL1Alk5o0b2kjJLfceTXqGFd5wcoeF4R5V7kv9VjHbLo7QKC3BLtJyLENdxcItkLAD3bafdC/NJR2miNHjhwi8g+LjCGk7X2qQwAAAABJRU5ErkJggg=='>" );
           }else {
               $(".love_film").replaceWith(" <img class='not_love_film' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAARKSURBVFhH7VhbbBtFFDUPCcQHEo8/xAf9AySQeIkPpAraOJv4lRjxgVDFR1EpAiohUUT6Ywo08a4fMQJVlKhFtBINgZICUl+URFWa9cw6jZs0QJLmWZwGUjsPex27dezhXnXAKYxfeTgg5UhHsnfn3nt2dubeO2tYxzr+yzC7u+6tcpI37I0Bv9VNI5Wyf6FaIclab2AE/n+6WaZP8KE5IdV3Pml10X1og7boA33ZfQG1SiGvb6qn9/ChxcPhYDebXKTO4qKxupaBeOv5MAtOJNnFyAILXk6y0/1zrPHEWLrGqyVsHu0n04fqfdz0bxg/0O6H+204xgdj0QZt0Ud3KMlag2GGvs0K0U0KeQdjctP8MDu67qjxaKe3H7iga+PzbHQ2k5NDkTRzHx9NmV00KjnJ09yFAX/jNd/J8dTQdFpo+xcxxrb9F3Sbl57C2NyFGPgUNjf9cdfXA4lCjhfzu54Ig1mIS3vIQ5VO+rDFReLfwzXRWBExVl1LP7wNesrA2E1czr+BU/3qgd4YzozIUT42nZlIw+sehJm4+NmZUEY0Jh8xJs6kpJC3uZwbYfSod5vdNEbH8r/WXBwBvvlFn47E36IxhegfjTPQEDU1dNzFZWWBOwoWrS4yLJYU1hNSdK9YvvvVgF5Zr27nsrKANKDizhIZlZNHusOstlE7y2VlYfVo4XOhhNConOz6LcFgs1y5rmoRqmSSwhwlMionUQNq4bKygKQ81zt5VWhUTvb9fo1BDo1xWVnYGzWKFUNkVE62D0ZZrVcb4rKykGSybefh/rjIqJzc2xbCWv0xl5WF5CB3Yu3VLq3tRtmyNzgnyepGLutGgMD3djav3Sye+GWWWT10LGe52+hovx3SzSTWVpGD1SRWn1eaeqLVMtnC5YhhlMmz2CL1XC7vjm7WpjJQy/uKarugwdyz4+DPsaXW1FIZgORscdOEsYE8ziXkBz4FbPUOz8nxayKHK8lhaLW2NvXMWxS6m4cvDtjdwHafag5Mldw6lUL5+FjS6qWdL7S03MJDFw9J8T8CU69juy5yvlx+3jmZsnjoBJ59eMjSUdFAnoPFG+sY1oVBlsqj5yMZs4vMbnb6H+Shlg44jdlsXm1ehYZSFKxUYr6DmZuFTfEoD7F8mFz0ZbtPixc6SBXiD73T2E5FjU71Ke565VDtIluf9wV0bM1FwQvx2+5wxuwmuuT0P8NdrjxMsvoSdLzxsyOlrclDnZNpOG9MV8rqY9zV6qHa6bfD6U1vG4gKxSzmyEyGKcdGr0LKClW4yAPcxeqjop4YMQUdORfOmSf7r6TYW1/+qlvdWnBJnziWCyxN0AHN7GsPLfxTHK7TFz/pjkN3clD66Nht3KT82NSgbTB7yKX3jw4lh2euH/gPa39AjqPzJsX/Gh+2tsCDNparHYf64rtbBxPw6ieK+fJVVkAveSsk3/01bvoNduf88jrW8T+HwfAnb7OIr85GDr0AAAAASUVORK5CYII='>" );
           }
        }
    });


});

$( "#watch_later_action" ).click(function() {
    if ($(".film_watch_later")[0]){
        dataLater = false;
    }
    else if ($(".film_no_watch_later")[0]){
        dataLater = true;
    }

    $.ajax({
        url: pathWatchLater,
        dataType: "json",
        data: {
            "later" : dataLater,
            "filmId" : filmId
        },
        type: 'POST',
        success: function (data)
        {
            console.log(data);
            if (data.watch == true){
                $(".film_no_watch_later").replaceWith(" <img class='film_watch_later' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFYSURBVFhH7dO7S8NAHMDxuPgf+C/ZBJNW8DGLbuLSv8BJappU0MXXooNuDi7OUtBegkGUxkVFRJcKgtA88FHPRu8npWhrTq534n3h4F4cHwhRZDLZHypTQDkF4z6yFKushZZUs9LIlpxV4ZAJbmLlODi6ifHU+mkgFBJwfu0JXz284rO7Zzy5dhIYNlomV/jVjkuGdxvj8UU31C2U/7jFKYmjTeJokzja/h9OnSsPkOmvYoLTipURrYjiQfNAJ1tUMcMNLzjhtlPDhu1GqnVokKNUsfms82g0wZUv6+8P7p/XqZDMfgjddnamN6rRxX3j8+G0SGa4pLHZan+u5Ozlt/ywHdncD7shmeIgWmRPcFBaZE9x0E+RXHBQN2QTsMsNB3VCzmz6j1xx0HfI1uHxwkGdkB5vHPQV0hMFB7Ui3etILBwESM1EL8LhoASZKaAhspTJZHxTlDc17GsTXkWYNAAAAABJRU5ErkJggg=='>" );;
            }else {
                $(".film_watch_later").replaceWith(" <img class='film_no_watch_later' src='data:image/png;base64,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'>" );
            }
        }
    });
});
