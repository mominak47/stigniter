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
use CodeIgniter\HTTP\IncomingRequest;
use \Config\Database;
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
		"components" => [],
		"translations" => []
	];
	protected $angular	 = [
		"routes" => []
	];
	protected $components = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->db = \Config\Database::connect();
		$this->request = service('request');
		$this->forge   = Database::forge();
		$this->cleanup();
		$this->loadSystemModules();
		$this->loadModules();
	}


	public function loadSystemModules()
	{

		$stigniter_path = ROOTPATH . "stigniter/";
		if (file_exists($stigniter_path . 'system/system-modules')) :

			$modules = scandir($stigniter_path . 'system/system-modules');

			unset($modules[0]); /* Removes /.. */
			unset($modules[1]); /* Removes /. */

			foreach ($modules as $module) :
				$module_name 		= 	strtolower($module);
				$module_path 		= 	$stigniter_path . 'system/system-modules/';
				$components_path  	= 	$module_path . $module . '/Components/';
				$routes_path  		= 	$module_path . $module . '/Config/routes.json';
				$languages  		= 	$module_path . $module . '/Languages/en.json'; /* Taking EN while development */
				$db_path 				= 	$module_path . $module . '/Config/db.json';

				$components = scandir($components_path);
				unset($components[0]);
				unset($components[1]);

				foreach ($components as $component) :
					$this->output_data['components'][] = $components_path . $component;
				endforeach;

				/* Routes */
				if(file_exists($routes_path)):

					$route = json_decode( file_get_contents($routes_path) , true );

					foreach($route as $r):
						$this->angular['routes'][] = $r;
					endforeach;

				endif;


				
				/* Translations */
				if(file_exists($languages)):

					$languages = json_decode( file_get_contents($languages) , true );
					
					$this->output_data['translations'][$module_name] = $languages;

				endif;

				/* Databases */
				if(file_exists($db_path)):
					$db = file_get_contents($db_path);
					$db = json_decode($db, true);

					foreach($db as $tb):
						$this->createTable($tb);
					endforeach;

				endif;


			endforeach;

		endif;
	}

	public function loadModules()
	{

		$stigniter_path = ROOTPATH . "stigniter/";
		if (file_exists($stigniter_path . 'modules')) :

			$modules = scandir($stigniter_path . 'modules');

			unset($modules[0]); /* Removes /.. */
			unset($modules[1]); /* Removes /. */

			foreach ($modules as $module) :
				$module_name 		= 	strtolower($module);
				$module_path 		= 	$stigniter_path . 'modules/';
				$components_path  	= 	$module_path . $module . '/Components/';
				$routes_path  		= 	$module_path . $module . '/Config/routes.json';
				$languages  		= 	$module_path . $module . '/Languages/en.json'; /* Taking EN while development */
				$db_path 				= 	$module_path . $module . '/Config/db.json';

				$components = scandir($components_path);
				unset($components[0]);
				unset($components[1]);

				foreach ($components as $component) :
					$this->output_data['components'][] = $components_path . $component;
				endforeach;

				/* Routes */
				if(file_exists($routes_path)):

					$route = json_decode( file_get_contents($routes_path) , true );

					foreach($route as $r):
						$this->angular['routes'][] = $r;
					endforeach;

				endif;


				
				/* Translations */
				if(file_exists($languages)):

					$languages = json_decode( file_get_contents($languages) , true );
					
					$this->output_data['translations'][$module_name] = $languages;

				endif;

				/* Databases */
				if(file_exists($db_path)):
					$db = file_get_contents($db_path);
					$db = json_decode($db, true);

					foreach($db as $tb):
						$this->createTable($tb);
					endforeach;

				endif;


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

	protected function is_angular_view(){
		$this->request = service('request');
	
		if(!$this->request->getHeader('STIGNITER-AJAX')){
			$path = $this->request->uri->getPath();
			header("Location:".base_url("/#!/$path"));
			exit;
		}

	}

	private function createTable($table = false){
		if(!$table) return false;

		$tb_name = $table['table'];
		$columns = $table['columns'];
		$first_query = false;
		if(isset($table['first_query'])){
			$first_query = $table['first_query'];
		}

		if (!$this->db->tableExists($tb_name)){
			$is_created = $this->forge->addPrimaryKey('id')->addField($columns)->createTable($tb_name);
			if($is_created and $first_query){
				/* Run First Query */
				$this->db->query($first_query);
			}
		}

	}
}
