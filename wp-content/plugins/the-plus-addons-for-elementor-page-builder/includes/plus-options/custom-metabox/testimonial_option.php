<?php
add_action( 'cmb2_admin_init', 'l_theplus_ele_testimonial_setting_metaboxes' );


function l_theplus_ele_testimonial_setting_metaboxes() {

	$prefix = 'theplus_testimonial_';
	$post_name=l_theplus_testimonial_post_name();
	$testimonial_field = new_cmb2_box(
		array(
			'id'         => 'testimonial_setting_metaboxes',
			'title'      => esc_html__('ThePlus Testimonial Options', 'tpebl'),
			'object_types'      => array($post_name),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true,
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Author Text', 'tpebl'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'author_text',
			   'type'	=> 'wysiwyg',
			   'options' => array(
					'wpautop' => false,
					'media_buttons' => false,
					'textarea_rows' => get_option('default_post_edit_rows', 7),
				),
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Title', 'tpebl'),
			   'desc'	=>  esc_html__('Enter title of testimonial.', 'tpebl'),
			   'id'	=> $prefix . 'title',
			   'type'	=> 'text',
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Logo Upload', 'tpebl'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'logo',
			   'type'	=> 'file',
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Designation', 'tpebl'),
			   'desc'	=>  esc_html__('Enter author Designation', 'tpebl'),
			   'id'	=> $prefix . 'designation',
			   'type'	=> 'text',
		)
	);
	
}
