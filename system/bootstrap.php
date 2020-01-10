<?php
/**
 * The bootstrap file creates and returns the container.
 */

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
//$containerBuilder->enableCompilation(__DIR__ . '/../storage/cache/di');
$container = $containerBuilder->build();

return $container;