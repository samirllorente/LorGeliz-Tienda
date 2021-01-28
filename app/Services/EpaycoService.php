<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ConsumesExternalServices;

class EpaycoService
{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $apiKey;

    protected $privateKey;

    public function __construct()
    {
        $this->baseUri = config('services.epayco.base_uri');
        $this->apiKey = config('services.epayco.api_key');
        $this->privateKey = config('services.epayco.private_key');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        //
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        //
    }

    public function handlePayment()
    {
        //
    }

    public function handleApproval()
    {
        //
    }

    public function resolveFactor()
    {
        //
    }
}

?>