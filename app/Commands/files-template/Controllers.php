<?php 

namespace {module-type}\{slug}\Controllers;

use App\Controllers\BaseController;

class {sanitized_title} extends BaseController
{

    function __construct(){
        $this->viewpath = "\{module-type}\\{slug}\Views\\";
    }

	public function index()
	{
        $this->is_angular_view();
        echo view($this->viewpath . "view_{sanitized_title}");
    }

}