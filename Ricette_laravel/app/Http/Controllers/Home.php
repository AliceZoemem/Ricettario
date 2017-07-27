<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use DOMDocument;


class Home extends Controller
{

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

        $doc = new DOMDocument();
        $doc->load('http://ricette_ricette_ricette.com/results');
        dd($doc);
        //        dd($vett_ids_recipes_finded);
        //        return response()->json([
        //            'status' => 'ok',
        //            'ids_ricette' => $vett_ids_recipes_finded]);
        return $vett_ids_recipes_finded;
    }
}
/*
 $dom = new DOMDocument();
$dom->loadHTMLFile("html/signinform.html");//loads file here
$form = $dom->getElementsByTagName("form")->item(0);
$div = $dom->createElement("div");
$dom->appendChild($div)->appendChild($form);
echo $dom->saveHTML();

$dom = new DOMDocument();
$dom->loadHTMLFile("assets/dom_document-form.html");
$div = $dom->createElement("div");
$form = $dom->getElementsByTagName("form")->item(0);
$form->appendChild($div);
echo $dom->saveHTML();

 require('http://ricette_ricette_ricette.com/all');

        $html = '
            <div>
                mydiv
                <ul>
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                </ul>
            </div>';

// intialize new DOM from markup
        phpQuery::newDocument($markup)
            ->find('ul > li')
            ->addClass('my-new-class')
            ->filter(':last')
            ->addClass('last-li');

// query all unordered lists in last used DOM
        pq('ul')->insertAfter('div');

// iterate all LIs from last used DOM
//        foreach(pq('li') as $li) {
//            // iteration returns plain DOM nodes, not phpQuery objects
//            pq($li)->addClass('my-second-new-class');
//        }

// same as pq('anything')->htmlOuter()
// but on document root (returns doctype etc)
        print phpQuery::getDocument();
        dd('stop');

*/