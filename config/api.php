<?php

return [

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | URlS a usar en la pasarela de pago
    |
    */

    'api_base' => env('API_BASE', 'https://test.placetopay.com/redirection/api/'),
    'api_create_request' =>  env('API_CREATE_REQUEST', 'session/'),
    'api_request_information' => env('API_REQUEST_INFORMATION', 'session/'),
    'api_reverse_payment' => env('API_REVERSE_PAYMENT', 'reverse'),

    /**
     * login de conexion para la api
    */
    'api_login' => env('API_LOGIN', '6dd490faf9cb87a9862245da41170ff2'),
    /**
     * secretId de conexion para la api
    */
    'api_secret_id' => env('API_SECRET_ID', '024h1IlD'),
    /**
     * estado existoso de la creacion de la orden
     */
    'api_create_request_success' => env('API_CREATE_REQUEST_SUCCESS', 'OK'),
    /**
     * tiempo de espera para preguntar por el estado de la orden
     */
    'api_time_wait' => env('API_TIME_WAIT', 7),
    /**
     * tiempo que debe esperar la sonda para volver a preguntar por
     * una solicitud
     */
    'api_time_schedule' => env('API_TIME_SCHEDULE', 12),
    /**
     * Tiempo maximo para que la sonda pregunte por la orden
     */
    'api_time_minute_max_wait' => env('API_TIME_MINUTE_MAX_WAIT', 60),
];
