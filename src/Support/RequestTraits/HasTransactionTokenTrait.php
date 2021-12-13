<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasTransactionTokenTrait
{
    /** @var string|null The token generated via payment.js. */
    private ?string $transactionToken = null;



    /**
     * Specify the token generated via payment.js.
     *
     * @param string|null $transactionToken The token generated via payment.js.
     * @return $this
     */
    public function setTransactionToken(?string $transactionToken): static
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
