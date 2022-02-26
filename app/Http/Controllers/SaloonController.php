<?php

namespace App\Http\Controllers;

use App\Http\Integrations\api\Requests\AddCustomerRequest;
use App\Http\Integrations\api\Requests\DeleteCustomerRequest;
use Illuminate\Http\Request;
use App\Http\Integrations\api\Requests\GetCustomerRequest;
use App\Http\Integrations\api\Requests\UpdateCustomerRequest;
use App\Http\Integrations\api\Requests\ViewCustomerDetailsRequest;
use App\Models\Customer;


class SaloonController extends Controller
{
    public function customer_list(Request $request){

        try {
            $user = auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json([
                'status_code'    => '0',
                'status_message' => $e->getMessage()
            ]);
        }

        $response = (new GetCustomerRequest($request->token))->send();

        return $response->json();
    }

    public function delete_customer(Request $request){
        try {
            $user = auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json([
                'status_code'    => '0',
                'status_message' => $e->getMessage()
            ]);
        }

        $response = (new DeleteCustomerRequest($request->id,$request->token))->send();

        return $response->json();
    }

    public function add_customer(Request $request){
        try {
            $user = auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json([
                'status_code'    => '0',
                'status_message' => $e->getMessage()
            ]);
        }

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


        $response = (new AddCustomerRequest(
            $validated['first_name'],
            $validated['last_name'],
            $validated['birthdate'],
            $validated['gender'],
                    $request->token
        ))->send();

        return $response->json();
    }

    public function update_customer(Request $request){
        try {
            $user = auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json([
                'status_code'    => '0',
                'status_message' => $e->getMessage()
            ]);
        }

        $validated = Validator::make($request->all(), [
            'id'         => 'required',
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

        $customer = Customer::find($request->id);

        $first_name = $request->first_name ? $request->first_name : $customer->first_name;
        $last_name  = $request->last_name ? $request->last_name : $customer->last_name;
        $birthdate  = $request->birthdate ? $request->birthdate : $customer->birthdate;
        $gender     = $request->gender ? $request->gender : $customer->gender;

        $response = (new UpdateCustomerRequest(
            $request->id,
            $first_name,
                $last_name,
                $birthdate,
                $gender,
                $request->token
        ))->send();

        return $response->json();

    }

    public function view_customer_details(Request $request){

        try {
            $user = auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json([
                'status_code'    => '0',
                'status_message' => $e->getMessage()
            ]);
        }

        $response = (new ViewCustomerDetailsRequest($request->id,$request->token))->send();

        return $response->json();
    }


}
