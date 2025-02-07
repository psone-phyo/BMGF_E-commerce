<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

//provider Login controller
class LoginController extends Controller
{
    public function providerLogin(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('google')->user();
        $existed_user = User::where('email', $user->email)->first();
        if ($existed_user){
            $token = $existed_user->createToken(time())->plainTextToken;
            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ],200);
        }else{
            $registereduser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'provider'=> 'google',
                'provider_id' => $user->id,
                'provider_token' => $user->token,
                'profile' => $user->avatar
            ]);

            $token = $registereduser->createToken(time())->plainTextToken;
            return response()->json([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ],201);
        }

    }

}
