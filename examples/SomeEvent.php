<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcherExample;

class SomeEvent
{
    private string $fromName;
    private string $message;

    /**
     * SomeEvent constructor.
     *
     * @param string $fromName
     * @param string $message
     */
    public function __construct(string $fromName, string $message)
    {
        $this->fromName = $fromName;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
