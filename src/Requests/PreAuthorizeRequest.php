<?php

namespace CodeDistortion\TillPayments\Requests;

use CodeDistortion\TillPayments\Support\BaseRequest;
use CodeDistortion\TillPayments\Support\RequestTraits\HasAmountTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasDescriptionTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasMerchantTranscationIdTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasReferenceUuidTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasTransactionIndicatorTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasTransactionTokenTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasWithRegisterTrait;

/**
 * A class to build and represent a Till Payments "pre-authorize" request.
 *
 * "A Preauthorize reserves the payment amount on the customer's payment instrument".
 *
 * @see https://gateway.tillpayments.com/documentation/apiv3#transaction-request-preauthorize
 */
class PreAuthorizeRequest extends BaseRequest
{
    use HasAmountTrait;
    use HasDescriptionTrait;
    use HasMerchantTranscationIdTrait;
    use HasReferenceUuidTrait;
    use HasTransactionIndicatorTrait;
    use HasTransactionTokenTrait;
    use HasWithRegisterTrait;



    /**
     * Set the request up with the values that are required.
     *
     * @param string $merchantTransactionId Your unique transaction id.
     * @param string $amount                Decimals separated by ".", max. 3 decimals.
     * @param string $currencyCode          Three letter currency code.
     */
    public function __construct(string $merchantTransactionId, string $amount, string $currencyCode)
    {
        // POST /transaction/{apiKey}/preauthorize
        parent::__construct('POST', 'transaction', 'preauthorize');

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
            "withRegister" => $this->getWithRegister(),
        ];
        return array_merge($requiredFields, $this->buildKeyValuePair('referenceUuid', $this->getReferenceUuid()), $this->buildKeyValuePair('transactionToken', $this->getTransactionToken()), $this->buildKeyValuePair('transactionIndicator', $this->getTransactionIndicator()), $this->buildKeyValuePair('description', $this->getDescription()));
    }
}
