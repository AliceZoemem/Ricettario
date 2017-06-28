<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Http\Request;
//use DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //function insert(Request $req)
    #function insert()
    //{
        //dd('apposto');
        //<form action="/insert" method="post">
        //<table>
        //<td>First Name : </td>
        //<td><input type="text" name="firstName"></td>
        //nella blade.php
        //Route::post('/insert', 'Controller@insert')
        //in web.php
        //qua invece
        /*$nome='Alice';
        $priorita='Alta';
        $data= array('name'=> $nome, 'priority'=> $priorita);
        DB::table('ingredients')->insert($data);
        echo ('Success');
        dd('ciao');*/
        //altri
        //$data= array('firstName'=> $firstName, etc..)
        //DB::table('nome_tabella')->insert($data)
        //csrf_field security reason for Laravel
        //{{ csrf_field()}}
        //nella blade
    //}
}
