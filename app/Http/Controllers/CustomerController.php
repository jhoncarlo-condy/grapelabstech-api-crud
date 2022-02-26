<?php

namespace App\Http\Controllers;

use App\Http\Integrations\api\Requests\GetCustomerRequest;
use App\Http\Integrations\api\Requests\AddCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller
{
    private $gender = [
        1 => 'Male',
        2 => 'Female',
        3 => 'Others'
    ];

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
        $validated = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'birthdate'  => 'required|date_format:Y-m-d',
            'gender'     => 'required|numeric|min:1|max:3'
        ]);


        if ($validated->fails()) {
            return response()->json([
                'status_code' => '0',
                'status_message' => $validated->messages()->first()
            ]);
        }

        $data = $validated->validated();

        $added_customer = Customer::insert([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'birthdate'  => $data['birthdate'],
            'gender'     => $data['gender']
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
        //array to change the output of integer gender to text
        $customer_details = [
            'id'         => $customer->id,
            'first_name' => $customer->first_name,
            'last_name'  => $customer->last_name,
            'birthdate'  => $customer->birthdate,
            'gender'     => $this->gender[$customer->gender]
        ];

        return response()->json([
            'status_code'    => '1',
            'status_message' => 'Success',
            'customer'       => $customer_details
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

        $validated = Validator::make($request->all(), [
            'first_name' => 'alpha',
            'last_name'  => 'alpha',
            'birthdate'  => 'date_format:Y-m-d',
            'gender'     => 'numeric|min:1|max:3'
        ]);


        if ($validated->fails()) {
            return response()->json([
                'status_code' => '0',
                'status_message' => $validated->messages()->first()
            ]);
        }

        $data = $validated->validated();

        try {
            Customer::find($customer->id)->update([
                'first_name' => $request->first_name ? $data['first_name'] : $customer->first_name,
                'last_name'  => $request->last_name ? $data['last_name'] : $customer->last_name,
                'birthdate'  => $request->birthdate ? $data['birthdate'] : $customer->birthdate,
                'gender'     => $request->gender ? $data['gender'] : $customer->gender,
            ]);

            return response()->json([
                'status_code'    => '1',
                'status_message' => 'Successfully Updated',
                'customer'       => $customer
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => '0',
                'status_code' => $th->getMessage()
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
