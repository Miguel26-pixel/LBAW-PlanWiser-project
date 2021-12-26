<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    protected function validator()
    {
        return  [
            'fullname' => 'string|max:255',
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore(Auth::user())],
            'username' => ['required','string','min:4',Rule::unique('users')->ignore(Auth::user())]
        ];
    }

    protected function passValidator()
    {
        return  [
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    public function showProfile(int $id) {
        if (Auth::id() == $id || Auth::user()->is_admin){
            $user = User::find($id);
            $projects = $user->projects->sortByDesc('created_at');
            return view('pages.user',['user' => $user,'projects' => $projects]);
        } else {
            return view('pages.homepage');
        }
    }

    public function update(int $id, Request $request) {
        if (!(Auth::id() == $id || Auth::user()->is_admin)) {
            return view('pages.homepage');
        }
        $validator = $request->validate($this->validator());

        if ($request->hasFile('img_url')) {
            $request->img_url->storeAs('images/users','img_user_'.$id.'.png','public_files');
        }

        $user = User::find($id);
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->img_url = 'images/users/img_user_'.$id.'.png';
        $user->save();

        return redirect()->back();
    }

    function updatePassword(int $id, Request $request) {
        if (!(Auth::id() == $id || Auth::user()->is_admin)) {
            return view('pages.homepage');
        }
        $validator = $request->validate($this->passValidator());

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back();
    }
}
