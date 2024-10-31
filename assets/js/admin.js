"use strict"

jQuery( "document" ).ready( function ( $ ) {
	jQuery("#privacy_policy_background_color, #privacy_policy_font_color, #privacy_policy_accept_button_color, #privacy_policy_button_accept_background_color").wpColorPicker();
    var checkbox = $( "#privacy_policy_info_transfer" );
    var section = $( "input[name='privacy_policy_genius_personal-information-transfer-purpose[]']" ).parents( "tr" );

    if( !checkbox.attr( 'checked' ) ) {
        section.hide();
    }

    checkbox.change( function ( e, ui ) {
        section.toggle();
    } );


    $( "#privacy_policy_last_updated" ).parents( "tr" ).hide();

} );
