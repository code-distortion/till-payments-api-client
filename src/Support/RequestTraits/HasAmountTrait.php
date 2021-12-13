<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasAmountTrait
{
    /** @var string Decimals separated by ".", max. 3 decimals. */
    private string $amount;

    /** @var string Three letter currency code. */
    private string $currencyCode;



    /**
     * Set the payment amount.
     *
     * @param string $amount The amount to set.
     * @return $this
     */
    public function setAmount(string $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get the payment amount.
     *
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Set the 3 letter currency code.
     *
     * @param string $currencyCode The code to set.
     * @return $this
     */
    public function setCurrencyCode(string $currencyCode): static
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }


    /**
     * Get the 3 letter currency code.
     *
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}
