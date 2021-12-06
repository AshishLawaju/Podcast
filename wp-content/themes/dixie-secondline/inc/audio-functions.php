<?php


/* DISABLE DEFAULT POWERPRESS OPTIONS */
function secondline_powerpress_options () {
	if( function_exists('the_powerpress_content') ) {
		static $secondline_player_called;
		/* DISABLE DEFAULT PLAYER LOCATION */		
		$slt_options = get_option('powerpress_general');
		if (!empty($slt_options['display_player'])) {
			static $secondline_player_called = true;
		} else {
			$secondline_player_called = false;
		} 
		$slt_options['display_player'] = '0';		
		
		if ( ($secondline_player_called != true) ) {
			update_option( 'powerpress_general', $slt_options );
            $secondline_player_called = true;
		}		
		
		if ($slt_options['display_player'] = '2') {
			remove_filter('the_content', 'powerpress_content', 10);					
		}		
		
	}
}
add_action('init', 'secondline_powerpress_options');