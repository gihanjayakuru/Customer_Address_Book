<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('addresses')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $customer = Customer::create($request->validated());
            if ($request->has('addresses') && is_array($request->addresses)) {
                $customer->addresses()->createMany($request->addresses);
            }

            return response()->json(['success' => true, 'message' => 'Customer created successfully.', 'customer' => new CustomerResource($customer)]);
        } catch (\Exception $e) {
            Log::alert('Customer creation failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to create customer.'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $customer->load('addresses');
 
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomerRequest $request, Customer $customer)
    {
        try {
            $customer->update($request->validated());
            $customer->addresses()->delete();
            if ($request->has('addresses') && is_array($request->addresses)) {
                $customer->addresses()->createMany($request->addresses);
            }
            return response()->json(['success' => true, 'message' => 'Customer updated successfully.', 'customer' => new CustomerResource($customer)]);
        } catch (\Exception $e) {
            Log::alert('Customer update failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update customer.'], 500);
        }
    }


    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully.']);
        } catch (\Exception $e) {
            Log::alert('Customer deletion failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete customer.']);
        }
    }

}
