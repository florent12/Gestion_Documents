<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
Use Illuminate\Support\Facades\Auth; 
class UserController extends Controller
{
    //
    function create(Request $request){
        //validation des champs
        $request->validate([
            'name'=>'required',
            'login'=>'required|unique:users,login',
            'password'=>'required|min:5|max:30',
            'cpassword'=>'required|min:5|max:30|same:password'
        
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->login = $request->login;
        $user->password= \Hash::make($request->password);
        $save=$user->save();
        if ($save){
            return redirect()->back()->with('success', 'l"utilisateur a été enrégistrer avec succès');
        }else{
            return redirect()->back()->with('fail','Echec de l"ajout d"un nouvel utilisateur, veuillez réessayer');

        }

    }
    function check(Request $request){
        //validation des champs
        $request->validate([
            'login'=>'required|exists:users,login',
            'password'=>'required|min:5|max:30'
        ],[
            'login.exists'=>'Ces données ne correspondent pas à nos enrégistrements'
        ]);
        $creds=$request->only('login','password');
        if (Auth::guard('web')->attempt($creds)){
            return redirect()->route('user.home');

        }else{
            return redirect()->route('user.login')->with('fail', 'Incorrect credentials');
        }

    }
    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
