<?php

namespace App\Util;

/**
 * Array manipulations
 * @package App\Util
 */
class ArrayManipulator
{
    /**
     * Manipulation with it
     * @var array
     */
    private $array;

    /**
     * Init ArrayManipulator array param
     * Convert obj param to array
     * @param $array
     */
    public function __construct($array)
    {
        $array = self::convertObjectToArray($array);
        $this->array = $array;
    }

    /**
     * Get manipulated array
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * Convert object to associative array
     * @param mixed $obj
     * @return mixed
     */
    public static function convertObjectToArray($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    /**
     * Add a column with fix value specified in $column_name and $value parameter
     * @param mixed $column_name
     * @param mixed $value
     * @return $this
     */
    public function addColumnWithFixValue($column_name, $value)
    {
        foreach ($this->array as $k=>$row) {
            $this->array[$k][$column_name] = $value;
        }

        return $this;
    }

    /**
     * Insert rows from $source_array to rows number in $row_counts
     * @param mixed $source_array
     * @param array $row_counts
     * @return $this
     */
    public function insertRowsByRowCounts($source_array, $row_counts)
    {
        if (is_object($source_array)) {
            // convert is not array
            $source_array = self::convertObjectToArray($source_array);
        }

        foreach ($row_counts as $row_num) {
            if ($row_num <= sizeof($this->array)) {
                // get the next element to insert
                $next_source = next($source_array);
                if ($next_source) {
                    array_splice($this->array, $row_num - 1, 0, [$next_source]);
                }
            }
        }

        return $this;
    }

    /**
     * Merge array with another array
     * @param array $array2
     * @return $this
     */
    public function mergeWith(array $array2)
    {
        $this->array = array_merge($this->array, $array2);

        return $this;
    }

    /**
     * Sort array by date desc
     * @param string $sort_param_name
     * @return $this
     */
    public function sortByDateDesc($sort_param_name = "date")
    {
        usort($this->array, function($a, $b) use ($sort_param_name) {
            $a = strtotime($a[$sort_param_name]);
            $b = strtotime($b[$sort_param_name]);
            return ($b-$a);
        });

        return $this;
    }

}