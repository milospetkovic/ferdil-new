<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer as CustomerModel;
use App\Http\Requests\CustomerRequest;
use App\Models\Worker as WorkerModel;

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
        $customers = DB::table('customers AS c')
            ->select('c.id', 'c.name',
                // Count all workers linked with customer.
                DB::raw('(SELECT COUNT(*) FROM workers as w1 WHERE w1.fk_customer = c.id) AS customer_count_all_workers'),
                // Count active workers linked with customer.
                DB::raw('(SELECT COUNT(*) FROM workers as w2 WHERE w2.fk_customer = c.id AND (w2.inactive != 1 OR w2.inactive IS NULL)) AS customer_count_active_workers')
            )
            ->where('c.fk_company', auth()->user()->company->id)
            ->orderBy('c.name', 'asc')
            ->get()
        ;

        return new JsonResponse($customers);
    }

    public function show(CustomerModel $customer, Request $request)
    {
        $customerWorkersSql = DB::table('customers AS c')
            ->leftJoin('workers as w', 'w.fk_customer', '=', 'c.id')
            ->select('c.id', 'c.name',
                // Count all workers linked with customer.
                DB::raw('(SELECT COUNT(*) FROM workers as w1 WHERE w1.fk_customer = c.id) AS customer_count_all_workers'),
                // Count active workers linked with customer.
                DB::raw('(SELECT COUNT(*) FROM workers as w2 WHERE w2.fk_customer = c.id AND (w2.inactive != 1 OR w2.inactive IS NULL)) AS customer_count_active_workers'),
                'w.first_name', 'w.last_name'
            )
            ->where('c.fk_company', auth()->user()->company->id)
            ->where('c.id', $customer->id)
            ->orderBy('c.name', 'asc')
        ;

        $sql = $customerWorkersSql->toSql();

        $customerWorkers = $customerWorkersSql->get();

        return new JsonResponse($customerWorkers);
    }

}
