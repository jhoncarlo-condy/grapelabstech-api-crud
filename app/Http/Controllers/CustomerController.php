<?php

namespace App\Http\Controllers;

use App\Http\Integrations\api\CustomerConnector;
use App\Http\Integrations\api\Requests\GetCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Sammyjo20\SaloonLaravel\Facades\Saloon;
use Sammyjo20\Saloon\Http\MockResponse;
use Sammyjo20\Saloon\Http\SaloonConnector;


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
        return response()->json([
            'status_code'    => '1',
            'status_message' => 'Success',
            'customer'       => $customer
        ]);
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

    public function customer_list(){
        $customers = Customer::latest()->get();
        return response()->json([
            'status_code'    => '1',
            'status_message' => 'Success',
            'customers'      => $customers
        ],200);
    }

    public function sample(){
        // return 'test';
        // $connector = new CustomerConnector();
        // $request = $connector->getCustomerRequest();
        // $response = $request->send();
        // $response->throw();
        // $data = $response->json();
        // return $data;


        //
        // $request = CustomerConnector::GetCustomerResponse();
        // $response = $request->send();
        // $response->throw();
        // $data = $response->json();
        // return $data;

        //
        $request = new GetCustomerRequest();
        $response = $request->send();
        $data = $response->json();
        return $data;

        //
        // $response = (new GetCustomerRequest)->connectorMethod()->send();
        // $data = $response->json();
        // return $data;

        // $response = (new GetCustomerRequest)->send();
        // $response->throw();
        // $data = $response->json();
        // return $data;

        // Saloon::fake([
        //     new MockResponse(['name' => 'Sam'], 200),
        //     new MockResponse(['name' => 'Alex'], 200),
        //     new MockResponse(['error' => 'Server Unavailable'], 500),
        // ]);

        // $test  = (new GetCustomerRequest)->send();
        // $test1 = (new GetCustomerRequest)->send();
        // $test2 = (new GetCustomerRequest)->send();

        // $data = $test->json();
        // return $data;
    }
}
