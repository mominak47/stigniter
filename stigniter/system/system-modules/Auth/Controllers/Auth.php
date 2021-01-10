<?php 

namespace SystemModules\Auth\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController{
    function __construct(){
        $this->viewpath = "\SystemModules\Auth\Views\\";
    }

	public function index()
	{
        $this->is_angular_view();
        echo view($this->viewpath . "login");
    }
    
    public function register()
	{
        $this->is_angular_view();
        echo view($this->viewpath . "register");
    }
    
    public function password()
	{
        $this->is_angular_view();
        echo view($this->viewpath . "register");
    }
    
}
