<?php
add_action( 'cmb2_admin_init', 'l_theplus_ele_team_memmber_setting_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function l_theplus_ele_team_memmber_setting_metaboxes() {

	$prefix = 'theplus_tm_';
	$post_name=l_theplus_team_member_post_name();
	$tema_mem_field = new_cmb2_box(
		array(
			'id'         => 'team_memmber_setting_metaboxes',
			'title'      => esc_html__('TP Team member options', 'tpebl'),
			'object_types'      => array($post_name),
			'context'    => 'normal',
			'priority'   => 'core',
			'show_names' => true, 
		)
	);
	$tema_mem_field->add_field(
		array(
		   'name'	=> esc_html__('Custom Url', 'tpebl'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'custom_url',
			   'type'	=> 'text_url',
		)
	);
	$tema_mem_field->add_field(
		array(
		   'name'	=> esc_html__('Designation', 'tpebl'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'designation',
			   'type'	=> 'text_medium',
		)
	);
    $tema_mem_field->add_field(
		array(
		    'name'	=> esc_html__('Website Url', 'tpebl'),
            'desc'	=> '',
            'id'	=> $prefix . 'website_url',
			'type'	=> 'text',
        )
	);
	$tema_mem_field->add_field(
		array(
		   'name'	=> esc_html__('Website Url', 'tpebl'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'website_url',
			   'type'	=> 'text',
		)
	);
	$tema_mem_field->add_field(
		array(
			'name' => esc_html__( 'Facebook Link', 'tpebl' ),
			'type' => 'text',
			'id'	=> $prefix . 'face_link',
		)
	);
    $tema_mem_field->add_field(
		array(
			'name'	=> esc_html__('Google plus Link', 'tpebl'),
			'desc'	=> '',
			'id'	=> $prefix . 'googgle_link',
			'type'	=> 'text',
		)
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Instagram Link', 'tpebl' ),
				'type' => 'text',
				'id'	=> $prefix . 'insta_link',
		)
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Twitter Link', 'tpebl' ),
				'type' => 'text',
				'id'	=> $prefix . 'twit_link',
		)		
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Linkedin Link', 'tpebl' ),
				'type' => 'text',
				'id'	=> $prefix . 'linked_link',
		)
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Email', 'tpebl' ),
				'type' => 'text',
				'id'	=> $prefix . 'email_link',
		)
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Phone', 'tpebl' ),
				'type' => 'text',
				'id'	=> $prefix . 'phone_link',
		)
	);
}
