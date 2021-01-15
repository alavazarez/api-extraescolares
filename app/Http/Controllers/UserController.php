<?php

namespace App\Http\Controllers;

use App\Mail\RegisterUser;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function sendEmail($email)
    {
        $route = 'http://localhost:8080/User/AddUser';
        Mail::to($email)->send(new RegisterUser($route));
        return response()->json($email,200);
    }

    public function register(Request $data)
    {
        if(User::where('email', $data['email'] )->exists()){
            return response()->json(false, 200);
           }
        else{
            /*User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);*/
            return response()->json($data, 200);
        }
    }
}
