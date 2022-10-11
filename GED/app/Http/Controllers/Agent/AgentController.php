<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;


class AgentController extends Controller
{
    //
    function check(Request $request){
        //Validation des champs
        $request->validate([
            'login'=>'required|exists:agents,login',
            'password'=>'required|min:5|max:30'
        ],[
            'login.exists'=>'Ces enrégistrements n"existe pas dans notre base de données'
        ]);
        $creds=$request->only('login','password');
        if (Auth::guard('agent')->attempt($creds)){
            return redirect()->route('agent.home');

        }else{
            return redirect()->route('agent.login')->with('fail', 'Incorrect credentials');
        }

    }
    function logout(){
        Auth::guard('agent')->logout();
        return redirect('/');
    }
}
