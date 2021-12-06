<?php
/**
 * SecondLine Block Editor Styles
 *
 * @package slt
 */


/**
 * Add custom colors to Gutenberg.
 */
function secondline_gutenberg_colors() {
	// Retrieve the accent color for the Customizer.
	$accent = get_theme_mod( 'secondline_themes_button_background', '#263669' );
	$accent_hover = get_theme_mod( 'secondline_themes_button_background_hover', '#2d2d2d' );
	// Build styles.
	$css  = '';
	
	$css .= '.has-button-background-background-color { background-color: ' . esc_attr( $accent ) . ' !important; }';
	$css .= '.has-button-background-color { color: ' . esc_attr( $accent ) . ' !important; }';
	
	$css .= '.has-button-background-hover-background-color { background-color: ' . esc_attr( $accent_hover ) . ' !important; }';
	$css .= '.has-button-background-hover-color { color: ' . esc_attr( $accent_hover ) . ' !important; }';	
	
	$css .= '.has-white-background-color { background-color: #ffffff !important; }';
	$css .= '.has-white-color { color: #ffffff !important; }';	
	
	$css .= '.has-black-background-color { background-color: #000000 !important; }';
	$css .= '.has-black-color { color: #000000 !important; }';
	
	$css .= '.has-dark-gray-background-color { background-color: #2d2d2d !important; }';
	$css .= '.has-dark-gray-color { color: #2d2d2d !important; }';
	
	$css .= '.has-navy-blue-background-color { background-color: #3b5987 !important; }';
	$css .= '.has-navy-blue-color { color: #3b5987 !important; }';
	
	$css .= '.has-light-blue-background-color { background-color: #b2c3de !important; }';
	$css .= '.has-light-blue-color { color: #b2c3de !important; }';	
	
	return wp_strip_all_tags( $css );
}

function secondline_gutenberg_editor_colors() {
	// Retrieve the accent color for the Customizer.
	$accent = get_theme_mod( 'secondline_themes_button_background', '#263669' );
	$accent_hover = get_theme_mod( 'secondline_themes_button_background_hover', '#2d2d2d' );
	$button_color = get_theme_mod( 'secondline_themes_button_font', '#ffffff' );
	$button_hover_color = get_theme_mod( 'secondline_themes_button_font_hover', '#ffffff' );	
	$link_color = get_theme_mod( 'secondline_themes_default_link_color', '#263669' );
	$link_hover_color = get_theme_mod( 'secondline_themes_default_link_hover_color', '#2d2d2d' );
	$slt_google_fonts = get_option('tt_font_theme_options');
	// Build styles.
	$css  = '';	
	
	$css .= 'body .editor-styles-wrapper .wp-block-button .wp-block-button__link { background-color: ' . esc_attr( $accent ) . '; color: ' . esc_attr( $button_color ) . '; }';
	$css .= 'body .editor-styles-wrapper .wp-block-button .wp-block-button__link:hover { background-color: ' . esc_attr( $accent_hover ) . '; color: ' . esc_attr( $button_hover_color ) . '; }';	
	
	$css .= 'body .editor-styles-wrapper ::selection, body .editor-styles-wrapper .editor-block-list__layout .editor-block-list__block ::selection {background: ' . esc_attr( $accent ) . '; }';	
	$css .= 'body .editor-styles-wrapper a, .editor-styles-wrapper .block-editor a, .editor-styles-wrapper .block-editor .wp-block-freeform.block-library-rich-text__tinymce a, .editor-styles-wrapper .block-editor .mce-content-body a[data-mce-selected="inline-boundary"], body a, .block-editor a, .block-editor .wp-block-freeform.block-library-rich-text__tinymce a {color: ' . esc_attr( $link_color ) . '; }';
	$css .= 'body .editor-styles-wrapper a:hover, .editor-styles-wrapper .block-editor a:hover, .editor-styles-wrapper .block-editor .wp-block-freeform.block-library-rich-text__tinymce a:hover, .editor-styles-wrapper .block-editor .mce-content-body a[data-mce-selected="inline-boundary"]:hover, body a:hover, .block-editor a:hover {color: ' . esc_attr( $link_hover_color ) . '; }';
	
	$css .= 'body .editor-styles-wrapper blockquote.wp-block-quote, body .editor-styles-wrapper .block-editor blockquote, body .editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large), body .editor-styles-wrapper .wp-block-quote.is-large, body .editor-styles-wrapper div.wp-block-freeform.block-library-rich-text__tinymce blockquote, body .editor-styles-wrapper .wp-block-quote.is-style-large, body .wp-block-pullquote blockquote, .block-editor blockquote, .editor-styles-wrapper figure.wp-block-pullquote blockquote {border-left-color: ' . esc_attr( $accent ) . '; }';
	
	$css .= 'body .editor-post-title .editor-post-title__input, body .edit-post-visual-editor, body .edit-post-visual-editor input, .edit-post-visual-editor select, .edit-post-visual-editor, .edit-post-visual-editor p, body .editor-styles-wrapper p, .editor-styles-wrapper p {color: ' . $slt_google_fonts['secondline_themes_body_font_family']['font_color'] . ' !important;}';
	
	$css .= '.editor-styles-wrapper {background-color: ' . get_theme_mod( 'secondline_themes_background_color', '#ffffff' ) . ' !important;}';
	
	
	return wp_strip_all_tags( $css );
}