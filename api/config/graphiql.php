<?php

return [

    'paths' => [
        // Absolute path to public assets folder
        'assets' => public_path('vendor/graphiql'),

        // Url to the assets folder
        'assets_public' => 'vendor/graphiql',

        // Absolute path to views folder
        'views' => base_path('resources/views/vendor/graphiql'),
    ],

    'routes' => [
        // Path to send the graphql queries
        'graphql' => 'graphql',

        // Path to the graphiql ui
        'ui' => 'graphql-ui',

        // Any middleware for the graphiql ui route
        'middleware' => [],
    ],

    'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Access-Control-Allow-Origin' => 'http://localhost:3000',
        'Access-Control-Allow-Methods' => 'GET',
        'Authorization' => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9jb25uZWN0XC9sb2dpbiIsImlhdCI6MTU2Nzc3MTQ1OSwiZXhwIjoxNTY3ODU3ODU5LCJuYmYiOjE1Njc3NzE0NTksImp0aSI6IkVXQVBYVGczenVIeDByejkiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.UlKV2ir6vyZCuDOd9C2IQbZYfIQlBk4qyHjWZaPG_ZA"
    ],
];
