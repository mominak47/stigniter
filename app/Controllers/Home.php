<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// generate_js_file(ROOTPATH."/stigniter/system/node_modules/angular/angular.min.js.map", "angular.min.js", "map");

		return view('app', [
			"scripts" => [
				"angular"		=> generate_js_file(ROOTPATH."/stigniter/system/node_modules/angular/angular.min.js", "angular.min", "js"),
				"angular-route"		=> generate_js_file(ROOTPATH."/stigniter/system/scripts/route.js", "angular.route", "js"),
				"app"			=> generate_js_file(ROOTPATH."/stigniter/system/scripts/app.js"),
				"components" 	=> generate_js_file($this->output_data['components'])
			]
		]);
	}

}
