<?php

namespace App\Http\Integrations\api\Requests;

use App\Http\Integrations\api\CustomerConnector;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Features\AcceptsJson;
use Sammyjo20\Saloon\Traits\Features\DisablesSSLVerification;

class GetCustomerRequest extends SaloonRequest
{
    use AcceptsJson;
    use DisablesSSLVerification;

    // use HasJsonBody;

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

    public function __construct(
        public string $token){}

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        // return '/users';
        return '/customers?token='.$this->token;
    }
}
