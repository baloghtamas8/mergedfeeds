<?php

namespace App\Service\Client;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use App\Service\Client\Exception\TwitterClientException;

/**
 * Twitter Service
 * Connect to a Twitter App and create requests
 * @package App\Service
 */
class TwitterClient
{
    private $result;

    /**
     * @var TwitterOAuth
     */
    private $connection = null;

    /**
     * Init Twitter connection
     * @param TwitterOAuth $connection
     */
    public function __construct(TwitterOAuth $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get last tweets by screen_name of the twitter user
     * @param string $username
     * @param int $count
     * @return array|bool
     * @throws TwitterClientException|TwitterOAuthException
     */
    public function getLastTweets($username, $count = 20)
    {
        $tweets = $this->connection->get("statuses/user_timeline", ["screen_name" => $username, "count" => $count]);
        if ($this->connection->getLastHttpCode() == 200) {
            // Get tweets successfully
            $this->result = $tweets;
            return $this->result;
        } else {
            // Error
            throw new TwitterClientException("Status code error", $this->connection->getLastHttpCode());
        }
    }

}