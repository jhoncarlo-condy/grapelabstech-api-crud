<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Integrations\api\Requests\GetCustomerRequest;


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


}
