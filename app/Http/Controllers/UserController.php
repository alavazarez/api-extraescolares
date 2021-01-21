<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\RegisterUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

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

    public function sendEmailReset(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
        
        //return response()->json($data,200);
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
                    ? new JsonResponse(['message' => trans($response)], 200)
                    : back()->with('status', trans($response));
    }
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }
    public function broker()
    {
        return Password::broker();
    }

    
}
