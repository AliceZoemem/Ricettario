<script type="text/javascript">
    $.get( "/api/recipes/5", function( data ) {
        var cList = $('#rightmenu');
        data.recipes.forEach(function (ricetta_db, i){
            i += 1;
            var li = $('<li>')
                .appendTo(cList);
            var aaa = $('<a />')
                .attr("href", 'http://localhost/' + i)
                .text(ricetta_db.name_recipe)
                .appendTo(li);
        });
    });

   /*

    <li><a href="#"><img src="css/img/cucina_marrone.jpg" style=" width: 200px; height: 150px"> difficolta:media</a></li>
    <li><a href="#"><img src="css/img/cucina_marrone.jpg" style=" width: 200px; height: 150px"> difficolta:media</a></li>
    <li><a href="#"><img src="css/img/cucina_marrone.jpg" style=" width: 200px; height: 150px"> difficolta:media</a></li>
    <li><a href="#"><img src="css/img/cucina_marrone.jpg" style=" width: 200px; height: 150px"> difficolta:media</a></li>
    <li><a href="#"><img src="css/img/cucina_marrone.jpg" style=" width: 200px; height: 150px"> difficolta:media</a></li>*/
</script>
<ul id="rightmenu">
    <li class="active" id="intro"><a>Ultime 5 ricette inserite</a></li>

</ul>