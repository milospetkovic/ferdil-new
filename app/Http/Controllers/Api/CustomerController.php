<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Return user's customers.
     *
     * @author Miloš Petković <elitasoft.web@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getUserCustomers()
    {
        return response()->json([
            1 => 'Company 1',
            2 => 'Company 2',
            3 => 'Company 3',
        ]);


//        // Get company of authenticated user.
//        $userCompany = auth()->user()->company;
//
//        $token = auth()->user()->createToken('authToken')->plainTextToken;
//
//        return response()->json([
//            'user' => auth()->user(),
//            'token' => $token
//        ]);
//
//
//        return response()->json([
//            'errors' => true,
//            'messages' => "Invalid credentials"
//        ]);
    }

}
