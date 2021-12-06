<?php
/**
 * @package slt
 */
?>


<?php                  
	$secondline_psb_subscribe_entries = $atts[ SECONDLINE_PSB_PREFIX . 'repeat_subscribe'];

	if($secondline_psb_subscribe_entries != '') {
		echo '<div class="secondline-psb-subscribe-icons">';
		foreach ( (array) $secondline_psb_subscribe_entries as $key => $entry ) {

			$secondline_psb_link = $secondline_psb_platform_slt = '';													

			if ( isset( $entry['secondline_psb_subscribe_platform'] ) ) {
				$secondline_psb_platform_slt = esc_html( $entry['secondline_psb_subscribe_platform'] );
				$secondline_psb_platform_text = str_replace("-", " ", $secondline_psb_platform_slt); 
			}
			if ( isset( $entry['secondline_psb_subscribe_url'] ) ) {
				$secondline_psb_link = esc_html( $entry['secondline_psb_subscribe_url'] );
			}
			if ( isset( $entry['secondline_psb_custom_link_label'] ) ) {
				$custom_label_secondline = esc_html( $entry['secondline_psb_custom_link_label'] );
			} else {
				$custom_label_secondline = $secondline_psb_link;
			}
			if(($secondline_psb_link != '') && ($secondline_psb_platform_slt != '') && ($secondline_psb_platform_slt != 'custom') ) {
				echo '<span class="secondline-psb-subscribe-'.esc_attr($secondline_psb_platform_slt).'"><a title="' . esc_attr($secondline_psb_platform_slt) . '" onMouseOver="this.style.color=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color_hover']) .'`; this.style.backgroundColor=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color_hover']) .'`" onMouseOut="this.style.color=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color']) .'`; this.style.backgroundColor=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color']) .'`" style="color:'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color']) .'; background-color:'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color']) .'" class="button podcast-subscribe-button" href="' . esc_url($secondline_psb_link) . '" target="_blank"><img class="secondline-psb-subscribe-img" src="'. SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL .'assets/img/icons/' . esc_attr($secondline_psb_platform_slt) . secondline_psb_icon_extension( $secondline_psb_platform_slt ) .'" alt="' . esc_attr($secondline_psb_platform_text) . '"  /></a></span>';
			} elseif(($secondline_psb_link != '') && ($secondline_psb_platform_slt == 'custom') ) {
				echo '<span class="secondline-psb-subscribe-'.esc_attr($secondline_psb_platform_slt).'"><a title="' . esc_attr($secondline_psb_platform_slt) . '" onMouseOver="this.style.color=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color_hover']) .'`; this.style.backgroundColor=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color_hover']) .'`" onMouseOut="this.style.color=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color']) .'`; this.style.backgroundColor=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color']) .'`" style="color:'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color']) .'; background-color:'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color']) .'" class="button podcast-subscribe-button" href="' . esc_url($secondline_psb_link) . '" target="_blank"><img class="secondline-psb-subscribe-img" src="'. SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL .'assets/img/icons/' . esc_attr($secondline_psb_platform_slt) . secondline_psb_icon_extension( $secondline_psb_platform_slt ) .'" alt="' . esc_attr($custom_label_secondline) . '"  /></a></span>';
			}
		}
		echo '</div>'; //
	}
?>                                       
