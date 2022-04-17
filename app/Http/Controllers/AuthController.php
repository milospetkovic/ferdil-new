<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\User as UserModel;

class AuthController extends Controller
{
    public function login()
    {
        $validationRules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make(request()->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'messages' => $validator->errors(),
            ]);
        }

        // Retrieve the validated inputs.
        $validated = $validator->validated();

        if (Auth::attempt($validated)) {

            // Get company of authenticated user.
            $userCompany = auth()->user()->company;

            $token = auth()->user()->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => auth()->user(),
                'token' => $token
            ]);
        }

        return response()->json([
            'errors' => true,
            'messages' => "Invalid credentials"
        ]);
    }

    public function logout()
    {
        if (auth()->check()) {
            //request()->session()->invalidate();
            //request()->session()->regenerateToken();
            // Revoke all tokens.
            request()->user()->tokens()->delete();

            // Logout user.
            Auth::logout();
        }
        return response()->noContent();
    }

}
