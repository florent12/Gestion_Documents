<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    function check(Request $request){
        //Validation des champs
        $request->validate([
            'login'=>'required|exists:admins,login',
            'password'=>'required|min:5|max:30'
        ],[
            'login.exists'=>'Ces enrégistrements n"existe pas dans notre base de données'
        ]);
        $creds=$request->only('login','password');
        if (Auth::guard('admin')->attempt($creds)){
            return redirect()->route('admin.home');

        }else{
            return redirect()->route('admin.login')->with('fail', 'Incorrect credentials');
        }

    }
    function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
