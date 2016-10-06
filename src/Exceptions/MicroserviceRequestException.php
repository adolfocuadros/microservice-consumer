<?php
/**
 * Created by PhpStorm.
 * User: Informatica-2016
 * Date: 06/10/2016
 * Time: 12:25 PM
 */

namespace Adolfocuadros\RenqoMicroservice\Exceptions;



use GuzzleHttp\Exception\RequestException;

class MicroserviceRequestException extends \Exception
{
    private $exception;

    function __construct($message, $code, RequestException $exception)
    {
        $this->exception = $exception;
        parent::__construct($message, $code);
    }

    public function responseJson() {
        $response = $this->exception->getResponse();

        if($this->exception->getResponse()->getHeader('Content-Type')[0] != 'application/json') {
            return response(json_encode(['error' => 'La respuesta no tiene formato JSON']),
                $this->exception->getResponse()->getStatusCode(),
                ['Content-Type' => 'application/json']);
        }
        return response($response->getBody()->getContents(),
            $this->exception->getResponse()->getStatusCode(),
            ['Content-Type' => 'application/json']);
    }

    public function getRealMessage() {
        return $this->exception->getMessage();
    }

    public function getHttpCode() {
        return $this->exception->getCode();
    }
}