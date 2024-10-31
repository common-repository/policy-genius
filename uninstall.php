<?php

use privacy_policy_genius\descriptor\Options;

include_once 'vendor/autoload.php';

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}


// Cleanup wp_options
$options = new \ReflectionClass( Options::class );

foreach( $options->getConstants() as $option ) {
    delete_option( $option );
}
