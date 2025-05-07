<?php
/**
 * Include this file in " functions.php "" to extend the features of an existing Gutenberg block.
 */
function extend_default_element_settings() {
    wp_enqueue_script(
        'custom-columns-justify-settings',
        get_theme_file_uri() . '/inc/core-extensions/column-config.js',
        array('wp-blocks', 'wp-hooks', 'wp-editor', 'wp-components', 'wp-element'),
        false,
        true
    );

    wp_enqueue_script(
        'custom-group-padding-settings',
        get_theme_file_uri() . '/inc/core-extensions/group-config.js',
        array('wp-blocks', 'wp-hooks', 'wp-editor', 'wp-components', 'wp-element'),
        false,
        true
    );
}
add_action('enqueue_block_editor_assets', 'extend_default_element_settings');

