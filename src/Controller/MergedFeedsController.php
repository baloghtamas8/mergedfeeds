<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Client\TwitterClient;
use App\Service\Client\IcndbClient;
use Abraham\TwitterOAuth\TwitterOAuthException;
use App\Service\Client\Exception\TwitterClientException;
use App\Service\Client\Exception\IcndbClientException;
use App\Service\Processor\MergedFeedsProcessor;

class MergedFeedsController extends AbstractController
{
    public function index(TwitterClient $twitter, IcndbClient $icndb, $handle1, $handle2, $method)
    {
        if ($handle1 == $handle2) {
            return $this->handlingError("A megadott két twitter fiók nem lehet azonos!");
        }

        try {
            // Get the last tweets from twitter accounts defined in handle1 and handle2
            $tweets1 = $twitter->getLastTweets($handle1);
            $tweets2 = $twitter->getLastTweets($handle2);
            // Get some random jokes
            $jokes = $icndb->getRandom();

            // Merge twitter feeds
            $merged_tweets = MergedFeedsProcessor::mergeFeeds($tweets1, $handle1, $tweets2, $handle2);
            // Sort by date (desc)
            $merged_tweets = MergedFeedsProcessor::sortByDate($merged_tweets);
            // Insert jokes to merged tweets
            $merged_tweets = MergedFeedsProcessor::insertionIntoFeed($merged_tweets, $jokes, "icndb", $method);

            // Render the list
            return $this->render('merged_feeds/index.html.twig', [
                'messages' => $merged_tweets,
            ]);

        } catch (TwitterOAuthException $e) {
            return $this->handlingError("Nem sikerült a tweetek letöltése OAuth hiba miatt.");
        } catch (TwitterClientException $e) {
            return $this->handlingError("Nem sikerült a tweetek letöltése.");
        } catch (IcndbClientException $e) {
            return $this->handlingError("Nem sikerült a viccek letöltése icndb-ről.");
        }

    }

    private function handlingError($error_message)
    {
        return $this->render('merged_feeds/error.html.twig', [
            'message' => $error_message,
        ]);
    }

}