<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return view('users.index',[
            'users' => $users
        ]);
    }

    public function online($id){
        $userStatus = User::find($id)->onlineStatus();
        return $userStatus;
    }
}
