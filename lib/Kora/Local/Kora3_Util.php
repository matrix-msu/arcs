<?php
namespace Lib\Kora3;

class Kora3_Util {

    public static function k3RecordToK2($k3Record, $pid, $schemeID, $mapping=true) {
        $k2Record = Array();
        $k2Record['kid'] = $k3Record->kid;
        $k2Record['pid'] = $pid;
        $k2Record['schemeID'] = $schemeID;
        $k2Record['linkers'] = $k3Record->meta->reverseAssociations;

        foreach ($k3Record->Fields as $field => $value) {
            if ($mapping) {
                $field = Kora3_Util::convertNameToK2($field);
            }
            $k2Record[$field] = isset($value->text)? $value->text : $value->options;

        }

        return $k2Record;
    }
    public static function convertNameToK2($field) {
        $strlen = strlen( $field );
        $newStr = "";
        for( $i = 0; $i <= $strlen; $i++ ) {
            $char = substr( $field, $i, 1 );
            if (!is_numeric($char)) {
                if ($char == "_") {
                    $newStr .= " ";
                } else {
                    $newStr .= $char;
                }
            }
        }
        return $newStr;
    }
}
