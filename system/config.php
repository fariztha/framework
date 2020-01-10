<?php

use function DI\create;
use App\Model\ArticleRepository;
use App\Persistence\InMemoryArticleRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Medoo\Medoo;

return [
    // Bind an interface to an implementation
    ArticleRepository::class => create(InMemoryArticleRepository::class),

    // Configure Twig
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../resource/views');
        return new Environment($loader, [
    		'cache' => __DIR__.'/../storage/cache/twig',
		]);                        
    },	
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
