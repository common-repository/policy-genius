<?php

namespace privacy_policy_genius\util;


class ArrayUtils {

    private function __construct() {}

    public static function array_ifind( $needle, array $haystack ) {
        $result = false;

        foreach( $haystack as $key => $value ) {
            if( strcasecmp( trim( $needle ), trim( $value ) ) == 0 ) {
                $result = $key;
            }
        }

        return $result;
    }

}
