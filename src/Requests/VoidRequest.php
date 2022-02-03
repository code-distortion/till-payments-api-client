<?php

namespace CodeDistortion\TillPayments\Requests;

use CodeDistortion\TillPayments\Support\BaseRequest;
use CodeDistortion\TillPayments\Support\RequestTraits\HasExtraDataTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasMerchantTranscationIdTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasReferenceUuidTrait;

/**
 * A class to build and represent a Till Payments "void" request.
 *
 * "A Void cancels a previously performed authorization made with the Preauthorize method".
 *
 * @see https://gateway.tillpayments.com/documentation/apiv3#transaction-request-void
 */
class VoidRequest extends BaseRequest
{
    use HasExtraDataTrait;
    use HasMerchantTranscationIdTrait;
    use HasReferenceUuidTrait;



    /**
     * Set the request up with the values that are required.
     *
     * @param string $referenceUuid         The reference to the original preauthorize.
     * @param string $merchantTransactionId Your unique transaction id.
     */
    public function __construct(string $referenceUuid, string $merchantTransactionId)
    {
        // POST /transaction/{apiKey}/void
        parent::__construct('POST', 'transaction', 'void');

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
