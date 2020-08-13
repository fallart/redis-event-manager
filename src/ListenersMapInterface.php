<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

interface ListenersMapInterface extends ListenerProviderInterface
{
    public function getEventsList(): array;
    public function getListenersMap(): array;
}