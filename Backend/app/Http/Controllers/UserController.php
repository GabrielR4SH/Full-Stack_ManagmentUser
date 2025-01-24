<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function insert(){
        return 'Oi';
    }

    public function save(Request $request){
        dd($request->all());
    }
}
