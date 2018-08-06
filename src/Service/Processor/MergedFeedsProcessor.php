<?php

namespace App\Service\Processor;

use App\Util\ArrayManipulator;
use App\Util\Fibonacci;

class MergedFeedsProcessor
{

    /**
     * Merge feeds (fill source column)
     * @param mixed $feed1 Feed 1 to merge
     * @param string $source1 Feed 1 source name
     * @param mixed $feed2 Feed 2 to merge
     * @param string $source2 Feed 2 source name
     * @return ArrayManipulator
     */
    public static function mergeFeeds($feed1, $source1, $feed2, $source2)
    {
        // Init feed array manipulators
        $feed1_manipulator = new ArrayManipulator($feed1);
        $feed2_manipulator = new ArrayManipulator($feed2);

        // Merge feed and sort by date (desc) after adding feed_source column to both
        $merged_feed = $feed1_manipulator->addColumnWithFixValue("feed_source", "twitter/" . $source1)
            ->mergeWith($feed2_manipulator->addColumnWithFixValue("feed_source",
                "twitter/" . $source2)->getArray());

        return $merged_feed;
    }

    /**
     * Sort ArrayManipulator ($feed) by date
     * @param ArrayManipulator $feed
     * @return ArrayManipulator
     */
    public static function sortByDate(ArrayManipulator $feed)
    {
        return $feed->sortByDateDesc("created_at");
    }

    /**
     * Insert from $source_feed to $feed by defined insertion mode ($method)
     * @param ArrayManipulator $feed Target feed
     * @param mixed $source_feed Source feed for insertion
     * @param string $source Source of the insertion
     * @param string $method Insertion mode
     * @return array
     */
    public static function insertionIntoFeed(ArrayManipulator $feed, $source_feed, string $source, string $method) {
        // Init array manipulator
        $manipulator = new ArrayManipulator($source_feed);

        // Add feed_source column to jokes
        $insertion = $manipulator->addColumnWithFixValue("feed_source", $source)->getArray();

        if ($method == "mod") {
            // Insert feed to merged feed in every third rows
            $feed->insertRowsByRowCounts($insertion, range(3, 57, 3));
        } else {
            // Default method is "fib", Insert feed to merged feed by fibonacci numbers
            $feed->insertRowsByRowCounts($insertion, Fibonacci::getNumbers(10, 3));
        }

        return $feed->getArray();
    }
}