<?php

namespace CodeDistortion\TillPayments;

use CodeDistortion\TillPayments\Responses\Response;
use CodeDistortion\TillPayments\Support\BaseRequest;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

/**
 * The Till Payments API client.
 */
class TillPaymentsApiClient
{
//    /** @var string The host to make api requests to. */
//    private string $host;
//
//    /** @var string The api user username. */
//    private string $userName;
//
//    /** @var string The api user password. */
//    private string $password;
//
//    /** @var string The api key. */
//    private string $apiKey;
//
//    /** @var string The api shared secret. */
//    private string $sharedSecret;
//
//    /** @var boolean Whether to add a signature to requests or not. */
//    private bool $addSignature;
//
//    /** @var string The payment.js key to use. */
//    private string $publicIntegrationKey;

    /** @var string The base part of the url path. */
    const BASE_PATH = '/api/v3';
    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $userName;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $sharedSecret;
    /**
     * @var boolean
     */
    private $addSignature;
    /**
     * @var string
     */
    private $publicIntegrationKey;
    /**
     * @var GuzzleClient
     */
    private $httpClient;
    /**
     * @param string       $host                 The host to make api requests to.
     * @param string       $userName             The username.
     * @param string       $password             The password.
     * @param string       $apiKey               The api-key.
     * @param string       $sharedSecret         The shared-secret.
     * @param boolean      $addSignature         Whether to add a signature to requests or not.
     * @param string       $publicIntegrationKey The payment.js key to use.
     * @param GuzzleClient $httpClient           The client used to make http requests.
     */
    public function __construct(string $host, string $userName, string $password, string $apiKey, string $sharedSecret, bool $addSignature, string $publicIntegrationKey, GuzzleClient $httpClient)
    {
        $this->host = $host;
        $this->userName = $userName;
        $this->password = $password;
        $this->apiKey = $apiKey;
        $this->sharedSecret = $sharedSecret;
        $this->addSignature = $addSignature;
        $this->publicIntegrationKey = $publicIntegrationKey;
        $this->httpClient = $httpClient;
        $this->host = rtrim($host, '/');
    }



    /**
     * Send an API request to Till Payments.
     *
     * @param BaseRequest $request The request to send.
     * @return Response
     */
    public function send($request): Response
    {
        $responseData = $this->makeRequest(
            $request->getHttpMethod(),
            $this->buildRequestPath($request),
            $request->buildRequestData()
        );
        return Response::buildFromResponse($responseData);
    }











    /**
     * Build the path part of an API url.
     *
     * @param BaseRequest $request The request being made.
     * @return string
     */
    private function buildRequestPath(BaseRequest $request): string
    {
        $type = $request->getRequestType();
        $action = $request->getRequestAction();
        return static::BASE_PATH . "/$type/$this->apiKey/$action";
    }

    /**
     * Send a request to Till Payments.
     *
     * @param string  $httpMethod  The http method to use.
     * @param string  $requestPath The path to make the request to.
     * @param mixed[] $requestData The data to send.
     * @return stdClass|null
     */
    private function makeRequest(string $httpMethod, string $requestPath, array $requestData)
    {
        $url = $this->host . $requestPath;
        $requestBody = (string) json_encode($requestData);

        $guzzleOptions = [
            'headers' => $this->buildRequestHeaders($httpMethod, $requestPath, $requestBody),
            'body' => $requestBody,
        ];

        try {

            $response = $this->httpClient->request($httpMethod, $url, $guzzleOptions);
            return json_decode($response->getBody()->getContents());

        } catch (GuzzleException $e) {
//            print "THE REQUEST CAUSED AN EXCEPTION:\n";
//            var_dump($e->getMessage());
            return null;
        }
    }

    /**
     * Build the request headers to send.
     *
     * @param string $httpMethod  The HTTP method being used.
     * @param string $requestPath The path being called - for the signature.
     * @param string $requestBody The request body (rendered as a string) - for the signature.
     * @return array<string,string>
     */
    private function buildRequestHeaders(string $httpMethod, string $requestPath, string $requestBody): array
    {
        $encoding = 'application/json; charset=utf-8';

        $headers = [
            'Content-Type' => $encoding,
            'Accept' => $encoding,
            'Date' => date('r'),
            'Authorization' => 'Basic ' . base64_encode("$this->userName:$this->password"),
        ];

        if ($this->addSignature) {
            $headers['X-Signature'] = $this->buildRequestSignature(
                $httpMethod,
                $requestPath,
                $requestBody,
                $encoding,
                $headers['Date']
            );
        }

        return $headers;
    }

    /**
     * Build the signature to pass in the headers for the current request.
     *
     * @param string $httpMethod  The HTTP method being used.
     * @param string $requestPath The path being called.
     * @param string $requestBody The request body (rendered as a string).
     * @param string $contentType The request's content-type header.
     * @param string $date        The date header.
     * @return string
     */
    private function buildRequestSignature(string $httpMethod, string $requestPath, string $requestBody, string $contentType, string $date): string
    {
        $data = [
            $httpMethod,
            hash('sha512', $requestBody),
            $contentType,
            $date,
            $requestPath,
        ];
        $data = implode("\n", $data);
        $sha512 = hash_hmac('sha512', $data, $this->sharedSecret, true);
        return base64_encode($sha512);
    }
}
