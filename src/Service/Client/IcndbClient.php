<?php

namespace App\Service\Client;

use App\Service\Client\Exception\IcndbClientException;

/**
 * Icndb Service
 * To communicate with icndb REST API
 * @package App\Service
 */
class IcndbClient
{
    /**
     * API url
     * @var string
     */
    private static $apiBaseURL = 'http://api.icndb.com/';

    /**
     * Get random jokes, false if error
     * @param int $count number of jokes (default=1)
     * @return array|bool
     * @throws IcndbClientException
     */
    public function getRandom($count = 20)
    {
        return $this->call("jokes/random/$count");
    }

    /**
     * Call icndb API
     * @param $uri
     * @return array|bool response array, false on errors
     * @throws IcndbClientException
     */
    public function call($uri)
    {
        $ch = curl_init(static::$apiBaseURL.$uri);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ));
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($status != 200 or $response == '') {
            throw new IcndbClientException("Status code error", $status);
        }
        // escaped characters
        $response = str_replace('\\', '', $response);
        $body = json_decode($response);
        if ($body->type != 'success') {
            throw new IcndbClientException("Body type error");
        }
        return $body->value;
    }
}