<?php

declare(strict_types=1);

session_start();

use App\Application;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;

require dirname(__DIR__) . '/vendor/autoload.php';

$builder = new ContainerBuilder();

$builder->addDefinitions(
    dirname(__DIR__) . '/config/container.php'
);

$container = $builder->build();

$container->get(Manager::class);

$application = $container->get(Application::class);

$application->run();