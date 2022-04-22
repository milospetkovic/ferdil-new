<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer as CustomerModel;

class CustomerController extends Controller
{
    /**
     * Return user's customers.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Validation\ValidationException
     * @author Miloš Petković <elitasoft.web@gmail.com>
     */
    public function getUserCustomers()
    {
        return CustomerResource::collection(CustomerModel::all());

//        return response()->json([
//            1 => 'Company 1',
//            2 => 'Company 2',
//            3 => 'Company 3',
//        ]);


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
