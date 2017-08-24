<!DOCTYPE html>
<html >
    <style>
        @font-face {
            font-family: Myfont;
            src: url(ufonts.com_segoe_script.eot);
        }
        .intro{
            font-size: 400%;
            font-family: "Myfont";
            text-align: center;
            margin-bottom: 2px;
        }
        .container{
            text-align: center;
        }
    </style>
    <head>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link rel="stylesheet" href="{{ URL::asset('/css/Ricette_stile.css') }}" />
        <script src="{{ asset('/js/Ricette_js.js') }}"></script>
        <title>@yield('title')</title>
    </head>

    <body onload="start()">
        @include('pag_recipes.rightmenu')
        @include('pag_recipes.header')
        <div class="intro"> Il mio frigo</div>
        <div class="container">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container_footer">
                <p class="text-muted">Ricette - project by @alicealbertin</p>
            </div>
        </footer>
    </body>
</html>
<!-- <small>Ricette - project by @alicealbertin</small>-->