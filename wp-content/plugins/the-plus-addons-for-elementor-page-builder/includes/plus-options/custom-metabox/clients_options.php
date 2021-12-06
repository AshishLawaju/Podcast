<?php
add_action( 'cmb2_admin_init', 'l_theplus_ele_clients_setting_metaboxes' );


function l_theplus_ele_clients_setting_metaboxes() {

	$prefix = 'theplus_clients_';
	$post_name=l_theplus_client_post_name();
	$client_field = new_cmb2_box(
		array(	
			'id'         => 'clients_setting_metaboxes',
			'title'      => esc_html__('TP Clients options', 'tpebl'),
			'object_types'      => array($post_name),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, 
		) 
	);
	$client_field->add_field(
		array(
		   'name'	=> esc_html__('Url', 'tpebl'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'url',
			   'type'	=> 'text_url',
			   'default' => '#',
		)				
	);	

}
