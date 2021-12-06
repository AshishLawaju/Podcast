<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

Class L_Plus_Generator
{
	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;
	
	public $transient_widgets;
	public $l_registered_widgets;
    
	public $plus_uid = null;
	public $requires_update;
	
	public function get_caching_option(){
		$theplus_options=get_option( 'theplus_performance' );
		$cacheOpt = (!empty($theplus_options['plus_cache_option'])) ? $theplus_options['plus_cache_option'] : '';
		
		if($cacheOpt=='separate'){
			return true;
		}else{
			return false;
		}
	}
	/**
     * Find Widgets in a page or post
     *
     * @since 2.0
     */
    public function collect_transient_widgets($widget)
    {
        if($widget->get_name() === 'global') {
            $global_widget = new \ReflectionClass(get_class($widget));
			
            $template_data = $global_widget->getProperty('template_data');
			
            $template_data->setAccessible(true);

            if($data_global = $template_data->getValue($widget)) {
				$widget_name=$this->get_global_widgets_use($data_global['content']);
				$widget_options=in_array($widget_name[0],array_keys($this->l_registered_widgets));
				if(!empty($widget_options) && $widget_options=='1'){
					$options=$widget->get_settings_for_display();					
					$this->plus_widgets_options($options,$widget_name[0]);
				}
                $this->transient_widgets = array_merge($this->transient_widgets, $widget_name);				
            }
        } else {
            $this->transient_widgets[] = $widget->get_name();
			$widget_options=in_array($widget->get_name(),array_keys($this->l_registered_widgets));
								
			$options=$widget->get_settings_for_display();
			if(!empty($options["seh_switch"]) && $options["seh_switch"]=='yes'){					
				$this->transient_widgets[] = 'plus-equal-height';
			}
			
			if(tp_has_lazyload()){			
				$this->transient_widgets[] = 'plus-lazyLoad';
			}
			
			if(!empty($widget_options) && $widget_options=='1'){
				$options=$widget->get_settings_for_display();
				$this->plus_widgets_options($options,$widget->get_name());
			}
		}
		
		
    }
	
	/**
	* Check Widgets Options
	* @since 2.0.2
	*/
	public function plus_widgets_options($options='',$widget_name=''){
		if(!empty($options["animation_effects"]) && $options["animation_effects"]!='no-animation'){
			$this->transient_widgets[] = 'plus-velocity';
		}
		
		if(!empty($options["loop_display_button"]) && $options["loop_display_button"]=='yes'){
			$this->transient_widgets[] = 'plus-button-extra';
		}
		
		if(!empty($widget_name) && $widget_name=='tp-button' && !empty($options["btn_hover_effects"])){
			$this->transient_widgets[] = 'plus-content-hover-effect';
		}
		if(!empty($widget_name) && $widget_name=='tp-blog-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
			if(!empty($options["layout"]) && $options["layout"]=='metro'){
				$this->transient_widgets[] = 'plus-listing-metro';
			}
		}
		
		if(!empty($widget_name) && $widget_name=='tp-clients-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
		}
			
		if(!empty($widget_name) && $widget_name=='tp-gallery-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
				}
			if(!empty($options["layout"]) && $options["layout"]=='metro'){
				$this->transient_widgets[] = 'plus-listing-metro';
			}
		}
		if(!empty($widget_name) && $widget_name=='tp-team-member-listout'){			
			if(!empty($options["layout"]) && $options["layout"]=='grid' || $options["layout"]=='masonry' ){
				$this->transient_widgets[] = 'plus-listing-masonry';
			}
		}
		if((!empty($widget_name) && $widget_name=='tp-flip-box') || (!empty($widget_name) && $widget_name=='tp-info-box')){
			if(!empty($options["display_button"]) && $options["display_button"]=='yes'){
				$this->transient_widgets[] = 'plus-button-extra';
			}			
			if(!empty($options["box_hover_effects"])){
				$this->transient_widgets[] = 'plus-content-hover-effect';
			}			
			if((!empty($options["image_icon"]) && $options["image_icon"]=='svg') || (!empty($options["loop_select_icon"]) && $options["loop_select_icon"]=='svg')){
				$this->transient_widgets[] = 'tp-draw-svg';
			}
		}
		
		if(!empty($options["box_hover_effects"]) && !empty($widget_name) && $widget_name=='tp-number-counter'){
			$this->transient_widgets[] = 'plus-content-hover-effect';
		}		
		
		if(!empty($widget_name) && $widget_name=='tp-page-scroll'){
			if(!empty($options["page_scroll_opt"]) && $options["page_scroll_opt"]=='tp_full_page'){
				$this->transient_widgets[] = 'tp-fullpage';
			}
		}		
	}
	
    /**
     * Merge all Files Load
     *
     * @since 2.0
     */
    public function plus_merge_files($paths = array(), $file = 'theplus-style.min.css',$type='')
    {
        $output = '';

        if (!empty($paths)) {
            foreach ($paths as $path) {
                $output .= file_get_contents(l_theplus_library()->secure_path_url($path));
            }
        }
		if(!empty($type) && $type=='css'){			
			// Remove comments
			$output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
			// Remove space after colons
			$output = str_replace(': ', ':', $output);
			// Remove whitespace
			$output = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $output);
			//Remove Last Semi colons
			$output = preg_replace('/;}/', '}', $output);
		}

        return file_put_contents(l_theplus_library()->secure_path_url(L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . $file), $output);
    }

    

    /**
     * Generate scripts and minify.
     *
     * @since 2.0
     */
    public function plus_generate_scripts($elements, $file_name = null)
    {
		
        if (empty($elements)) {
            return;
        }
		
        if (!file_exists(L_THEPLUS_ASSET_PATH)) {
            wp_mkdir_p(L_THEPLUS_ASSET_PATH);
        }

        // default load js and css
        $js_url = array();
		$tp_path_get = L_THEPLUS_PATH;
		if(defined('THEPLUS_VERSION') && defined('THEPLUS_URL')){
			$tp_path_get = THEPLUS_PATH;
		}

        $css_url = array(
			$tp_path_get . DIRECTORY_SEPARATOR . "assets/css/main/plus-extra-adv/plus-extra-adv.min.css",
        );
		
        // collect library scripts & styles
        $js_url = array_merge($js_url, $this->plus_dependency_widgets($elements, 'js'));
        $css_url = array_merge($css_url, $this->plus_dependency_widgets($elements, 'css'));

        // merge files widgets
        $this->plus_merge_files($css_url, ($file_name ? $file_name : 'theplus') . '.min.css','css');
        $this->plus_merge_files($js_url, ($file_name ? $file_name : 'theplus') . '.min.js','js');
    }

	 /**
     * Generate Separate scripts and style.
     *
     * @since 5.0.1
     */
    public function plus_load_separate_file($elements, $file_name = null) {
		
        if (empty($elements)) {
            return;
        }
		
        // default load js and css
        $js_url = array();
		$tp_path_get = L_THEPLUS_PATH;
		if(defined('THEPLUS_VERSION') && defined('THEPLUS_URL')){
			$tp_path_get = THEPLUS_PATH;
		}
        $css_url = array(
			$tp_path_get . DIRECTORY_SEPARATOR . "assets/css/main/plus-extra-adv/plus-extra-adv.min.css",
        );
		
        // collect library scripts & styles
        $js_url = array_merge($js_url, $this->plus_dependency_widgets($elements, 'js'));
        $css_url = array_merge($css_url, $this->plus_dependency_widgets($elements, 'css'));
		
		return ['css' => $css_url, 'js' => $js_url ];
    }

    /**
     * Check if cache files exists
     *
     * @since 2.0
     */
    public function check_cache_files($post_type = null, $post_id = null)
    {
        $css_url = L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'theplus') . ($post_id ? '-' . $post_id : '') . '.min.css';
        $js_url = L_THEPLUS_ASSET_PATH . DIRECTORY_SEPARATOR . ($post_type ? 'theplus-' . $post_type : 'theplus') . ($post_id ? '-' . $post_id : '') . '.min.js';

        if (is_readable(l_theplus_library()->secure_path_url($css_url)) && is_readable(l_theplus_library()->secure_path_url($js_url))) {
			return true;
        }
        return false;
    }

	/**
     * Widgets dependency for modules
     *
     * @since 2.0
     */
    public function plus_dependency_widgets(array $elements, $type)
    {
        $paths = [];
		if(has_filter('theplus_pro_registered_widgets')) {
			$this->l_registered_widgets = apply_filters('theplus_pro_registered_widgets', $this->l_registered_widgets );
		}
        foreach ($elements as $element) {
            if (isset($this->l_registered_widgets[$element])) {
                if (!empty($this->l_registered_widgets[$element]['dependency'][$type])) {
                    foreach ($this->l_registered_widgets[$element]['dependency'][$type] as $path) {
                        $paths[] = $path;
                    }
                }
            } elseif (isset($this->registered_extensions[$element])) {
                if (!empty($this->registered_extensions[$element]['dependency'][$type])) {
                    foreach ($this->registered_extensions[$element]['dependency'][$type] as $path) {
                        $paths[] = $path;
                    }
                }
            }
        }

        return array_unique($paths);
    }
	/**
     * Find global widgets
     * @since 2.0.2
     */
    public function get_global_widgets_use($widgets) {
        $get_widget = [];

        array_walk_recursive($widgets, function($val, $key) use (&$get_widget) {
            if($key == 'widgetType') {
                $get_widget[] = $val;
            }
        });

        return $get_widget;
    }
    /**
     * Generate single post scripts
     *
     * @since 2.0
     */
    public function generate_scripts_frontend() {
		
		if ($this->is_background_running()) {
            return;
        }
		
		if ($this->plus_uid === null) {
            return;
        }
		
        if (l_theplus_library()->is_preview_mode()) {
            return;
        }
		
		if (!$this->requires_update) {
            return;
        }
		
		if(get_option('tp_save_update_at') === false){
			update_option('tp_save_update_at', strtotime('now'),false);
		}
		
		if (get_option('tp_save_update_at') == get_option($this->plus_uid . '_update_at')) {
            return;
        }
		
        $replace = [
            'plus-woocommerce' => 'product-plus',
        ];
		if(has_filter('tp_pro_transient_widgets')) {
			$this->transient_widgets = apply_filters('tp_pro_transient_widgets', $this->transient_widgets);
		}
		
        $elements = array_map(function ($val) use ($replace) {
			$val = str_replace(['theplus-'], [''], $val);
		    return (array_key_exists($val, $replace) ? $replace[$val] : $val);
        }, $this->transient_widgets);
		
		if(has_filter('theplus_pro_registered_widgets')) {
			$this->l_registered_widgets = apply_filters('theplus_pro_registered_widgets', $this->l_registered_widgets );
		}
		
        $elements = array_intersect(array_keys($this->l_registered_widgets), $elements);
		
        $extensions = apply_filters('theplus/section/after_render', $this->transient_extensions);

        $elements = array_unique(array_merge($elements, $extensions));
		
		sort($elements);
		
		global $wp_query;		
        if (is_home() || is_singular() || is_archive() || is_search() || (isset( $wp_query ) && (bool) $wp_query->is_posts_page) || is_404()) {
			
            $queried_object = get_queried_object_id();
			if(is_search()){
				$queried_object = 'search';
			}
			if(is_404()){
				$queried_object = '404';
			}
            $post_type = (is_singular() ? 'post' : 'term');
            $old_elements = (array) get_metadata($post_type, $queried_object, 'theplus_transient_widgets', true);

            // sort two arr for compare
            sort($elements);
            sort($old_elements);

            if ($old_elements != $elements) {
				
                 update_metadata($post_type, $queried_object, 'theplus_transient_widgets', $elements);

            }
			
			update_option($this->plus_uid . 'tp_widgets', $elements, false);
			update_option($this->plus_uid . '_update_at', get_option('tp_save_update_at'), false);
			
			l_theplus_library()->remove_files_unlink($post_type, $queried_object);
			
            // if no cache files, generate new
            if (!$this->check_cache_files($post_type, $queried_object) && !$this->get_caching_option()) {			
                $this->plus_generate_scripts($elements, 'theplus-' . $post_type . '-' . $queried_object);
            }
			
			$tp_url = L_THEPLUS_URL;
			$tp_path = L_THEPLUS_PATH . DIRECTORY_SEPARATOR;
			$tp_version = L_THEPLUS_VERSION;
			if(defined('THEPLUS_VERSION') && defined('THEPLUS_URL')){
				$tp_url = THEPLUS_URL;
				$tp_path = THEPLUS_PATH . DIRECTORY_SEPARATOR;
				$tp_version = THEPLUS_VERSION;
			}
			if(!empty($elements) && $this->get_caching_option()){
				$separate_path = $this->plus_load_separate_file($elements);
						
				if(!empty($separate_path) && isset($separate_path['css']) && !empty($separate_path['css'])){

					foreach( $separate_path['css'] as $key => $path ){
						if(is_readable(l_theplus_library()->secure_path_url($path))){
							$css_sep_url = str_replace( $tp_path, $tp_url, $path);
							$css_file_key = basename($css_sep_url, ".css");
							$css_file_key = basename($css_file_key, ".min");
							
							wp_enqueue_style('theplus-'.$css_file_key,$this->pathurl_security($css_sep_url),false,$tp_version);
						}
					}
				}
				if(!empty($separate_path) && isset($separate_path['js']) && !empty($separate_path['js'])){

					foreach( $separate_path['js'] as $key => $path ){
						if(is_readable(l_theplus_library()->secure_path_url($path))){
							$js_sep_url = str_replace( $tp_path, $tp_url, $path);
							$js_file_key = basename($js_sep_url, ".js");
							$js_file_key = basename($js_file_key, ".min");
							wp_enqueue_script('theplus-'.$js_file_key,$this->pathurl_security($js_sep_url),['jquery'],$tp_version,true);
						}
					}
				}
				
			}
        }		
    }
	
	//Plus Addons Scripts
	public function plus_enqueue_scripts() {
	
		if ( is_admin_bar_showing() && !$this->get_caching_option()) {
			wp_enqueue_script(
				'plus-purge-js',
				$this->pathurl_security(L_THEPLUS_URL . '/assets/js/main/general/theplus-purge.js'),
				['jquery'],
				L_THEPLUS_VERSION,
				true
			);
			$js_inline1 = 'var theplus_ajax_url = "'.admin_url("admin-ajax.php").'";
            var theplus_nonce = "'.wp_create_nonce("theplus-addons").'";';
			echo wp_print_inline_script_tag($js_inline1);			
		}
		
		if (l_theplus_library()->is_preview_mode()) {
			
			// generate fallback scripts
			if (!$this->check_cache_files()) {
				$plus_widget_settings = l_theplus_library()->get_plus_widget_settings();
				if(has_filter('plus_widget_setting')) {
					$plus_widget_settings = apply_filters('plus_widget_setting', $plus_widget_settings);
				}
				$this->plus_generate_scripts($plus_widget_settings);
			}

			// enqueue scripts
			
			if ($this->check_cache_files()) {
				$css_file = L_THEPLUS_ASSET_URL . '/theplus.min.css';
				$js_file = L_THEPLUS_ASSET_URL . '/theplus.min.js';
			} else {
				if(defined('THEPLUS_VERSION')){
					$css_file = THEPLUS_URL . '/assets/css/main/general/theplus.min.css';
					$js_file = THEPLUS_URL . '/assets/js/main/general/theplus.min.js';
				}else{
					$css_file = L_THEPLUS_URL . '/assets/css/main/general/theplus.min.css';
					$js_file = L_THEPLUS_URL . '/assets/js/main/general/theplus.min.js';
				}				
			}
			wp_enqueue_style(
				'plus-editor-css',
				$this->pathurl_security($css_file),
				false,
				L_THEPLUS_VERSION
			);

			wp_enqueue_script(
				'plus-editor-js',
				$this->pathurl_security($js_file),
				['jquery'],
				L_THEPLUS_VERSION,
				true
			);
			$js_inline2 = 'var theplus_ajax_url = "'.admin_url("admin-ajax.php").'";';
			echo wp_print_inline_script_tag($js_inline2);
			// hook extended assets
			do_action('theplus/after_enqueue_scripts', $this->check_cache_files());

		} else {
			global $wp_query;
			if (is_home() || is_singular() || is_archive() || is_search() || (isset( $wp_query ) && (bool) $wp_query->is_posts_page) || is_404()) {
				
				$queried_obj = get_queried_object_id();
				if(is_search()){
					$queried_obj = 'search';
				}
				if(is_404()){
					$queried_obj = '404';
				}
				$post_type = (is_singular() ? 'post' : 'term');
				
				$this->enqueue_frontend_load($post_type, $queried_obj);
			}
		}
	}
	// rules how css will be enqueued on front-end
	protected function enqueue_frontend_load($post_type, $queried_obj){
		$separate_path = [];
		if ($this->requires_update) {
			$elements = array_keys($this->l_registered_widgets);
		} else {
			$elements = get_option($this->plus_uid . 'tp_widgets');
			if($this->get_caching_option()){				
				$separate_path = $this->plus_load_separate_file($elements);				
				l_theplus_library()->remove_files_unlink($post_type, $queried_obj);
			}else{
				if (!$this->check_cache_files($post_type, $queried_obj) && !empty($elements)) {
					$this->plus_generate_scripts($elements, 'theplus-' . $post_type . '-' . $queried_obj);
				}
			}
		}

		// if no widget in page, return
		if (empty($elements)) {
			return;
		}
		
		$tp_url = L_THEPLUS_URL;
		$tp_path = L_THEPLUS_PATH . DIRECTORY_SEPARATOR;
		$tp_version = L_THEPLUS_VERSION;
		if(defined('THEPLUS_VERSION') && defined('THEPLUS_URL')){
			$tp_url = THEPLUS_URL;
			$tp_path = THEPLUS_PATH . DIRECTORY_SEPARATOR;
			$tp_version = THEPLUS_VERSION;
		}
		
		if ($this->requires_update){
			
			if (file_exists(L_THEPLUS_ASSET_PATH . '/theplus.min.css') && file_exists(L_THEPLUS_ASSET_PATH . '/theplus.min.js')) {
				$css_file = L_THEPLUS_ASSET_URL . '/theplus.min.css';
				$js_file = L_THEPLUS_ASSET_URL . '/theplus.min.js';
			}else{
				$css_file = $tp_url . '/assets/css/main/general/theplus.min.css';
				$js_file = $tp_url . '/assets/js/main/general/theplus.min.js';
			}
		}else{
			if ($this->check_cache_files($post_type, $queried_obj)) {
				$css_file = L_THEPLUS_ASSET_URL . '/theplus-' . $post_type . '-' . $queried_obj . '.min.css';
				$js_file = L_THEPLUS_ASSET_URL . '/theplus-' . $post_type . '-' . $queried_obj . '.min.js';
			} else {			
				if (file_exists(L_THEPLUS_ASSET_PATH . '/theplus.min.css') && file_exists(L_THEPLUS_ASSET_PATH . '/theplus.min.js')) {
					$css_file = L_THEPLUS_ASSET_URL . '/theplus.min.css';
					$js_file = L_THEPLUS_ASSET_URL . '/theplus.min.js';
				}else{
					$css_file = $tp_url . '/assets/css/main/general/theplus.min.css';
					$js_file = $tp_url . '/assets/js/main/general/theplus.min.js';
				}
			}
		}
		
		wp_enqueue_script( 'jquery-ui-slider' );//Audio Player
		
		
		$plus_version=get_post_meta( $queried_obj, '_elementor_css', true );
		if(!empty($plus_version) && !empty($plus_version['time'])){
			$plus_version=$plus_version['time'];
		}else{
			$plus_version=time();
		}
		if($this->get_caching_option() && !empty($separate_path)){
			if(isset($separate_path['css']) && !empty($separate_path['css'])){

				foreach( $separate_path['css'] as $key => $path ){
					if(is_readable(l_theplus_library()->secure_path_url($path))){
						$css_sep_url = str_replace( $tp_path, $tp_url, $path);
						$css_file_key = basename($css_sep_url, ".css");
						$css_file_key = basename($css_file_key, ".min");
						wp_enqueue_style('theplus-'.$css_file_key,$this->pathurl_security($css_sep_url),false,$tp_version);
					}
				}
			}
			if(isset($separate_path['js']) && !empty($separate_path['js'])){

				foreach( $separate_path['js'] as $key => $path ){
					if(is_readable(l_theplus_library()->secure_path_url($path))){
						$js_sep_url = str_replace( $tp_path, $tp_url, $path);
						$js_file_key = basename($js_sep_url, ".js");
						$js_file_key = basename($js_file_key, ".min");
						wp_enqueue_script('theplus-'.$js_file_key,$this->pathurl_security($js_sep_url),['jquery'],$tp_version,true);
					}
				}
			}
			
		}else if(!$this->get_caching_option()){
			wp_enqueue_style('theplus-front-css',$this->pathurl_security($css_file),false,$plus_version);
			wp_enqueue_script('theplus-front-js',$this->pathurl_security($js_file),['jquery'],$plus_version,true);
		}
		
		$js_inline3 = 'var theplus_ajax_url = "'.admin_url("admin-ajax.php").'";';
		echo wp_print_inline_script_tag($js_inline3);
		
		// hook extended assets
		do_action('theplus/after_enqueue_scripts', $this->check_cache_files($post_type, $queried_obj));
	}
	
    /**
     * Clear cache files
     *
     * @since 2.0
     */
    public function theplus_smart_perf_clear_cache()
    {
		check_ajax_referer('theplus-addons', 'security');

        // clear cache files
		l_theplus_library()->remove_dir_files(L_THEPLUS_ASSET_PATH);

		wp_send_json(true);
    }
	
	/**
     * Clear cache files
     *
     * @since 2.0.2
     */
    public function theplus_backend_clear_cache()
    {
		check_ajax_referer('theplus-addons', 'security');

        // clear cache files
		l_theplus_library()->remove_backend_dir_files();

		wp_send_json(true);
    }
	
	/**
     * Current Page Clear cache files
     *
     * @since 2.0.2
     */
    public function theplus_current_page_clear_cache()
    {
		check_ajax_referer('theplus-addons', 'security');
		
		$plus_name='';
		if(isset($_POST['plus_name']) && !empty($_POST['plus_name'])){
			$plus_name = sanitize_text_field($_POST['plus_name']);
		}
		if($plus_name== 'theplus-all') {
			// All clear cache files
			l_theplus_library()->remove_dir_files(L_THEPLUS_ASSET_PATH);		
		}else {
			// Current Page cache files
			l_theplus_library()->remove_current_page_dir_files( L_THEPLUS_ASSET_PATH, $plus_name );
		}		
		wp_send_json(true);
    }
	/**
	 * Generate secure path url
	 *
	 * @since v2.0
	 */
	public function pathurl_security($url) {
        return preg_replace(['/^http:/', '/^https:/', '/(?!^)\/\//'], ['', '', '/'], $url);
    }
	
	/**
	 * Add menu in admin bar.
	 *
	 * Adds "Plus Clear Cache" items to the WordPress admin bar.
	 *
	 * Fired by `admin_bar_menu` filter.
	 *
	 * @since 2.1.0
	 */
	public function add_plus_clear_cache_admin_bar( \WP_Admin_Bar $wp_admin_bar ) {
		
		global $wp_admin_bar;

		if ( ! is_super_admin()
			 || ! is_object( $wp_admin_bar ) 
			 || ! function_exists( 'is_admin_bar_showing' ) 
			 || ! is_admin_bar_showing() ) {
			return;
		}
		
		$queried_obj = get_queried_object_id();
		if(is_search()){
			$queried_obj = 'search';
		}
		if(is_404()){
			$queried_obj = '404';
		}
		$post_type = (is_singular() ? 'post' : 'term');
		
		if (file_exists(L_THEPLUS_ASSET_PATH . '/theplus-' . $post_type . '-' . $queried_obj . '.min.css') || file_exists(L_THEPLUS_ASSET_PATH . '/theplus-' . $post_type . '-' . $queried_obj . '.min.js')) {
		
				//Parent
				$wp_admin_bar->add_node( [
					'id'	=> 'theplus-purge-clear',					
					'meta'	=> array(
						'class' => 'theplus-purge-clear',
					),
					'title' => esc_html__( 'The Plus Performance', 'tpebl' ),
					
				] );
				
				//Child Item
				$args = array();
				array_push($args,array(
					'id'		=>	'plus-purge-all-pages',
					'title'		=>	esc_html__( 'Purge All Pages', 'tpebl' ),
					'href'		=> 	'#clear-theplus-all',
					'parent'	=>	'theplus-purge-clear',
					'meta'   	=> 	array( 'class' => 'plus-purge-all-pages' ),
				));

				array_push($args,array(
					'id'     	=>	'plus-purge-current-page',
					'title'		=>	esc_html__( 'Purge Current Page', 'tpebl' ),
					'href'		=>	'#clear-theplus-' . $post_type . '-' . $queried_obj,
					'parent' 	=>	'theplus-purge-clear',
					'meta'   	=>	array( 'class' => 'plus-purge-current-page' ),
				));
				
				sort($args);
				foreach( $args as $each_arg) {
					$wp_admin_bar->add_node($each_arg);
				}
		}
	}
	
	/**
	 * Print style.
	 *
	 * Fired by `admin_head` and `wp_head` filters.
	 *
	 * @since 1.0.0
	 */
	public function plus_purge_clear_print_style() {
		if((is_admin_bar_showing())){
		?>
			<style>#wpadminbar .theplus-purge-clear > .ab-item:before {content: '';background-image: url(<?php echo L_THEPLUS_URL . '/assets/images/theplus-logo-small.png'; ?>) !important;background-size: 20px !important;background-position: center;width: 20px;height: 20px;background-repeat: no-repeat;top: 50%;transform: translateY(-50%);}</style>
		<?php
		}
	}
	
	/**
     * Check if wp running in background
     *
     * @since 5.0.1
     */
    public function is_background_running() {
        if (wp_doing_cron()) {
            return true;
        }

        if (wp_doing_ajax()) {
            return true;
        }
        
        return false;
    }
	
	/**
     * Set transient post save
     *
     * @since 5.0.1
     */
	public function tp_post_save_transient( $post_id, $post, $update ){
		update_option('tp_save_update_at', strtotime('now'), false);
	}
	
	/**
     * Check Post Data
     *
     * @since 5.0.1
     */
	public function init_post_request_data(){
		
		if (is_admin()) {
            return;
        }
		
		if ($this->is_background_running()) {
            return;
        }
		
		$uid = null;
		
		if (!l_theplus_library()->is_preview_mode()) {
			if (is_home() || is_singular() || is_archive() || is_search() || (isset( $wp_query ) && (bool) $wp_query->is_posts_page) || is_404()) {
				$queried_obj = get_queried_object_id();
				
				if(is_search()){
					$queried_obj = 'search';
				}
				if(is_404()){
					$queried_obj = '404';
				}
				$post_type = (is_singular() ? 'post' : 'term');
				$uid = 'theplus-' . $post_type . '-' . $queried_obj;
			}
		}else{
			$uid = 'theplus';
		}
		
		if ($uid && $this->plus_uid == null) {
            $this->plus_uid = $uid;
            $this->requires_update = $this->requires_update();
        }
	}
	
	/**
     * Require Update Data
     *
     * @since 5.0.1
     */
	public function requires_update(){
		
		$widgets = get_option($this->plus_uid . 'tp_widgets');
        $save_updated_at = get_option('tp_save_update_at');
        $post_updated_at = get_option($this->plus_uid . '_update_at');

        if ($widgets === false) {
            return true;
        }
        if ($save_updated_at === false) {
            return true;
        }
        if ($post_updated_at === false) {
            return true;
        }
        if ($save_updated_at != $post_updated_at) {
            return true;
        }

		return false;
	}
	
	public function init(){
		$this->l_registered_widgets = l_registered_widgets();
		
		$this->transient_widgets = [];
		$this->transient_extensions = [];
		if(!defined('THEPLUS_VERSION')){
			add_action('elementor/frontend/before_render', array($this, 'collect_transient_widgets'));
		}
		
        add_action('wp_footer', array($this, 'generate_scripts_frontend'));
		
		add_action( 'save_post', array($this,'tp_post_save_transient'), 10,3 );
		
		add_action('wp', [$this, 'init_post_request_data']);
		if(!$this->get_caching_option()){
			add_action( 'admin_bar_menu', [ $this, 'add_plus_clear_cache_admin_bar' ], 300 );
			add_action('wp_ajax_plus_purge_current_clear', array($this, 'theplus_current_page_clear_cache'));
		
			if(is_user_logged_in()){
				add_action( 'wp_head', [ $this, 'plus_purge_clear_print_style' ]);		
			}
		}
		
		add_action('wp_enqueue_scripts', array($this, 'plus_enqueue_scripts'));
		
		if (is_admin()) {
			add_action('wp_ajax_smart_perf_clear_cache', array($this, 'theplus_smart_perf_clear_cache'));
			add_action('wp_ajax_backend_clear_cache', array($this, 'theplus_backend_clear_cache'));
		}
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
 * Returns instance of L_Plus_Generator
 */
function l_theplus_generator() {
	return L_Plus_Generator::get_instance();
}
