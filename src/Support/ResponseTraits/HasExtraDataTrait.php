<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

use CodeDistortion\TillPayments\Support\ResponseParts\ReturnData\ExtraData;

trait HasExtraDataTrait
{
    /** @var ExtraData|null The ExtraData (key-value-pair object). */
    private $extraData;



    /**
     * Set the response's ExtraData.
     *
     * @param ExtraData|null $extraData The ExtraData object to use.
     * @return void
     */
    private function setExtraData(?ExtraData $extraData): void
    {
        $this->extraData = $extraData;
    }

    /**
     * Get the response's ExtraData.
     *
     * @return ExtraData|null
     */
    public function getExtraData(): ?ExtraData
    {
        return $this->extraData;
    }

    /**
     * Get the response's capture-id (if present).
     *
     * @return string|null
     */
    public function getCaptureId(): ?string
    {
        return ($extraData = $this->extraData) ? $extraData->get('captureId') : null;
    }
}
