<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasWithRegisterTrait
{
    /** @var boolean Tell Till Payments to "store customer's payment instrument for recurring transactions". */
    private $withRegister = false;



    /**
     * Set the "with register" flag.
     *
     * @param boolean $withRegister Turn the flag on or off.
     * @return $this
     */
    public function setWithRegister($withRegister)
    {
        $this->withRegister = $withRegister;
        return $this;
    }

    /**
     * Get the "with register" flag.
     *
     * @return boolean
     */
    public function getWithRegister(): bool
    {
        return $this->withRegister;
    }
}
