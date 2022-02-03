<?php

namespace CodeDistortion\TillPayments\Requests;

use CodeDistortion\TillPayments\Support\RequestTraits\HasExtraDataTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasMerchantTranscationIdTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasReferenceUuidTrait;
use CodeDistortion\TillPayments\Support\BaseRequest;

/**
 * A class to build and represent a Till Payments "deregister" request.
 *
 * "A Deregister deletes a previously registered payment instrument using Register".
 *
 * @see https://gateway.tillpayments.com/documentation/apiv3#transaction-request-deregister
 */
class DeregisterRequest extends BaseRequest
{
    use HasExtraDataTrait;
    use HasMerchantTranscationIdTrait;
    use HasReferenceUuidTrait;



    /**
     * Set the request up with the values that are required.
     *
     * @param string $referenceUuid         UUID of a register, debit-with-register or preauthorize-with-register.
     * @param string $merchantTransactionId Your unique transaction id.
     */
    public function __construct(string $referenceUuid, string $merchantTransactionId)
    {
        // POST /transaction/{apiKey}/deregister
        parent::__construct('POST', 'transaction', 'deregister');

        $this->setReferenceUuid($referenceUuid);
        $this->setMerchantTransactionId($merchantTransactionId);
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
            "referenceUuid" => $this->getReferenceUuid(),
        ];
        return array_merge(
            $requiredFields,
            $this->buildKeyValuePair('extraData', $this->getExtraData()),
        );
    }
}
