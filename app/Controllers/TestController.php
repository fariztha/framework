<?php
namespace App\Controllers;
use Delight\Cookie\Cookie;
use Delight\Cookie\Session;
use Valitron\Validator;
use Medoo\Medoo;
use App\Utils\HeaderResponse;
use WebPConvert\WebPConvert;

class TestController
{
	protected $database;
    protected $response;

    public function __construct(Medoo $database,HeaderResponse $response){
         $this->database = $database;
         $this->response = $response;
    }


	public function index()
    {            
        if (Cookie::exists('coba')) {
            $columns = [
                'id',
                'created_at',
                'name',
            ];

            $data=$this->database->select('profiles', $columns);
            echo $this->response->json_response(200, $data);   
        }else{
            echo "need cookie <a href='cookie'>set cookie </a>";
        }          
    }

   	public function cookie()   	
    {    	    	
        $cookie = new Cookie('coba');
        $cookie->setValue('cobacoba');
        // expired 24 jam
        $cookie->setMaxAge(60 * 60 * 24);
        //never expired        
        //$cookie->setMaxAge(time() + (10 * 365 * 24 * 60 * 60)); 
        $cookie->setPath('/');
        $cookie->setDomain('localhost');
        $cookie->setHttpOnly(true);
        //$cookie->setSecureOnly(true);
        $cookie->setSameSiteRestriction('Strict');
        echo $cookie;
        $cookie->save();
    }

    public function konversi()
    {
        $source = __DIR__ . '/../../storage/images/coba.jpg';
        $destination = __DIR__ . '/../../storage/images/coba.webp';
        $success = WebPConvert::convert($source, $destination, [
            //'converters' => ['cwebp']
            'converters' => ['gd']
        ]);
        echo "<img src='../storage/images/coba.webp'>";
    }

    public function post()
    {
        $v = new Validator($_POST);
        $v->rule('required', ['name', 'email']);
        $v->rule('email', 'email');
        if($v->validate()) {
            echo "Yay! We're all good!";
        } else {
            // Errors
            print_r($v->errors());
        }
    }

}