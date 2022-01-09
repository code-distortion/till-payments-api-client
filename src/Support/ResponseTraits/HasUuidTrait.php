<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasUuidTrait
{
    /** @var string|null UUID of the transaction. */
    private $uuid;



    /**
     * Set the response's uuid.
     *
     * @param string|null $uuid The response's uuid.
     * @return void
     */
    private function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Get the response's uuid.
     *
     * @return string|null
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
