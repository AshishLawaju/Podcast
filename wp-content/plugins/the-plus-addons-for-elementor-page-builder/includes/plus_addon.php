<?php 
	if ( ! defined( 'ABSPATH' ) ) { exit; }
		
	global $theplus_options,$post_type_options;
		
add_image_size( 'tp-image-grid', 700, 700, true);

// Check Html Tag
function l_theplus_html_tag_check(){
	return [ 'div',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'a',
		'span',
		'p',
		'header',
		'footer',
		'article',
		'aside',
		'main',
		'nav',		
		'section',		
	];
}		

function l_theplus_validate_html_tag( $check_tag ) {
	return in_array( strtolower( $check_tag ), l_theplus_html_tag_check() ) ? $check_tag : 'div';
}


/*panel start*/
function theplus_free_import_data_content(){
	echo '<div class="tp-pro-note-title"><p>Collection of 18+ Full page Templates, All PlusWidget Pages, All PlusListing Pages, All PlusExtras Pages, and 300+ Special UI Blocks with our pro version.</p></div>
		<div style="text-align:center;">
			<img style="width:75%;" src="'.L_THEPLUS_URL .'assets/images/panel/plus-design.png" alt="'.esc_attr__('Plus Design','tpebl').'" class="panel-plus-design" />								
		</div>
	<div class="tp-pro-note-link"><a href="https://theplusaddons.com/plus-design/" target="_blank" rel="noopener noreferrer">Check Plus Design</a></div>';
}
add_action('theplus_free_pro_import_data', 'theplus_free_import_data_content');

function theplus_free_purchase_code_content(){
	echo '<div class="tp-pro-note-title"><p style="margin-bottom:40px;">Upgrade to Pro version to get lots more Widgets, Features, PlusDesign and Lot more.</p></div>
		<div style="text-align:center;">
			<img style="width:55%;" src="'.L_THEPLUS_URL .'assets/images/panel/activate.png" alt="'.esc_attr__('Activate','tpebl').'" class="panel-plus-activate" />
		</div>
		<div class="tp-pro-note-link"><a href="https://theplusaddons.com/free-vs-pro-compare/" target="_blank" rel="noopener noreferrer">Compare Free vs Pro</a></div>';
}
add_action('theplus_free_pro_purchase_code', 'theplus_free_purchase_code_content');

function theplus_free_white_label_content(){
	echo '<div class="tp-pro-note-title"><p style="margin-bottom:50px;">White Label our plugin and setup client\'s branding all around. You can update name, description, Icon and even hide the menu from dashboard. Get our pro version to have access of this feature.</p></div>
		<div style="text-align:center;">
			<img style="width:55%;" src="'.L_THEPLUS_URL .'assets/images/panel/white-lable.png" alt="'.esc_attr__('White Lable','tpebl').'" class="panel-plus-white-lable" />
		</div>
	<div class="tp-pro-note-link"><a href="https://theplusaddons.com/free-vs-pro-compare/" target="_blank" rel="noopener noreferrer">Compare Free vs Pro</a></div>';
}
add_action('theplus_free_pro_white_label', 'theplus_free_white_label_content');
/*panel start*/

//user profile social
function L_theplus_user_social_links( $user_contact ) {   
   $user_contact['tp_phone_number'] = __('Phone Number', 'tpebl');
   $user_contact['tp_profile_facebook'] = __('Facebook Link', 'tpebl');
   $user_contact['tp_profile_twitter'] = __('Twitter Link', 'tpebl');
   $user_contact['tp_profile_instagram'] = __('Instagram', 'tpebl');

   return $user_contact;
}
add_filter('user_contactmethods', 'L_theplus_user_social_links',10);

/* WOOCOMMERCE Mini Cart */
function l_theplus_woocomerce_ajax_cart_update($fragments) {
	if(class_exists('woocommerce')) {		
		ob_start();
		?>			
			
			<div class="cart-wrap"><span><?php echo WC()->cart->get_cart_contents_count(); ?></span></div>
		<?php
		$fragments['.cart-wrap'] = ob_get_clean();
		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'l_theplus_woocomerce_ajax_cart_update',10,3);

function l_theplus_get_thumb_url(){
	return L_THEPLUS_ASSETS_URL .'images/placeholder-grid.jpg';
}

class L_Theplus_MetaBox {
	
	public static function get($name) {
		global $post;
		
		if (isset($post) && !empty($post->ID)) {
			return get_post_meta($post->ID, $name, true);
		}
		
		return false;
	}
}
function l_theplus_get_option($options_type,$field){
	$theplus_options=get_option( 'theplus_options' );
	$post_type_options=get_option( 'post_type_options' );
	$values='';
	if($options_type=='general'){
		if(isset($theplus_options[$field]) && !empty($theplus_options[$field])){
			$values=$theplus_options[$field];
		}
	}
	if($options_type=='post_type'){
		if(isset($post_type_options[$field]) && !empty($post_type_options[$field])){
			$values=$post_type_options[$field];
		}
	}
	return $values;
}

function l_theplus_testimonial_post_name(){
	$post_type_options=get_option( 'post_type_options' );
	$testi_post_type=!empty($post_type_options['testimonial_post_type']) ? $post_type_options['testimonial_post_type'] : '';
	$post_name='theplus_testimonial';
	if(isset($testi_post_type) && !empty($testi_post_type)){
		if($testi_post_type=='themes'){
			$post_name=l_theplus_get_option('post_type','testimonial_theme_name');
		}elseif($testi_post_type=='plugin'){
			$get_name=l_theplus_get_option('post_type','testimonial_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=l_theplus_get_option('post_type','testimonial_plugin_name');
			}
		}elseif($testi_post_type=='themes_pro'){
			$post_name='testimonial';
		}
	}else{
		$post_name='theplus_testimonial';
	}
	return $post_name;
}
function l_theplus_testimonial_post_category(){
	$post_type_options=get_option( 'post_type_options' );	
	$testi_post_type=!empty($post_type_options['testimonial_post_type']) ? $post_type_options['testimonial_post_type'] : '';
	$taxonomy_name='theplus_testimonial_cat';
	if(isset($testi_post_type) && !empty($testi_post_type)){
		if($testi_post_type=='themes'){
			$taxonomy_name=l_theplus_get_option('post_type','testimonial_category_name');
		}else if($testi_post_type=='plugin'){
			$get_name=l_theplus_get_option('post_type','testimonial_category_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$taxonomy_name=l_theplus_get_option('post_type','testimonial_category_plugin_name');
			}
		}elseif($testi_post_type=='themes_pro'){
			$taxonomy_name='testimonial_category';
		}
	}else{
		$taxonomy_name='theplus_testimonial_cat';
	}
	return $taxonomy_name;
}
function l_theplus_client_post_name(){
	$post_type_options=get_option( 'post_type_options' );
	$client_post_type=!empty($post_type_options['client_post_type']) ? $post_type_options['client_post_type'] : '';
	$post_name='theplus_clients';
	if(isset($client_post_type) && !empty($client_post_type)){
		if($client_post_type=='themes'){
			$post_name=l_theplus_get_option('post_type','client_theme_name');
		}elseif($client_post_type=='plugin'){
			$get_name=l_theplus_get_option('post_type','client_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=l_theplus_get_option('post_type','client_plugin_name');
			}
		}elseif($client_post_type=='themes_pro'){
			$post_name='clients';
		}
	}else{
		$post_name='theplus_clients';
	}
	return $post_name;
}
function l_theplus_client_post_category(){
	$post_type_options=get_option( 'post_type_options' );
	$client_post_type=!empty($post_type_options['client_post_type']) ? $post_type_options['client_post_type'] : '';
	$post_name='theplus_clients_cat';
	if(isset($client_post_type) && !empty($client_post_type)){
		if($client_post_type=='themes'){
			$post_name=l_theplus_get_option('post_type','client_category_name');
		}else if($client_post_type=='plugin'){
			$get_name=l_theplus_get_option('post_type','client_category_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=l_theplus_get_option('post_type','client_category_plugin_name');
			}
		}elseif($client_post_type=='themes_pro'){
			$post_name='clients_category';
		}
	}else{
		$post_name='theplus_clients_cat';
	}
	return $post_name;
}
function l_theplus_team_member_post_name(){
	$post_type_options=get_option( 'post_type_options' );
	$team_post_type=!empty($post_type_options['team_member_post_type']) ? $post_type_options['team_member_post_type'] : '';
	$post_name='theplus_team_member';
	if(isset($team_post_type) && !empty($team_post_type)){
		if($team_post_type=='themes'){
			$post_name=l_theplus_get_option('post_type','team_member_theme_name');
		}elseif($team_post_type=='plugin'){
			$get_name=l_theplus_get_option('post_type','team_member_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$post_name=l_theplus_get_option('post_type','team_member_plugin_name');
			}
		}elseif($team_post_type=='themes_pro'){
			$post_name='team_member';
		}
	}else{
		$post_name='theplus_team_member';
	}
	return $post_name;
}
function l_theplus_team_member_post_category(){
	$post_type_options=get_option( 'post_type_options' );
	$team_post_type=!empty($post_type_options['team_member_post_type']) ? $post_type_options['team_member_post_type'] : '';
	$taxonomy_name='theplus_team_member_cat';
	if(isset($team_post_type) && !empty($team_post_type)){
		if($team_post_type=='themes'){
			$taxonomy_name=l_theplus_get_option('post_type','team_member_category_name');
		}else if($team_post_type=='plugin'){
			$get_name=l_theplus_get_option('post_type','team_member_category_plugin_name');
			if(isset($get_name) && !empty($get_name)){
				$taxonomy_name=l_theplus_get_option('post_type','team_member_category_plugin_name');
			}
		}elseif($team_post_type=='themes_pro'){
			$taxonomy_name='team_member_category';
		}
	}else{
		$taxonomy_name='theplus_team_member_cat';
	}
	return $taxonomy_name;
}
function l_theplus_styling_option(){	
	$theplus_styling_data=get_option( 'theplus_styling_data' );
	
	$css_rules=$js_rules='';
	if(!empty($theplus_styling_data['theplus_custom_css_editor'])){
		$css_rules .='<style>';	
			$theplus_custom_css_editor=$theplus_styling_data['theplus_custom_css_editor'];
			$css_rules .=$theplus_custom_css_editor;
		$css_rules .='</style>';
	}	
	echo $css_rules;
	
	if(!empty($theplus_styling_data['theplus_custom_js_editor'])){		
			$theplus_custom_js_editor=$theplus_styling_data['theplus_custom_js_editor'];
			$js_rules =$theplus_custom_js_editor;
			echo wp_print_inline_script_tag($js_rules);
	}
	
}
add_action('wp_head', 'l_theplus_styling_option');

function l_theplus_scroll_animation(){	
	
	$value= '85%';
	
	return $value;
}
function l_theplus_excerpt($limit) {
	if(method_exists('WPBMap', 'addAllMappedShortcodes')) {
		WPBMap::addAllMappedShortcodes();
	}
		global $post;
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		} else {
			$excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	
	return $excerpt;
}
function l_limit_words($string, $word_limit){
	$words = explode(" ",$string);
	return implode(" ",array_splice($words,0,$word_limit));
}	
function l_theplus_get_title($limit) {
	if(method_exists('WPBMap', 'addAllMappedShortcodes')) {
		WPBMap::addAllMappedShortcodes();
	}
		global $post;
		$title = explode(' ', get_the_title(), $limit);
		if (count($title)>=$limit) {
			array_pop($title);
			$title = implode(" ",$title).'...';
		} else {
			$title = implode(" ",$title);
		}	
		$title = preg_replace('`[[^]]*]`','',$title);
	
	return $title;
}
function l_theplus_loading_image_grid($postid='',$type=''){
	global $post;
	$content_image='';
	if($type!='background'){		
		$image_url=L_THEPLUS_ASSETS_URL .'images/placeholder-grid.jpg';
		$content_image='<img width="600" height="600" loading="lazy" src="'.esc_url($image_url).'" alt="'.esc_attr(get_the_title()).'"/>';
		
		return $content_image;
	
	}elseif($type=='background'){
	
		$image_url=L_THEPLUS_ASSETS_URL .'images/placeholder-grid.jpg';
		$data_src='style="background-image:url('.esc_url($image_url).');" ';
		
		return $data_src;
		
	}
}
function l_theplus_loading_bg_image($postid=''){
	global $post;
	$content_image='';
	if(!empty($postid)){
		$featured_image=get_the_post_thumbnail_url($postid,'full');
		if(empty($featured_image)){
			$featured_image=l_theplus_get_thumb_url();
		}
		$content_image='style="background-image:url('.esc_url($featured_image).');"';
		return $content_image;
	}else{
	return $content_image;
	}
}
function l_theplus_array_flatten($array) {
	  if (!is_array($array)) { 
		return FALSE; 
	  } 
	  $result = array(); 
	  foreach ($array as $key => $value) { 
		if (is_array($value)) { 
		  $result = array_merge($result, l_theplus_array_flatten($value)); 
		} 
		else { 
		  $result[$key] = $value; 
		} 
	  } 
	  return $result; 
}
function l_theplus_createSlug($str, $delimiter = '-'){
	
	$slug=preg_replace('/[^A-Za-z0-9-]+/', $delimiter, $str);
	return $slug;
	
} 

if(!function_exists('plus_simple_crypt')){
	function plus_simple_crypt( $string, $action = 'dy' ) {
	    $secret_key = 'PO$_key';
	    $secret_iv = 'PO$_iv';
	    $output = false;
	    $encrypt_method = "AES-128-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
	    if( $action == 'ey' ) {
	        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    }
	    else if( $action == 'dy' ){
	        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    }
	 
	    return $output;
	}
}


add_action('elementor/widgets/widgets_registered', function($widgets_manager){
  $elementor_widget_blacklist = [
  'plus-elementor-widget',
];

  foreach($elementor_widget_blacklist as $widget_name){
    $widgets_manager->unregister_widget_type($widget_name);
  }
}, 15);

function l_registered_widgets(){
	// widgets class map
	return apply_filters('theplus/l_registered_widgets', [
		
		'tp-adv-text-block' => [
			'dependency' => [],
		],
		'tp-accordion' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/tabs-tours/plus-tabs-tours.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/accordion/plus-accordion.min.js',
				],
			],
		],
		'tp-age-gate' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/age-gate/plus-age-gate.min.css',
				],
				'js' => [
					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/age-gate/plus-age-gate.min.js',
				],
			],
		],
		'tp-blockquote' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/block-quote/plus-block-quote.css',
				],
			],
		],
		'tp-blog-listout' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/blog-list/plus-blog-list.min.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'plus-listing-metro' => [
			'dependency' => [
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-metro-list.min.js',
				],
			],
		],
		'plus-listing-masonry' => [
			'dependency' => [
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/isotope.pkgd.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/packery-mode.pkgd.min.js',
				],
			],
		],
		'tp-button' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-button.min.css',
				],
			],
		],
		'tp-caldera-forms' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-caldera-form.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/forms-style/plus-caldera-form.js',
				],
			],
		],
		'tp-contact-form-7' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-cf7-style.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/forms-style/plus-cf7-form.js',
				],
			],
		],
		'tp-clients-listout' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/client-list/plus-client-list.css',					
				],
				'js' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-countdown' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/countdown/plus-countdown.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/jquery.downCount.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/countdown/plus-countdown.min.js',
				],
			],
		],
		'tp-everest-form' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-everest-form.css',
				],
			],
		],
		'tp-smooth-scroll' => [
			'dependency' => [
				'js' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/smooth-scroll.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/smooth-scroll/plus-smooth-scroll.min.js',
				],
			],
		],
		'tp-flip-box' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/info-box/plus-info-box.min.css',
				],
			],
		],		
		'tp-gallery-listout' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/gallery-list/plus-gallery-list.min.css',					
				],
				'js' => [			
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-gravityt-form' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-gravity-form.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/forms-style/plus-gravity-form.js',
				]
			],
		],		
		'tp-heading-animation' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/heading-animation/plus-heading-animation.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/heading-animation/plus-heading-animation.min.js',
				]
			],
		],
		'tp-header-extras' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/header-extras/plus-header-extras.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/header-extras/plus-header-extras.min.js',
				],
			],
		],
		'tp-heading-title' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/heading-title/plus-heading-title.min.css',
				],
			],
		],
		'tp-info-box' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/info-box/plus-info-box.min.css',
				],
			],
		],
		'tp-messagebox' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/messagebox/plus-messagebox.min.css',
				],
				'js' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/messagebox/plus-messagebox.min.js',
				],
			],
		],
		'tp-navigation-menu-lite' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/navigation-menu-lite/plus-nav-menu-lite.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/navigation-menu-lite/plus-nav-menu-lite.min.js',
				],
			],
		],
		'tp-ninja-form' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/forms-style/plus-ninja-form.css',
				],
			],
		],
		'tp-number-counter' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/number-counter/plus-number-counter.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/numscroller.js',
				],
			],
		],
		'tp-post-featured-image' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-feature-image/plus-post-image.min.css',					
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/post-feature-image/plus-post-feature-image.min.js',
				],
			],
		],
		'tp-post-title' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-title/plus-post-title.min.css',					
				],				
			],
		],
		'tp-post-content' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-content/plus-post-content.min.css',					
				],				
			],
		],
		'tp-post-meta' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-meta-info/plus-post-meta-info.min.css',
				],
				
			],
		],
		'tp-post-author' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-author/plus-post-author.min.css',
				],				
			],
		],
		'tp-post-comment' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-comment/plus-post-comment.min.css',
				],				
			],
		],
		'tp-post-navigation' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/post-navigation/plus-post-navigation.min.css',
				],				
			],
		],
		'tp-page-scroll' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/page-scroll/plus-page-scroll.min.css',
				],
				'js'  => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/page-scroll/plus-page-scroll.min.js',
				],
			],
		],
		'tp-fullpage' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/fullpage.css',
				],
				'js'  => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/fullpage.js',
				],
			],
		],
		'tp-pricing-table' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/pricing-table/plus-pricing-table.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/pricing-table/plus-pricing-table.min.js',
				],
			],
		],
		'tp-post-search' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/mailchimp/plus-mailchimp.css',
				],
			],
		],
		'tp-progress-bar' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/progress-piechart/plus-progress-piechart.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/extra/circle-progress.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/progress-bar/plus-progress-bar.min.js',
				],
			],
		],
		'tp-scroll-navigation' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/scroll-navigation/plus-scroll-navigation.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/pagescroll2id.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/js/main/scroll-navigation/plus-scroll-navigation.min.js',
				],
			],
		],
		'tp-social-icon' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/social-icon/plus-social-icon.min.css',
				],				
			],
		],
		'tp-tabs-tours' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/tabs-tours/plus-tabs-tours.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/tabs-tours/plus-tabs-tours.min.js',
				],
			],
		],
		'tp-team-member-listout' => [
			'dependency' => [
				'css' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/team-member-list/plus-team-member.css',
				],
				'js' => [					
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/posts-listing/plus-posts-listing.min.js',
				],
			],
		],
		'tp-testimonial-listout' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/extra/slick.min.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/extra/tp-bootstrap-grid.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-slick-carousel.min.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/testimonial/plus-testimonial.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/imagesloaded.pkgd.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/slick.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-slick-carousel.min.js',
				],
			],
		],
		'tp-video-player' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/extra/lity.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/video-player/plus-video-player.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/lity.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/video-player/plus-video-player.min.js',
				],
			],
		],
		'tp-wp-forms' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/css/main/forms-style/plus-wpforms-form.css',
				],
			],
		],
		'plus-velocity' => [
			'dependency' => [
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.ui.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-animation-load.min.js',
				],
			],
		],
		'plus-content-hover-effect' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-content-hover-effect.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/js/main/general/plus-content-hover-effect.min.js',
				],
			],
		],
		'plus-button' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-button.min.css',
				],
			],
		],
		'plus-button-extra' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/plus-extra-adv/plus-button-extra.min.css',
				],
			],
		],
		'plus-equal-height' => [
			'dependency' => [
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/equal-height/plus-equal-height.min.js',
				],
			],
		],
		'plus-lazyLoad' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .'assets/css/main/lazy_load/tp-lazy_load.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/lazyload.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/lazy_load/tp-lazy_load.js',
				],
			],
		],
		'plus-backend-editor' => [
			'dependency' => [
				'css' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-button.min.css',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/css/main/plus-extra-adv/plus-content-hover-effect.min.css',
				],
				'js' => [
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/jquery.waypoints.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/general/modernizr.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/extra/velocity/velocity.ui.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/plus-extra-adv/plus-backend-editor.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR . 'assets/js/main/general/plus-animation-load.min.js',
					L_THEPLUS_PATH . DIRECTORY_SEPARATOR .  'assets/js/main/general/plus-content-hover-effect.min.js',
				],
			],
		],
	]);
}