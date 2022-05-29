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
use App\Http\Services\Api\WorkerService;

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
        return CustomerResource::collection(CustomerModel::where('fk_company', auth()->user()->company->id)
            ->orderBY('name', 'asc')
            ->get());
    }

    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['fk_company'] = auth()->user()->company->id;
        $customer = CustomerModel::create($data);
        return new CustomerResource($customer);
    }

    public function getUserCustomersList()
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

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param \App\Models\Customer $customer
     * @return CustomerResource
     */
    public function update(CustomerRequest $request, CustomerModel $customer)
    {
        $customer->update($request->validated());
        return new CustomerResource($customer);
    }

    public function show($customerId)
    {
        $customer = CustomerModel::where('id', $customerId)
            ->where('fk_company', auth()->user()->company->id)
            ->firstOrFail();
        return new JsonResponse(new CustomerResource($customer));
    }

    public function getCustomerWorkers($customerId, Request $request)
    {
        $customer = CustomerModel::findOrFail($customerId);
        $customerWorkersSql = (new WorkerService)->getWorkersSql();
        $customerWorkersSql->orderBy('w.last_name', 'asc');
        $customerWorkers = $customerWorkersSql->get();

        $data = [
            'customer' => new CustomerResource($customer),
            'customer_workers' => $customerWorkers,
        ];

        return new JsonResponse($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerModel $customer)
    {
        CustomerModel::where('id', $customer->id)
            ->where('fk_company', auth()->user()->company->id)
            ->delete();
        return response()->noContent();
    }

}
