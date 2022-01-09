<?php

namespace CodeDistortion\TillPayments\Exceptions;

use Exception;
use Throwable;

/**
 * The base Till Payments exception class.
 */
class TillPaymentsException extends Exception
{
    /**
     * Constructor.
     *
     * @param string         $message  The Exception message to throw.
     * @param integer        $code     The Exception code.
     * @param Throwable|null $previous The previous throwable used for the exception chaining.
     */
    final private function __construct(string $message = "", int $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
