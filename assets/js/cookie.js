( function ( $ ) {

    $( document ).ready( function () {

	var cnDomNode = $( '#cookie-notice' );

	// handle set-cookie button click
	$( document ).on( 'click', '.cn-button', function ( e ) {
	    e.preventDefault();
	    $( this ).setCookieNotice( $( this ).data( 'cookie-set' ) );
		jQuery("#cookie-notice").fadeOut("slow");
	} );

	// handle on scroll
	if ( cnArgs.onScroll == 'yes' ) {
	    var cnHandleScroll = function () {
		var win = $( this );
		if ( win.scrollTop() > parseInt( cnArgs.onScrollOffset ) ) {
		    // If user scrolls at least 100 pixels
		    win.setCookieNotice( 'accept' );
		    win.off( 'scroll', cnHandleScroll ); //remove itself after cookie accept
		}
	    };

	    $( window ).on( 'scroll', cnHandleScroll );
	}

	// display cookie notice
	if ( document.cookie.indexOf( 'cookie_info_accepted' ) === -1 ) {
	    
		cnDomNode.fadeIn( 300 );
	    $('.cookie-notifier').addClass('show');
	    
	    $( 'body' ).addClass( 'cookies-not-accepted' );
	} else {
	    cnDomNode.removeCookieNotice();
	}

    } );

    // set Cookie Notice
    $.fn.setCookieNotice = function ( cookie_value ) {

	var cnTime = new Date(),
	    cnLater = new Date(),
	    cnDomNode = $( '#cookie-notice' ),
	    cnSelf = this;

	// set expiry time in seconds
	cnLater.setTime( parseInt( cnTime.getTime() ) + parseInt( cnArgs.cookieTime ) * 1000 );

	// set cookie
	cookie_value = cookie_value === 'accept' ? true : false;
	document.cookie = cnArgs.cookieName + '=' + cookie_value + ';expires=' + cnLater.toGMTString() + ';' + ( cnArgs.cookieDomain !== undefined && cnArgs.cookieDomain !== '' ? 'domain=' + cnArgs.cookieDomain + ';' : '' ) + ( cnArgs.cookiePath !== undefined && cnArgs.cookiePath !== '' ? 'path=' + cnArgs.cookiePath + ';' : '' );

	// trigger custom event
	$.event.trigger( {
	    type: "setCookieNotice",
	    value: cookie_value,
	    time: cnTime,
	    expires: cnLater
	} );

	var browser = '';

	if (navigator.userAgent.search("MSIE") >= 0) {
	    browser = 'MSIE';
	}
	else if (navigator.userAgent.search("OPR") >= 0) {
	    browser = 'Opera';
	}
	else if (navigator.userAgent.search("Chrome") >= 0) {
	    browser = 'Chrome';
	}
	else if (navigator.userAgent.search("Firefox") >= 0) {
	    browser = 'Firefox';
	}
	else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
	    browser = 'Safari';
	}
		var decision = cookie_value === true ? 'Accepted' : 'Declined';
		// var gid = ga.getAll()[0].get('clientId');
		// var data = {
			// 'action'  : 'my_cis_form',
			// 'value'   : decision,
			// 'gid'	  : gid,
			// 'website' : cnArgs.website,
			// 'ipaddress' : cnArgs.ipaddress, 	
			// 'page'	  : cnArgs.cis_page,
			// 'browser' : browser
		// };
		// console.log(cookie_value);

		// $.post(cnArgs.ajaxurl, data, function(response) {
          // console.log('Got this from the server: ' + response);
      // });
	
	    // cnSelf.removeCookieNotice();
	
    };

    // remove Cookie Notice
    $.fn.removeCookieNotice = function ( cookie_value ) {

	$( '#cookie-notice' ).remove();
	$('.cookie-notifier').removeClass('show');
	$( 'body' ).removeClass( 'cookies-not-accepted' );
    }

} )( jQuery );

