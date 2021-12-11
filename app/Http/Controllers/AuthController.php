<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login()
    {
        \request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (\Auth::attempt(\request()->only('email', 'password'))) {
            $user = \Auth::user();
            $token = $user->createToken('admin')->accessToken;
            return response()->success(compact( 'token'));
        }
        return response()->error('Invalid Credential');
    }

    public function register(RegisterRequest $request)
    {
            $newUser = User::create($request->only(['first_name', 'last_name', 'email', 'role_id']) + ['password' => Hash::make($request->password)]);
            return response()->success($newUser);

    }
}
