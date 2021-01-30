<?php
namespace App\ApiControllers;
use Bcrypt\Bcrypt;
use App\Utils\HeaderResponse;
use Valitron\Validator;
use Medoo\Medoo;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class AuthController 
{
    private $database;
    private $response;

    public function __construct(Medoo $database,HeaderResponse $response)
    {
        $this->database = $database;
        $this->response = $response;        
    }

    public function login()
    {
        $bcrypt = new Bcrypt();        
        $bcrypt_version = '2a';                       
        $v = new Validator($_POST);
        $v->rule('required', ['username', 'password']);
        if($v->validate()) {      
        $cekAuth = $this->database->select("users",["id","username","password"],[
                "username" => $_POST["username"]
        ]);        
        if(!empty($cekAuth)){            
            if($bcrypt->verify($_POST["password"], $cekAuth[0]['password'])){
                // create token
                $time = time();
                $signer = new Sha256();          
                //remember
                if($_POST['remember'] == 'Yes'){
                    //never expired
                    $token = (new Builder())
                    ->issuedBy($_SERVER['SERVER_NAME'])
                    ->permittedFor($_SERVER['SERVER_NAME']) 
                    ->identifiedBy('Framework', true)      
                    ->issuedAt($time)
                    ->canOnlyBeUsedAfter($time) 
                    ->expiresAt($time + 315360000) 
                    ->withClaim('uid',$cekAuth[0]['id'])                    
                    ->getToken($signer, new Key($cekAuth[0]['password']));
                    $this->database->update("users",["expired_token" => $time + 315360000],["id" => $cekAuth[0]['id']]);                    
                    $data = array("data" => $token);
                    echo $this->response->json_response(200,$data);
                }else{
                    // expired 24 jam
                    $token = (new Builder())
                    ->issuedBy($_SERVER['SERVER_NAME'])
                    ->permittedFor($_SERVER['SERVER_NAME']) 
                    ->identifiedBy('Framework', true)      
                    ->issuedAt($time)
                    ->canOnlyBeUsedAfter($time)
                    ->expiresAt($time + 86400) 
                    ->withClaim('uid',$cekAuth[0]['id'])                    
                    ->getToken($signer, new Key($cekAuth[0]['password']));
                    $this->database->update("users",["expired_token" => $time + 86400],["id" => $cekAuth[0]['id']]);                    
                    $data = array("data" => $token);
                    echo $this->response->json_response(200,$data);
                }                 
            }else{
                echo $this->response->json_response(401, "Password Salah!"); 
            }
        }else{
            echo $this->response->json_response(401, "User tidak di temukan"); 
        }
        } else {
            // Errors                       
            echo $this->response->json_response(400,$v->errors());            
        }           
    }   
}