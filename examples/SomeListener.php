<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcherExample;

class SomeListener
{
    public function __invoke(SomeEvent $event)
    {
        file_put_contents(
            __DIR__ . '/../data/result.log',
            sprintf(
                '%s: %s',
                $event->getFromName(),
                $event->getMessage()
            ),
            FILE_APPEND
        );
    }
}