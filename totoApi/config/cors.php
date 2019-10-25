<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => [],
    'X-Requested-With ' => ['*'],
    'allowedMethods ' => [' * '], // ex: ['GET', 'POST', 'PUT', 'DELETE'] ' posedHeaders ' => [], ' maxAge ' => 0 ,];     
    'maxAge' => 0,

     
      

];
