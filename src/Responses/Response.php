<?php

namespace CodeDistortion\TillPayments\Responses;

use CodeDistortion\TillPayments\Support\ResponseParts\ReturnData\ExtraData;
use CodeDistortion\TillPayments\Support\ResponseParts\ReturnData\CardData;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasCardDataTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasErrorsTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasExtraDataTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasPaymentMethodTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasPurchaseIdTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasRedirectUrlTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasRegistrationIdTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasReturnTypeTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasSuccessTrait;
use CodeDistortion\TillPayments\Support\ResponseTraits\HasUuidTrait;
use stdClass;

/**
 * A class to represent various types of Till Payments API responses.
 *
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-debit
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-preauthorize
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-capture
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-void
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-register
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-deregister
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-refund
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-payout
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-incremental-authorization
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-request-transaction-response
 */
class Response
{
    use HasCardDataTrait;
    use HasErrorsTrait;
    use HasExtraDataTrait;
    use HasPaymentMethodTrait;
    use HasPurchaseIdTrait;
    use HasRedirectUrlTrait;
    use HasRegistrationIdTrait;
    use HasReturnTypeTrait;
    use HasSuccessTrait;
    use HasUuidTrait;

//    public CONST RETURN_TYPE_UNKNOWN = null;
//    public CONST RETURN_TYPE_FINISHED = 1;
//    public CONST RETURN_TYPE_REDIRECT = 2;
//    public CONST RETURN_TYPE_HTML = 3;
//    public CONST RETURN_TYPE_PENDING = 4;
//    public CONST RETURN_TYPE_ERROR = 5;










    /**
     * Constructor - not callable.
     */
    protected function __construct()
    {
    }

    /**
     * Build the response based on the data returned from Till Payments.
     *
     * @param stdClass|null $responseData The data returned from Till Payments.
     * @return self
     */
    public static function buildFromResponse(?stdClass $responseData): self
    {
        $response = new self();

        $response->setSuccess(($responseData->success ?? null) === true);
        $response->setUuid($responseData->uuid ?? null);
        $response->setPurchaseId($responseData->purchaseId ?? null);
        $response->setRegistrationId($responseData->registrationId ?? null);
        $response->setReturnType($responseData->returnType ?? null);
//        $response->setRedirectType($responseData->redirectType ?? null);
        $response->setRedirectUrl($responseData->redirectUrl ?? null);
//        $response->setHtmlContent($responseData->htmlContent ?? null);
//        $response->setPaymentDescriptor($responseData->paymentDescriptor ?? null);
        $response->setPaymentMethod($responseData->paymentMethod ?? null);

        $response->setCardData(CardData::buildFromResponse($responseData->returnData ?? null));
//        $response->ibanData = IbanData::buildFromResponse($responseData->returnData ?? null);
//        $response->phoneData = PhoneData::buildFromResponse($responseData->returnData ?? null);
//        $response->walletData = WalletData::buildFromResponse($responseData->returnData ?? null);

//        $response->scheduleData = ScheduleData::buildFromResponse($responseData->scheduleData ?? null);

//        $response->customerProfileData =
//            CustomerProfileData::buildFromResponse($responseData->customerProfileData ?? null);

//        $response->riskCheckData = RiskCheckData::buildFromResponse($responseData->riskCheckData ?? null);

        $response->setExtraData(ExtraData::buildFromResponse($responseData->extraData ?? null));

        $response->setErrors(static::buildTransactionResponseErrors($responseData->errors ?? []));

        return $response;
    }
}
