<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use app\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function apiregister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:8'],
            'c_password' => ['required', 'same:password'],

        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        // $input = $request->all();
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User registration successfully'
        ];

        return response()->json($request, 200);
    }


    public function apilogin(Request $request)
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
