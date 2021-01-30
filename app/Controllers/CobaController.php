<?php 
namespace App\Controllers;
use App\Controllers\PageController;

class CobaController extends PageController
{
    public function index()
    {
        echo $this->blade->run("hello",array("variable1"=>"VariableDariController"));
    }
}
