<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;

class Home extends Controller
{
    public function getingredients(){
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.welcome', [
            'ingredientifromdb' => $item_ingredienti,]);
    }

}