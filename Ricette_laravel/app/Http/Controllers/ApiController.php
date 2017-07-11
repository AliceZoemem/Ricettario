<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use Illuminate\Support\Facades\DB;
use Goutte;
use Illuminate\Validation\Rules\In;

class ApiController extends Controller
{
    public function getRecipes($number = null){
        if($number!=null){
            $recipes = Recipe::orderBy('created_at','desc')->take($number)->get();
        }else{
            $recipes = Recipe::all();
        }
        return response()->json([
            'status' => 'ok',
            'recipes' => $recipes]);
    }

    public function getIngredients(){
        $ingredients = Ingredient::all();
        //costruisce un object formato json
        return response()->json([
            'status' => 'ok',
            'ingredient' => $ingredients]);
    }

    public function getPivot(){
        $ricette = new Recipe();
        $pivot = $ricette->ingredients();
        return response()->json([
            'status' => 'ok',
            'pivot' => $pivot]);
    }
}