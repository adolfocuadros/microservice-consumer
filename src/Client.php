<?php

namespace Adolfocuadros\RenqoMicroservice;


use \GuzzleHttp\Client as ClientBase;

class Client extends ClientBase
{
    function __construct($url, $token = null)
    {
        $request = app('request');
        $config = [
            'base_uri'=> $url,
            'timeout' => 20.0
        ];

        if($token != null) {
            $config['headers'] = [
                'Auth-Token' => $token
            ];
        } elseif(!empty($request->header('Auth-Token'))) {
            $config['headers'] = [
                'Auth-Token' => $request->header('Auth-Token')
            ];
        }

        parent::__construct($config);
    }
}