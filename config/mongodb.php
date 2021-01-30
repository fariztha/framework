<?php

use MongoDB\Client;

return [     
    //database    
    Client::class => function() {    	
    	return new Client('mongodb+srv://<username>:<password>@<cluster-address>/test?retryWrites=true&w=majority');
    },
    // end
];