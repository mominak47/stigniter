<?php 

namespace SystemModules\auth\Controllers;

use App\Controllers\BaseController;

class SMS extends BaseController
{

    function __construct(){
        $this->viewpath = "\SystemModules\\auth\Views\\";
    }

	public function index()
	{
        $this->is_angular_view();
        echo view($this->viewpath . "view_SMS");
    }

}