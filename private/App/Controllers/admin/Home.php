<?php
use App\Libraries\AuthController;

class Home extends AuthController
{

  public function __construct()
  {
    parent::__construct();
  }
  
  public function index()
  {
    $this->_web->view('admin.home');
  }
}
