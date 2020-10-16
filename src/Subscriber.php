<?php
declare(strict_types=1);

namespace RedisEventDispatcher;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Redis;
use Throwable;

class Subscriber
{
    private Redis $client;
    private ListenersMapInterface $listenersMap;
    private ContainerInterface $container;
    private LoggerInterface $logger;
    private ?DbReconnectServiceInterface $dbReconnectService = null;

    /**
     * Subscriber constructor.
     *
     * @param Redis                       $client
     * @param ListenersMapInterface       $listenersMap
     * @param ContainerInterface          $container
     * @param LoggerInterface             $logger
     * @param DbReconnectServiceInterface $dbReconnectService
     */
    public function __construct(
        Redis $client,
        ListenersMapInterface $listenersMap,
        ContainerInterface $container,
        LoggerInterface $logger,
        ?DbReconnectServiceInterface $dbReconnectService
    ) {
        $this->client = $client;
        $this->listenersMap = $listenersMap;
        $this->container = $container;
        $this->logger = $logger;
        $this->dbReconnectService = $dbReconnectService;
    }

    public function subscribe()
    {
        $client = $this->client;
        $map = $this->listenersMap;
        $container = $this->container;
        $logger = $this->logger;

        $client->subscribe(
            $map->getEventsList(),
            function (Redis $client, string $event, string $message) use ($map, $container, $logger) {
                try {
                    /** @var EventInterface|string $event - only for hinting */
                    $eventObject = $event::createFromArray(json_decode($message, true));
                    $logger->info(sprintf('Event received: %s', $event));
                    $this->reconnectDb();

                    foreach ($map->getListenersForEvent($eventObject) as $listenerClassname) {
                        try {
                            $listener = $container->get($listenerClassname);
                            $logger->info(sprintf('Trigger listener <<%s>> for event <<%s>>', $listenerClassname, $event));
                            $listener($eventObject);
                        } catch (Throwable $exception) {
                            $logger->error(
                                sprintf(
                                    'Got error from %s!',
                                    $listenerClassname
                                ),
                                [
                                    'message' => $exception->getMessage(),
                                    'file'    => $exception->getFile(),
                                    'line'    => $exception->getLine(),
                                    'trace'   => $exception->getTraceAsString(),
                                ]
                            );
                        }
                    }
                } catch (Throwable $throwable) {
                    $logger->error(
                        sprintf(
                            'Got error from %s!',
                            $event
                        ),
                        [
                            'message' => $throwable->getMessage(),
                            'file'    => $throwable->getFile(),
                            'line'    => $throwable->getLine(),
                            'trace'   => $throwable->getTraceAsString(),
                        ]
                    );
                }
            }
        );
    }

    private function reconnectDb(): void
    {
        if ($this->dbReconnectService !== null) {
            $this->dbReconnectService->reconnect();
        }
    }
}
