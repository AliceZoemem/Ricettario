@extends('master')
@section('title','Tutte le ricette - Il mio frigo')
@section('content')

    <div id="tutte_ricette" >

    </div>

    <script type="text/javascript">
        $.get( "/api/recipes", function( data) {

            data.recipes.forEach(function (ricetta_db, i){
                //crea prima una div per la foto
                var cdiv = $('#tutte_ricette');
                var h1 = $('<h1 />')
                    .text(data.recipes[i].name_recipe)
                    .appendTo(cdiv);
                var l_diff = $('<li />')
                    .text(data.recipes[i].difficulty)
                    .appendTo(cdiv);
                var l_dosi = $('<li />')
                    .text(data.recipes[i].doses_per_person)
                    .appendTo(l_diff);
                var l_tempo_c = $('<li />')
                    .text(data.recipes[i].cooking_time)
                    .appendTo(l_dosi);
                var l_tempo_p = $('<li />')
                    .text(data.recipes[i].preparation_time)
                    .appendTo(l_tempo_c);
                var p = $('<p />')
                    .text(data.recipes[i].description)
                    .appendTo(l_tempo_p);
            });
        });
    </script>
@endsection
