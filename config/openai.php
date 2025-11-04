<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI / CodeGPT Configuration
    |--------------------------------------------------------------------------
    |
    | Store defaults and read the API key from the environment. The
    | 'OPENAI_API_KEY' environment variable should be set in your local
    | `.env` (not committed) or in your hosting environment.
    |
    */

    'api_key' => env('OPENAI_API_KEY'),

    // Default model to use when making requests (can be overridden at call time)
    'default_model' => env('OPENAI_MODEL', 'gpt-4o-mini'),

    // Optional base URI for alternate endpoints / proxies
    'base_uri' => env('OPENAI_BASE_URI', null),
];
