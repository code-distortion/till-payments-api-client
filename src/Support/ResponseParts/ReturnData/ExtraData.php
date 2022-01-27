<?php

namespace CodeDistortion\TillPayments\Support\ResponseParts\ReturnData;

use stdClass;

/**
 * Represent an ExtraData object, returned by Till Payments.
 *
 * @see https://test-gateway.tillpayments.com/documentation/apiv3?php#transaction-data-customer
 */
class ExtraData
{
    /** @var array<string,string> The returned key-value pairs. */
    private $data = [];



    /**
     * Constructor - not callable.
     */
    protected function __construct()
    {
    }

    /**
     * Build based on the data returned from Till Payments.
     *
     * @param stdClass|null $data The data returned from Till Payments.
     * @return self|null
     */
    public static function buildFromResponse($data): ?self
    {
        if (is_null($data)) {
            return null;
        }

        $return = new self();
        foreach (get_object_vars($data) as $key => $value) {
            $return->data[$key] = $value;
        }
        return $return;
    }

    /**
     * Retrieve a key's value.
     *
     * @param string $key The key to get the value for.
     * @return string|null
     */
    public function get($key): ?string
    {
        return $this->data[$key] ?? null;
    }
}
