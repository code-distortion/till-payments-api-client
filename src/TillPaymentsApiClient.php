<?php

namespace CodeDistortion\TillPayments;

use Carbon\Carbon;
use CodeDistortion\TillPayments\Responses\Response;
use CodeDistortion\TillPayments\Support\BaseRequest;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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

    /** @var callable|null The callback used to log each http request. */
    private $loggerCallback = null;

    /** @var string The base part of the url path. */
    private const BASE_PATH = '/api/v3';



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
    public function __construct(
        private string $host,
        private string $userName,
        private string $password,
        private string $apiKey,
        private string $sharedSecret,
        private bool $addSignature,
        private string $publicIntegrationKey,
        private GuzzleClient $httpClient,
    ) {
        $this->host = rtrim($host, '/');
    }

    /**
     * Let the caller set a logger callback to log http requests.
     *
     * @param callable $callback The callback that performs the logging.
     * @return void
     */
    public function setHttpRequestLogger(callable $callback): void
    {
        $this->loggerCallback = $callback;
    }



    /**
     * Send an API request to Till Payments.
     *
     * @param BaseRequest $tillRequest The request to send.
     * @return Response
     */
    public function send(BaseRequest $tillRequest): Response
    {
        $httpRequest = $this->buildGuzzleRequest($tillRequest);
        $httpResponse = null;
        $tillResponse = null;

        $start = Carbon::now('UTC');
        $startTimestamp = microtime(true);

        try {
            $httpResponse = $this->httpClient->send($httpRequest, ['exceptions' => false]);
            $responseJson = json_decode($httpResponse->getBody()->getContents());
            $tillResponse = Response::buildFromResponse($responseJson);

        } catch (GuzzleException $e) {

            $tillResponse ??= Response::buildFromResponse(null);

        } finally {

            $end = Carbon::now('UTC');
            $timeTaken = microtime(true) - $startTimestamp;
            $httpRequest->getBody()->rewind();
            $httpResponse?->getBody()?->rewind();
            $this->logHttpRequest($httpRequest, $httpResponse, $tillResponse, $start, $end, $timeTaken);
        }

        return $tillResponse;
    }











    /**
     * Build a guzzle request, ready to send.
     *
     * @param BaseRequest $tillRequest The Till Payments version of the request.
     * @return GuzzleRequest
     */
    private function buildGuzzleRequest(BaseRequest $tillRequest): GuzzleRequest
    {
        $httpMethod = $tillRequest->getHttpMethod();
        $requestPath = $this->buildRequestPath($tillRequest);
        $requestData = $tillRequest->buildRequestData();
        $url = $this->host . $requestPath;
        $requestBody = (string) json_encode($requestData);
        $headers = $this->buildRequestHeaders($httpMethod, $requestPath, $requestBody);

        return new GuzzleRequest($httpMethod, $url, $headers, $requestBody);
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
    private function buildRequestSignature(
        string $httpMethod,
        string $requestPath,
        string $requestBody,
        string $contentType,
        string $date,
    ): string {

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



    /**
     * Log the http request and response, if a callback has been specified.
     *
     * @param RequestInterface       $request      The request being sent.
     * @param ResponseInterface|null $response     The response received.
     * @param Response|null          $tillResponse The Till Payments version of the response.
     * @param Carbon                 $start        When the request started.
     * @param Carbon                 $end          When the request finished.
     * @param float                  $timeTaken    The number of seconds taken.
     * @return void
     */
    private function logHttpRequest(
        RequestInterface $request,
        ?ResponseInterface $response,
        ?Response $tillResponse,
        Carbon $start,
        Carbon $end,
        float $timeTaken
    ): void {

        if (!$this->loggerCallback) {
            return;
        }

        $loggerCallback = $this->loggerCallback;
        $loggerCallback($request, $response, $tillResponse, $start, $end, $timeTaken);
    }
}
