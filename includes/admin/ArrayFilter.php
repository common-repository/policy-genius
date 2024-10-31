<?php

namespace privacy_policy_genius\admin;


use smartcat\admin\ValidationFilter;

class ArrayFilter implements ValidationFilter {
    protected $values;

    public function __construct( array $values ) {
        $this->values = $values;
    }

    public function filter( $values ) {
        for( $ctr = 0; $ctr < count( $values ); $ctr++ ) {
            if( !in_array( $values[ $ctr ], $this->values ) ) {
                unset( $values[ $ctr ] );
            }
        }

        return $values;
    }
}
