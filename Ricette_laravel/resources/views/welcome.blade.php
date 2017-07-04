<!DOCTYPE html>
<html>
    <style>
        html {
            background:linear-gradient(
                    rgba(0, 0, 0, 0.5),
                    rgba(0, 0, 0, 0.5)
            ), url('spezie_1.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            color: white;

        }
        canvas { display:block; }
    </style>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Ricette</title>
    </head>

    <body id="corpo_testo">
        <input type="text" name="ingrediente" id="ingrediente" value="" style="height: 30px; width: 300px;" onchange="cambia_testo"/>
        <button type="add" onclick="">Add!</button>
    </body>

</html>