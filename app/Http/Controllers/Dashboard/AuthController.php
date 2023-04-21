<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResponseAPI;
use Auth;

class AuthController extends Controller
{
    use ResponseAPI;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('generate_token')->accessToken;
            // return $token;
            return $this->success($token);
        } else {
            return $this->error();
        }
    }

    public function getUserDetail()
    {
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            return $this->success($user);
        }
        return $this->error();
    }

    public function logout()
    {
        if(Auth::guard('api')->check()){
            $accessToken = Auth::guard('api')->user()->token();

                \DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);
            $accessToken->revoke();

            return $this->success('User logout successfully.');
            // return Response(['data' => 'Unauthorized','message' => 'User logout successfully.'],200);
        }
        return $this->error();
    }
}
