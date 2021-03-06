<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}


$stigniter_path = ROOTPATH.'stigniter/';

if(file_exists($stigniter_path . 'modules' )):

	$modules = scandir($stigniter_path . 'modules');
	unset($modules[0]); /* Removes /.. */
	unset($modules[1]); /* Removes /. */

	foreach($modules as $module):
		$module_path = $stigniter_path . 'modules/';
		$manifest = $module_path . $module . '/manifest.json';
		$route = 	$module_path . $module . '/Config/Routes.php';

		if(file_exists($route)) require_once $route;

	endforeach;

endif;


if(file_exists($stigniter_path . 'system/system-modules' )):

	$modules = scandir($stigniter_path . 'system/system-modules');
	unset($modules[0]); /* Removes /.. */
	unset($modules[1]); /* Removes /. */

	foreach($modules as $module):
		$module_path = $stigniter_path . 'system/system-modules/';
		$route = 	$module_path . $module . '/Config/Routes.php';
		if(file_exists($route)) require_once $route;
	endforeach;

endif;