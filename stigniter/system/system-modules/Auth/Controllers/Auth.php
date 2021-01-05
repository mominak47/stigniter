<?php 

namespace SystemModules\Auth\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    function __construct(){
        $this->viewpath = "\SystemModules\Auth\Views\\";
    }

	public function index()
	{
        echo view($this->viewpath . "test");
	}

}
