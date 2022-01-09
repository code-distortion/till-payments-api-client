<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

use CodeDistortion\TillPayments\Support\ResponseParts\ReturnData\CardData;

trait HasCardDataTrait
{
    /** @var CardData|null The CardData. */
    private $cardData;



    /**
     * Set the response's CardData.
     *
     * @param CardData|null $cardData The CardData object.
     * @return void
     */
    private function setCardData($cardData)
    {
        $this->cardData = $cardData;
    }

    /**
     * Get the response's CardData.
     *
     * @return CardData|null
     */
    public function getCardData()
    {
        return $this->cardData;
    }
}
