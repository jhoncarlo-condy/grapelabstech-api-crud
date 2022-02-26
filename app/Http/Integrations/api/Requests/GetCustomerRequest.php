<?php

namespace App\Http\Integrations\api\Requests;

use App\Http\Integrations\api\CustomerConnector;
use App\Http\Integrations\api\Responses\CustomerResponse;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Features\HasJsonBody;

class GetCustomerRequest extends SaloonRequest
{

    use HasJsonBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;

    /**
     * The connector.
     *
     * @var string|null
     */
    protected ?string $connector = CustomerConnector::class;


    public function boot(): void
    {
        $this->addResponseInterceptor(function (SaloonRequest $request, SaloonResponse $response) {
            $response->throw();

            return $response;
        });
    }

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        // return '/users';
        return '/customer_list';
    }
}
