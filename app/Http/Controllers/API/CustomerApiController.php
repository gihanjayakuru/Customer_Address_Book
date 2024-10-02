<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function index()
    {
        return CustomerResource::collection(Customer::with('addresses')->get());
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        $customer->addresses()->createMany($request->addresses);
        return new CustomerResource($customer);
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer->load('addresses'));
    }

    public function update(StoreCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        $customer->addresses()->delete();
        $customer->addresses()->createMany($request->addresses);
        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }

}
