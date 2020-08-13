<?php
declare(strict_types=1);

namespace RedisEventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Redis;

class Dispatcher implements EventDispatcherInterface
{
    private Redis $client;

    public function __construct(Redis $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event)
    {
        $this->client->publish(get_class($event), serialize($event));
    }
}