<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register(Request $data)
    {
        if(User::where('email', $data['email'] )->exists()){
            return response()->json(false, 200);
           }
        else{
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            return response()->json($data, 200);
        }
    }

    public function update(Request $data, $id)
    {
        $user = User::find($id);
        if(Hash::check($data->oldPassword, $user->password))
        {
            $user->password = Hash::make($data->newPassword);
            $user->save();
            return response()->json($data, 200);
        }
        else{
            return response()->json(false, 200);
        } 
    }

    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response()->json([
                'message' => 'Usuario no encontrado/Codigo Invalido',
                'status_code' => 202
            ], 202);
        }
        else
        {
            $random = rand(111111, 999999);
            $user->verification_code = $random;
            if($user->save())
            {
                $userData = array(
                    'email' => $user->email,
                    'full_name' => $user->name,
                    'random' => $random
                );
                
                Mail::send('emails.reset_password', $userData, function ($message) use ($userData)
                {
                    $message->from('FormacionIntegral@tuxtla.tecnm.mx', 'Password Request');
                    $message->to($userData['email'], $userData['full_name']);
                    $message->subject('Reseteo de contraseña');
                });

                if(Mail::failures())
                {
                    return response()->json([
                        'message' => 'Ha ocurrido un error, vuelva a intentarlo',
                        'status_code' => 500
                    ], 500);
                }
                else 
                {
                    return response()->json([
                        'message' => 'Se ha enviado un codigo de verificacion a tu correo electronico',
                        'status_code' => 200
                    ], 200);
                }
            }
            else
            {
                return response()->json([
                    'message' => 'Ha ocurrido un error, vuelva a intentarlo',
                    'status_code' => 500
                ], 200);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|integer',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::where('email', $request->email)->where('verification_code', $request->verification_code)->first();
        if(!$user)
        {
            return response()->json([
                'message' => 'Usuario no encontrado/Codigo Invalido',
                'status_code' => 401
            ], 401);
        }
        else
        {
            $user->password = bcrypt(trim($request->password));
            $user->verification_code = null;

            if($user->save())
            {
                return response()->json([
                    'message' => 'Contraseña actualizada satisfactoriamente',
                    'status_code' => 200
                ], 200);
            }
            else
            {
                return response()->json([
                    'message' => 'Ha ocurrido un error, vuelva a intentarlo',
                    'status_code' => 500
                ], 200);
            }
        }
    }

    public function logout(Request $request)
    {
        //$this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }
    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard();
    }

}
