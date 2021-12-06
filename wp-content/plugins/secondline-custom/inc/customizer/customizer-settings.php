<?php



function secondline_themes_audio_settings( $wp_customize ) {
		 
	$wp_customize->add_setting( 'secondline_themes_fancy_player' ,array(
		'default' =>  'secondline-themes-fancy-player',			
		'sanitize_callback' => 'secondline_themes_sanitize_plugin',
	) );
	$wp_customize->add_control( 'secondline_themes_fancy_player', array(
		'label'          => 'Audio Player Type',
		'type'          => 'select',
		'description'    => 'Enable a fancy podcast player with additional controls',
		'section' => 'secondline_themes_section_media_player',
		'priority'   => 1,
		'choices'     => array(
			'secondline-themes-fancy-player' => esc_html__( 'Fancy', 'secondline-custom-plugin' ),
			'secondline-themes-regular-player' => esc_html__( 'Regular', 'secondline-custom-plugin' ),
		),
	));
		
		
	/* Section - General - General Layout */
	$wp_customize->add_section( 'secondline_themes_audio_playlist', array(
		'title'          => esc_html__( 'Audio Playlist Options', 'tusant-secondline' ),
		'panel'          => 'secondline_themes_media_player', // Not typically needed.
		'priority'       => 50,
		) 
	);	

	$wp_customize->add_setting( 'secondline_themes_playlist_background' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_background', array(
		'label'          => 'Audio Playlist Background Color',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 3,
		))
	);	

	$wp_customize->add_setting( 'secondline_themes_playlist_color' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_color', array(
		'label'          => 'Audio Playlist Title Color',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 4,
		))
	);	
	
	$wp_customize->add_setting( 'secondline_themes_playlist_border' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_border', array(
		'label'          => 'Audio Playlist Border Color',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 5,
		))
	);		
	
	$wp_customize->add_setting( 'secondline_themes_playlist_controls' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_controls', array(
		'label'          => 'Audio Playlist Controls',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 6,
		))
	);		
	
	$wp_customize->add_setting( 'secondline_themes_playlist_knobs' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_knobs', array(
		'label'          => 'Audio Playlist Volume/Timerail Knobs',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 7,
		))
	);	
	
	$wp_customize->add_setting( 'secondline_themes_playlist_timerail' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_timerail', array(
		'label'          => 'Audio Playlist Remaining Runtime Background',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 8,
		))
	);		
	
	$wp_customize->add_setting( 'secondline_themes_playlist_timerail_played' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_timerail_played', array(
		'label'          => 'Audio Playlist Elapsed Runtime Background',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 9,
		))
	);		
	
	$wp_customize->add_setting( 'secondline_themes_playlist_font_color' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_font_color', array(
		'label'          => 'Audio Playlist Font Color',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 10,
		))
	);		

	$wp_customize->add_setting( 'secondline_themes_playlist_now_playing_bg' ,array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_playlist_now_playing_bg', array(
		'label'          => 'Audio Playlist Current Track Background',
		'section' => 'secondline_themes_audio_playlist',
		'priority'   => 11,
		))
	);		
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting('secondline_themes_page_title_show_hide',array(
		'default' => 'block',
		'sanitize_callback' => 'secondline_themes_sanitize_plugin',
	));
	$wp_customize->add_control( 'secondline_themes_page_title_show_hide', array(
		'label'    => 'Show/Hide Page Title',
		'description'    => 'This setting applies to all pages',
		'type'     => 'select',
		'section'  => 'tt_font_secondline-themes-page-title',
		'priority'   => 1,
		'choices'     => array(
			'block' => esc_html__( 'Show', 'secondline-custom-plugin' ),
			'none' => esc_html__( 'Hide', 'secondline-custom-plugin' ),
		),
	));	
		
}
add_action( 'customize_register', 'secondline_themes_audio_settings' );


/* Sanitize */
function secondline_themes_sanitize_plugin( $input ) {
    return wp_filter_nohtml_kses( $input );
}


function secondline_themes_customizer_plugin_styles() {
	
	//https://codex.wordpress.org/Function_Reference/wp_add_inline_style
	wp_enqueue_style( 'secondline-audio-player-styles',  SECONDLINE_THEME_ELEMENTS_URL . 'assets/css/secondline-audio.css'  );

	$secondline_themes_custom_css = "
	body #page-title-slt h1 {
		display:" . esc_attr(get_theme_mod('secondline_themes_page_title_show_hide')) . ";
	}
	
	body.secondline-fancy-player .mejs-playlist-current.mejs-layer, body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-container .mejs-controls, body.secondline-fancy-player #main-container-secondline .wp-playlist-tracks, body.secondline-fancy-player #main-container-secondline .wp-playlist-item, body.secondline-fancy-player #main-container-secondline .mejs-layers, body.secondline-fancy-player .wp-playlist-current-item, body.secondline-fancy-player .mejs-playlist-current.mejs-layer {
		background:" . esc_attr( get_theme_mod('secondline_themes_playlist_background')) . ";
	}
	
	body.secondline-fancy-player #main-container-secondline .wp-playlist-item, body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-container .mejs-controls {
		border-color:" . esc_attr( get_theme_mod('secondline_themes_playlist_border')) . ";
	}
	
	body.secondline-fancy-player #main-container-secondline .wp-playlist-item-title, body.secondline-fancy-player #main-container-secondline .mejs-playlist-current.mejs-layer p {
		color:" . esc_attr( get_theme_mod('secondline_themes_playlist_color')) . ";
	}
	
	body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-inner .mejs-controls button, body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-inner .mejs-controls button:before,
	body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-button.mejs-speed-button button	{
		color:" . esc_attr( get_theme_mod('secondline_themes_playlist_controls')) . ";
		border-color:" . esc_attr( get_theme_mod('secondline_themes_playlist_controls')) . ";
	}	
	
	body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-current, body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, body.secondline-fancy-player #main-container-secondline .wp-playlist-item.wp-playlist-playing, body #main-container-secondline .wp-playlist-item.wp-playlist-playing:hover, body.secondline-fancy-player #main-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded {
		background:" . esc_attr( get_theme_mod('secondline_themes_playlist_timerail_played')) . ";
	}	
	
	body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded, body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-total, body.secondline-fancy-player #main-container-secondline .wp-playlist.wp-audio-playlist .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total {
		background:" . esc_attr( get_theme_mod('secondline_themes_playlist_timerail')) . ";
	}
	
	body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-handle, body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-controls .mejs-time-rail .mejs-time-handle {
		background:" . esc_attr( get_theme_mod('secondline_themes_playlist_knobs')) . ";
		border-color:" . esc_attr( get_theme_mod('secondline_themes_playlist_knobs')) . ";
	}	
	
	body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-playlist-item-description, body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-inner .mejs-time .mejs-currenttime, body.secondline-fancy-player #main-container-secondline .secondline_playlist .mejs-inner .mejs-time .mejs-duration {
		color:" . esc_attr( get_theme_mod('secondline_themes_playlist_font_color')) . " !important;
	}
	
	body.secondline-fancy-player #main-container-secondline .secondline_playlist  li.mejs-playlist-selector-list-item.wp-playlist-item.mejs-playlist-selected {
		background:" . esc_attr( get_theme_mod('secondline_themes_playlist_now_playing_bg')) . ";
	}
	
	
	";
	/**
	* Combine the values from above and minifiy them.
	*/
	
	/* Minify Customizer CSS */
	function secondline_plugin_minify_css( $css ) {
		// Remove comments.
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

		// Backup values within single or double quotes.
		preg_match_all( '/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER );
		$count = count( $hit[1] );
		for ( $i = 0; $i < $count; $i++ ) {
			$css = str_replace( $hit[1][ $i ], '##########' . $i . '##########', $css );
		}

		// Remove traling semicolon of selector's last property.
		$css = preg_replace( '/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css );

		// Remove any whitespace between semicolon and property-name.
		$css = preg_replace( '/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css );

		// Remove any whitespace surrounding property-colon.
		$css = preg_replace( '/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css );

		// Remove any whitespace surrounding selector-comma.
		$css = preg_replace( '/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css );

		// Remove any whitespace surrounding opening parenthesis.
		$css = preg_replace( '/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css );

		// Remove any whitespace between numbers and units.
		$css = preg_replace( '/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css );

		// Shorten zero-values.
		$css = preg_replace( '/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css );

		// Constrain multiple whitespaces.
		$css = preg_replace( '/\p{Zs}+/ims', ' ', $css );

		// Remove newlines.
		$css = str_replace( array( "\r\n", "\r", "\n" ), '', $css );

		// Restore backupped values within single or double quotes.
		$count = count( $hit[1] );
		for ( $i = 0; $i < $count; $i++ ) {
			$css = str_replace( '##########' . $i . '##########', $hit[1][ $i ], $css );
		}
		return $css;
	}	
	
	$secondline_themes_custom_css = secondline_plugin_minify_css( $secondline_themes_custom_css );
	wp_add_inline_style( 'secondline-audio-player-styles', wp_strip_all_tags( $secondline_themes_custom_css ) );
	
	
}
add_action( 'wp_enqueue_scripts', 'secondline_themes_customizer_plugin_styles' );
