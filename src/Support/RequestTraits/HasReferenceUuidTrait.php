<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasReferenceUuidTrait
{
    /** @var string|null UUID of the preauthorized transaction. */
    private ?string $referenceUuid = null;



    /**
     * Set the reference-uuid.
     *
     * @param string|null $referenceUuid The uuid to set.
     * @return $this
     */
    public function setReferenceUuid(?string $referenceUuid): static
    {
        $this->referenceUuid = $referenceUuid;
        return $this;
    }

    /**
     * Get the reference-uuid.
     *
     * @return string|null
     */
    public function getReferenceUuid(): ?string
    {
        return $this->referenceUuid;
    }
}
