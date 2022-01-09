<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasRedirectUrlTrait
{
    /** @var string|null Where the customer must be redirected to. */
    private $redirectUrl;



    /**
     * Set the response's redirectUrl.
     *
     * @param string|null $redirectUrl The response's redirectUrl.
     * @return void
     */
    private function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Get the response's redirectUrl.
     *
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}
