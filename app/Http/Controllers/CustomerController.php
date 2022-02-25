<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return $customers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthdate'  => 'required',
            'gender'     => 'required|numeric|min:1|max:3'
        ]);

        $added_customer = Customer::insert([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'birthdate'  => $validated['birthdate'],
            'gender'     => $validated['gender']
        ]);

        ///or simply this query
        //Customer::create($validated);

        if($added_customer){

            return response()->json([
                'status_code'    => '1',
                'status_message' => 'Customer Successfully Created'
            ],201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

        $validated = $request->validate([
            'gender'     => 'numeric|min:1|max:3'
        ]);

        if($customer->update($validated)){
            return response()->json([
                'status_code'    => '1',
                'status_message' => 'Successfully Updated',
                'customer'       => $customer
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if($customer->delete()){
            return response()->json([
                'status_code'    => '1',
                'status_message' => 'Deleted Successfully'
            ]);
        }
    }
}
