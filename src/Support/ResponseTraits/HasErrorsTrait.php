<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

use CodeDistortion\TillPayments\Support\ResponseParts\TransactionResponseError;

trait HasErrorsTrait
{
    /** @var TransactionResponseError[] The TransactionResponseError-s.  */
    private array $errors = [];



    /**
     * Set the response's TransactionResponseError errors.
     *
     * @param TransactionResponseError[] $errors The errors to set.
     * @return void
     */
    private function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Check if the response has TransactionResponseError errors.
     *
     * @return boolean
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
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
    public function getError(int $count = 0): ?TransactionResponseError
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
