<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $validation= Validator::make($request->all(),[
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        if ($validation->fails()){
            $errors = collect($validation->errors()->toArray())->map(function($error){
                return $error[0];
            });
            return response()->json([
                'error'=> $errors
            ],422);
        }

        $user = User::where('email', $request->email)->first();

        if (!password_verify($request->password, $user['password'])) {
            return response()->json([
                'error' => ['password' => 'Incorrect Password']
            ], 422);
        }
        $token = $user->createToken(time())->plainTextToken;
        $request->authenticate();

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'role' => $user->role
        ],201);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
