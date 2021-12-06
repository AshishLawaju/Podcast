<?php
/**
 * TP Pro LazyLoad Images
 *
 * @package TP
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
Class Tp_LazyLoad_Images {
	
	public function tp_change_attribute_form_images( $img_content, $old_attr_name, $new_attr_name ){
			$tagname = 'img';
			if ( ! preg_match_all( '/<' . $tagname . ' [^>]+>/', $img_content, $matches ) ) {
				return $img_content;
			}

			$sel_images = [];

			foreach ( $matches[0] as $image ) {
				$sel_images[] = $image;
			}

			foreach ( $sel_images as $image ) {
				
				$img_content = str_replace(
					$image,
					$this->tp_rename_attribute_for_image(
						$image,
						$old_attr_name,
						$new_attr_name
					),
					$img_content
				);
			}

			return $img_content;
	}

	public function tp_rename_attribute_for_image( $image, $old_attr_name, $new_attr_name ) {
		$tag = 'img';
		
		$old_attr_value = ltrim(
			rtrim(
				trim(
					preg_replace(
						'/(\\<' .
						$tag .
						'[^>]+)(\\s?' .
						$old_attr_name .
						'\\="[^"]+"\\s?)([^>]+)(>)/',
						'${2}',
						$image
					)
				),
				'"'
			),
			$old_attr_name . '="'
		);

		$removed = $this->tp_remove_attribute_from_images(
			$image,
			$old_attr_name
		);

		$image = $this->tp_add_attribute_to_image(
			$removed,
			$new_attr_name,
			$old_attr_value
		);
		
		return $image;
	}

	/**
	 * Remove attribute from HTML Content
	 */
	public function tp_remove_attribute_from_images( $img_content, $attribute ) {
		$tagname = 'img';
		if ( ! preg_match_all( '/<' . $tagname . ' [^>]+>/', $img_content, $matches ) ) {
			return $img_content;
		}

		$select_images = array();

		foreach ( $matches[0] as $image ) {
			$select_images[] = $image;
		}

		foreach ( $select_images as $image ) {
			$img_content = str_replace(
				$image,
				$this->tp_remove_attribute_from_single_image(
					$image,
					$attribute
				),
				$img_content
			);
		}

		return $img_content;
	}

	/**
	 * Remove existing attribute from html content.
	 */
	public function tp_remove_attribute_from_single_image( $image, $attribute ) {
		$tagname = 'img';
		
		return preg_replace(
			'/(\\<' .
			$tagname .
			'[^>]+)(\\s?' .
			$attribute .
			'\\="[^"]+"\\s?)([^>]+)(>)/',
			'${1}${3}${4}',
			$image
		);
	}

	/**
	 * Add an attribute with a value in html and remove attribute exits
	 */
	public function tp_add_attribute_to_image( $image, $attr_name, $attr_value ) {
		$tagname = 'img';
		$update_attr = sprintf(
			' %s="%s"',
			esc_attr( $attr_name ),
			esc_attr( $attr_value )
		);

		$val = preg_replace(
			'/<' . $tagname . ' ([^>]+?)[\\/ ]*>/',
			'<' . $tagname . ' $1' . $update_attr . ' />',
			$this->tp_remove_attribute_from_images( $image, $attr_name )
		);
		
		return $val;
	}
}

if (! function_exists('tp_getAspectRatio')) {
	function tp_getAspectRatio( int $width, int $height ) {
		$aspactRatio =  $width / $height;//tp_getAspectRatio($image_src[1], $image_src[2]);
		$targetWidth = $targetHeight = min(10, max($width, $height));

		if ($aspactRatio < 1) {
			$targetWidth = $targetHeight * $aspactRatio;
		} else {
			$targetHeight = $targetWidth / $aspactRatio;
		}
		return [ $targetWidth  , $targetHeight ];
	}
}

if (! function_exists('tp_has_lazyload')) {
	function tp_has_lazyload() {
		$theplus_options=get_option( 'theplus_api_connection_data' );
		$lazyopt = (!empty($theplus_options['plus_lazyload_opt'])) ? $theplus_options['plus_lazyload_opt'] : '';
		
		if($lazyopt=='enable'){
			return true;
		}else{
			return false;
		}
		
	}
}

if (! function_exists('tp_lazyload_type')) {
	function tp_lazyload_type() {
		$theplus_options=get_option( 'theplus_api_connection_data' );
		$lazyopt = (!empty($theplus_options['plus_lazyload_opt'])) ? $theplus_options['plus_lazyload_opt'] : '';
		$lazyanimopt = (!empty($theplus_options['plus_lazyload_opt_anim'])) ? $theplus_options['plus_lazyload_opt_anim'] : '';
		if($lazyopt=='enable' && !empty($lazyanimopt)){			
			return $lazyanimopt;
			//return 'dbl-circle';	//fade | dbl-circle | circle | blur-img | skeleton
		}
		
	}
}

if (! function_exists('tp_get_image_rander')) {
	function tp_get_image_rander( $id ='', $size = 'full', $attr =[], $posttype = 'attachment' ) {
		if( empty($id) ){
			return '';
		}
		
		if(!empty($posttype) && $posttype=='post' ){
			$get_post = get_post( $id );
	 
			if ( ! $get_post ) {
				return '';
			}
			$id = get_post_thumbnail_id( $get_post );
		}
		
		if( ! wp_get_attachment_image_src( $id ) ){
			return '';
		}
		
		$output = '';
		
		if(tp_has_lazyload()){
			$lazy_type = tp_lazyload_type();
			$attr['data-tp-lazy'] = $lazy_type;
			
			if($lazy_type == 'dbl-circle' || $lazy_type == 'circle' || $lazy_type == 'skeleton'){	
				$output .= '<span class="tp-loader-'.esc_attr($lazy_type).'"></span>';
			}else if($lazy_type == 'blur-img'){
				$image_src = wp_get_attachment_image_src($id, $size);
				
				if(!empty($image_src[1]) && !empty($image_src[2])){
					$aspactRatio =  tp_getAspectRatio($image_src[1], $image_src[2]);
					
					$attr['src'] = wp_get_attachment_image_url( $id, $aspactRatio );
				}
				$attr['data-src'] = wp_get_attachment_image_url( $id, $size );
				
			}
			$attr['class'] = (isset($attr['class']) ? $attr['class'] : '') . ' tp-lazyload';
		}
		
		$get_image = wp_get_attachment_image( $id, $size, false, $attr );
		
		$check_srcset = strpos( $get_image, 'srcset' ) !== false;
		
		if( tp_has_lazyload() ){
			$lazy_type = tp_lazyload_type();
			$output .= '<noscript>' . $get_image . '</noscript>';
			
			$lazyloadImage = new Tp_LazyLoad_Images();
			if($lazy_type != 'blur-img'){
				$get_image = $lazyloadImage->tp_change_attribute_form_images(
					$get_image,
					'src',
					'data-src'
				);
			}
			if ( $check_srcset ) {
				$get_image = $lazyloadImage->tp_change_attribute_form_images(
					$get_image,
					'srcset',
					'data-srcset'
				);
			}
		}
		
		$output = $get_image . $output;

		return $output;
	}
}

function tp_bg_lazyLoad($option =[], $option2 =[]){
	
	if(tp_has_lazyload() && isset($option) && !empty($option) && isset($option['url']) && !empty($option['url'])){
		return ' lazy-background';
	}
	if(tp_has_lazyload() && isset($option2) && !empty($option2) && isset($option2['url']) && !empty($option2['url'])){
		return ' lazy-background';
	}
	return '';
}