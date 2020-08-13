<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcherExample;

use RedisEventDispatcher\ListenersMapInterface;

class ListenersMap implements ListenersMapInterface
{
    private const MAP = [
        SomeEvent::class => [
            SomeListener::class,
        ],
    ];

    public function getListenersForEvent(object $event): iterable
    {
        $className = get_class($event);

        return self::MAP[$className] ?? [];
    }

    public function getEventsList(): array
    {
        return array_keys(self::MAP);
    }

    public function getListenersMap(): array
    {
        return self::MAP;
    }
}