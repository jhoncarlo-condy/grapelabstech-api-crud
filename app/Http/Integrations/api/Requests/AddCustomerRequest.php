<?php

namespace App\Http\Integrations\api\Requests;

use App\Http\Integrations\api\CustomerConnector;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Features\AcceptsJson;
use Sammyjo20\Saloon\Traits\Features\DisablesSSLVerification;

class AddCustomerRequest extends SaloonRequest
{
    use AcceptsJson;
    use DisablesSSLVerification;

    // use HasJsonBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::POST;

    /**
     * The connector.
     *
     * @var string|null
     */
    protected ?string $connector = CustomerConnector::class;

    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $birthdate,
        public string $gender,
        public string $token,
        ){}

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        // return '/users';
        return '/customers?first_name='.$this->first_name.'&last_name='.$this->last_name.
                '&birthdate='.$this->birthdate.'&gender='.$this->gender.'&token='.$this->token;
    }
}
