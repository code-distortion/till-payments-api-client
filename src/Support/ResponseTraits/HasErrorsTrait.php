<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

use CodeDistortion\TillPayments\Support\ResponseParts\TransactionResponseError;

trait HasErrorsTrait
{
    /** @var TransactionResponseError[] The TransactionResponseError-s.  */
    private $errors = [];



    /**
     * Set the response's TransactionResponseError errors.
     *
     * @param TransactionResponseError[] $errors The errors to set.
     * @return void
     */
    private function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get all of the response's TransactionResponseError errors.
     *
     * @return TransactionResponseError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Return a particular error.
     *
     * @param integer $count The error to retrieve.
     * @return TransactionResponseError|null
     */
    public function getError($count = 0)
    {
        return $this->errors[$count] ?? null;
    }



    /**
     * Build a list of TransactionResponseError from the response data.
     *
     * @param mixed[] $errors The errors returned by Till Payments.
     * @return TransactionResponseError[]
     */
    private static function buildTransactionResponseErrors(array $errors): array
    {
        $return = [];
        foreach ($errors as $errorData) {
            $return[] = TransactionResponseError::buildFromResponse($errorData);
        }
        return $return;
    }
}
