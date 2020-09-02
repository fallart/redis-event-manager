<?php
declare(strict_types=1);

namespace RedisEventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Redis;

class Dispatcher implements EventDispatcherInterface
{
    private Redis $client;
    private LoggerInterface $logger;

    public function __construct(Redis $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event)
    {
        $eventName = get_class($event);

        $this->logger->info(sprintf('Dispatching event: %s', $eventName));
        $this->client->publish($eventName, json_encode($event));
    }
}