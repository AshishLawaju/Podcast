<?php

  $slt_get_current_user = get_current_user_id();
  $slt_get_post_id = $post->ID;

  // if the Memberful plugin is activated, check for access/restrictions
  if(function_exists('memberful_can_user_access_post')) {
    if(current_user_can('administrator') || memberful_can_user_access_post($slt_get_current_user, $slt_get_post_id)) {
      get_template_part( 'template-parts/audio-components/audio', 'player');
    }
  // if the Restrict Content Pro plugin is activated, check for access/restrictions
  } elseif (function_exists('rcp_user_can_access')) {
    if(current_user_can('administrator') || rcp_user_can_access($slt_get_current_user, $slt_get_post_id)) {
      get_template_part( 'template-parts/audio-components/audio', 'player');
    }
  // if the MemberPress plugin is activated, check for access/restrictions
  } elseif (function_exists('mepr_plugin_info')) {
    if(current_user_can('administrator') || current_user_can('mepr-auth')) {
      get_template_part( 'template-parts/audio-components/audio', 'player');
    }
  // if the WooCommerce Memberships plugin is activated, check for access/restrictions
  } elseif (function_exists('wc_memberships_user_can')) {
    if(wc_memberships_user_can( $slt_get_current_user, 'view', array( 'post' => $slt_get_post_id ) )) {
      get_template_part( 'template-parts/audio-components/audio', 'player');
    }
  // else: no restrictions on the content.
  } else {
    get_template_part( 'template-parts/audio-components/audio', 'player');
  }
