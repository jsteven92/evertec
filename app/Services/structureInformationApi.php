<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class structureInformationApi
{
    private  $arrayAuth = null;
    private  $arrayPayment = null;
    private  $arrayBuyer = null;
    private  $reference = null;


    /**
     * Function que se encarga de retornar un arreglo con las credenciales 
     * del Auth
     * @return array
     */
    function structureAuth(): void
    {
        $seed = Carbon::now()->toIso8601String();

        $nonce = '';
        $auth = [];

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }


        $tranKey = base64_encode(sha1($nonce . $seed . config('api.api_secret_id'), true));

        $this->arrayAuth = [
            "login" => config('api.api_login'),
            "tranKey" => $tranKey,
            "nonce" => base64_encode($nonce),
            "seed" => $seed,
        ];
    }

    function structureBuyer(
        string $name,
        string $surmane,
        string $email,
        string $document,
        string $document_type,
        string $mobile
    ): void {
        $this->arrayBuyer = [
            "name" => $name,
            "surname" => $surmane,
            "email" => $email,
            "document" => $document,
            "documentType" => $document_type,
            "mobile" => $mobile
        ];
    }

    function structurePayment(
        string $description,
        string $currency,
        string $total
    ): void {
        
        $this->arrayPayment =  [
            "reference" => $this->reference,
            "description" => $description,
            "amount" => [
                "currency" => $currency,
                "total" => $total
            ],
            "allowPartial" => false
        ];
    }

    function structureCreateRequest(): array
    {
        $day = Carbon::now()->addDay(1)->toIso8601String();

        $arrayBase = [
            "locale" => "en_CO",
            "expiration" => $day,
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox",
            "returnUrl" => "http://example.com/" . $this->reference,
        ];

        if (isset($this->arrayAuth)) {
            $arrayBase["auth"] = $this->arrayAuth;
        }
        if (isset($this->arrayPayment)) {
            $arrayBase["payment"] = $this->arrayPayment;
        }
        if (isset($this->arrayBuyer)) {
            $arrayBase["buyer"] = $this->arrayBuyer;
        }

        return $arrayBase;
    }

    function structureRequestInformation(): array
    {
        $arrayBase["auth"] = $this->arrayAuth;
        return $arrayBase;
    }

    function structureRevercePayMent(string $internalReference): array
    {
        $arrayBase["internalReference"] = $internalReference;
        $arrayBase["auth"] = $this->arrayAuth;
        return $arrayBase;
    }

    /**
     * set de la variable para los test
     */
    function setArrayAuth(): array
    {
        return $this->arrayAuth;
    }
    /**
     * set de la variable para los test
     */
    function setArrayPayment(): array
    {
        return $this->arrayPayment;
    }
    /**
     * set de la variable para los test
     */
    function setArrayBuyer(): array
    {
        return $this->arrayBuyer;
    }

    function getReference($reference): void
    {
        $this->reference = $reference;
    }
    function setReference(): string
    {
        return $this->reference;
    }
}
