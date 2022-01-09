<?php

namespace CodeDistortion\TillPayments\Support\ResponseParts;

use stdClass;

/**
 * Represent a TransactionResponseError object, returned by Till Payments.
 *
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-data-transactionresponseerror
 */
class TransactionResponseError
{
    /** @var string The error return message. */
    private $errorMessage;

    /** @var integer The returned error-code. */
    private $errorCode;

    /** @var string|null The returned adapter message (if given). */
    private $adapterMessage;

    /** @var string|null The returned adapter-code (if given). */
    private $adapterCode;



    /**
     * Constructor - not callable.
     */
    protected function __construct()
    {
    }

    /**
     * Build based on the data returned from Till Payments.
     *
     * @param stdClass $data The data returned from Till Payments.
     * @return self
     */
    public static function buildFromResponse($data): self
    {
        $return = new self();
        $return->errorMessage = $data->errorMessage ?? null;
        $return->errorCode = $data->errorCode ?? null;
        $return->adapterMessage = $data->adapterMessage ?? null;
        $return->adapterCode = $data->adapterCode ?? null;

        return $return;
    }

    /**
     * Get the error message.
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Get the error code.
     *
     * @return integer
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * Get the adapter message.
     *
     * @return string|null
     */
    public function getAdapterMessage()
    {
        return $this->adapterMessage;
    }

    /**
     * Get the adapter code.
     *
     * @return string|null
     */
    public function getAdapterCode()
    {
        return $this->adapterCode;
    }
}
