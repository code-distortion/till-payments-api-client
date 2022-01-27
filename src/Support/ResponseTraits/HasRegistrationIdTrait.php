<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasRegistrationIdTrait
{
    /** @var string|null registrationId. */
    private $registrationId;



    /**
     * Set the response's registrationId.
     *
     * @param string|null $registrationId The response's registrationId.
     * @return void
     */
    private function setRegistrationId(?string $registrationId): void
    {
        $this->registrationId = $registrationId;
    }

    /**
     * Get the response's registrationId.
     *
     * @return string|null
     */
    public function getRegistrationId(): ?string
    {
        return $this->registrationId;
    }
}
