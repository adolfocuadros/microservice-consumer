<?php

namespace Adolfocuadros\RenqoMicroservice;


use Adolfocuadros\RenqoMicroservice\Exceptions\MicroserviceRequestException;
use GuzzleHttp\Exception\RequestException;

class Microservice
{
    protected $path_root = '';

    private $response = null;
    private $client;

    function __construct($token = null)
    {
        $this->path_root = (substr($this->path_root, -1) == '/') ? $this->path_root : $this->path_root.'/';
        
        $this->client = new Client($this->path_root, $token);
    }

    public function get($path, array $params = [])
    {
        try {
            $this->response = new Response($this->client->get($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException($e->getMessage(), 1000, $e);
        }
        return $this->response;
    }

    public function post($path, array $params = [])
    {
        try {
            $this->response = new Response($this->client->post($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException('Error al procesar Solicitud: ' . $e->getMessage(), 1000, $e);
        }
        return $this->response;
    }

    public function delete($path, array $params = [])
    {
        try {

            $this->response = new Response($this->client->delete($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException($e->getMessage(), 1000, $e);
        }
        return $this->response;
    }

    public function patch($path, array $params = [])
    {
        try {

            $this->response = new Response($this->client->patch($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException($e->getMessage(), 1000, $e);
        }
        return $this->response;
    }

    public function create($path, array $params = [])
    {
        return $this->post($path, $params);
    }

    public function update($path, array $params = [])
    {
        return $this->patch($path, $params);
    }

    public function put($path, array $params = [])
    {
        try {

            $this->response = new Response($this->client->put($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException($e->getMessage(), 1000, $e);
        }
        return $this->response;
    }

    public function getResponse()
    {
        if(!is_null($this->response)) {
            return $this->response;
        }
    }

    public function getPathRoot()
    {
        return $this->path_root;
    }

    public static function request($tp = 'get', $uri = null, $params = []) {
        $thisClass = get_called_class();
        try {
            $response = (new $thisClass())->$tp($uri, $params);
        } catch (MicroserviceRequestException $e) {
            abort($e->getHttpCode(), $e->getMessage());
        }
        return $response->toArray();
    }

    public static function requestWithErrors($tp = 'get', $uri = null, $params = []) {
        $thisClass = get_called_class();

        $response = (new $thisClass())->$tp($uri, $params);

        return $response->toArray();
    }
}