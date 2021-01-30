<?php
namespace App\ApiControllers;

use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class ApiController
{
	public function __construct($response,$database)
    {
        $this->response = $response;
        $this->database = $database;
        $headers=array_change_key_case(apache_request_headers(),CASE_LOWER);
    	if (empty($headers['authorization'])){
            echo $this->response->json_response(400, "Header Kosong");            
            exit;
        }
        
        //cek token jwt	
        $signer = new Sha256();            	
        $auth = $headers['authorization'];
        if (preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
            $token = (new Parser())->parse((string) $matches[1]);
            $this->token = $token;
            $data = new ValidationData();
            $data->setIssuer($_SERVER['SERVER_NAME']);
            $data->setAudience($_SERVER['SERVER_NAME']);
            $data->setId('Framework');
            //-------- cek user
            $cekUser = $this->database->select( "users",["password"],[
                "expired_token" => $token->getClaim('exp') , "id" => $token->getClaim('uid')
            ]);            
            if(empty($cekUser)){
                echo $this->response->json_response(401, "Token user tidak ditemukan, Silahkan logout dan login kembali");                
                exit; 
            }            
            if (!$token->verify($signer, $cekUser[0]['password'])){
                echo $this->response->json_response(401, "token User tidak ter-validasi");
                exit;
            }                       
            if (!$token->validate($data)){    
                echo $this->response->json_response(401, "token tidak ter-validasi");
                exit;
            }
        }else{
        	echo $this->response->json_response(400, "Header Tidak benar");
        	exit;
        }

    }    
//--- end
}