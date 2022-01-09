<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasPaymentMethodTrait
{
    /** @var string|null Payment method used (if already determined). */
    private $paymentMethod;



    /**
     * Set the response's paymentMethod.
     *
     * @param string|null $paymentMethod The response's paymentMethod.
     * @return void
     */
    private function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Get the response's paymentMethod.
     *
     * @return string|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }
}
