<?php
/**
* Custom Popup Option and definitions
*
* @package herostencilpt
*/

function popup_options_injector() {
    // Check if user is allowed to update options
    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }

    // Save form data for both popups
    if ( isset( $_POST['submit_popup_options'] ) ) {
        // Use wp_unslash to prevent slashes from being added
        $popup_show_hide = sanitize_text_field( wp_unslash( $_POST['popup_show_hide'] ) );
        $popup_on_page = sanitize_text_field( wp_unslash( $_POST['popup_on_page'] ) );
        $popup_selected_page = sanitize_text_field( wp_unslash( $_POST['popup_selected_page'] ) );
        $popup_content = wp_kses_post( wp_unslash( $_POST['popup_content'] ) );

        // Ebook Popup options
        $ebook_popup_show_hide = sanitize_text_field( wp_unslash( $_POST['ebook_popup_show_hide'] ) );
        $ebook_popup_content = wp_kses_post( wp_unslash( $_POST['ebook_popup_content'] ) );
        $ebook_popup_image = esc_url_raw( wp_unslash( $_POST['ebook_popup_image'] ) );
        $ebook_popup_form_title = sanitize_text_field( wp_unslash( $_POST['ebook_popup_form_title'] ) );
        $ebook_popup_form = sanitize_text_field( wp_unslash( $_POST['ebook_popup_form'] ) );

        // Update options
        update_option( 'popup_show_hide', $popup_show_hide );
        update_option( 'popup_on_page', $popup_on_page );
        update_option( 'popup_selected_page', $popup_selected_page );
        update_option( 'popup_content', $popup_content );

        update_option( 'ebook_popup_show_hide', $ebook_popup_show_hide );
        update_option( 'ebook_popup_content', $ebook_popup_content );
        update_option( 'ebook_popup_image', $ebook_popup_image );
        update_option( 'ebook_popup_form_title', $ebook_popup_form_title );
        update_option( 'ebook_popup_form', $ebook_popup_form );
    }

    // Get saved data for Primary popup
    $popup_show_hide = get_option( 'popup_show_hide', 'disable' );
    $popup_on_page = get_option( 'popup_on_page', 'home' );
    $popup_selected_page = get_option( 'popup_selected_page', '' );
    $popup_content = get_option( 'popup_content', '' );

    // Get saved data for Ebook popup    
    $ebook_popup_show_hide = get_option( 'ebook_popup_show_hide', 'disable' );
    $ebook_popup_content = get_option( 'ebook_popup_content', '' );
    $ebook_popup_image = get_option( 'ebook_popup_image', '' );
    $ebook_popup_form_title = get_option( 'ebook_popup_form_title', '' );
    $ebook_popup_form = get_option( 'ebook_popup_form', '' );
    ?>

    <div class="wrap ga-wrap">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="popup-primary">Site POPUP Primary</a>
            <a href="#" class="nav-tab" data-tab="ebook-primary">Exit Ebook Popup</a>
        </h2>

        <form method="post" action="">

            <!-- Site Popup Primary Tab -->
            <table id="popup-primary" class="form-table tab-content">
                <tr>
                    <th scope="row"><?php _e( 'Popup Show/Hide', 'herostencilpt' ); ?></th>
                    <td>
                        <select name="popup_show_hide">
                            <option value="disable" <?php selected( $popup_show_hide, 'disable' ); ?>><?php _e( 'Disable', 'herostencilpt' ); ?></option>
                            <option value="enable" <?php selected( $popup_show_hide, 'enable' ); ?>><?php _e( 'Enable', 'herostencilpt' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Popup on which page?', 'herostencilpt' ); ?></th>
                    <td>
                        <select id="popup_on_page" name="popup_on_page">
                            <option value="all-page" <?php selected( $popup_on_page, 'all-page' ); ?>><?php _e( 'All Pages', 'herostencilpt' ); ?></option>
                            <option value="home" <?php selected( $popup_on_page, 'home' ); ?>><?php _e( 'Home Page', 'herostencilpt' ); ?></option>
                            <option value="inner-page" <?php selected( $popup_on_page, 'inner-page' ); ?>><?php _e( 'Inner Pages', 'herostencilpt' ); ?></option>
                            <option value="selected_page" <?php selected( $popup_on_page, 'selected_page' ); ?>><?php _e( 'Selected Page', 'herostencilpt' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr id="select_page_row" style="display: none;">
                    <th scope="row"><?php _e( 'Select Page for Popup', 'herostencilpt' ); ?></th>
                    <td>
                        <select name="popup_selected_page">
                            <?php
                            $pages = get_pages();
                            foreach ( $pages as $page ) {
                                echo '<option value="' . esc_attr( $page->ID ) . '" ' . selected( $popup_selected_page, $page->ID ) . '>' . esc_html( $page->post_title ) . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Popup Content', 'herostencilpt' ); ?></th>
                    <td>
                        <?php
                        wp_editor( $popup_content, 'popup_content', array(
                            'textarea_name' => 'popup_content',
                            'textarea_rows' => 25,
                            'media_buttons' => true
                        ) );
                        ?>
                    </td>
                </tr>
            </table>

            <!-- Ebook Popup Tab -->
            <table id="ebook-primary" class="form-table tab-content" style="display:none;">
                <tr>
                    <th scope="row"><?php _e( 'Ebook Popup Show/Hide', 'herostencilpt' ); ?></th>
                    <td>
                        <select name="ebook_popup_show_hide">
                            <option value="disable" <?php selected( $ebook_popup_show_hide, 'disable' ); ?>><?php _e( 'Disable', 'herostencilpt' ); ?></option>
                            <option value="enable" <?php selected( $ebook_popup_show_hide, 'enable' ); ?>><?php _e( 'Enable', 'herostencilpt' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Ebook Popup Content', 'herostencilpt' ); ?></th>
                    <td>
                        <?php
                        wp_editor( $ebook_popup_content, 'ebook_popup_content', array(
                            'textarea_name' => 'ebook_popup_content',
                            'textarea_rows' => 100  ,
                            'media_buttons' => true
                        ) );
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Popup Image', 'herostencilpt' ); ?></th>
                    <td>
                        <input type="hidden" id="ebook_popup_image" name="ebook_popup_image" value="<?php echo esc_url( $ebook_popup_image ); ?>" />
                        <img id="ebook_popup_image_preview" src="<?php echo esc_url( $ebook_popup_image ); ?>" style="max-width: 250px; height: auto; <?php echo $ebook_popup_image ? '' : 'display:none;'; ?>" />
                        <button class="button select-media"><?php _e( 'Select Image', 'herostencilpt' ); ?></button>
                        <button class="button remove-media" style="<?php echo $ebook_popup_image ? '' : 'display:none;'; ?>"><?php _e( 'Remove Image', 'herostencilpt' ); ?></button>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Ebook Popup Form Title', 'herostencilpt' ); ?></th>
                    <td>
                        <input type="text" name="ebook_popup_form_title" value="<?php echo esc_attr( $ebook_popup_form_title ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Form Shortcode', 'herostencilpt' ); ?></th>
                    <td>
                        <input type="text" name="ebook_popup_form" value="<?php echo esc_attr( $ebook_popup_form ); ?>" />
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" name="submit_popup_options" class="button button-primary" value="<?php _e( 'Save Changes', 'herostencilpt' ); ?>" />
            </p>
        </form>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Show/hide selected page option based on popup_on_page value
            function toggleSelectedPageRow() {
                if ($('#popup_on_page').val() === 'selected_page') {
                    $('#select_page_row').show();
                } else {
                    $('#select_page_row').hide();
                }
            }

            $('#popup_on_page').change(toggleSelectedPageRow);
            toggleSelectedPageRow(); // Run on page load to set initial state

            var mediaUploader;

            $('.select-media').click(function(e) {
                e.preventDefault();

                // If the uploader object has already been created, reopen the dialog.
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Extend the wp.media object
                mediaUploader = wp.media({
                    title: '<?php _e( "Choose Image", "herostencilpt" ); ?>',
                    button: {
                        text: '<?php _e( "Use Image", "herostencilpt" ); ?>'
                    },
                    multiple: false // Set to true to allow multiple files to be selected
                });

                // When a file is selected, grab the URL and set it as the input value
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#ebook_popup_image').val(attachment.url);
                    $('#ebook_popup_image_preview').attr('src', attachment.url).show();
                    $('.remove-media').show();
                });

                mediaUploader.open();
            });

            $('.remove-media').click(function(e) {
                e.preventDefault();
                $('#ebook_popup_image').val('');
                $('#ebook_popup_image_preview').hide();
                $(this).hide();
            });

        });
    </script>

    <?php
}

/** Theme popup primary */
function theme_popup_primary() {
    ob_start();

    $spp_enabledisable  = get_option('popup_show_hide', 'disable') === 'enable' ? 1 : 0;
    $spp_popupcontent   = get_option('popup_content', '');
    
    if ($spp_enabledisable && $spp_popupcontent) {
        $spp_popupcontentdata = strip_tags($spp_popupcontent);
        $spp_popupcontentdatapreg = preg_replace('/[^A-Za-z0-9\-]/', '', $spp_popupcontentdata);
        $spp_popupcontentarray = str_split(str_replace(' ', '', $spp_popupcontentdatapreg), 9);
        $spp_popupcontentlast = array_keys($spp_popupcontentarray)[count($spp_popupcontentarray) - 1];
        $spp_popupcontentmiddle = $spp_popupcontentlast / 2;
        $spp_popupcontentmiddle2 = $spp_popupcontentlast / 4;
        $spp_popupcontentval1 = intval($spp_popupcontentmiddle);
        $spp_popupcontentval2 = intval($spp_popupcontentmiddle2);
        $spp_popupcontentdatafinal = $spp_popupcontentval1 . $spp_popupcontentarray[$spp_popupcontentval1] . $spp_popupcontentval2 . $spp_popupcontentarray[$spp_popupcontentval2] . $spp_popupcontentarray[$spp_popupcontentlast];
        echo '<div class="theme-popup-btn theme-popup-primary-btn"><a href="#theme-popup-primary" data-fancybox="theme-popup-primary" class="btn">'. __( 'TP-Popup', 'herostencilpt' ) .'</a></div>'.
        '<div id="theme-popup-primary" data-name="primary-'. $spp_popupcontentdatafinal .'" class="theme-popup theme-popup-primary">'.
            '<div class="theme-popup-wrapper">'.
                '<div class="theme-popup-inner">'.
                    '<div class="theme-popup-close theme-popup-primary-close" role="button" aria-label="close popup" tabindex="0"><span class="icon icon-close"></span></div>'.
                    $spp_popupcontent.
                    '<div class="theme-popup-alert theme-popup-primary-alert">'.
                        '<h3>'. __( 'Close popup for ....', 'herostencilpt' ) .'</h3>'.
                        '<div class="button-group">'.
                            '<span class="btn" role="button">'. __( 'Just Once', 'herostencilpt' ) .'</span>'.
                            '<span class="btn cookiebutton-primary" role="button">'. __( '24 Hours', 'herostencilpt' ) .'</span>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</div>'.
        '</div>';
    }
    return ob_get_clean();
}

// Hook to display the popup after the footer
add_action('wp_footer', 'display_theme_popup_primary');
function display_theme_popup_primary() {
    $spp_enabledisable  = get_option('popup_show_hide', 'disable') === 'enable' ? 1 : 0;
    $spp_popupcontent   = get_option('popup_content', '');
    $spp_popupwhichpage = get_option('popup_on_page', 'home');
    $spp_selectedpage   = get_option('popup_selected_page', '');
    if ($spp_enabledisable && $spp_popupcontent) {
        global $post;
        if ($spp_popupwhichpage === 'all-page') {
            echo theme_popup_primary();
        } elseif ($spp_popupwhichpage === 'home') {
            if (is_front_page()) {
                echo theme_popup_primary();
            }
        } elseif ($spp_popupwhichpage === 'inner-page') {
            if (!is_front_page()) {
                echo theme_popup_primary();
            }
        } elseif ($spp_popupwhichpage === 'selected_page') {
            $spp_selectedpageID = $spp_selectedpage;
            if ($post->ID == $spp_selectedpageID) {
                echo theme_popup_primary();
            }
        }
    }

    /** Ebook popup show on close the tab on home page */
    if ( is_front_page() ) :
        $ebook_popup_show_hide   = get_option('ebook_popup_show_hide', 'disable');
        $ebook_popup_content      = get_option('ebook_popup_content', '');
        $ebook_popup_image        = get_option('ebook_popup_image', '');
        $ebook_popup_form_title   = get_option('ebook_popup_form_title', '');
        $ebook_popup_form         = get_option('ebook_popup_form', '');
        
        if ( ( $ebook_popup_show_hide == 'enable' ) && $ebook_popup_content ) :
            echo '<div class="ebook-theme-popup-btn">'.
                '<a href="#ebook-theme-popup" data-fancybox class="btn">'.
                    __( 'E-Popup', 'herostencilpt2k22' ).
                '</a>'.
            '</div>'.
            '<div id="ebook-theme-popup" class="ebook-theme-popup has-primary-background-color">'.
                '<div class="ebook-theme-popup-inner">'.
                    '<div class="ebook-theme-popup-info">'.
                        $ebook_popup_content.
                    '</div>'.
                    '<div class="ebook-theme-popup-wrapper">'.
                        ( $ebook_popup_image 
                        ? '<div class="ebook-theme-popup-image">'.
                            '<img src="'. $ebook_popup_image .'" alt="">'.
                        '</div>' 
                        : '' ).
                        ( ( $ebook_popup_form || $ebook_popup_form_title )
                        ? '<div class="ebook-theme-popup-content">'.
                            '<h3>'. esc_html($ebook_popup_form_title) .'</h3>'.
                            do_shortcode( $ebook_popup_form ).
                        '</div>'
                        : '' ).
                    '</div>'.
                '</div>'.
            '</div>';
        endif;
    endif;
}
?>