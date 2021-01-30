<?php
/**
 * The bootstrap file creates and returns the container.
 */

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder;
/* Sql Database ORM */
$containerBuilder->addDefinitions(__DIR__ . '../../config/medoo.php');

/* MongoDB Database */
// $containerBuilder->addDefinitions(__DIR__ . '../../config/mongodb.php');

/* cache dependency injector */
// $containerBuilder->enableCompilation(__DIR__ . '/../storage/cache/di');

$container = $containerBuilder->build();

return $container;