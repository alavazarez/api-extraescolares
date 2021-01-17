<?php

namespace App\Repository;

use GuzzleHttp\Client;
//use GuzzleHttp\RequestOptions;


class GuzzleHttpRequest {

    protected $client;
    protected $response;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get($url) {
        $response = $this->client->request('GET', $url, ['verify' => false]);
        $response = json_decode($response->getBody()->getContents());
        $this->response = $response->data;
        return $this;
    }

    protected function toCollection() {
        return collect($this->response);
    }

    protected function getValues() {
        return $this->response;
    }

}