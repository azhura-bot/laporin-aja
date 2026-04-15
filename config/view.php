<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. In Vercel serverless, use /tmp.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        env('VERCEL') ? '/tmp/storage/framework/views' : realpath(storage_path('framework/views'))
    ),

];
