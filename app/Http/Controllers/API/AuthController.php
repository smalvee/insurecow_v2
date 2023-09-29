<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use validator;
use app\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'c_password' => ['required', 'same:password'],

        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User registration successfully'
        ];

        return response()->json($request, 200);
    }


    public function login(Request $request)
    {
        if ($request->phone == null) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                $success['name'] = $user->name;

                $response = [
                    'success' => true,
                    'data' => $success,
                    'message' => 'User logn successfully'
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Unauthorised'
                ];
                return response()->json($response);
            }
        } 
        
        else {
            if (Auth::attempt(['phone' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                $success['name'] = $user->name;

                $response = [
                    'success' => true,
                    'data' => $success,
                    'message' => 'User logn successfully'
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Unauthorised'
                ];
                return response()->json($response);
            }
        }
    }
}