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






Route::get('crawler', 'Crawler@getrecipes');


Route::get('/', function () {
    //$array = array('apple', 'banana', 'coconut');

    //print_r(array_splice($array, 5));
    return view('welcome');
});
//lui ha fatto una parte di form con una function post:insert

