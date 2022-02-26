<?php

namespace App\Http\Integrations\api;

use App\Http\Integrations\api\Requests\GetCustomerRequest;
use App\Http\Integrations\api\Requests\AddCustomerRequest;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Features\AcceptsJson;
use Sammyjo20\Saloon\Traits\Features\AlwaysThrowsOnErrors;
use Sammyjo20\Saloon\Traits\Features\DisablesSSLVerification;

class CustomerConnector extends SaloonConnector
{
    // use AcceptsJson;
    // use DisablesSSLVerification;
    // use AlwaysThrowsOnErrors;


    /**
     * Register Saloon requests that will become methods on the connector.
     * For example, GetUserRequest would become $this->getUserRequest(...$args)
     *
     * @var array
     */

    protected array $requests = [
        'get_key' => GetCustomerRequest::class,
        'add_key' => AddCustomerRequest::class,
    ];

    /**
     * Define the base url of the api.
     *
     * @return string
     */
    public function defineBaseUrl(): string
    {
        // return 'https://jsonplaceholder.typicode.com';
        return 'http://apicrud.test/api';
    }

    /**
     * Define the base headers that will be applied in every request.
     *
     * @return string[]
     */
    public function defaultHeaders(): array
    {
        return [

        ];
    }
}
