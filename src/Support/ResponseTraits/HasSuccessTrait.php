<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasSuccessTrait
{
    /** @var boolean Returns true or false depending on whether the request was successful. */
    private $success;



    /**
     * Set the response's success flag.
     *
     * @param boolean $success The response's success flag.
     * @return void
     */
    private function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * Check if the request was successful or not.
     *
     * @return boolean
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Check if the request was successful or not - alias for getSuccess().
     *
     * @return boolean
     */
    public function wasSuccessful(): bool
    {
        return $this->getSuccess();
    }
}
