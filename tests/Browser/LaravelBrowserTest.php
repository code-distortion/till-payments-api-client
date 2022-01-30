<?php

namespace CodeDistortion\TillPayments\Tests\Browser;

use CodeDistortion\TillPayments\Requests\CaptureRequest;
use CodeDistortion\TillPayments\Requests\DebitRequest;
use CodeDistortion\TillPayments\Requests\DeregisterRequest;
use CodeDistortion\TillPayments\Requests\IncrementalAuthorizationRequest;
use CodeDistortion\TillPayments\Requests\PreAuthorizeRequest;
use CodeDistortion\TillPayments\Requests\RefundRequest;
use CodeDistortion\TillPayments\Requests\RegisterRequest;
use CodeDistortion\TillPayments\Requests\VoidRequest;
use CodeDistortion\TillPayments\Responses\Response;
use CodeDistortion\TillPayments\Support\BaseRequest;
use CodeDistortion\TillPayments\Tests\Browser\Support\SubmitsPaymentFormTrait;
use CodeDistortion\TillPayments\Tests\LaravelDuskTestCase;
use CodeDistortion\TillPayments\TillPaymentsApiClient;

/**
 * Test integration with a browser.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class LaravelBrowserTest extends LaravelDuskTestCase
{
    use SubmitsPaymentFormTrait;

    /** @var TillPaymentsApiClient The Till Payments client to use. */
    private TillPaymentsApiClient $tillClient;



    /**
     * Initialisation for the test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        /** @var TillPaymentsApiClient $tillClient */
        $tillClient = app(TillPaymentsApiClient::class);
        $this->tillClient = $tillClient;
    }

    /**
     * Test a credit card debit - with an invalid credit-card number.
     *
     * @test
     * @return void
     */
    public function test_a_debit_failure(): void
    {
        // send a debit $10
        $transactionToken = $this->submitInvalidPaymentForm();
        $request = (new DebitRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken)
            ->setWithRegister(true);
        $response = $this->sendRequest($request, false);

        // 2003 - "The transaction was declined"
        $this->assertSame(2003, $response->getError(0)?->getErrorCode());
    }


    /**
     * Test a credit card debit (register the card as well).
     *
     * @test
     * @return void
     */
    public function test_a_debit_with_register(): void
    {
        // send a debit $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new DebitRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken)
            ->setWithRegister(true);
        $response = $this->sendRequest($request);

        $this->assertNotNull($response->getRegistrationId());
    }

    /**
     * Test a credit card pre-auth with capture (register the card as well).
     *
     * @test
     * @return void
     */
    public function test_a_preauth_capture_with_register(): void
    {
        // send a pre-auth $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken)
            ->setWithRegister(true);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();
        $this->assertNotNull($response->getRegistrationId());

        // send a capture $10
        $request = (new CaptureRequest((string) $referenceUuid, uniqid(), '10', 'AUD'));
        $this->sendRequest($request);
    }

    /**
     * Test a credit card pre-auth with 2 captures.
     *
     * @test
     * @return void
     */
    public function test_a_preauth_2captures(): void
    {
        // send a pre-auth $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();

        // send a capture $5
        $request = (new CaptureRequest((string) $referenceUuid, uniqid(), '5', 'AUD'));
        $this->sendRequest($request);

        // send a capture $5
        $request = (new CaptureRequest((string) $referenceUuid, uniqid(), '5', 'AUD'));
        $this->sendRequest($request);
    }

    /**
     * Test a credit card pre-auth with 2 captures - that exceed the original amount.
     *
     * @test
     * @return void
     */
    public function test_a_preauth_capture_too_much(): void
    {
        // send a pre-auth $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();

        // send a capture $5
        $request = (new CaptureRequest((string) $referenceUuid, uniqid(), '5', 'AUD'));
        $this->sendRequest($request);

        // send a capture $5.01 (will fail)
        $request = (new CaptureRequest((string) $referenceUuid, uniqid(), '5.01', 'AUD'));
        $response = $this->sendRequest($request, false);
        // 1006 - "Amount to capture exceeds amount left to capture"
        $this->assertSame(1006, $response->getError(0)?->getErrorCode());
    }

    /**
     * Test a credit card pre-auth, incremental-authorisation and void.
     *
     * @test
     * @return void
     */
    public function test_a_preauth_incrementalauth_void(): void
    {
        // send a pre-auth $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();

        // send an incremental authorisation $5
        $request = (new IncrementalAuthorizationRequest((string) $referenceUuid, uniqid(), '5', 'AUD'));
        $this->sendRequest($request);

        // send a void
        $request = (new VoidRequest((string) $referenceUuid, uniqid()));
        $this->sendRequest($request);
    }

    /**
     * Test a credit card pre-auth, capture and void.
     *
     * @test
     * @return void
     */
    public function test_a_preauth_capture_void(): void
    {
        // send a pre-auth $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();

        // send an incremental authorisation $5
        $request = (new IncrementalAuthorizationRequest((string) $referenceUuid, uniqid(), '5', 'AUD'));
        $this->sendRequest($request);

        // send an incremental authorisation $5
        $request = (new IncrementalAuthorizationRequest((string) $referenceUuid, uniqid(), '5', 'AUD'));
        $this->sendRequest($request);

        // send a capture $17.50
        $request = (new CaptureRequest((string) $referenceUuid, uniqid(), '17.5', 'AUD'));
        $this->sendRequest($request);

        // send a void
        $request = (new VoidRequest((string) $referenceUuid, uniqid()));
        $this->sendRequest($request);
    }

    /**
     * Test a credit register,  debit,  de-register and another debit request.
     *
     * @test
     * @return void
     */
    public function test_a_register_debit_deregister_debit(): void
    {
        // send a register request
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new RegisterRequest(uniqid()))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $registrationId = $response->getRegistrationId();

        $this->assertNotNull($registrationId);

        // send a debit $10 - against the registered card
        $request = (new DebitRequest(uniqid(), '10', 'AUD'))
            ->setReferenceUuid((string) $registrationId);
        $this->sendRequest($request);

        // send a pre-auth $10 - against the registered card
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setReferenceUuid((string) $registrationId);
        $this->sendRequest($request);

        // send a deregister request
        $request = (new DeregisterRequest((string) $registrationId, uniqid()));
        $this->sendRequest($request);

        // send a debit $10 (will fail)
        $request = (new DebitRequest(uniqid(), '10', 'AUD'))
            ->setReferenceUuid((string) $registrationId);
        $response = $this->sendRequest($request, false);
        // 1006 - "referenced transaction is already de-registered"
        $this->assertSame(1006, $response->getError(0)?->getErrorCode());

        // send a pre-auth $10 - against the registered card (will fail)
        $request = (new PreAuthorizeRequest(uniqid(), '10', 'AUD'))
            ->setReferenceUuid((string) $registrationId);
        $this->sendRequest($request, false);
        // 1006 - "referenced transaction is already de-registered"
        $this->assertSame(1006, $response->getError(0)?->getErrorCode());
    }

    /**
     * Test a credit debit with refund.
     *
     * @test
     * @return void
     */
    public function test_a_debit_refund(): void
    {
        // send a debit $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new DebitRequest(uniqid(), '10', 'AUD'))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();

        // send a refund $10
        $request = (new RefundRequest($referenceUuid, uniqid(), '10', 'AUD'));
        $this->sendRequest($request);
    }

    /**
     * Test a credit debit with 3 refunds - where the last exceeds the original amount.
     *
     * @test
     * @return void
     */
    public function test_a_debit_refund_too_much(): void
    {
        // send a debit $10
        $transactionToken = $this->submitValidPaymentForm();
        $request = (new DebitRequest(uniqid(), 10, 'AUD'))
            ->setTransactionToken($transactionToken);
        $response = $this->sendRequest($request);

        $referenceUuid = $response->getUuid();

        // send a refund $2.50
        $request = (new RefundRequest($referenceUuid, uniqid(), '2.5', 'AUD'));
        $this->sendRequest($request);

        // send a refund $2.50
        $request = (new RefundRequest($referenceUuid, uniqid(), '2.5', 'AUD'));
        $this->sendRequest($request);

        // send a refund $5.01 (will fail)
        $request = (new RefundRequest($referenceUuid, uniqid(), '5.01', 'AUD'));
        $response = $this->sendRequest($request, false);
        // 1006 - "amount to refund exceeds amount left to refund"
        $this->assertSame(1006, $response->getError(0)?->getErrorCode());
    }



    /**
     * Send a Till Payments request,  and check the response is successful (or not).
     *
     * @param BaseRequest $request         The Till Payments request to send.
     * @param boolean     $expectedSuccess Whether the request is expected to be successful or not.
     * @return Response
     */
    private function sendRequest(BaseRequest $request, bool $expectedSuccess = true): Response
    {
        $response = $this->tillClient->send($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame($expectedSuccess, $response->wasSuccessful());
        $this->assertSame(!$expectedSuccess, $response->hasErrors());

        return $response;
    }
}
