<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcher;

interface DbReconnectServiceInterface
{
    public function reconnect(): void;
}
