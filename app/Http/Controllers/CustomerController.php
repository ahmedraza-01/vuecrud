<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    // Show form for creating a customer
    public function create()
    {
        return Inertia::render('create');
    }


    public function index()
    {
        // Fetch customers ordered by latest created or updated first
        $customers = Customer::orderBy('created_at', 'desc')->get(); 
        return Inertia::render('index', [
            'customers' => $customers
        ]);
    }
    
    

    // Store a new customer
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
        ]);

        // Create the customer after validation
        Customer::create($validatedData);

        session()->flash('message', 'Customer created successfully!');
    
        return redirect()->route('customer.index');
    }
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully!']);

    }
    public function edit(Customer $customer)
    {
        return Inertia::render('edit', [
            'customer' => $customer
        ]);
    }
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        // Create the customer after validation
        $customer->update($validatedData);
        session()->flash('message', 'Customer updated successfully!');
    
        return redirect()->route('customer.index');

    }
}
