<?php

namespace App\Http\Controllers;

use App\Mail\RegisterUser;
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
}
