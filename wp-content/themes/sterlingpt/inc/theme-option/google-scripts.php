<?php
/**
* Google Scripts Option and definitions
*
* @package herostencilpt
*/

/** Callback function for the google-scripts Option page */
function google_scripts_injector() {
    // Check if user is allowed to update options
    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }

    // Save form data
    if ( isset( $_POST['submit_google_scripts'] ) ) {
        update_option( 'google_tag_manager_id', sanitize_text_field( $_POST['google_tag_manager_id'] ) );
        update_option( 'google_analytics_id', sanitize_text_field( $_POST['google_analytics_id'] ) );
        update_option( 'google_ads_id', sanitize_text_field( $_POST['google_ads_id'] ) );
        update_option( 'google_ads_label', sanitize_text_field( $_POST['google_ads_label'] ) );

        $allowed_html = array(
            'script' => array(
                'type' => true,
                'src' => true,
                'async' => true,
            ),
        );
        
        update_option( 'head_script', wp_kses( $_POST['head_script'], $allowed_html ) );
        update_option( 'footer_script', wp_kses( $_POST['footer_script'], $allowed_html ) );

    }

    // Get saved data
    $google_tag_manager_id = get_option( 'google_tag_manager_id', '' );
    $google_analytics_id   = get_option( 'google_analytics_id', '' );
    $google_ads_id         = get_option( 'google_ads_id', '' );
    $google_ads_label      = get_option( 'google_ads_label', '' );
    $head_script           = get_option( 'head_script', '' );
    $footer_script         = get_option( 'footer_script', '' );
    ?>

    <div class="wrap ga-wrap">
        <h1><?php _e( 'Google | Scripts', 'herostencilpt' ); ?></h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e( 'Google Tag Manager ID', 'herostencilpt' ); ?></th>
                    <td>
                        <p class="description">Add Google Tag Manager ID like <b>GTM-XXXXXXX</b>.</p>
                        <input type="text" name="google_tag_manager_id" value="<?php echo esc_attr( $google_tag_manager_id ); ?>" placeholder="GTM-XXXXXXXX" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Google Analytics ID', 'herostencilpt' ); ?></th>
                    <td>
                        <p class="description">Add Google Analytics ID like GA3 <b>UA-XXXXXXXXX-X</b> or GA4 <b>G-XXXXXXXXXX</b>.</p>
                        <input type="text" name="google_analytics_id" value="<?php echo esc_attr( $google_analytics_id ); ?>" placeholder="UA-XXXXXXXX-X or G-XXXXXXXXXX" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Google Ads ID', 'herostencilpt' ); ?></th>
                    <td>
                        <p class="description">Add Google Ads ID(Conversion ID) like <b>AW-XXXXXXXXX</b>/XXXXXXXXXXXXXXXXXXXX.</p>
                        <input type="text" name="google_ads_id" value="<?php echo esc_attr( $google_ads_id ); ?>" placeholder="AW-XXXXXXXXXX" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Google Ads Label', 'herostencilpt' ); ?></th>
                    <td>
                        <p class="description">Add Google Ads ID(Conversion label) like AW-XXXXXXXXX<b>/XXXXXXXXXXXXXXXXXXXX</b>.</p>
                        <input type="text" name="google_ads_label" value="<?php echo esc_attr( $google_ads_label ); ?>" placeholder="XXXXXXXXXXXXXXX" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Head Script', 'herostencilpt' ); ?></th>
                    <td>
                        <p class="description">Add script in <head> part. Ex. <script>...</script></p>
                        <textarea name="head_script" rows="5" class="large-text"><?php echo esc_textarea( $head_script ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Footer Script', 'herostencilpt' ); ?></th>
                    <td>
                        <p class="description">Add script in <body> part. Ex. <script>...</script></p>
                        <textarea name="footer_script" rows="5" class="large-text"><?php echo esc_textarea( $footer_script ); ?></textarea>
                    </td>
                </tr>
            </table>

            <?php submit_button( 'Save Settings', 'primary', 'submit_google_scripts' ); ?>
        </form>
    </div>

    <?php
}


/** Added data into the head tag */
function my_theme_wp_head() {
    /** Google tag manager/analytics id script */
	$gtm_id = get_option('google_tag_manager_id', '');
	$ga_id  = get_option('google_analytics_id', '');
	$ads_id = get_option('google_ads_id', '');
	$ads_lbl = get_option('google_ads_label', '');
	$head_script  = get_option('head_script', '');
	if ( $gtm_id || $ga_id || $ads_id || $head_script ) :
		if ( $gtm_id ) :
			echo "<!-- Google Tag Manager -->";
			echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','". $gtm_id ."');</script>";
			echo '<!-- End Google Tag Manager -->';
		endif;
		if ( $ga_id || $ads_id ) :
            if ( $ga_id ) :
				echo '<!-- Global site tag (gtag.js) - Google Analytics -->';
				echo '<script async src="https://www.googletagmanager.com/gtag/js?id='. $ga_id .'"></script>';
			endif;
			if ( $ads_id ) :
				echo '<!-- Global site tag (gtag.js) - Google Ads -->';
				echo '<script async src="https://www.googletagmanager.com/gtag/js?id='. $ads_id .'"></script>';
			endif;

			echo "<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				". ( $ga_id ? "gtag('config', '". $ga_id ."');" : '' ) . ( $ads_id ? "gtag('config', '". $ads_id ."');" : '' )."
			</script>";
			if ( $ads_id && $ads_lbl ) :
				echo '<!-- Event snippet for Phone call lead conversion page -->';
				echo "<script> gtag('event', 'conversion', {'send_to': '". $ads_id ."/". $ads_lbl ."'}); </script>";
			endif;
		endif;
		if ( $head_script ) :
			echo $head_script;
		endif;
	endif;
}
add_action( 'wp_head', 'my_theme_wp_head' );

/** Added data after start body tag */
function my_theme_wp_body_open() {
	/** Google tag manager id script */
	$gtm_id = get_option('google_tag_manager_id', '');
	if ( $gtm_id ) :
		echo '<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='. $gtm_id .'"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->';
	endif;
}
add_action( 'wp_body_open', 'my_theme_wp_body_open' );

/** Added data into the footer */
function my_theme_wp_footer() {
	/** Script added on footer */
    $footer_script = get_option( 'footer_script', '' );
	if ( $footer_script ) :
		echo $footer_script;
	endif;
}
add_action( 'wp_footer', 'my_theme_wp_footer' );

?>