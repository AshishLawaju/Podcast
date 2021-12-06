<?php
/**
 * @package slt
 */
?>

<?php
    // We need a unique ID that's different on each block re-render inside block editor
    $modal_unique_id = uniqid();
    $secondline_unique_shortcode = 'modal-'.$modal_unique_id;
?>

<a class="button podcast-subscribe-button <?php echo $secondline_unique_shortcode;?>" <?php echo 'onMouseOver="this.style.color=`'. esc_attr( $atts[ SECONDLINE_PSB_PREFIX . 'text_color_hover' ] ) .'`; this.style.backgroundColor=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color_hover' ]) .'`" onMouseOut="this.style.color=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color' ]) .'`; this.style.backgroundColor=`'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color' ]) .'`" style="color:'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'text_color' ]) .'; background-color:'. esc_attr($atts[ SECONDLINE_PSB_PREFIX . 'background_color' ]) .'"';?> href=""><?php echo esc_html($atts[ SECONDLINE_PSB_PREFIX . 'text' ]);?></a>
<!-- Modal HTML embedded directly into document. -->
<div id="secondline-psb-subs-modal" class="<?php echo $secondline_unique_shortcode;?> modal secondline-modal-<?php echo $modal_unique_id;?>">
	<?php                  
		$secondline_psb_subscribe_entries = $atts[ SECONDLINE_PSB_PREFIX . 'repeat_subscribe' ];

		if( !empty($secondline_psb_subscribe_entries) ) {
			echo '<div class="secondline-psb-subscribe-modal"><ul>';
			foreach ( $secondline_psb_subscribe_entries as $key => $entry ) {

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
				if(($secondline_psb_link != '') && ($secondline_psb_platform_slt != '') && ($secondline_psb_platform_slt != 'custom')) {
					echo '<li class="secondline-psb-subscribe-'.esc_attr($secondline_psb_platform_slt).'"><a href="' . esc_url($secondline_psb_link) . '" target="_blank"><img class="secondline-psb-subscribe-img" src="'. SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL .'assets/img/icons/' . esc_attr($secondline_psb_platform_slt) . secondline_psb_icon_extension( $secondline_psb_platform_slt ) .'" alt="' . esc_attr($secondline_psb_platform_text) . '" />' . esc_html($secondline_psb_platform_text) . '</a></li>';
				} elseif(($secondline_psb_link != '') && ($secondline_psb_platform_slt == 'custom')) {
					echo '<li class="secondline-psb-subscribe-'.esc_attr($secondline_psb_platform_slt).'"><a href="' . esc_url($secondline_psb_link) . '" target="_blank"><img class="secondline-psb-subscribe-img" src="'. SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL .'assets/img/icons/' . esc_attr($secondline_psb_platform_slt) . secondline_psb_icon_extension( $secondline_psb_platform_slt ) .'" alt="' . esc_attr($custom_label_secondline) . '" />' . esc_html($custom_label_secondline) . '</a></li>';
				}
			}
			echo '</ul></div>'; ///
		}
	?>                                       
</div>  

<script>
	jQuery(document).ready(function($) {
		 'use strict';
		$('#podcast-subscribe-button-<?php echo $atts['id'];?> .podcast-subscribe-button.<?php echo $secondline_unique_shortcode;?>').on("click", function() {
			$("#secondline-psb-subs-modal.<?php echo $secondline_unique_shortcode;?>.modal.secondline-modal-<?php echo $modal_unique_id;?>").modal({
				fadeDuration: 250,
				closeText: '',
			});
			return false;
		}); 			
	});		
</script>