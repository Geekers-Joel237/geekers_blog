<?php

namespace App\Business\Utils;

class Stringify
{
    /**
     * @param array $toArray
     * @return string
     */
    public static function fromArray(array $toArray): string
    {
        $keys = array_keys($toArray);
        $values = array_values($toArray);

        $toString = "(" . implode(", ", $keys) . ") VALUES (";

        for ($i = 0; $i < count($values); $i++) {
            $toString .= "'" . $values[$i] . "'";
            if ($i < count($values) - 1) {
                $toString .= ", ";
            }
        }

        $toString .= ")";

        return $toString;
    }


}