<?php

namespace Adolfocuadros\RenqoMicroservice;


use Adolfocuadros\RenqoMicroservice\Exceptions\MicroserviceRequestException;
use GuzzleHttp\Exception\RequestException;

class Microservice
{
    protected $path_root = '';

    private $response = null;
    private $client;

    function __construct()
    {
        $this->client = new Client($this->path_root);
    }

    public function get($path, array $params = []) {
        try {
            $this->response = new Response($this->client->get($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException('Error al procesar Solicitud', 1000, $e);
        }
        return $this->response;
    }

    public function post($path, array $params = []) {
        try {

            $this->response = new Response($this->client->post($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException('Error al procesar Solicitud', 1000, $e);
        }
        return $this->response;
    }

    public function delete($path, array $params = []) {
        try {

            $this->response = new Response($this->client->delete($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException('Error al procesar Solicitud', 1000, $e);
        }
        return $this->response;
    }

    public function patch($path, array $params = []) {
        try {

            $this->response = new Response($this->client->patch($path, ['form_params'=>$params]));
        } catch(RequestException $e) {
            throw new MicroserviceRequestException('Error al procesar Solicitud', 1000, $e);
        }
        return $this->response;
    }

    public function create($path, array $params = []) {
        return $this->post($path, $params);
    }

    public function update($path, array $params = []) {
        return $this->patch($path, $params);
    }

    public function getResponse() {
        if(!is_null($this->response)) {
            return $this->response;
        }
    }
}