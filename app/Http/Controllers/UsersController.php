<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function showProfile(int $id) {
        if (Auth::id() == $id || Auth::user()->is_admin){
            return view('pages.user',['user' => User::find($id)]);
        } else {
            return view('pages.homepage');
        }
    }
}
