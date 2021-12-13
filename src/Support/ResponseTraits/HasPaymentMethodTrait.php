<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasPaymentMethodTrait
{
    /** @var string|null Payment method used (if already determined). */
    private ?string $paymentMethod;



    /**
     * Set the response's paymentMethod.
     *
     * @param string|null $paymentMethod The response's paymentMethod.
     * @return void
     */
    private function setPaymentMethod(?string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Get the response's paymentMethod.
     *
     * @return string|null
     */
    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }
}
