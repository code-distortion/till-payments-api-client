<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasExtraDataTrait
{
    /** @var mixed[]|null The ExtraData (key-value-pair array). */
    private $extraData = [];



    /**
     * Set the request's ExtraData.
     *
     * @param mixed[]|null $extraData The ExtraData (key-value-pair) array to use.
     * @return void
     */
    public function setExtraData($extraData): void
    {
        $this->extraData = $extraData;
    }

    /**
     * Get the request's ExtraData.
     *
     * @return mixed[]|null
     */
    public function getExtraData(): ?array
    {
        return $this->extraData;
    }
}
