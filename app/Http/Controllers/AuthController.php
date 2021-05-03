<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        return view('login');
    }
    public function login(Request $request){
        // dd($request->all());

        $data = User::where('email',$request->email)->firstOrFail();
        if($data){
            if(\Hash::check($request->password,$data->password)){
                session(['berhasil' => true]);
                return redirect('dashboard');
            }
        }
        return redirect('/')->with('message','Email atau Password salah');
        // dd($data->email);
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
