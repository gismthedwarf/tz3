<?php

namespace App\Http\Controllers;


use App\Http\Requests\AuthUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('guest')->except(['logout']);
//    }

    public function authenticate(AuthUserRequest $request)
    {

        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return new UserResource(User::find(Auth::id()));
        }

        return response()->json([
            "message" => "Invalid credentials."
        ], 422);

    }

    public function logout()
    {
        Auth::logout();
        Session::flush(); // Clear all session data
        Session::regenerate(); // Regenerate the session ID
        return response()->noContent();
    }
}
