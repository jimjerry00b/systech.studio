<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Country Code
    |--------------------------------------------------------------------------
    |
    | Used to normalise renter phone numbers into international format for
    | wa.me / WhatsApp click-to-chat links. Numbers entered in local format
    | (e.g. 01712-345678) get their leading zero dropped and this code
    | prepended -> 8801712345678. Set WHATSAPP_COUNTRY_CODE in .env to change.
    |
    */

    'country_code' => env('WHATSAPP_COUNTRY_CODE', '880'),

];
