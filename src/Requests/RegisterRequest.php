<?php

namespace CodeDistortion\TillPayments\Requests;

use CodeDistortion\TillPayments\Support\BaseRequest;
use CodeDistortion\TillPayments\Support\RequestTraits\HasMerchantTranscationIdTrait;
use CodeDistortion\TillPayments\Support\RequestTraits\HasTransactionTokenTrait;

/**
 * A class to build and represent a Till Payments "register" request.
 *
 * "Registers a customer's payment instrument for future charges (Debits or Preauthorizations)".
 *
 * @see https://gateway.tillpayments.com/documentation/apiv3#transaction-request-register
 */
class RegisterRequest extends BaseRequest
{
    use HasMerchantTranscationIdTrait;
    use HasTransactionTokenTrait;



    /**
     * Set the request up with the values that are required.
     *
     * @param string $merchantTransactionId Your unique transaction id.
     */
    public function __construct(string $merchantTransactionId)
    {
        // POST /transaction/{apiKey}/register
        parent::__construct('POST', 'transaction', 'register');

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
        ];
        return array_merge($requiredFields, $this->buildKeyValuePair('transactionToken', $this->getTransactionToken()));
    }
}
