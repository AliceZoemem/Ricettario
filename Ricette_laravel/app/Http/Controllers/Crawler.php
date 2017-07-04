<?php
    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\DB;
    use Goutte;

    class Crawler extends Controller
    {
        public function getrecipes(){
            $ricette_ottenute = 0;
            $vett_cibi=array('pasta', 'pizza', 'insalata', 'pollo', 'riso', 'torta', 'zuppa', 'verdura', 'pesce', 'formaggio', 'patate', 'spinaci', 'porchetta', 'spigola', 'tonno', 'salsiccia', 'prosciutto', 'pomodori', 'gamberetti', 'limone', 'ceci', 'legumi', 'farina');
            foreach($vett_cibi as $cibo) {
                $url = 'http://www.giallozafferano.it/ricerca-ricette/' . $cibo;
                $crawler_ricerche = Goutte::request('GET', $url);
                $tot = $crawler_ricerche->filter('.sitewidth .format .loop .flex .title-recipe')->each(function ($node) {
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
                    requisiti($html);

                });
            }
            $tabella_ricette =(array) DB::select('SELECT * FROM recipes');
            $ricette_ottenute = count($tabella_ricette);
            return 'Success for '.$ricette_ottenute.' different recipes';
        }
    }

    function ingredienti($html_ricerca)
    {
        $vett_ing = array();
        $crawler = Goutte::request('GET', $html_ricerca);
        $vett_ing = $crawler->filter('.format .recepy .right-push .intro .ingredienti .fs .ingredient ')->each(function ($ing, $s){
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
        $vect = array('.difficolta', '.preptime', '.cooktime', '.yield', '.costo');
        $field = array('difficulty', 'preparation_time', 'cooking_time', 'doses_per_person', 'cost_level');
        $i = 0;
        foreach ($vect as $par){
            $classi_ricerca = '.format .recepy .right-push .intro .jus .rInfos ' .$par;
            $req = $crawler->filter($classi_ricerca)->each(function ($requirements) {
                $requirements_str = $requirements->text();
                $requirements_str = preg_replace("/\t/", '', $requirements_str);
                $requirements_str = preg_replace("/\n/", '', $requirements_str);
                $requirements_str = trim($requirements_str);

                if($requirements_str != null){
                    return $requirements_str;
                }


            });
            if($req != null){
                $req[0] =  str_replace( "Difficoltà:", "", $req[0]);
                $req[0] =  str_replace( "Preparazione:", "", $req[0]);
                $req[0] =  str_replace( "Cottura:", "", $req[0]);
                $req[0] =  str_replace( "Dosi per:", "", $req[0]);
                $req[0] =  str_replace( "Costo:", "", $req[0]);
                $vett_req[$field[$i]] = $req[0];
                $i += 1;
                if($i == 5){
                    $inserisci = true;
                    $vett_req['description'] = preparazione($html_ricerca);
                    $tabella_ricette =(array) DB::select('SELECT difficulty, preparation_time, cooking_time, doses_per_person, cost_level, description FROM recipes');
                    foreach ($tabella_ricette as $row){
                        $row = (array) $row;
                        if($row == $vett_req){
                            $inserisci = false;
                        }
                    }
                    if($inserisci == true){
                        DB::table('recipes')->insert($vett_req);
                    }
                    $vett_ing = ingredienti($html_ricerca);
                    //print_r($vett_ing);
                    //Aggiungili nella tabella ingredienti
                    //da levare q.b e g  Guanciale250g Sale finoq.b. Aglio1spicchio  Uova( 2 medie)100g )
                    //CApisci dove sistemare priority perche max l aveva messa nella pivot
                    //DA FARE Ricerca con query per confronto per caricare nuove ricette
                }
            }
        }
    }

    function preparazione($html_ricerca){
        $descrizione = '';
        $vett_prep = array();
        $crawler = Goutte::request('GET', $html_ricerca);
        $vett_prep = $crawler->filter('.sitewidth .format .recepy .right-push > p')->each(function ($preparazione) {
            $preparazione_str=$preparazione->text();
            $preparazione_str = preg_replace("/\t/", '', $preparazione_str);
            $preparazione_str = preg_replace("/\n/", '', $preparazione_str);
            $preparazione_str=trim ( $preparazione_str);
            $pos_commento = strpos($preparazione_str, 'comment');
            if($pos_commento == null ){
                return $preparazione_str;
            }
        });
        for($e = 0; $e < count($vett_prep); $e++){
            $descrizione = $descrizione . ' ' .$vett_prep[$e];
        }

        return $descrizione;
    }




