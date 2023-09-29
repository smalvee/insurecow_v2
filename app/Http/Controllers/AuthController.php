<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response; //must notice

class AuthController extends Controller
{
    public function user()
    {
        return Auth::user();
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return $user;
    }

    public function login(Request $request)
    {

        if($request->phone == null){
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response([
                    'message' => 'Inavalid Credentials'
                ], Response::HTTP_UNAUTHORIZED);
            };
        }else{
            if (!Auth::attempt($request->only('phone', 'password'))) {
                return response([
                    'message' => 'Inavalid Credentials'
                ], Response::HTTP_UNAUTHORIZED);
            };
        }
 
        $user = Auth::user(); 
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt',$token,60*24); //1day
        return response([
            'message' => $token
        ])->withCookie($cookie);

    }



    public function logout(){
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

}
