<?php
namespace Adolfocuadros\RenqoMicroservice;


use Psr\Http\Message\ResponseInterface;

class Response
{
    private $response;

    function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getContent() {
        return $this->response->getBody()->getContents();
    }

    public function  getStatusCode() {
        return $this->response->getStatusCode();
    }

    public function toArray()
    {
        return json_decode($this->response->getBody()->getContents(), true);
    }

    public function toObject()
    {
        return json_decode($this->response->getBody()->getContents());
    }

    public function responseJson() {
        return response($this->getContent(), $this->getStatusCode(), ['Content-Type' => 'application/json']);
    }
}