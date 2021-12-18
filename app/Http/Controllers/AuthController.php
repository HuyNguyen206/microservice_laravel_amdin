<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    //

    public function login()
    {
        \request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (\Auth::guard('web')->attempt(\request()->only('email', 'password'))) {
//            $user = \Auth::guard('web')->user();
//            $token = $user->createToken('admin')->accessToken;
            return response()->success(auth()->user());
        }
//        return response()->error('Invalid Credential');
    }

    public function register(RegisterRequest $request)
    {
        $newUser = User::create($request->only(['first_name', 'last_name', 'email', 'role_id']) + ['password' => Hash::make($request->password)]);
        return response()->success($newUser);

    }

//    public function logout()
//    {
////        auth()->user()->tokens
////        auth('web')->logout();
//         \request()->user()->tokens()->delete();
////        $tokenRepo = app(TokenRepository::class);
////        $tokenRepo->revokeAccessToken('ec74be0fd5d2dcb4ecadb78aa3232d575fe2346b66b32e8adbad15d0468986472f73de2983e8e699');
//        return response()->success([]);
//    }

    public function logout()
    {
        auth()->logout();
        return response()->success([]);

    }
}
