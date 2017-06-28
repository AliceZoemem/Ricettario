<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
function ingredienti($html_ricerca)
{
    $vett_ing = array();
    $crawler = Goutte::request('GET', $html_ricerca);
    $vett_ing = $crawler->filter('.format .recepy .right-push .intro .ingredienti .fs .ingredient ')->each(function ($ing){
        $ing_str = $ing->text();
        $ing_str = preg_replace("/\t/", '', $ing_str);
        $ing_str = preg_replace("/\n/", '', $ing_str);
        $ing_str = trim($ing_str);
        try {
            $ing_str = str_replace("Scopri i segreti peruna pasta perfetta", "", $ing_str);
        } catch (Exception $exception) {
        }
        return $ing_str;
    });
    if($vett_ing != null)
        return $vett_ing;

}

function requisiti($html_ricerca)
{
    $vett_req = array();
    $crawler = Goutte::request('GET', $html_ricerca);
    $field = array('difficulty', 'preparation_time', 'cooking_time', 'doses_per_person', 'cost_level');
    $vett_req = $crawler->filter('.recepy .right-push .intro .jus .rInfos > li')->each(function ($requirements, $new) {
        $requirements_str = $requirements->text();
        $requirements_str = preg_replace("/\t/", '', $requirements_str);
        $requirements_str = preg_replace("/\n/", '', $requirements_str);
        $requirements_str = trim($requirements_str);
        return $requirements_str;
        //DB::table('recipes')->insert($data);
    });
    $requisiti_database = array();
    if($vett_req != null){
        //return $vett_req;
        $field= array('difficulty', 'preparation_time', 'cooking_time', 'doses_per_person', 'cost_level');
        for($c = 0; $c < count($vett_req); $c++){
            if(strpos($vett_req[$c], 'Difficoltà') == false){
                $vett_req[$c]=str_replace( "Difficoltà:", "", $vett_req[$c]);
            }
            if(strpos($vett_req[$c], 'Preparazione:') == false){
                $vett_req[$c]=str_replace( "Preparazione:", "", $vett_req[$c]);
            }
            if(strpos($vett_req[$c], 'Cottura:') == false){
                $vett_req[$c]=str_replace( "Cottura:", "", $vett_req[$c]);
            }
            if(strpos($vett_req[$c], 'Dosi per:') == false){
                $vett_req[$c]=str_replace( "Dosi per:", "", $vett_req[$c]);
            }
            if(strpos($vett_req[$c], 'Costo:') == false){
                $vett_req[$c]=str_replace( "Costo:", "", $vett_req[$c]);
            }
            $requisiti_database[$field[$c]]=$vett_req[$c];

        }
        return $requisiti_database;


    }

}

function preparazione($html_ricerca){
    $vett_database = '';
    $vett_prep = array();
    $crawler = Goutte::request('GET', $html_ricerca);
    $vett_prep = $crawler->filter('.sitewidth .format .recepy .right-push > p')->each(function ($preparazione, $i) {
        $preparazione_str=$preparazione->text();
        $preparazione_str = preg_replace("/\t/", '', $preparazione_str);
        $preparazione_str = preg_replace("/\n/", '', $preparazione_str);
        $preparazione_str=trim ( $preparazione_str);
        $pos_commento = strpos($preparazione_str, 'comment');
        if($pos_commento == null ){
            return $preparazione_str;
        }
    });
    if($vett_prep != null){
        for($e = 0; $e < count($vett_prep); $e++){
            $vett_database = $vett_database. ' ' .$vett_prep[$e];
        }
        return $vett_database;
    }
    //FINITO

        //print_r($vett_prep);

        return $vett_database;
        /*
         //print_r($vett_prep);
        $vett_database['description']= $vett_prep;
        print_r($vett_database);
        return $vett_prep;
        */
    //$data= array('name'=> $nome, 'priority'=> $priorita);
    //DB::table('ingredients')->insert($data);
    //echo ('Success');
    //DB::table('recipes')->insert('name'= $nome, 'priority' = $priorita);
}


Route::get('crawler', function () {
    $ricette_ottenute = 0;
    $vett_cibi=array('pasta');
    //, 'pizza','insalata', 'pollo', 'riso', 'torta', 'zuppa', 'verdura', 'pesce', 'formaggio', 'patate', 'spinaci', 'porchetta', 'spigola', 'tonno');
    for($i=0; $i < count($vett_cibi); $i++) {
        $url = 'http://www.giallozafferano.it/ricerca-ricette/' . $vett_cibi[$i];
        $crawler_ricerche = Goutte::request('GET', $url);
        $tot = $crawler_ricerche->filter('.sitewidth .format .loop .flex .title-recipe')->each(function ($node, $x) {
            //filtro tutti i risultati delle rcerche fatte tramite il vettore dei cibi
            //node risulta ad ogni giro un nome di una ricetta diversa
            //la formattazione di una pagina di una ricetta e http://www.giallozafferano.it/Pasta-brise.html
            //riformulo quindi ogni node stampandolo con il dash separatore
            //$vett_ingredienti= array();
            try {
                $node_withoutdelimiter = explode(" ", $node->text());
                $html = '';
                //disassemblo e riassemblo i cibi trovati dalla ricerca nelle pagine e creo un link riassemblandoli
                for ($x = 0; $x < count($node_withoutdelimiter); $x++)
                    $html = $html . '-' . $node_withoutdelimiter[$x];

                $html = $html . '.html';
                $html = ltrim($html, '-');
                $html = 'http://ricette.giallozafferano.it/' . $html;
            } catch (Exception $node_withoutdelimiter) {
                $html = 'http://ricette.giallozafferano.it/' . $node . '.html';
            }
            $vett_ingredienti = ingredienti($html);//ingredienti e quantita un array e l insieme degli ingredienti di una ricetta
            $vett_requisiti = requisiti($html);//un array e l insieme dei requisiti di una ricetta
            $vett_preparazione = preparazione($html);//tutto un vettore e una sola preparazione
            //print_r($vett_preparazione);
            //dd(gettype($vett_preparazione));
            //DB::table('recipes')->insert($vett_requisiti);

            return $x;
        });
        for($w = 0; $w < count($tot); $w++)
            $ricette_ottenute = $ricette_ottenute + $tot[$w];
    }
    return 'Success for '.$ricette_ottenute.' different recipes';
});


Route::get('/', function () {
    /*function get_info() {
        $something = "cacca";
        return $something;
    }
    echo get_info();*/
    $c = 1;
    $field= array('difficulty', 'preparation_time');
    $vett_req = array('molto bassa', '10 min');
    $requisiti_database= array();
    $requisiti_database[$field[$c]]=$vett_req[$c];
    echo $requisiti_database[$field[$c]];
    echo $field[$c];
});
//lui ha fatto una parte di form con una function post:insert

