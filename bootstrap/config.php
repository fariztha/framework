<?php

use function DI\create;
use Medoo\Medoo;

return [     
    //database    
    Medoo::class => function() {
    	$dbconfig = require 'database.php';
    	return new Medoo([
	        'database_type' => 'mysql',
	        'database_name' => $dbconfig['name'],
	        'server' => $dbconfig['host'],
	        'username' => $dbconfig['username'],
	        'password' => $dbconfig['password']
    	]);
    },
    // end
];
