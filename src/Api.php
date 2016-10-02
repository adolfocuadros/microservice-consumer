<?php
namespace Adolfocuadros\MicroserviceConsumer;


class Api
{
    /**
     * @param $service
     * @param $resource
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public static function get($service, $resource, array $params = [])
    {
        $request = new HttpService($service);
        return $request->consume($resource, 'GET', $params);
    }
}