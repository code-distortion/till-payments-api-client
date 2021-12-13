<?php

namespace CodeDistortion\TillPayments\Requests;

use CodeDistortion\TillPayments\Support\BaseRequest;
use CodeDistortion\TillPayments\Support\RequestTraits\HasAmountTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasDescriptionTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasMerchantTranscationIdTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasReferenceUuidTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasTransactionTokenTrait;

/**
 * A class to build and represent a Till Payments "incremental authorization" request.
 *
 * "An incremental authorization increases the authorized amount on the customer's payment instrument".
 *
 * @see https://gateway.tillpayments.com/documentation/apiv3#transaction-request-incremental-authorization
 */
class IncrementalAuthorizationRequest extends BaseRequest
{
    use HasAmountTrait;
    use HasDescriptionTrait;
    use HasMerchantTranscationIdTrait;
    use HasReferenceUuidTrait;
    use HasTransactionTokenTrait;



    /**
     * Set the request up with the values that are required.
     *
     * @param string $referenceUuid         UUID of the initial preauthorize.
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

        // POST /transaction/{apiKey}/incrementalAuthorization
        parent::__construct('POST', 'transaction', 'incrementalAuthorization');

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
            "referenceUuid" => $this->getReferenceUuid(),
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrencyCode(),
        ];
        return array_merge(
            $requiredFields,
            $this->buildKeyValuePair('transactionToken', $this->getTransactionToken()),
            $this->buildKeyValuePair('description', $this->getDescription()),
        );
    }
}
