<?php
namespace App\Controllers;

class PageController
{
	public function halaman404()
    {
    	echo "404 notfound";
    }

   	public function halaman405()
    {
    	echo "405 method not allowed";
    }

}