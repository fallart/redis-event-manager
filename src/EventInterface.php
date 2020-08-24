<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcher;

use JsonSerializable;

interface EventInterface extends JsonSerializable
{
    public static function createFromArray(array $data): self;
}
