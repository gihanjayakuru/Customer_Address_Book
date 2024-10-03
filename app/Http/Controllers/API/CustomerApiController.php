<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Response;

class CustomerApiController extends Controller
{
    public function index()
    {
        $customers = Customer::with('addresses')->get();
        return CustomerResource::collection($customers);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        if ($request->has('addresses')) {
            $customer->addresses()->createMany($request->addresses);
        }
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
        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }
}
