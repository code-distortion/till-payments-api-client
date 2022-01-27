<?php

namespace CodeDistortion\TillPayments\Support\ResponseTraits;

trait HasReturnTypeTrait
{
    /** @var string|null FINISHED, REDIRECT, HTML, PENDING or ERROR. */
    private $returnType;



    /**
     * Set the response's returnType.
     *
     * @param string|null $returnType The response's returnType.
     * @return void
     */
    private function setReturnType(?string $returnType): void
    {
        $this->returnType = $returnType;
    }

    /**
     * Get the response's returnType.
     *
     * @return string|null
     */
    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

//    /**
//     * Check if the return-type is "FINISHED".
//     *
//     * @return boolean
//     */
//    public function isFinishedReturnType(): bool
//    {
//        return $this->returnType == static::RETURN_TYPE_FINISHED;
//    }
//
//    /**
//     * Check if the return-type is "REDIRECT".
//     *
//     * @return boolean
//     */
//    public function isRedirectReturnType(): bool
//    {
//        return $this->returnType == static::RETURN_TYPE_REDIRECT;
//    }
//
//    /**
//     * Check if the return-type is "HTML".
//     *
//     * @return boolean
//     */
//    public function isHtmlReturnType(): bool
//    {
//        return $this->returnType == static::RETURN_TYPE_HTML;
//    }
//
//    /**
//     * Check if the return-type is "PENDING".
//     *
//     * @return boolean
//     */
//    public function isPendingReturnType(): bool
//    {
//        return $this->returnType == static::RETURN_TYPE_PENDING;
//    }
//
//    /**
//     * Check if the return-type is "ERROR".
//     *
//     * @return boolean
//     */
//    public function isErrorReturnType(): bool
//    {
//        return $this->returnType == static::RETURN_TYPE_ERROR;
//    }

//    /**
//     * Determine the response's "return-type".
//     *
//     * @return integer|null
//     */
//    private static function pickReturnType(?string $returnType): ?int
//    {
//        return match($returnType) {
//            'FINISHED' => static::RETURN_TYPE_FINISHED,
//            'REDIRECT' => static::RETURN_TYPE_REDIRECT,
//            'HTML' => static::RETURN_TYPE_HTML,
//            'PENDING' => static::RETURN_TYPE_PENDING,
//            'ERROR' => static::RETURN_TYPE_ERROR,
//            default => static::RETURN_TYPE_UNKNOWN,
//        };
//    }
}
