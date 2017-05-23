<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

/*
|----------------------------------------------------------------------------
| Basic API Routes                                                          |
|----------------------------------------------------------------------------
*/

$router->get('/', function () {
    return 'Welcome to RAISe';
});

/*
|----------------------------------------------------------------------------
| Client API Routes                                                         |
|----------------------------------------------------------------------------
*/

$router->mount('/client', function () use ($router) {
    // Register a Client
    $router->post('/register', 'ClientController@register');

    // List Clients
    $router->get('/', 'ClientController@list');
});

/*
|----------------------------------------------------------------------------
| Service API Routes                                                        |
|----------------------------------------------------------------------------
*/

$router->mount('/service', function () use ($router) {
    // Register a Service
    $router->post('/register', 'ServiceController@register');

    // List Service
    $router->get('/', 'ServiceController@list');
});

/*
|----------------------------------------------------------------------------
| Data API Routes                                                           |
|----------------------------------------------------------------------------
*/

$router->mount('/data', function () use ($router) {
    // Register Data
    $router->post('/register', 'DataController@register');

    // List Data
    $router->get('/', 'DataController@list');
});

/*
|----------------------------------------------------------------------------
| Management API Routes                                                     |
|----------------------------------------------------------------------------
*/

// Todo

return $router;
