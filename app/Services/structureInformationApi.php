<?php

namespace App\Services;

use Carbon\Carbon;

class structureInformationApi
{
    private  $arrayAuth;
    private  $arrayPayment;
    private  $arrayBuyer;
    private  $reference;


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

        $tranKey = base64_encode(sha1($nonce . $seed . Env('API_SECRET_ID'), true));

        $this->arrayAuth = [
            "login" => Env('API_LOGIN'),
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
        string $reference,
        string $description,
        string $currency,
        string $total
    ): void {
        $this->reference = $reference;
        $this->arrayPayment =  [
            "reference" => $reference,
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

        $arrayBase["auth"] = $this->arrayAuth;
        $arrayBase["payment"] = $this->arrayPayment;
        $arrayBase["buyer"] = $this->arrayBuyer;

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
}
