<?php

namespace CodeDistortion\TillPayments\Requests;

use CodeDistortion\TillPayments\Support\BaseRequest;
use CodeDistortion\TillPayments\Support\RequestTraits\HasAmountTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasDescriptionTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasExtraDataTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasMerchantTranscationIdTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasReferenceUuidTrait;

/**
 * A class to build and represent a Till Payments "capture" request.
 *
 * "A Capture completes the payment which was previously authorized with the Preauthorize method".
 *
 * @see https://gateway.tillpayments.com/documentation/apiv3#transaction-request-capture
 */
class CaptureRequest extends BaseRequest
{
    use HasAmountTrait;
    use HasDescriptionTrait;
    use HasExtraDataTrait;
    use HasMerchantTranscationIdTrait;
    use HasReferenceUuidTrait;



    /**
     * Set the request up with the values that are required.
     *
     * @param string $referenceUuid         The reference to the original preauthorize.
     * @param string $merchantTransactionId Your unique transaction id.
     * @param string $amount                Decimals separated by ".", max. 3 decimals.
     * @param string $currencyCode          Three letter currency code.
     */
    public function __construct(
        string $referenceUuid,
        string $merchantTransactionId,
        string $amount,
        string $currencyCode
    ) {

        // POST /transaction/{apiKey}/capture
        parent::__construct('POST', 'transaction', 'capture');

        $this->setReferenceUuid($referenceUuid);
        $this->setMerchantTransactionId($merchantTransactionId);
        $this->setAmount($amount);
        $this->setCurrencyCode($currencyCode);
    }

    /**
     * Build the data to send in the api request.
     *
     * @return mixed[]
     */
    public function buildRequestData(): array
    {
        $requiredFields = [
            "merchantTransactionId" => $this->getMerchantTransactionId(),
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrencyCode(),
            "referenceUuid" => $this->getReferenceUuid(),
        ];
        return array_merge(
            $requiredFields,
            $this->buildKeyValuePair('description', $this->getDescription()),
            $this->buildKeyValuePair('extraData', $this->getExtraData()),
        );
    }
}
