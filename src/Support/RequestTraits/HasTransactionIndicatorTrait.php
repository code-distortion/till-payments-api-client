<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasTransactionIndicatorTrait
{
    /**
     * String indicating the purpose of the transaction.
     *
     * "SINGLE", "INITIAL", "RECURRING", "CARDONFILE", "CARDONFILE-MERCHANT-INITIATED" or "MOTO".
     *
     * @var string|null
     */
    private $transactionIndicator;



    /**
     * Specify the transaction-indicator.
     *
     * @param string|null $transactionIndicator The transaction-indicator.
     * @return $this
     */
    public function setTransactionIndicator($transactionIndicator)
    {
        $this->transactionIndicator = $transactionIndicator;
        return $this;
    }

    /**
     * Get the transaction-indicator.
     *
     * @return string|null
     */
    public function getTransactionIndicator(): ?string
    {
        return $this->transactionIndicator;
    }
}
