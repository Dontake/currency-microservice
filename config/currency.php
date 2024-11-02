<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for currency external services such
    | as Cbr and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'cbr' => [
        'url' => env('CBR_BASE_URL'),
        'dws_uri' => env('CBR_DWS_URI'),
    ],

];
