<?php

namespace Adolfocuadros\RenqoMicroservice;


use \GuzzleHttp\Client as ClientBase;

class Client extends ClientBase
{
    function __construct($url)
    {
        $config = [
            'base_uri'=> $url,
            'timeout' => 5.0
        ];

        if(!empty(getallheaders()['Auth-Token'])) {
            $config['headers'] = [
                'Auth-Token' => getallheaders()['Auth-Token']
            ];
        }

        parent::__construct($config);
    }
}