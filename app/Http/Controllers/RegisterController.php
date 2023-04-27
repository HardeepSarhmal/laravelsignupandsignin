<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:5|max:255',
            

            'phone'=>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',
            'address'=>'required|regex:/([- ,\/0-9a-zA-Z]+)/',
           
            
        ]);
       

        // User::user_type = '0';
        // $user = User::create($attributes);
        // dd($user);
        $user= User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            
            'password' => Hash::make($request['password']),
            
            'phone' => $request['phone'] ,
            'address' => $request['address'] ,
            'user_type' =>'0'
        ]);
        $user->save();
        
        auth()->login($user);
        
        return redirect('/dashboard');
    } 
}
