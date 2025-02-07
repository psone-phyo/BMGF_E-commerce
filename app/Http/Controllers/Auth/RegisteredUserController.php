<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try{
            $validation= Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|max:12',
            ]);

            if ($validation->fails()){
                $errors = collect($validation->errors()->toArray())->map(function($error){
                    return $error[0];
                });
                return response()->json([
                    'error'=> $errors
                ],400);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            $token = $user->createToken(time())->plainTextToken;

            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ],201);
        }
        catch (Exception $e) {
            dd('ok2');

            return response()->json([
                'error' => $e
            ], 500);
        }

    }
}
