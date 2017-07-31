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

namespace App\Controllers;

/**
 * Class Manage.
 *
 * A Controller that Manages the Management Routes
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Manage extends Controller
{
    /**
     * Login Page.
     *
     * Show the Login Page
     */
    public function login()
    {
        response()::type('text/html');

        blade()::make('header.login');
        blade()::make('body.login');
    }

    /**
     * Config Page.
     *
     * Show the Configuration Page
     */
    public function config()
    {
        response()::type('text/html');

        blade()::make('header.config');
        blade()::make('body.menu');
        blade()::make('body.config', ['raise' => setting('raise'), 'database' => setting('database'), 'security' => setting('security')]);
        blade()::make('footer.page-footer');
    }
}
