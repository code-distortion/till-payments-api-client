<?php

namespace CodeDistortion\TillPayments\Support;

/**
 * An abstract class to build and represent various types of Till Payments API requests.
 */
abstract class BaseRequest
{
    /** @var string The http method to use when sending the request. */
    private $httpMethod;

    /** @var string The type of request to make - is the beginning of the api url path. */
    private $requestType;

    /** @var string The action to be called - is the end of the api url path. */
    private $requestAction;



    /**
     * Set the request up with the basic required settings.
     *
     * @param string $httpMethod    The http method to use when sending the request.
     * @param string $requestType   The type of request to make - is the beginning of the api url path.
     * @param string $requestAction The action to be called - is the end of the api url path.
     */
    public function __construct(string $httpMethod, string $requestType, string $requestAction)
    {
        $this->setHttpMethod($httpMethod);
        $this->setRequestType($requestType);
        $this->setRequestAction($requestAction);
    }



    /**
     * Set the http method (GET or POST).
     *
     * @param string $httpMethod The method to set.
     * @return void
     */
    protected function setHttpMethod($httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * Get the http method (GET or POST).
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Set the request-type (the beginning of the api url path).
     *
     * @param string $requestType The request-type to set.
     * @return void
     */
    protected function setRequestType($requestType): void
    {
        $this->requestType = $requestType;
    }

    /**
     * Get the request-type (the beginning of the api url path).
     *
     * @return string
     */
    public function getRequestType(): string
    {
        return $this->requestType;
    }

    /**
     * Set the request-action (the end of the api url path).
     *
     * @param string $requestAction The request-action to set.
     * @return void
     */
    protected function setRequestAction($requestAction): void
    {
        $this->requestAction = $requestAction;
    }

    /**
     * Get the request-action (the end of the api url path).
     *
     * @return string
     */
    public function getRequestAction(): string
    {
        return $this->requestAction;
    }



    /**
     * Build the data to send in the api request.
     *
     * @return mixed[]
     */
    abstract public function buildRequestData(): array;



    /**
     * Build an array with a single key-value-pair.
     *
     * Useful when merging arrays of request data.
     *
     * @param string       $field    The key to use.
     * @param mixed        $value    The value to set.
     * @param boolean|null $override Null = set when $value is not null,
     *                               true = always set (even when null),
     *                               false = don't set.
     * @return mixed[]
     */
    protected function buildKeyValuePair($field, $value, $override = null): array
    {
        if ($override === false) {
            return [];
        }

        // include, even if null
        if ($override === true) {
            return [$field => $value];
        }

        // don't include null values
        if (!is_null($value)) {
            return [$field => $value];
        }

        return [];
    }
}
