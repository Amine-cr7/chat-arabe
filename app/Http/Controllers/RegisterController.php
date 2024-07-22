<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function registerPage(){
        if(Auth::check()){
            return redirect()->back();
        }
        return view('register');
    }
    public function registerAction(Request $request){
       $user =  User::create($request->all());
        Auth::login($user);
        return redirect('/users');
    }
    public function logout(){
        $user = User::find(auth()->user()->id);
        $user->delete();
        Auth::logout();
        return redirect('/register');
    }
}
