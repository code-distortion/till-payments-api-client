<?php

namespace CodeDistortion\TillPayments\Support\ResponseParts\ReturnData;

use stdClass;

/**
 * Represent a CardData object, returned by Till Payments.
 *
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-data-returndata
 */
class CardData
{
    /** @var string The type of credit card. */
    private $type;

    /** @var string|null The card-holder's first name. */
    private $firstName;

    /** @var string|null The card-holder's last name. */
    private $lastName;

    /** @var string|null The card's country-code. */
    private $country;

    /** @var string The card-holder's full name. */
    private $cardHolder;

    /** @var integer The card's expiry month.  */
    private $expiryMonth;

    /** @var integer The card's expiry year.  */
    private $expiryYear;

    /** @var string The card number's first 6 digits. */
    private $firstSixDigits;

    /** @var string The card number's last 4 digits. */
    private $lastFourDigits;

    /** @var string|null A fingerprint of the card. */
    private $fingerprint;

    /** @var string|null The card's binBrand. */
    private $binBrand;

    /** @var string|null The card's binBank. */
    private $binBank;

    /** @var string|null The card's binType. */
    private $binType;

    /** @var string|null The card's binLevel. */
    private $binLevel;

    /** @var string|null The card's binCountry. */
    private $binCountry;

    /** @var string|null The 3-D Secure value. */
    private $threeDSecure;

    /** @var string|null The eci value. */
    private $eci;


    /**
     * Constructor - not callable.
     */
    protected function __construct()
    {
    }

    /**
     * Build based on the data returned from Till Payments.
     *
     * @param stdClass|null $data The data returned from Till Payments.
     * @return self|null
     */
    public static function buildFromResponse($data): ?self
    {
        if (is_null($data)) {
            return null;
        }
        if ($data->_TYPE != 'cardData') {
            return null;
        }

        $return = new self();
        $return->type = $data->type;
        $return->firstName = $data->firstName ?? null;
        $return->lastName = $data->lastName ?? null;
        $return->country = $data->country ?? null;
        $return->cardHolder = $data->cardHolder;
        $return->expiryMonth = $data->expiryMonth;
        $return->expiryYear = $data->expiryYear;
        $return->firstSixDigits = $data->firstSixDigits;
        $return->lastFourDigits = $data->lastFourDigits;
        $return->fingerprint = $data->fingerprint ?? null;
        $return->binBrand = $data->binBrand ?? null;
        $return->binBank = $data->binBank ?? null;
        $return->binType = $data->binType ?? null;
        $return->binLevel = $data->binLevel ?? null;
        $return->binCountry = $data->binCountry ?? null;
        $return->threeDSecure = $data->threeDSecure ?? null;
        $return->eci = $data->eci ?? null;
//        $return->merchantFingerprint = $data->merchantFingerprint ?? null; // not documented
//        $return->globalFingerprint = $data->globalFingerprint ?? null; // not documented

        return $return;
    }

    /**
     * Retrieve the card's type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Generate a readable version of the credit card number (the middle section will be missing).
     *
     * @param string       $middle          The string to put in the middle.
     * @param integer|null $firstDigitCount The number of first digits to use (null for all 6).
     * @param integer|null $lastDigitCount  The number of last digits to use (null for all 4).
     * @return string
     */
    public function getReadableCardNumber(
        $middle = ' … ',
        $firstDigitCount = null,
        $lastDigitCount = null
    ): string {

        $firstDigitCount = is_int($firstDigitCount) ? max(0, $firstDigitCount) : 9999;
        $firstDigits = mb_substr($this->firstSixDigits, 0, $firstDigitCount);

        $lastDigitCount = is_int($lastDigitCount) ? max(0, $lastDigitCount) : 9999;
        $lastDigits = mb_substr($this->lastFourDigits, -$lastDigitCount, $lastDigitCount);

        return trim($firstDigits . $middle . $lastDigits);
    }
}
