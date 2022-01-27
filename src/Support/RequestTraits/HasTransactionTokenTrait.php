<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasTransactionTokenTrait
{
    /** @var string|null The token generated via payment.js. */
    private $transactionToken;



    /**
     * Specify the token generated via payment.js.
     *
     * @param string|null $transactionToken The token generated via payment.js.
     * @return $this
     */
    public function setTransactionToken($transactionToken)
    {
        $this->transactionToken = $transactionToken;
        return $this;
    }

    /**
     * Get the transaction token.
     *
     * @return string|null
     */
    public function getTransactionToken(): ?string
    {
        return $this->transactionToken;
    }
}
