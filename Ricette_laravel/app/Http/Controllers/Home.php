<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use DOMDocument;


class Home extends Controller
{

    public function ing_db(){
        $ingredienti = Ingredient::all();
        $ingrediente_inserito = $_POST['ingredient'];
        foreach ($ingredienti as $ing){
            if($ing->name == $ingrediente_inserito){
                return 'si';
            }
        }
        return 'no';
    }

    public function getingredients(){
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.index', [
            'ingredientifromdb' => $item_ingredienti]);
    }

    public function getrecipes(){
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.index', [
            'ingredientifromdb' => $item_ingredienti]);
    }

    public function getallrecipes(){
        $item_ingredienti = Ingredient::all();
        $dom = new DOMDocument('1.0', 'utf-8');

        $element = $dom->createElement('test', 'This is the root element!');

        $dom->appendChild($element);
        return view('pag_recipes.all');
        //, ['ingredientifromdb' => $item_ingredienti]
    }

    public function print_results(){
        $id_ingredients = $_POST['ids_recipes'];
        return view('pag_recipes.results', [
            'idingredientsfinded' => $id_ingredients]);
    }

    public function stamponerecipe($number = null){
        if($number != null){
            $myfile = fopen("../resources/views/pag_recipes/singlerecipe.blade.php", "r+")or die("Unable to open file!");
                while(!feof($myfile)) {
                    $riga = fgets($myfile);
                    if(strpos($riga, '<div id=') > 0){
                        $div_results = '<h1>'.Recipe::find($number)->name_recipe.'</h1>'.
                            '<li> difficolta: '.Recipe::find($number)->difficulty.'</li>'.
                            '<li> dosi: '.Recipe::find($number)->doses_per_person.'</li>'.
                            '<li> tempo di cottura: '.Recipe::find($number)->cooking_time.'</li>'.
                            '<li> tempo di preparazione: '.Recipe::find($number)->preparation_time.'</li>'.
                            '<h3> Preparazione: </h3>'.
                            '<p>'.Recipe::find($number)->description.'</p>'.
                            '</br></br>@endsection'
                        ;
                        fwrite($myfile, $div_results);
                    }
                }
            fclose($myfile);
        }
    }

    public function giveingredient(){
        $vett_ids_ingredients = array();
        $ingredients_gave = $_POST['ingredients'];
        $item_ingredienti = Ingredient::all();
        foreach($item_ingredienti as $ingredient_table) {
            foreach ($ingredients_gave as $single_ingredient_gave){
                if($single_ingredient_gave == $ingredient_table['name']){
                    array_push($vett_ids_ingredients, $ingredient_table['id']);
                }
            }

        };
        $vett_ids_recipes = array();
        $recipes = array();
        $vett_query = array();
        $vett_ids_recipes_finded = array();
        foreach ($vett_ids_ingredients as $id){
            array_push($recipes, Recipe::whereHas('ingredients', function ($query) use ($id, $vett_query){
                //foreach ($id_ingredients as $id){
                $query->where('id',$id);
                //}

            })->get());
        }
        foreach ($recipes as $single_recipe){
            foreach ($single_recipe as $id_single_recipe) {
                array_push($vett_ids_recipes, $id_single_recipe->id);
            }
        }
        $vett_count_ids = array_count_values($vett_ids_recipes);
        foreach($vett_count_ids as $key => $value){
            if($value > 1){
                array_push($vett_ids_recipes_finded, $key);
            }
        }
        if($vett_ids_recipes_finded == null){
            foreach($vett_count_ids as $key => $value){
                array_push($vett_ids_recipes_finded, $key);
            }

        }

        $myfile = fopen("../resources/views/pag_recipes/results.blade.php", "r+")or die("Unable to open file!");
            while(!feof($myfile)) {
                $riga = fgets($myfile);
                if(strpos($riga, '<div id=') > 0){
                    foreach ($vett_ids_recipes_finded as $result){
                        $div_results = '<h1><a href="singlerecipe/'.$result.'">'.'<u>'.Recipe::find($result)->name_recipe.'</u>'.'</a></h1>'.
                            '<li> difficolta: '.Recipe::find($result)->difficulty.'</li>'.
                            '<li> dosi: '.Recipe::find($result)->doses_per_person.'</li>'.
                            '<li> tempo di cottura: '.Recipe::find($result)->cooking_time.'</li>'.
                            '<li> tempo di preparazione: '.Recipe::find($result)->preparation_time.'</li>'.
                            '<h3> Preparazione: </h3>'.
                            '<p>'.Recipe::find($result)->description.'</p>'.
                            '</br></br></div>@endsection'
                        ;

                        fwrite($myfile, $div_results);
                    }
                }
            }
        fclose($myfile);


        //$doc = new DOMDocument();
        //$doc->load('http://ricette_ricette_ricette.com/results');
        //dd($doc);
        //        dd($vett_ids_recipes_finded);
        //        return response()->json([
        //            'status' => 'ok',
        //            'ids_ricette' => $vett_ids_recipes_finded]);
        return $vett_ids_recipes_finded;
    }
}

