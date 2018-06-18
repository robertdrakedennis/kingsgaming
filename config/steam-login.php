<?php

return [
    /*
     * Login route
     */
    'login_route' => env('STEAM_LOGIN', '/login'),

    /*
     * Return route
     */
    'return_route' => env('STEAM_RETURN', '/auth/steam'),

    /*
     * Timeout when validating
     */
    'timeout' => env('STEAM_TIMEOUT', 5),

    /*
     * Method of retrieving user's info
     */
    'method' => env('STEAM_PROFILE_METHOD', 'api'),

    /*
     * API key (http://steamcommunity.com/dev/apikey)
     */
    'api_key' => env('STEAM_API_KEY', '727651FF4C2F14A9ECFF5067C9D06184'),
];
