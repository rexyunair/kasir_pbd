<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class SesiController extends Controller
{
    function index(){
        return view('login');
    }

    function login(Request $request){
        $request -> validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        if (Auth::attempt($infologin)) {
            if(Auth::User()->role == 'admin'){
                return redirect('admin');
            }elseif(Auth::User()->role == 'petugasgudang'){
                return redirect('petugasgudang');
            }
            elseif(Auth::User()->role == 'kasir'){
                return redirect('kasir');
            }
        } else {
            return redirect()->back()->withErrors('Username dan Password Tidak Sesuai')->withInput();
        }
    }
    function logout(){
        Auth::logout();
        return redirect('home');
    }
}