<?php
declare(strict_types=1);

namespace RedisEventDispatcher;

use Psr\Container\ContainerInterface;
use Redis;

class Subscriber
{
    private Redis $client;
    private ListenersMapInterface $listenersMap;
    private ContainerInterface $container;

    /**
     * Subscriber constructor.
     *
     * @param Redis                 $client
     * @param ListenersMapInterface $listenersMap
     * @param ContainerInterface    $container
     */
    public function __construct(Redis $client, ListenersMapInterface $listenersMap, ContainerInterface $container)
    {
        $this->client = $client;
        $this->listenersMap = $listenersMap;
        $this->container = $container;
    }

    public function subscribe()
    {
        $client = $this->client;
        $map = $this->listenersMap;
        $container = $this->container;

        $client->subscribe(
            $map->getEventsList(),
            function (Redis $client, string $event, string $message) use ($map, $container) {
                $eventObject = unserialize($message);

                foreach ($map->getListenersForEvent($eventObject) as $listenerClassname) {
                    $listener = $container->get($listenerClassname);
                    $listener($eventObject);
                }
            }
        );
    }
}
