<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function showRegister(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request -> validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'hak' => 'kasir',
        ]);
        return redirect()->route('login')->with('success', 'Akun Berhasil dibuat');
    }

    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            if(Auth::user()->hak === 'admin'){
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('kasir.dashboard');
            }
        }


        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
