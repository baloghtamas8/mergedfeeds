<?php

namespace App\Tests\Util;

use App\Util\ArrayManipulator;
use PHPUnit\Framework\TestCase;

class ArrayManipulatorTest extends TestCase
{

    private static function getTestObj() {
        $array_of_objects[] = (object)[
            "created_at" => "Mon Jul 23 14:46:09 +0000 2018",
            "id" => "1025523335587753984",
            "text" => "A week of symfony #605 (30 July - 5 August 2018) https://t.co/1fNFo2P7ae #symfony",
            "lang" => "en"
        ];
        $array_of_objects[] = (object)[
            "created_at" => "Fri Jul 20 09:19:34 +0000 2018",
            "id" => "1020236765775507456",
            "text" => "RT @KnpUniversity: Having \"smart\" components with state and \"dumb\" components *without* state is the winning recipe. Except... sometimes...…",
            "lang" => "en"
        ];
        return $array_of_objects;
    }

    public function testConvertObjectToArray()
    {
        $result = ArrayManipulator::convertObjectToArray(static::getTestObj());
        $this->assertEquals($result[1]["id"], "1020236765775507456");
    }

    public function testAddColumnWithFixValue()
    {
        $arrayManipulator = new ArrayManipulator(static::getTestObj());
        $insertedFeed = $arrayManipulator->addColumnWithFixValue("test_column", "test_value")->getArray();
        $this->assertEquals($insertedFeed[0]["test_column"], "test_value");
        $this->assertEquals($insertedFeed[1]["test_column"], "test_value");
    }

}