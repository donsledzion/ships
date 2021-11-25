<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function show(string $error){
            return view('error',[
                'message' => $error
            ]);
    }
}
