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

namespace App\Facades;

use Jenssegers\Blade\Blade as BladeEngine;

/**
 * Class Blade.
 *
 * A Facade that handles and manages the Blade template Engine
 *
 * @see https://github.com/jenssegers/blade Blade GitHub
 * @see http://laravel.com/docs/5.1/blade Blade Documentation
 * @see https://en.wikipedia.org/wiki/Facade_pattern Documentation of the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class Blade extends Facade
{
    /**
     * The Blade Engine Handler
     *
     * @var BladeEngine
     */
    private static $blade;

    /**
     * This method tries to recover the
     * Blade Engine Handler
     *
     * @return BladeEngine the Blade Engine
     */
    protected static function cover()
    {
        if (null === self::$blade) {
            self::$blade = new BladeEngine([path('resources/views')], path('resources/cache'));
        }

        return self::$blade;
    }

    /**
     * Handle the BladeEngine and make a view
     *
     * @param string $view the view to be called and handled
     * @param array $parse the variables to be extracted and parsed
     */
    public static function make(string $view, array $parse = [])
    {
        $content = self::cover()->make($view, $parse);

        response()::setContent($content);
    }
}
