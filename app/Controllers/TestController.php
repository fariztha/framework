<?php
namespace App\Controllers;
use Medoo\Medoo;

class TestController
{
	protected $database;

    public function __construct(Medoo $database){
         $this->database = $database;
    }


	public function index()
    {    
        $columns = [
            'id',
            'created_at',
            'name',
        ];

        $data=$this->database->select('profiles', $columns);
        echo $this->json_response(200, $data);     	
    }

   	public function coba($language)   	
    {    	    	
    	header('Content-Type: application/json');
    	
		$age = array("Peter"=>35, "Ben"=>37, "Joe"=>$language);

		$myJSON = json_encode($age);

		echo $myJSON;
    }

    public function wow($language,$variable)
    {
    	echo "halaman Berbahasa ".$language." dan variable ".$variable;    	
    }

    public function json_response($code = 200, $message = null)
    {
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
        ));
    }

}