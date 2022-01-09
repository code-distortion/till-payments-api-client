<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasReferenceUuidTrait
{
    /** @var string|null UUID of the preauthorized transaction. */
    private $referenceUuid;



    /**
     * Set the reference-uuid.
     *
     * @param string|null $referenceUuid The uuid to set.
     * @return $this
     */
    public function setReferenceUuid($referenceUuid)
    {
        $this->referenceUuid = $referenceUuid;
        return $this;
    }

    /**
     * Get the reference-uuid.
     *
     * @return string|null
     */
    public function getReferenceUuid()
    {
        return $this->referenceUuid;
    }
}
