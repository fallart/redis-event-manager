<?php
/**
 * @copyright  Copyright (c) 2020 Jobplanner Ltd. (jobplanner.io)
 */
declare(strict_types=1);

namespace RedisEventDispatcherExample;

use RedisEventDispatcher\EventInterface;

class SomeEvent implements EventInterface
{
    const FIELD_FROM    = 'from';
    const FIELD_MESSAGE = 'message';

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

    public static function createFromArray(array $data): EventInterface
    {
        return new self(
            $data[self::FIELD_FROM],
            $data[self::FIELD_MESSAGE]
        );
    }

    public function jsonSerialize()
    {
        return [
            self::FIELD_FROM    => $this->getFromName(),
            self::FIELD_MESSAGE => $this->getMessage(),
        ];
    }
}
