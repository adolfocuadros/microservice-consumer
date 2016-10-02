<?php

namespace Adolfocuadros\MicroserviceConsumer;

use Adolfocuadros\MicroserviceConsumer\Exceptions\NotFoundTokenException;
use Adolfocuadros\MicroserviceConsumer\Exceptions\ServiceNotFoundException;
use GuzzleHttp\Client;

class HttpService
{
    private $microService;
    private $authToken;
    private $headers;
    
    private $client;
    private $timeout= 2.0;

    private $success = false;
    private $error;

    private $request;

    function __construct($service) {
        if(config('microservice.' . $service) == null) {
            throw new ServiceNotFoundException('Not found service: ' . $service);
        }
        $this->microService = config('microservice.' . $service);
    }

    /**
     * @param $resource
     * @param string $method
     * @param $params
     * @param $headers
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws NotFoundTokenException
     */
    public function consume($resource, $method = 'GET', $params, $headers = null) {
        try {
            $this->request = $this->client()->request($method, $resource, [
                'form_params' => $params
            ]);
        } catch (\Exception $e) {
            $this->success = false;
            $this->error = $e;
        }
        $this->success = true;
        return $this;
    }

    /** If Success or Fail
     * @param callable $success
     * @param callable $fail
     */
    public function then(callable $success, callable $fail) {
        if($this->success) {
            $success($this->request, $this->request->getStatusCode());
        } else {
            $fail($this->error);
        }
    }

    /** Method for initializer guzzle
     * @return Client
     * @throws NotFoundTokenException
     */
    public function client()
    {
        if(empty($this->authToken)) {
            throw new NotFoundTokenException('Token not found');
        }
        $this->client = new Client([
            'base_uri' => $this->microService,
            'timeout'  => $this->timeout,
            'headers'  => [
                'Auth-Token' => $this->authToken
            ]
        ]);
        return $this->client;
    }

    /** Add token
     * @param $token
     */
    public function setAuthToken($token) {
        $this->authToken = $token;
        $this->addHeader('Auth-Token', $this->authToken);
    }

    /** Add header for consume
     * @param $header
     * @param $value
     */
    public function addHeader($header, $value) {
        $this->headers[$header] = $value;
    }
}