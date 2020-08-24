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

$subscriber = new \RedisEventDispatcher\Subscriber(
    $client,
    new \RedisEventDispatcherExample\ListenersMap(),
    new Container(), // here you need some container
    new \Psr\Log\Test\TestLogger()
);
$subscriber->subscribe();