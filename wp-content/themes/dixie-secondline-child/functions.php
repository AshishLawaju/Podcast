<?php
/**
 * Theme functions and definitions.
 */
function dixiesecondline_child_enqueue_styles() {

    wp_enqueue_style( 'dixie-secondline-style' , get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'dixie-secondline-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'dixie-secondline-style' ),
        wp_get_theme()->get('Version')
    );

    if ( is_rtl() ) {
        wp_enqueue_style( 'dixie-secondline-rtl', get_template_directory_uri() . '/rtl.css' );
    }

}

add_action(  'wp_enqueue_scripts', 'dixiesecondline_child_enqueue_styles' );