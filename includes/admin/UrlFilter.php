<?php

namespace privacy_policy_genius\admin;

use smartcat\admin\ValidationFilter;

class UrlFilter implements ValidationFilter {
    public function filter( $value ) {
        return esc_url_raw( $value );
    }
}
