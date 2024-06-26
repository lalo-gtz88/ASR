<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function authenticate(Request $request){

         $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt(['username'=>$request->username, 'password'=>$request->password, 'activo'=> 1])) {
            
            $request->session()->regenerate();
            return redirect()->intended('tickets');
        }
 
        return back()->withErrors([
            'username' => 'Las credenciales proporcionadas son incorrectas, favor de verificar',
        ])->onlyInput('username');
    }


    public function logout(Request $request){
        
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

    public function create(){

        return view('newUser');

    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required | min:8',
        ]);
        
        if($request->password != $request->confirmPassword)
            return;

        if(User::create([
            'name'=> $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ])){
            return back()->with('success', 'Registro guardado');
        }
    }
}
