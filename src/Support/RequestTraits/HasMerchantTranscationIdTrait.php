<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasMerchantTranscationIdTrait
{
    /** @var string Your unique transaction id. */
    private $merchantTransactionId;



    /**
     * Set the merchant-transaction id (your unique transaction id).
     *
     * @param string $merchantTransactionId The id to set.
     * @return $this
     */
    public function setMerchantTransactionId($merchantTransactionId)
    {
        $this->merchantTransactionId = $merchantTransactionId;
        return $this;
    }

    /**
     * Get the merchant-transaction id (your unique transaction id).
     *
     * @return string
     */
    public function getMerchantTransactionId(): string
    {
        return $this->merchantTransactionId;
    }
}
