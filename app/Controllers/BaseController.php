<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ["angular"];
	protected $output_data = [
		"components" => []
	];
	protected $components = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->cleanup();
		$this->loadSystemModules();
	}


	public function loadSystemModules()
	{

		$stigniter_path = ROOTPATH . "stigniter/";
		if (file_exists($stigniter_path . 'system/system-modules')) :

			$modules = scandir($stigniter_path . 'system/system-modules');
			unset($modules[0]); /* Removes /.. */
			unset($modules[1]); /* Removes /. */

			foreach ($modules as $module) :
				$module_path = $stigniter_path . 'system/system-modules/';
				$components_path  = 	$module_path . $module . '/Components/';

				$components = scandir($components_path);
				unset($components[0]);
				unset($components[1]);

				foreach ($components as $component) :
					$this->output_data['components'][] = $components_path . $component;
				endforeach;

			endforeach;

		endif;
	}

	public function cleanup()
	{
		$folder_path = FCPATH ."scripts";

		$files = glob($folder_path . '/*');

		// Deleting all the files in the list 
		foreach ($files as $file) {

			if (is_file($file))
				// Delete the given file 
				unlink($file);
		}
	}
}
