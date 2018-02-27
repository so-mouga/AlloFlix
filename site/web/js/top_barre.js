$(function ()
{
    console.log($("#find_film"));

    var liste = [
        "Harry Potter",
        "Spiderman",
        "X-Men",
        "Dragon Ball Z",
        "Pokemon"
    ];

    $('#find_film').autocomplete({
        source : liste
    });
});
