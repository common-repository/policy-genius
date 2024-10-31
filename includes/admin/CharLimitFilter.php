<?php

namespace privacy_policy_genius\admin;


use smartcat\admin\ValidationFilter;

class CharLimitFilter implements ValidationFilter {

    protected $max_chars;
    protected $fill;

    public function __construct( $max_chars, $fill ) {
        $this->max_chars = $max_chars;
        $this->fill = $fill;
    }

    public function filter( $value ) {
        return substr( $value, 0, $this->max_chars );
    }
}
