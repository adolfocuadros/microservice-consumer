<?php
namespace Adolfocuadros\RenqoMicroservice;


class Api
{
    /**
     * @param $service
     * @param $resource
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public static function get($service, $resource, array $params = [], $token = null)
    {
        $request = new HttpService($service);
        if ($token != null)
            $request->setAuthToken($token);
        return $request->consume($resource, 'GET', $params);
    }
}