<?php

namespace Adolfocuadros\RenqoMicroservice;


use \GuzzleHttp\Client as ClientBase;

class Client extends ClientBase
{
    function __construct($url, $token = null)
    {
        $config = [
            'base_uri'=> $url,
            'timeout' => 5.0
        ];

        if($token != null) {
            $config['headers'] = [
                'Auth-Token' => $token
            ];
        } elseif(!empty(request()->getHeader('Auth-Token'))) {
            $config['headers'] = [
                'Auth-Token' => request()->getHeader('Auth-Token')
            ];
        }

        parent::__construct($config);
    }
}