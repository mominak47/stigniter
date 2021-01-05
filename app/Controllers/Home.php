<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{

		return view('app', [
			"styles"  => [
				"login"	=> generate_file(ROOTPATH."/stigniter/system/system-modules/Auth/css/Login.css", "login", "css")
			],
			"scripts" => [
				"angular"		=> generate_file(ROOTPATH."/stigniter/system/node_modules/angular/angular.min.js", "angular.min", "js"),
				"angular-route"		=> generate_file(ROOTPATH."/stigniter/system/scripts/route.js", "angular.route", "js"),
				"app"			=> generate_file(ROOTPATH."/stigniter/system/scripts/app.js"),
				"components" 	=> generate_file($this->output_data['components']),
				"router"		=> generate_file( createRouterFile($this->angular['routes']) )
			]
		]);
	}

}
