<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$client = new Redis();
$client->connect('127.0.0.1', 6379);

if (!$client->isConnected()) {
    echo "NOT CONNECTED!";
    exit;
}

$dispatcher = new \RedisEventDispatcher\Dispatcher($client, $logger); // Add logger here
$dispatcher->dispatch(new \RedisEventDispatcherExample\SomeEvent('John Doe', 'Hello World!'));