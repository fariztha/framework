<?php
namespace App\Controllers;
use App\Controllers\ApiController;

class CobaApiController extends ApiController
{
	public function coba()
    {
    	echo $this->response->json_response(200, "Berhasil");    	
    }

}