<?php namespace App\Lib\Router;

/**
 * Class for Laravel routing to be compatible with version 5.0 Route::controller command
 * 2019/08/07
 * 
 * @author ahmad (アフマド)
 * @link https://github.com/laravel/framework/blob/5.0/src/Illuminate/Routing/Router.php
 */

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Route as BaseRoute;

class Route extends BaseRoute
{
    /**
	 * Route a controller to a URI with wildcard routing.
	 *
	 * @param  string  $uri
	 * @param  string  $controller
	 * @param  array   $names
	 * @return void
	 */
	public static function controller($uri, $controller, $names = array())
	{
        $prepended = $controller;
        $router = Container::getInstance()->router;
        
		// First, we will check to see if a controller prefix has been registered in
		// the route group. If it has, we will need to prefix it before trying to
		// reflect into the class instance and pull out the method for routing.
		if ( ! empty($router->groupStack))
		{
			$prepended = $router->prependGroupUses($controller);
		}
        
		$routable = (new ControllerInspector)
                            ->getRoutable('App\Http\Controllers\\' . $prepended, $uri);

		// When a controller is routed using this method, we use Reflection to parse
		// out all of the routable methods for the controller, then register each
		// route explicitly for the developers, so reverse routing is possible.
		foreach ($routable as $method => $routes)
		{
			foreach ($routes as $route)
			{
				self::registerInspected($router, $route, $controller, $method, $names);
			}
		}
		self::addFallthroughRoute($router, $controller, $uri);
    }
    
    /**
	 * Register an inspected controller route.
	 *
	 * @param  array   $route
	 * @param  string  $controller
	 * @param  string  $method
	 * @param  array   $names
	 * @return void
	 */
	private static function registerInspected($router, $route, $controller, $method, &$names)
	{
		$action = $controller.'@'.$method;
		// If a given controller method has been named, we will assign the name to the
		// controller action array, which provides for a short-cut to method naming
		// so you don't have to define an individual route for these controllers.
		$name = array_get($names, $method);
		// $route['verb'] = 'get';
		if (empty($name)) {
			$router->{$route['verb']}($route['uri'], $action);
		} else {
			$router->{$route['verb']}($route['uri'], $action)->name($name);
		}
    }
    
    /**
	 * Add a fallthrough route for a controller.
	 *
	 * @param  string  $controller
	 * @param  string  $uri
	 * @return void
	 */
	private static function addFallthroughRoute($router, $controller, $uri)
	{
		$missing = $router->any($uri.'/{_missing}', $controller.'@missingMethod');
		$missing->where('_missing', '(.*)');
	}
}
