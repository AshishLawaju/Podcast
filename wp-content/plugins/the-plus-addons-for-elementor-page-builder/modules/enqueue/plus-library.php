<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

Class L_Plus_Library
{
	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */	
	private static $instance = null;
	
	public $l_registered_widgets;
    /**
     *  Return array of registered elements.
     *
     * @todo filter output
     */	 
    public function get_l_registered_widgets()
    {
        return array_keys($this->l_registered_widgets);
    }

    /**
     * Return saved settings
     *
     * @since 2.0
     */
    public function get_plus_widget_settings($element = null)
    {
		$replace = [
			'tp_smooth_scroll' => 'tp-smooth-scroll',
			'tp_accordion' => 'tp-accordion',
			'tp_age_gate' => 'tp-age-gate',
			'tp_adv_text_block' => 'tp-adv-text-block',
			'tp_blockquote' => 'tp-blockquote',
			'tp_blog_listout' => 'tp-blog-listout',
			'tp_button' => 'tp-button',
			'tp_caldera_forms' => 'tp-caldera-forms',
			'tp_clients_listout' => 'tp-clients-listout',
			'tp_contact_form_7' => 'tp-contact-form-7',
			'tp_countdown' => 'tp-countdown',		
			'tp_everest_form' => 'tp-everest-form',
			'tp_flip_box' => 'tp-flip-box',
			'tp_gallery_listout' => 'tp-gallery-listout',
			'tp_gravity_form' => 'tp-gravityt-form',			
			'tp_heading_animation' => 'tp-heading-animation',
			'tp_header_extras' => 'tp-header-extras',
			'tp_heading_title' => 'tp-heading-title',
			'tp_hovercard' => 'tp-hovercard',
			'tp_info_box' => 'tp-info-box',
			'tp_messagebox' => 'tp-messagebox',
			'tp_meeting_scheduler' => 'tp-meeting-scheduler',
			'tp_navigation_menu_lite' => 'tp-navigation-menu-lite',
			'tp_ninja_form' => 'tp-ninja-form',
			'tp_number_counter' => 'tp-number-counter',
			'tp_post_title' => 'tp-post-title',
			'tp_post_content' => 'tp-post-content',
			'tp_post_featured_image' => 'tp-post-featured-image',
			'tp_post_meta' => 'tp-post-meta',
			'tp_post_author' => 'tp-post-author',
			'tp_post_comment' => 'tp-post-comment',
			'tp_page_scroll' => 'tp-page-scroll',
			'tp_pricing_table' => 'tp-pricing-table',
			'tp_post_search' => 'tp-post-search',
			'tp_progress_bar' => 'tp-progress-bar',
			'tp_scroll_navigation' => 'tp-scroll-navigation',
			'tp_social_icon' => 'tp-social-icon',
			'tp_tabs_tours' => 'tp-tabs-tours',
			'tp_team_member_listout' => 'tp-team-member-listout',
			'tp_testimonial_listout' => 'tp-testimonial-listout',
			'tp_video_player' => 'tp-video-player',
			'tp_wp_forms' => 'tp-wp-forms',
        ];
		$merge = [
			'plus-backend-editor'
		];
		
		$elements=l_theplus_get_option('general','check_elements');
		if(empty($elements)){
			$elements = array_keys($replace);
		}
		$plus_extras=l_theplus_get_option('general','extras_elements');
		$elements = array_map(function ($val) use ($replace) {
		    return (array_key_exists($val, $replace) ? $replace[$val] : $val);
        }, $elements);
		
		if(in_array('tp-number-counter',$elements)){
			$merge[]= 'tp-draw-svg';
		}
		if(in_array('tp-blog-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-listing-metro';
		}
		if(in_array('tp-gallery-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
			$merge[] = 'plus-listing-metro';
		}
		if(in_array('tp-team-member-listout',$elements)){
			$merge[] = 'plus-listing-masonry';
		}
		if(in_array('tp-page-scroll',$elements)){
			$merge[] = 'tp-fullpage';
		}		
		
		if(!empty($plus_extras) && in_array('section_scroll_animation',$plus_extras)){
			$merge[] ='plus-extras-section-skrollr';
		}
		if(!empty($plus_extras) && in_array('plus_equal_height',$plus_extras)){
			$merge[] ='plus-equal-height';
		}
		
		if(tp_has_lazyload()){
			$merge[] ='plus-lazyLoad';
		}
		
		$result =array_unique($merge);
		$elements =array_merge($result , $elements);
        return (isset($element) ? (isset($elements[$element]) ? $elements[$element] : 0) : array_filter($elements));
    }

    /**
     * Remove files
     * @since 2.0
     */
    public function remove_files_unlink($post_type = null, $post_id = null)
    {
        $css_path_url = $this->secure_path_url(L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'tpebl') . ($post_id ? '-' . $post_id : '') . '.min.css');
        $js_path_url = $this->secure_path_url(L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'tpebl') . ($post_id ? '-' . $post_id : '') . '.min.js');

        if (file_exists($css_path_url)) {
            unlink($css_path_url);
        }

        if (file_exists($js_path_url)) {
            unlink($js_path_url);
        }
    }

    /**
     * Remove in directory files
     * @since 2.0
     */
    public function remove_dir_files($path_url)
    {
        if (!is_dir($path_url) || !file_exists($path_url)) {
            return;
        }

        foreach (scandir($path_url) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            unlink($this->secure_path_url($path_url . DIRECTORY_SEPARATOR . $item));
        }
    }
	
	/**
     * Remove backend in directory files
     * @since 2.0.2
     */
    public function remove_backend_dir_files()
    {
		if (file_exists(L_THEPLUS_ASSET_PATH . '/theplus.min.css')) {
			unlink($this->secure_path_url(L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . '/theplus.min.css'));
		}
		if(file_exists(L_THEPLUS_ASSET_PATH . '/theplus.min.js')){
			unlink($this->secure_path_url(L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . '/theplus.min.js'));
		}
    }
	
	/**
     * Remove current Page in directory files
     * @since 2.1.0
     */
    public function remove_current_page_dir_files( $path_url, $plus_name = '' ) {
	
		if ((!is_dir($path_url) || !file_exists($path_url)) && empty($plus_name)) {
            return;
        }
		
		if (file_exists($path_url . '/'. $plus_name. '.min.css')) {
			unlink($this->secure_path_url($path_url . DIRECTORY_SEPARATOR . '/'. $plus_name . '.min.css'));
		}
		if(file_exists($path_url . '/'. $plus_name. '.min.js')){
			unlink($this->secure_path_url($path_url. DIRECTORY_SEPARATOR . '/'. $plus_name . '.min.js'));
		}
		
    }

    /**
     * Check if elementor preview mode or not 
	 * @since 2.0
     */
    public function is_preview_mode()
    {
        if (isset($_POST['doing_wp_cron'])) {
            return true;
        }
        if (wp_doing_ajax()) {
            return true;
        }
        if (isset($_GET['elementor-preview']) && (int)$_GET['elementor-preview']) {
            return true;
        }
        if (isset($_POST['action']) && $_POST['action'] == 'elementor') {
            return true;
        }

        return false;
    }

    /**
     * Generate secure path url
     * @since 2.0
     */
    public function secure_path_url($path_url)
    {
        $path_url = str_replace(['//', '\\\\'], ['/', '\\'], $path_url);

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path_url);
    }
	/**
	 * Returns the instance.
	 * @since  1.0.0
	 */
	public static function get_instance( $shortcodes = array() ) {
		
		if ( null == self::$instance ) {
			self::$instance = new self( $shortcodes );
		}
		return self::$instance;
	}
}
/**
 * Returns instance of L_Plus_Library
 */
function l_theplus_library() {
	return L_Plus_Library::get_instance();
}