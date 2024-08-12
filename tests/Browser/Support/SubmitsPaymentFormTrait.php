<?php

namespace CodeDistortion\TillPayments\Tests\Browser\Support;

use CodeDistortion\TillPayments\Laravel\ServiceProvider;
use CodeDistortion\TillPayments\Tests\LaravelDuskTestCase;
use Laravel\Dusk\Browser;

/**
 * Trait that adds methods to submit a Till Payments payment form.
 *
 * @mixin LaravelDuskTestCase
 */
trait SubmitsPaymentFormTrait
{
    /**
     * Load the form, submit valid details, and get a transaction-token back from till-payments.
     *
     * @return string
     */
    private function submitValidPaymentForm(): string
    {
        $transactionToken = $this->submitPaymentForm(
            'Test Person',
            '4111111111111111',
            '01',
            (int) date('y') + 1,
            '123'
        );

        self::assertNotEmpty($transactionToken);

        return $transactionToken;
    }
    /**
     * Load the form, submit valid details (but for a card without enough credit),
     * and get a transaction-token back from till-payments.
     *
     * @return string
     */
    private function submitInvalidPaymentForm(): string
    {
        $transactionToken = $this->submitPaymentForm(
            'Test Person',
            '4242424242424242',
            '01',
            (int) date('y') + 1,
            '123'
        );

        self::assertNotEmpty($transactionToken);

        return $transactionToken;
    }

    /**
     * Load the form, submit the given details, and get a transaction-token back from till-payments if valid.
     *
     * @param string $cardHolder The card-holder's name.
     * @param string $cardNumber The card number.
     * @param string $expMonth   The card's expiry month.
     * @param string $expYear    The card's expiry year.
     * @param string $cvv        The card's cvv.
     * @return string|null
     */
    private function submitPaymentForm(
        string $cardHolder,
        string $cardNumber,
        string $expMonth,
        string $expYear,
        string $cvv
    ): ?string {

        $transactionToken = null;

        $callback = function (Browser $browser) use (
            $cardHolder,
            $cardNumber,
            $expMonth,
            $expYear,
            $cvv,
            &$transactionToken
        ) {

            $publicIntegrationKey = config(ServiceProvider::CONFIG_NAME . '.public_integration_key');

            // add the public key and initialise the payment object
            $browser->visit('http://localhost:80')
                ->type('#public_integration_key', $publicIntegrationKey)
                ->click('#init_form button')
                ->waitFor('#card_number_div iframe', 20)
                ->waitFor('#cvv_div iframe', 20);

            // fill in the form and submit it
            $browser->type('#card_holder', $cardHolder)
                ->withinFrame('#card_number_div iframe', function (Browser $browser) use ($cardNumber) {
                    $browser->waitFor('input', 20)->type('input', $cardNumber);
                })
                ->type('#exp_month', $expMonth)
                ->type('#exp_year', $expYear)
                ->withinFrame('#cvv_div iframe', function (Browser $browser) use ($cvv) {
                    $browser->waitFor('input', 20)->type('input', $cvv);
                })
                ->click('#payment_form button');

            // read the transaction token returned from till-payments
            $transactionToken = $browser->waitFor('#transaction_token', 20)
                ->element('#transaction_token')
                ?->getAttribute('value');
        };

        $this->browse($callback);

        return $transactionToken;
    }
}
