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
    private $timeout= 5.0;

    private $success = false;
    private $error;

    private $request;

    function __construct($service) {
        if(config('microservice.api.' . $service) == null) {
            throw new ServiceNotFoundException('Not found service: ' . $service);
        }
        $this->microService = config('microservice.api.' . $service);
        if(isset(getallheaders()['Auth-Token'])) {
            $this->setAuthToken(getallheaders()['Auth-Token']);
        }
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
        $this->request = $this->client()->request($method, $resource, [
            'form_params' => $params
        ]);
        $this->success = true;
        //return $this->request;
        return $this;
    }

    /** If Success or Fail
     * @param callable $success
     * @param callable $fail
     */
    public function then(callable $success = null, callable $fail = null) {
        if($this->success && is_callable($success)) {
            return $success($this->request, $this->request->getStatusCode());
        } elseif(is_callable($fail)) {
            return $fail($this->error);
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
        //dd($this->microService);
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

    public function body() {
        /*if($this->success) {
            return \GuzzleHttp\json_decode($this->request->getBody()->getContents());
        }*/
        if($this->success) {
            return $this->request->getBody()->getContents();
        }
        return null;
    }
    
    public function responseJson() {
        if($this->success) {
            return response($this->request->getBody()->getContents(),
                $this->request->getStatusCode(),
                ['Content-Type'=>'application/json']);
        }

        return response('',200,['Content-Type'=>'application/json']);
    }
}