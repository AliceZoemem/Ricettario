<div class="topmenu" id="Menu">
    <a href="/">Home</a></li>
    <a href="all">Tutte le ricette</a>
    <a href="oneperson">Ricette per 1</a>
    <a href="#">Contatti</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="respo()">&#9776;</a>
</div>
<script>
function respo() {
        var x = document.getElementById("Menu");
    if (x.className === "topmenu") {
        x.className += " responsive";
    } else {
          x.className = "topmenu";
      }
    }
</script>

