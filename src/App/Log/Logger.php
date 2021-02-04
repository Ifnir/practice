<?php


namespace App\Log;


class Logger extends AbstractLogger implements LoggerInterface
{

    public function log($level, $message, array $context = array())
    {
        $message = (string)$message;

            switch($level) {
                case LogLevel::EMERGENCY:
                    $this->emergency($message, $context);
                    break;
                default:
                    throw new InvalidArgumentException("Unknown");
            }
    }

}