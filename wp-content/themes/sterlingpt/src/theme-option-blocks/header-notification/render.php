<?php

    global $cookieset;
	global $notificationbarvalue;
	$notificationbardata = strip_tags( get_option('header_address_bar', '') );
	$notificationbartext = preg_replace( '/[^A-Za-z0-9\-]/', '', $notificationbardata );
	$notificationbarvalue = strtolower( $notificationbartext );
	if ( isset( $_COOKIE['notificationbarcookie'] ) ) :
		if ( $_COOKIE['notificationbarcookie'] != $notificationbarvalue ) {
			$cookieset = 2;
		} else {
			$cookieset = 1;
		}
	endif;

$HeaderNotificationBar = get_option('header_address_bar', '');

echo (
        ( $HeaderNotificationBar && ( $cookieset != 1 ) )
        ? '<div data-name="'. $notificationbarvalue .'" id="notification-bar" class="notification-bar alignfull">'.
            '<div class="notification-text">'. wp_kses_post($HeaderNotificationBar) .'</div>'.
            '<div class="notification-close icon-close"></div>'.
        '</div>'
        : ''
);

?>
