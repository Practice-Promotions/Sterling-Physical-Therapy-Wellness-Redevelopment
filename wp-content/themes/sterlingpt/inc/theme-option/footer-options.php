<?php
/**
* Custom Footer Option and definitions
*
* @package herostencilpt
*/


/**  Callback function for the Footer Option page */
function footer_option_injector() {
    echo '<h1>' . __( 'Footer Option', 'herostencilpt' ) . '</h1>';
    echo '<p>' . __( 'This is the footer option page.', 'herostencilpt' ) . '</p>';
}


?>