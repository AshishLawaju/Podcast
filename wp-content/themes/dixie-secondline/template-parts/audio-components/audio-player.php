<?php
if( function_exists('the_powerpress_content') && (!has_post_format( 'video' )) && (get_the_powerpress_content() != '') && (!get_post_meta($post->ID, 'secondline_themes_external_embed', true) )) {
  if(function_exists('spp_sl_sppress_plugin_updater')) {
    // If PP & SPP are active - Display SPP
    $MetaData = get_post_meta($post->ID, 'enclosure', true);
    $MetaParts = explode("\n", $MetaData, 4);
    if (isset($MetaParts[0])) {
      $meta_url = $MetaParts[0];
    };
    if ($meta_url != '') {
      echo do_shortcode('[spp-player url="'. $meta_url . '"]');
    }

  } else {
    the_powerpress_content();
  }
} elseif((get_post_meta($post->ID, '_audiourl', true)) && (function_exists('spp_sl_sppress_plugin_updater')) && (!get_post_meta($post->ID, 'secondline_themes_external_embed', true) )) {

    echo do_shortcode('[spp-player]');

} elseif((function_exists('ssp_episodes')) && (!has_post_format( 'video' )) && (!get_post_meta($post->ID, 'secondline_themes_external_embed', true) ) ) {

    $ssp_player_style = get_option( 'ss_podcasting_player_style', 'standard' );
      if(is_singular('post') || is_singular('podcast') ) {
        if($ssp_player_style != 'standard') {
          echo do_shortcode('[ss_player]');
          // Hide the original audio player and show the HTML5 SSP player
          echo '<div style="display:none;">' . do_shortcode('[podcast_episode]') . '</div>';
        } else {
          echo do_shortcode('[podcast_episode]');
        }
      } else {
        echo do_shortcode('[ss_player]');
      }

} elseif((function_exists('load_podlove_podcast_publisher')) && (!has_post_format( 'video' )) && (!get_post_meta($post->ID, 'secondline_themes_external_embed', true) ) ) {
    echo '<div class="podlove-player">';
      echo do_shortcode('[podlove-episode-web-player]');
    echo '</div>';

} elseif(get_post_meta($post->ID, 'secondline_themes_external_embed', true)) {
  echo '<div class="embed-player-single-slt">';
     if(has_post_format( 'video' ) || (strpos(get_post_meta($post->ID, 'secondline_themes_external_embed', true), 'youtube.com') !== false) || (strpos(get_post_meta($post->ID, 'secondline_themes_external_embed', true), 'vimeo.com') !== false)) {
       echo '<div class="single-video-secondline">';
     }
    // Check to see if we have any oEmbed supported content, otherwise - echo the shortcode/iframe.
    $secondline_oembed = wp_oembed_get(get_post_meta($post->ID, 'secondline_themes_external_embed', true));
    if( !empty($secondline_oembed) && ($secondline_oembed !== '') ) {
      echo wp_oembed_get(get_post_meta($post->ID, 'secondline_themes_external_embed', true));
    } else {
      echo do_shortcode(get_post_meta($post->ID, 'secondline_themes_external_embed', true));
    };

    if(has_post_format( 'video' ) || (strpos(get_post_meta($post->ID, 'secondline_themes_external_embed', true), 'youtube.com') !== false) || (strpos(get_post_meta($post->ID, 'secondline_themes_external_embed', true), 'vimeo.com') !== false)) {
      echo '</div>';
    }

    echo '</div>';

}


;?>
