<?php

namespace App\Business\Utils;

use App\Business\Enum\ActionEnum;

class Stringify
{
    /**
     * @param array $toArray
     * @param ActionEnum $action
     * @return string
     */
    public static function fromArray(array $toArray, ActionEnum $action): string
    {
        $keys = array_keys($toArray);
        $values = array_values($toArray);
        $toString = "";

        if (ActionEnum::SAVE === $action) {
            $toString = "(" . implode(", ", $keys) . ") VALUES (";
            for ($i = 0; $i < count($values); $i++) {
                $toString .= "'" . $values[$i] . "'";
                if ($i < count($values) - 1) {
                    $toString .= ", ";
                }
            }

            $toString .= ")";
        }
        if (ActionEnum::UPDATE === $action) {
            for ($i = 0; $i < count($values); $i++) {
                $toString .= $keys[$i];
                $toString .= ' = ';
                $toString .= "'" . $values[$i] . "'";
                if ($i < count($values) - 1) {
                    $toString .= ", ";
                }
            }
        }

        return $toString;
    }

}