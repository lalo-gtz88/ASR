<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    public function index() {
        
        return view('usuarios');
    }

    public function roles($id){
        return view('roles',['id'=> $id]);
    }

    public function authenticate(Request $request){

         $request->validate([
            'usuario' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt(['username'=>$request->usuario, 'password'=>$request->password, 'activo'=> 1])) {
            
            $request->session()->regenerate();
            return redirect()->intended('tickets');
        }
 
        return back()->withErrors([
            'password' => 'Las credenciales proporcionadas son incorrectas, favor de verificar',
        ])->onlyInput('password');
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
            'usuario' => 'required',
            'password' => 'required | min:8',
        ]);
        
        if($request->password != $request->confirmPassword)
            return;

        if(User::create([
            'name'=> $request->name,
            'username' => $request->usuario,
            'password' => bcrypt($request->password)
        ])){
            return back()->with('success', 'Registro guardado');
        }
    }
}
