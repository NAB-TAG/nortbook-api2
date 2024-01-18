<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Cookie;

class AuthService
{
    public function register( array $data )
    {
        $user = new User();
        $user->name = $data[ "name" ];
        $user->pseudonym = $data[ "pseudonym" ];
        $user->email = $data[ "email" ];
        $user->password = Hash::make($data[ "password" ]);

        if ( $user->save() ) {
            return response()->json(["success", "Successful operation", "The user has registered successfully."], 201);
        } else {
            return response()->json(["error", "Failed operation", "The user has can not registered for a problem the server, cominicate have the admin."], 500);
        }
    }

    public function login( array $data )
    {
        if( Auth::attempt( $data ))
        {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $tokenEncrypt = encrypt($token);

            $cookie = cookie('cookie_token', $tokenEncrypt, 1440, null, null, true, true );

            Auth::login($user);
            
            return response()->json(['info', 'Start of successful session.', "Perfect!, Now use the next Token to put in in (authorization) within (headers) of all HTTP requests that require a user authenticate. 1- If you use Postman or Thunderclient just put the token inside (Bearer) in the Auth section. 2- If you are Front-end developer in just you need to add on the headers ('Authorization': `Bearer you_token`) in all HTTP request you need. Token: $token "])->withCookie( $cookie );
            
            
        } else {
            return response()->json(["warning", "Failed operation", "Incorrect email and/or password"], 401);
        }
    }

    public function index()
    {
        $user = auth('sanctum')->user();

        if(isset($user))
        {
            return $user;
        }
        return response()->json(["error", "Failed operation", "There is no connected user."], 403);
    }

    public function logout()
    {
        $cookie = Cookie::forget('auth_token');
        $user = auth('sanctum')->user();
        $user->currentAccessToken()->delete();
        
        return response()->json(["success", "Good!", "You just closed session"], 200);
    }

    public function decrypt()
    {
        try {
            $access_token = Cookie::get('auth_token');
            $decryptedToken = decrypt($access_token);

            return response()->json(['token' => $decryptedToken], 201);
        } catch (\Throwable $th) {
            return response()->json(["error","Failed operation", "The cookie 'auth_token' was not found, you did not start session or someone delete it."], 401);
        }
    }
}