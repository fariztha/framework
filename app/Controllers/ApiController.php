<?php
namespace App\Controllers;
use App\Utils\HeaderResponse;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;

class ApiController
{
	public function __construct(HeaderResponse $response)
    {
    	$this->response = $response;
    	if (empty(apache_request_headers()['Authorization'])){
    		echo $this->response->json_response(200, "Header Tidak benar");
    		exit;
    	}    
    	//cek token jwt	
    	$headers = apache_request_headers();
        $auth = $headers['Authorization'];
        if (preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
            $token = (new Parser())->parse((string) $matches[1]);
            $data = new ValidationData();
            $data->setIssuer('https://localhost');
            $data->setAudience('https://localhost');
            $data->setId('4f1g23a12aa');
            if (!$token->validate($data)){    
                echo $this->response->json_response(200, "token tidak ter-validasi");
                exit;
            }
        }else{
        	echo $this->response->json_response(200, "Header Tidak benar");
        	exit;      
        }

    }

}