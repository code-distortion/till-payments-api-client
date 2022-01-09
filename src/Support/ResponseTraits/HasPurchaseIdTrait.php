<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasPurchaseIdTrait
{
    /** @var string|null Purchase ID of the transaction. */
    private $purchaseId;



    /**
     * Set the response's purchaseId.
     *
     * @param string|null $purchaseId The response's purchaseId.
     * @return void
     */
    private function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;
    }

    /**
     * Get the response's purchaseId.
     *
     * @return string|null
     */
    public function getPurchaseId()
    {
        return $this->purchaseId;
    }
}
