<?php
use App\Wrapper\Controller;
use App\Helpers\Mod;

class Home extends Controller
{

    public function index()
    {
        echo Mod::hash('admin');
    }
}
