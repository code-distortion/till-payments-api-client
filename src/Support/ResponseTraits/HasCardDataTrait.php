<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

use CodeDistortion\TillPayments\Support\ResponseParts\ReturnData\CardData;

trait HasCardDataTrait
{
    /** @var CardData|null The CardData. */
    private ?CardData $cardData;



    /**
     * Set the response's CardData.
     *
     * @param CardData|null $cardData The CardData object.
     * @return void
     */
    private function setCardData(?CardData $cardData): void
    {
        $this->cardData = $cardData;
    }

    /**
     * Get the response's CardData.
     *
     * @return CardData|null
     */
    public function getCardData(): ?CardData
    {
        return $this->cardData;
    }
}
