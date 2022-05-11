<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer as CustomerModel;
use App\Http\Requests\CustomerRequest;

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

    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['fk_company'] = auth()->user()->company->id;
        $customer = CustomerModel::create($data);
        return new CustomerResource($customer);
    }

    public function index(Request $request)
    {
        $customers = CustomerModel::where('fk_company', auth()->user()->company->id)
            ->orderBy('name', 'asc')
            ->get(['id', 'name'])
        ;
        return new JsonResponse($customers);
    }

}
