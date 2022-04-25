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
        return CustomerResource::collection(CustomerModel::where('fk_company', auth()->user()->company->id)->get());
    }

}
