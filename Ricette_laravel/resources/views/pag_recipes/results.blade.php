@extends('master')

@section('title','Risultati - Il mio frigo')

@section('content')

    <div id="ricette_trovate" >
        {{--<label for="prova_ids">ids:</label>--}}
        {{--<input type="text" name="ing" id="prova_ids" style="height: 30px; width: 300px;">--}}
    </div>
    <script type="text/javascript">
        {{--var idsrecipesresults=<?php--}}
            {{--$str = '[';--}}
            {{--foreach($idingredientsfinded as $ids){--}}
                {{--dd($ids);--}}
            {{--}--}}
            {{--$str.=']';--}}
            {{--echo $str;--}}
            {{--?>;--}}
        {{--$(document).ready(function() {--}}
            {{--$( "#prova_ids" ).value({--}}
                {{--source: idsrecipesresults--}}
            {{--});--}}
        {{--} );--}}
    </script>
@endsection
