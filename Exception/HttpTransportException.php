<?php

namespace SP\Data\Exception;

class HttpTransportException extends \RuntimeException
{
    private $ownerName;

    public function __construct($message, $ownerName, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->ownerName = $ownerName;
    }

    public function getOwnerName()
    {
        return $this->ownerName;
    }
}
