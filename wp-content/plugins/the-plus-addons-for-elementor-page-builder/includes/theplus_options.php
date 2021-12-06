<?php	
use Elementor\Plugin;
if (!defined('ABSPATH')) {
    exit;
}

class L_Theplus_Elementor_Plugin_Options
{
    
    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'theplus_options';
    
    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected $option_metabox = array();
    
    /**
     * Options Page title
     * @var string
     */
    protected $title = '';
	
	/**
     * Widgets
     * @version 5.0
     */
	public $widgets = array();
    
    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';
    protected $options_pages = array();
	protected $widget_lists  = [];
	protected $plus_extra_lists = [];
    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct()
    {
        // Set our title
		add_action( 'admin_enqueue_scripts', [ $this,'theplus_options_scripts'] );
		if(defined('THEPLUS_VERSION')){
			$options = get_option( 'theplus_white_label' );
			$this->title = (!empty($options['tp_plugin_name'])) ? $options['tp_plugin_name'] : 'ThePlus Settings';
		}else{
			$this->title = esc_html__('ThePlus Settings', 'tpebl');
		}
        
        require_once L_THEPLUS_INCLUDES_URL.'plus-options/cmb2-conditionals.php';
        // Set our CMB fields
        $this->fields = array(
        );
		$this->widget_listout();
		$this->plus_extra_listout();
		add_action( 'admin_post_theplus_widgets_opts_save', array( $this,'theplus_widgets_opts_save_action') );
		add_action('wp_ajax_theplus_widget_search', array($this, 'theplus_widget_search'));
		
		//Elementor widget
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'tp_ele_unregister_widgets' ), 15 );
		add_action( 'admin_post_tp_ele_widgets_opts_save', array( $this,'ele_widgets_opts_save_action') );
		
    }
    
	/**
     * Version 5.0
     * @Elementor Widget Categories
     */
	public function ele_get_categories() {
		return array(
			'basic',
			'general',
			'woocommerce-elements',
			'wordpress',			
			'pro-elements',
			'theme-elements',
		);
	}	
	
	/**
     * Version 5.0
     * @Elementor Get Widget
     */
	public function tp_ele_get_registered_widgets() {
		if ( ! empty( $this->widgets ) ) {
			return $this->widgets;
		}
		
		$types = Elementor\Plugin::instance()->widgets_manager->get_widget_types();
		
		$ele_cat = $this->ele_get_categories();
		
		$widgets = array();

		foreach ( $types as $type ) {
			$ele_widget_cat = $type->get_categories();
			
			if ( ! in_array( $ele_widget_cat[0], $ele_cat, true ) ) {
				continue;
			}			
			$widgets[ $type->get_name() ] = $type->get_title();
		}
		
		if ( isset( $widgets['common'] ) ) {
			unset( $widgets['common'] );
		}
		
		asort( $widgets );
		$this->widgets = $widgets;
		$option_name='ele_default_plus_options';
		$value='1';
		$deprecated = null;
		$autoload = 'no';
		if ( is_admin() && get_option( $option_name ) !== false ) {
		} else if( is_admin() ){
			$default_load=get_option( 'theplus_elementor_widget' );
			if ( $default_load !== false && $default_load!='' ) {
				add_option( $option_name,$value, $deprecated, $autoload );
			}else{
				$ele_wid_options=get_option( 'theplus_elementor_widget' );
				$ele_wid_options['elementor_check_elements']= array_keys($widgets);
				add_option( 'theplus_elementor_widget',$ele_wid_options, $deprecated, $autoload );
				add_option( $option_name,$value, $deprecated, $autoload );
			}

		}
		
		return $widgets;
	}
	
	public function ele_widgets_opts_save_action() {
		$action_page = 'theplus_elementor_widget';
		if(isset($_POST["ele-submit-key"]) && !empty($_POST["ele-submit-key"]) && $_POST["ele-submit-key"]=='Save'){
			
			if ( ! isset( $_POST['nonce_ele_options'] ) || ! wp_verify_nonce( $_POST['nonce_ele_options'], 'nonce_ele_options_action' ) ) {
			   wp_safe_redirect(admin_url('admin.php?page='.$action_page));
			} else {
			
				if ( FALSE === get_option($action_page) ){
					$default_value = array('elementor_check_elements' => '');
					add_option($action_page,$default_value);
					wp_safe_redirect(admin_url('admin.php?page=theplus_elementor_widget'));
				}
				else{
					$update_value=[];
					if(isset($_POST['elementor_check_elements']) && !empty($_POST['elementor_check_elements'])){
						$update_value['elementor_check_elements'] = $_POST['elementor_check_elements'];						
					}else if(empty($_POST['elementor_check_elements'])){
						$update_value['elementor_check_elements'] = '';					
					}
					
					update_option( $action_page, $update_value );
					wp_safe_redirect(admin_url('admin.php?page='.$action_page));
					
				}
			}
			
		}else{
			wp_safe_redirect(admin_url('admin.php?page='.$action_page));
		}
	}
	
	/**
     * Version 5.0
     * @Elementor Unregister Widget
     */
	public function tp_ele_unregister_widgets() {
		$elementor = Elementor\Plugin::instance();
		if ( ! $elementor->editor->is_edit_mode() ) {
			return;
		}

		$selected_widgets = get_option( 'theplus_elementor_widget' );
		$elewid = array_keys($this->tp_ele_get_registered_widgets());
				
		if(!empty($selected_widgets) && isset($selected_widgets['elementor_check_elements'])){			
		$get_unreg = array_diff($elewid,$selected_widgets['elementor_check_elements']);
			foreach ( $get_unreg as $key => $widget ) {
				$elementor->widgets_manager->unregister_widget_type( $widget );
			}
		}
	}
	
    /**
     * Initiate our hooks
     * @since 1.0.0
     */
	public function theplus_options_scripts() {
		wp_enqueue_script( 'cmb2-conditionals', L_THEPLUS_URL .'includes/plus-options/cmb2-conditionals.js', array() );
		wp_enqueue_script('thickbox', null, array('jquery'));
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
	}

    public function hooks()
    {
        add_action('admin_init', array(
            $this,
            'init'
        ));
        add_action('admin_menu', array(
            $this,
            'add_options_page'
        ));
    }
    
    /**
     * Register our setting to WP
     * @since  1.0.0
     */
    public function init()
    {
        //register_setting( $this->key, $this->key );
        $option_tabs = self::option_fields();
        foreach ($option_tabs as $index => $option_tab) {
            register_setting($option_tab['id'], $option_tab['id']);
        }
    }
	
	public function theplus_widgets_opts_save_action() {
		$action_page = 'theplus_options';
		if(isset($_POST["submit-key"]) && !empty($_POST["submit-key"]) && $_POST["submit-key"]=='Save'){
			
			if ( ! isset( $_POST['nonce_theplus_options'] ) || ! wp_verify_nonce( $_POST['nonce_theplus_options'], 'nonce_theplus_options_action' ) ) {
			   wp_safe_redirect(admin_url('admin.php?page='.$action_page));
			} else {
			l_theplus_library()->remove_backend_dir_files();
				if ( FALSE === get_option($action_page) ){
					$default_value = array('check_elements' => '','extras_elements' => '');
					add_option($action_page,$default_value);
					wp_safe_redirect(admin_url('admin.php?page=theplus_options'));
				}
				else{
					$update_value=[];
					if(isset($_POST['check_elements']) && !empty($_POST['check_elements'])){
						$update_value['check_elements'] = $_POST['check_elements'];						
					}else if(empty($_POST['check_elements'])){
						$update_value['check_elements'] = '';					
					}
					
					if(isset($_POST['extras_elements']) && !empty($_POST['extras_elements'])){
						$update_value['extras_elements'] = $_POST['extras_elements'];
					}else if(empty($_POST['extras_elements'])){
						$update_value['extras_elements'] = '';
					}
					
					update_option( $action_page, $update_value );
					wp_safe_redirect(admin_url('admin.php?page='.$action_page));
					
				}
			}
			
		}else{
			wp_safe_redirect(admin_url('admin.php?page='.$action_page));
		}
	}
	public function widget_listout(){
		$this->widget_lists = [
			'tp_accordion' => [
				'label' => esc_html__('Accordion','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/accordion/',
				'docUrl' => 'https://docs.posimyth.com/tpae/accordion/',
				'videoUrl' => 'https://www.youtube.com/embed/9wy4Pgs_WcU',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 352 512"><path d="M176 0C73.05 0-.12 83.54 0 176.24c.06 44.28 16.5 84.67 43.56 115.54C69.21 321.03 93.85 368.68 96 384l.06 75.18c0 3.15.94 6.22 2.68 8.84l24.51 36.84c2.97 4.46 7.97 7.14 13.32 7.14h78.85c5.36 0 10.36-2.68 13.32-7.14l24.51-36.84c1.74-2.62 2.67-5.7 2.68-8.84L256 384c2.26-15.72 26.99-63.19 52.44-92.22C335.55 260.85 352 220.37 352 176 352 78.8 273.2 0 176 0zm47.94 454.31L206.85 480h-61.71l-17.09-25.69-.01-6.31h95.9v6.31zm.04-38.31h-95.97l-.07-32h96.08l-.04 32zm60.4-145.32c-13.99 15.96-36.33 48.1-50.58 81.31H118.21c-14.26-33.22-36.59-65.35-50.58-81.31C44.5 244.3 32.13 210.85 32.05 176 31.87 99.01 92.43 32 176 32c79.4 0 144 64.6 144 144 0 34.85-12.65 68.48-35.62 94.68zM176 64c-61.75 0-112 50.25-112 112 0 8.84 7.16 16 16 16s16-7.16 16-16c0-44.11 35.88-80 80-80 8.84 0 16-7.16 16-16s-7.16-16-16-16z"/></svg>',
				'keyword' => ['accordion', 'tabs', 'toggle','faq'],
			],
			'tp_adv_text_block' => [
				'label' => esc_html__('TP Text Block','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advance-text-block/',
				'docUrl' => 'https://docs.posimyth.com/tpae/advanced-text-block/',
				'videoUrl' => 'https://www.youtube.com/embed/SsyUaK_f3pQ',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zm-22.6 22.7c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9zM336 480H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304c0 8.8-7.2 16-16 16zm-48-244v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12z"/></svg>',
				'keyword' => ['text block','advance text block'],
			],
			'tp_advanced_typography' => [
				'label' => esc_html__('Advanced Typography','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advanced-typography/',
				'docUrl' => 'https://docs.posimyth.com/tpae/advanced-typography/',
				'videoUrl' => 'https://www.youtube.com/embed/_zdX4iGcbtA',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M440 0H296a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h56v224a128 128 0 0 1-256 0V32h56a8 8 0 0 0 8-8V8a8 8 0 0 0-8-8H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h56v224c0 88.22 71.78 160 160 160s160-71.78 160-160V32h56a8 8 0 0 0 8-8V8a8 8 0 0 0-8-8zm0 480H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8z"/></svg>',
				'keyword' => ['advanced typography'],
			],
			'tp_advanced_buttons' => [
				'label' => esc_html__('Advanced Buttons','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advanced-buttons/',
				'docUrl' => 'https://docs.posimyth.com/tpae/advanced-buttons/',
				'videoUrl' => 'https://www.youtube.com/embed/BxIrCaIRAE0',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M504.485 264.485c-4.686-4.686-12.284-4.686-16.971 0l-67.029 67.029c-7.56 7.56-2.206 20.485 8.485 20.485h49.129C461.111 420.749 390.501 473.6 304 479.452V192h52c6.627 0 12-5.373 12-12v-8c0-6.627-5.373-12-12-12h-52v-34.016c28.513-7.339 49.336-33.833 47.933-64.947-1.48-32.811-28.101-59.458-60.911-60.967C254.302-1.619 224 27.652 224 64c0 29.821 20.396 54.879 48 61.984V160h-52c-6.627 0-12 5.373-12 12v8c0 6.627 5.373 12 12 12h52v287.452C185.498 473.6 114.888 420.749 97.901 352h49.129c10.691 0 16.045-12.926 8.485-20.485l-67.029-67.03c-4.686-4.686-12.284-4.686-16.971 0l-67.029 67.03C-3.074 339.074 2.28 352 12.971 352h52.136C83.963 448.392 182.863 512 288 512c110.901 0 204.938-68.213 222.893-160h52.136c10.691 0 16.045-12.926 8.485-20.485l-67.029-67.03zM256 64c0-17.645 14.355-32 32-32s32 14.355 32 32-14.355 32-32 32-32-14.355-32-32zM61.255 320L80 301.255 98.745 320h-37.49zm416 0L496 301.255 514.745 320h-37.49z"/></svg>',
				'keyword' => ['buttons', 'advance buttons', 'call to action buttons', 'CTA buttons', 'download buttons', 'creative buttons'],
			],			
			'tp_shape_divider' => [
				'label' => esc_html__('Advanced Separators','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advanced-separators/',
				'docUrl' => 'https://docs.posimyth.com/tpae/animated-separator/',
				'videoUrl' => 'https://www.youtube.com/embed/REW41xU0aRg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M571.7 238.8c2.8-9.9 4.3-20.2 4.3-30.8 0-61.9-50.1-112-112-112-16.7 0-32.9 3.6-48 10.8-31.6-45-84.3-74.8-144-74.8-94.4 0-171.7 74.5-175.8 168.2C39.2 220.2 0 274.3 0 336c0 79.6 64.4 144 144 144h368c70.7 0 128-57.2 128-128 0-47-25.8-90.8-68.3-113.2zM512 448H144c-61.9 0-112-50.1-112-112 0-56.8 42.2-103.7 97-111-.7-5.6-1-11.3-1-17 0-79.5 64.5-144 144-144 60.3 0 111.9 37 133.4 89.6C420 137.9 440.8 128 464 128c44.2 0 80 35.8 80 80 0 18.5-6.3 35.6-16.9 49.2C573 264.4 608 304.1 608 352c0 53-43 96-96 96z"/></svg>',
				'keyword' => ['advanced separators','separators','divider'],
			],
			'tp_advertisement_banner' => [
				'label' => esc_html__('Advertisement Banner','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advrtsment-banner/',
				'docUrl' => 'https://docs.posimyth.com/tpae/advertisement-banner/',
				'videoUrl' => 'https://www.youtube.com/embed/ac9R_tQnh1c',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M372 32c-19.9 0-36 16.1-36 36v172c0 64-40 96-79.9 96-40 0-80.1-32-80.1-96V68c0-19.9-16.1-36-36-36H36.4C16.4 32 .2 48.3.4 68.4c.3 24.5.6 58.4.7 91.6H0v32h1.1C1 218.3.7 242 0 257.3 0 408 136.2 504 256.8 504 377.5 504 512 408 512 257.3V68c0-19.9-16.1-36-36-36H372zM36.5 68H140v92H37.1c-.1-33.4-.4-67.4-.6-92zM476 258.1c-.1 30.4-6.6 59.3-19.4 85.8-11.9 24.9-29 47.2-50.8 66.3-20.6 18.1-45.2 32.9-71.2 42.9-25.5 9.8-52.4 15-77.9 15-25.5 0-52.5-5.2-78.2-15-26.2-10-51-24.9-71.8-43-22-19.2-39.2-41.5-51.3-66.3-12.9-26.5-19.4-55.3-19.6-85.6.7-15.9 1-39.7 1.1-66.1H140v48c0 49.2 18.9 79.7 34.8 96.6 10.8 11.5 23.5 20.4 37.8 26.5 13.8 5.9 28.5 8.9 43.5 8.9s29.7-3 43.5-8.9c14.3-6.1 27-15 37.7-26.5 15.8-16.9 34.7-47.4 34.7-96.6v-48h102.9c.1 26.2.4 50.1 1.1 66zM372 160V68h103.5c-.3 24.6-.6 58.6-.6 92H372z"/></svg>',
				'keyword' => ['advertisement','banner','advertisement banner'],
			],
			'tp_age_gate' => [
				'label' => esc_html__('Age Gate','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/age-gate/',
				'docUrl' => 'https://docs.posimyth.com/tpae/age-gate/',
				'videoUrl' => 'https://youtu.be/L7-Kq4Er7Ps',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 640 512"><path fill="currentColor" d="M622.3 271.1l-115.2-45c-4.1-1.6-12.6-3.7-22.2 0l-115.2 45c-10.7 4.2-17.7 14-17.7 24.9 0 111.6 68.7 188.8 132.9 213.9 9.6 3.7 18 1.6 22.2 0C558.4 489.9 640 420.5 640 296c0-10.9-7-20.7-17.7-24.9zM496 462.4V273.3l95.5 37.3c-5.6 87.1-60.9 135.4-95.5 151.8zM224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm96 40c0-2.5.8-4.8 1.1-7.2-2.5-.1-4.9-.8-7.5-.8h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c6.8 0 13.3-1.5 19.2-4-54-42.9-99.2-116.7-99.2-212z"></path></svg>',
				'keyword' => ['age gate'],
			],
			'tp_animated_service_boxes' => [
				'label' => esc_html__('Animated Service Boxes','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/animated-service-boxes/',
				'docUrl' => 'https://docs.posimyth.com/tpae/animated-service-boxes/',
				'videoUrl' => 'https://www.youtube.com/embed/EZDOPlaO_2Y',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48H48C21.49 32 0 53.49 0 80zm320-16v106.667H192V64h128zm160 245.333H352V202.667h128v106.666zm-160 0H192V202.667h128v106.666zM32 202.667h128v106.667H32V202.667zM160 64v106.667H32V80c0-8.837 7.163-16 16-16h112zM32 432v-90.667h128V448H48c-8.837 0-16-7.163-16-16zm160 16V341.333h128V448H192zm160 0V341.333h128V432c0 8.837-7.163 16-16 16H352zm128-277.333H352V64h112c8.837 0 16 7.163 16 16v90.667z"/></svg>',
				'keyword' => ['image accordion','sliding boxes','article box','info banner','hover section','fancy box','services element','portfolio','verticle slider', 'horizontal slider'],
			],
			'tp_audio_player' => [
				'label' => esc_html__('Audio Player','tpebl'),
				'demoUrl' => 'https://theplusaddons.com-widget/audio-player/',
				'docUrl' => 'https://docs.posimyth.com/tpae/audio-player/',
				'videoUrl' => 'https://www.youtube.com/embed/TUNSQWJozfk',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 32C114.517 32 0 146.497 0 288v51.429a16.003 16.003 0 0 0 8.213 13.978l23.804 13.262c-.005.443-.017.886-.017 1.331 0 61.856 50.144 112 112 112h24c13.255 0 24-10.745 24-24V280c0-13.255-10.745-24-24-24h-24c-49.675 0-91.79 32.343-106.453 77.118L32 330.027V288C32 164.205 132.184 64 256 64c123.796 0 224 100.184 224 224v42.027l-5.547 3.09C459.79 288.343 417.676 256 368 256h-24c-13.255 0-24 10.745-24 24v176c0 13.255 10.745 24 24 24h24c61.856 0 112-50.144 112-112 0-.445-.012-.888-.017-1.332l23.804-13.262A16.002 16.002 0 0 0 512 339.428V288c0-141.482-114.497-256-256-256zM144 288h16v160h-16c-44.112 0-80-35.888-80-80s35.888-80 80-80zm224 160h-16V288h16c44.112 0 80 35.888 80 80s-35.888 80-80 80z"/></svg>',
				'keyword' => ['audio player','player'],
			],
			'tp_before_after' => [
				'label' => esc_html__('Before After','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/before-after-2/',
				'docUrl' => 'https://docs.posimyth.com/tpae/before-after/',
				'videoUrl' => 'https://www.youtube.com/embed/vi_lRiOeOfc',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M288 403.4l-145.5 76.5 27.8-162L52.5 203.1l162.7-23.6L288 32V0c-11.4 0-22.8 5.9-28.7 17.8L194 150.2 47.9 171.4c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.1 23 46 46.4 33.7L288 439.6v-36.2z"/></svg>',
				'keyword' => ['before after'],
			],
			'tp_blockquote' => [
				'label' => esc_html__('Blockquote','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/blockquote/',
				'docUrl' => 'https://docs.posimyth.com/tpae/blockquote/',
				'videoUrl' => 'https://www.youtube.com/embed/Ma7YtFHXIrs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M448 224h-64v-24c0-30.9 25.1-56 56-56h16c22.1 0 40-17.9 40-40V72c0-22.1-17.9-40-40-40h-16c-92.6 0-168 75.4-168 168v216c0 35.3 28.7 64 64 64h112c35.3 0 64-28.7 64-64V288c0-35.3-28.7-64-64-64zm32 192c0 17.7-14.3 32-32 32H336c-17.7 0-32-14.3-32-32V200c0-75.1 60.9-136 136-136h16c4.4 0 8 3.6 8 8v32c0 4.4-3.6 8-8 8h-16c-48.6 0-88 39.4-88 88v56h96c17.7 0 32 14.3 32 32v128zM176 224h-64v-24c0-30.9 25.1-56 56-56h16c22.1 0 40-17.9 40-40V72c0-22.1-17.9-40-40-40h-16C75.4 32 0 107.4 0 200v216c0 35.3 28.7 64 64 64h112c35.3 0 64-28.7 64-64V288c0-35.3-28.7-64-64-64zm32 192c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V200c0-75.1 60.9-136 136-136h16c4.4 0 8 3.6 8 8v32c0 4.4-3.6 8-8 8h-16c-48.6 0-88 39.4-88 88v56h96c17.7 0 32 14.3 32 32v128z"/></svg>',
				'keyword' => ['blockquote'],
			],
			'tp_blog_listout' => [
				'label' => esc_html__('Blog Listing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#plus-blog',
				'docUrl' => 'https://docs.posimyth.com/tpae/blog-posts/',
				'videoUrl' => 'https://www.youtube.com/embed/JeCxbLLEqco',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M552 64H88c-13.234 0-24 10.767-24 24v8H24c-13.255 0-24 10.745-24 24v280c0 26.51 21.49 48 48 48h504c13.233 0 24-10.767 24-24V88c0-13.233-10.767-24-24-24zM32 400V128h32v272c0 8.822-7.178 16-16 16s-16-7.178-16-16zm512 16H93.258A47.897 47.897 0 0 0 96 400V96h448v320zm-404-96h168c6.627 0 12-5.373 12-12V140c0-6.627-5.373-12-12-12H140c-6.627 0-12 5.373-12 12v168c0 6.627 5.373 12 12 12zm20-160h128v128H160V160zm-32 212v-8c0-6.627 5.373-12 12-12h168c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H140c-6.627 0-12-5.373-12-12zm224 0v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-64v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-128v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0 64v-8c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12z"/></svg>',
				'keyword' => ['blog listing','post','listing'],
			],			
			'tp_breadcrumbs_bar' => [
				'label' => esc_html__('Breadcrumbs Bar','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/breadcrumb-bar/',
				'docUrl' => 'https://docs.posimyth.com/tpae/breadcrumb-bar-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/Bzbl0LmNZ1s',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 192 512"><path d="M166.9 264.5l-117.8 116c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17L127.3 256 25.1 155.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0l117.8 116c4.6 4.7 4.6 12.3-.1 17z"/></svg>',
				'keyword' => ['breadcrumbs bar'],
			],
			'tp_button' => [
				'label' => esc_html__('Button','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/buttons/',
				'docUrl' => 'https://docs.posimyth.com/tpae/buttons/',
				'videoUrl' => 'https://www.youtube.com/embed/cuxzApRULv8',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M301.148 394.702l-79.2 79.19c-50.778 50.799-133.037 50.824-183.84 0-50.799-50.778-50.824-133.037 0-183.84l79.19-79.2a132.833 132.833 0 0 1 3.532-3.403c7.55-7.005 19.795-2.004 20.208 8.286.193 4.807.598 9.607 1.216 14.384.481 3.717-.746 7.447-3.397 10.096-16.48 16.469-75.142 75.128-75.3 75.286-36.738 36.759-36.731 96.188 0 132.94 36.759 36.738 96.188 36.731 132.94 0l79.2-79.2.36-.36c36.301-36.672 36.14-96.07-.37-132.58-8.214-8.214-17.577-14.58-27.585-19.109-4.566-2.066-7.426-6.667-7.134-11.67a62.197 62.197 0 0 1 2.826-15.259c2.103-6.601 9.531-9.961 15.919-7.28 15.073 6.324 29.187 15.62 41.435 27.868 50.688 50.689 50.679 133.17 0 183.851zm-90.296-93.554c12.248 12.248 26.362 21.544 41.435 27.868 6.388 2.68 13.816-.68 15.919-7.28a62.197 62.197 0 0 0 2.826-15.259c.292-5.003-2.569-9.604-7.134-11.67-10.008-4.528-19.371-10.894-27.585-19.109-36.51-36.51-36.671-95.908-.37-132.58l.36-.36 79.2-79.2c36.752-36.731 96.181-36.738 132.94 0 36.731 36.752 36.738 96.181 0 132.94-.157.157-58.819 58.817-75.3 75.286-2.651 2.65-3.878 6.379-3.397 10.096a163.156 163.156 0 0 1 1.216 14.384c.413 10.291 12.659 15.291 20.208 8.286a131.324 131.324 0 0 0 3.532-3.403l79.19-79.2c50.824-50.803 50.799-133.062 0-183.84-50.802-50.824-133.062-50.799-183.84 0l-79.2 79.19c-50.679 50.682-50.688 133.163 0 183.851z"/></svg>',
				'keyword' => ['button'],
			],
			'tp_caldera_forms' => [
				'label' => esc_html__('Caldera Forms','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/caldera-forms',
				'docUrl' => 'https://docs.posimyth.com/tpae/caldera-forms-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/8J8Qg2aMQqs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M349.32 52.26C328.278 35.495 292.938 0 256 0c-36.665 0-71.446 34.769-93.31 52.26-34.586 27.455-109.525 87.898-145.097 117.015A47.99 47.99 0 0 0 0 206.416V464c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V206.413a47.989 47.989 0 0 0-17.597-37.144C458.832 140.157 383.906 79.715 349.32 52.26zM464 480H48c-8.837 0-16-7.163-16-16V206.161c0-4.806 2.155-9.353 5.878-12.392C64.16 172.315 159.658 95.526 182.59 77.32 200.211 63.27 232.317 32 256 32c23.686 0 55.789 31.27 73.41 45.32 22.932 18.207 118.436 95.008 144.714 116.468a15.99 15.99 0 0 1 5.876 12.39V464c0 8.837-7.163 16-16 16zm-8.753-216.312c4.189 5.156 3.393 12.732-1.776 16.905-22.827 18.426-55.135 44.236-104.156 83.148-21.045 16.8-56.871 52.518-93.318 52.258-36.58.264-72.826-35.908-93.318-52.263-49.015-38.908-81.321-64.716-104.149-83.143-5.169-4.173-5.966-11.749-1.776-16.905l5.047-6.212c4.169-5.131 11.704-5.925 16.848-1.772 22.763 18.376 55.014 44.143 103.938 82.978 16.85 13.437 50.201 45.69 73.413 45.315 23.219.371 56.562-31.877 73.413-45.315 48.929-38.839 81.178-64.605 103.938-82.978 5.145-4.153 12.679-3.359 16.848 1.772l5.048 6.212z"/></svg>',
				'keyword' => ['caldera forms','form'],
			],
			'tp_carousel_anything' => [
				'label' => esc_html__('Carousel Anything','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/carousal-anything/',
				'docUrl' => 'https://docs.posimyth.com/tpae/carousel-anything-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/yszLgc0TJPA',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M504 384H192v-40c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v40H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h88v40c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24v-40h312c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm-344 64h-32v-96h32v96zM504 96H256V56c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v40H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h152v40c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24v-40h248c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm-280 64h-32V64h32v96zm280 80h-88v-40c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v40H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h312v40c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24v-40h88c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm-120 64h-32v-96h32v96z"/></svg>',
				'keyword' => ['carousel anything'],
			],
			'tp_carousel_remote' => [
				'label' => esc_html__('Carousel Remote','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/carousal-remote/',
				'docUrl' => 'https://docs.posimyth.com/tpae/carousal-remote/',
				'videoUrl' => 'https://www.youtube.com/embed/gSsIVufNAr4',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 352 512"><path fill="currentColor" d="M196.48 260.023l92.626-103.333L143.125 0v206.33l-86.111-86.111-31.406 31.405 108.061 108.399L25.608 368.422l31.406 31.405 86.111-86.111L145.84 512l148.552-148.644-97.912-103.333zm40.86-102.996l-49.977 49.978-.338-100.295 50.315 50.317zM187.363 313.04l49.977 49.978-50.315 50.316.338-100.294z"></path></svg>',
				'keyword' => ['carousel remote'],
			],
			'tp_cascading_image' => [
				'label' => esc_html__('Cascading Image','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/image-cascading/',
				'docUrl' => 'https://docs.posimyth.com/tpae/image-cascading/',
				'videoUrl' => 'https://www.youtube.com/embed/lnPIIOvAWhY',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M404 192h-84v-52c0-6.6-5.4-12-12-12H108c-6.6 0-12 5.4-12 12v168c0 6.6 5.4 12 12 12h84v52c0 6.6 5.4 12 12 12h200c6.6 0 12-5.4 12-12V204c0-6.6-5.4-12-12-12zm-276 96V160h160v128zm256 64H224v-32h84c6.6 0 12-5.4 12-12v-84h64zm116-224c6.6 0 12-5.4 12-12V44c0-6.6-5.4-12-12-12h-72c-6.6 0-12 5.4-12 12v20H96V44c0-6.6-5.4-12-12-12H12C5.4 32 0 37.4 0 44v72c0 6.6 5.4 12 12 12h20v256H12c-6.6 0-12 5.4-12 12v72c0 6.6 5.4 12 12 12h72c6.6 0 12-5.4 12-12v-20h320v20c0 6.6 5.4 12 12 12h72c6.6 0 12-5.4 12-12v-72c0-6.6-5.4-12-12-12h-20V128zM32 64h32v32H32zm32 384H32v-32h32zm352-52v20H96v-20c0-6.6-5.4-12-12-12H64V128h20c6.6 0 12-5.4 12-12V96h320v20c0 6.6 5.4 12 12 12h20v256h-20c-6.6 0-12 5.4-12 12zm64 52h-32v-32h32zM448 96V64h32v32z"/>',
				'keyword' => ['cascading image'],
			],
			'tp_chart' => [
				'label' => esc_html__('Chart','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advanced-charts-js-elementor/',
				'docUrl' => 'https://docs.posimyth.com/tpae/advanced-charts/',
				'videoUrl' => 'https://www.youtube.com/embed/2kDLRWNj3r8',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M500 416c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H12c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h8c6.6 0 12 5.4 12 12v340h468zM372 162l-84 54-86.5-84.5c-5.1-5.1-13.4-4.6-17.9 1L64 288v96h416l-90.3-216.7c-3-6.9-11.5-9.4-17.7-5.3zM96 299.2l98.7-131.3 89.3 89.3 85.8-57.2 61.7 152H96v-52.8z"/></svg>',
				'keyword' => ['chart','line','bar','vertical bar','horizontal bar','radar','pie','doughnut','polararea','bubble'],
			],
			'tp_circle_menu' => [
				'label' => esc_html__('Circle Menu','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/circle-menu',
				'docUrl' => 'https://docs.posimyth.com/tpae/circle-menu/',
				'videoUrl' => 'https://www.youtube.com/embed/eYdFGdThs6A',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M288 24.103v8.169a11.995 11.995 0 0 0 9.698 11.768C396.638 63.425 472 150.461 472 256c0 118.663-96.055 216-216 216-118.663 0-216-96.055-216-216 0-104.534 74.546-192.509 174.297-211.978A11.993 11.993 0 0 0 224 32.253v-8.147c0-7.523-6.845-13.193-14.237-11.798C94.472 34.048 7.364 135.575 8.004 257.332c.72 137.052 111.477 246.956 248.531 246.667C393.255 503.711 504 392.789 504 256c0-121.187-86.924-222.067-201.824-243.704C294.807 10.908 288 16.604 288 24.103z"/></svg>',
				'keyword' => ['circle menu'],
			],
			'tp_clients_listout' => [
				'label' => esc_html__('Clients Listing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#plus-clients',
				'docUrl' => 'https://docs.posimyth.com/tpae/client-logos-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/NnqDnjmdRE',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 32c61.8 0 112 50.2 112 112s-50.2 112-112 112-112-50.2-112-112S194.2 32 256 32m128 320c52.9 0 96 43.1 96 96v32H32v-32c0-52.9 43.1-96 96-96 85 0 67.3 16 128 16 60.9 0 42.9-16 128-16M256 0c-79.5 0-144 64.5-144 144s64.5 144 144 144 144-64.5 144-144S335.5 0 256 0zm128 320c-92.4 0-71 16-128 16-56.8 0-35.7-16-128-16C57.3 320 0 377.3 0 448v32c0 17.7 14.3 32 32 32h448c17.7 0 32-14.3 32-32v-32c0-70.7-57.3-128-128-128z"/></svg>',
				'keyword' => ['clients listing'],
			],
			'tp_contact_form_7' => [
				'label' => esc_html__('Contact Form 7','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/contact-form-7/',
				'docUrl' => 'https://docs.posimyth.com/tpae/contact-form-7-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/SxpvbUZoby8',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z"/></svg>',
				'keyword' => ['contact form 7','form'],
			],
			'tp_countdown' => [
				'label' => esc_html__('Count Down','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/countdown/',
				'docUrl' => 'https://docs.posimyth.com/tpae/timer-countdown/',
				'videoUrl' => 'https://www.youtube.com/embed/6gB--xqBLUE',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm216 248c0 118.7-96.1 216-216 216-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216zm-148.9 88.3l-81.2-59c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h14c6.6 0 12 5.4 12 12v146.3l70.5 51.3c5.4 3.9 6.5 11.4 2.6 16.8l-8.2 11.3c-3.9 5.3-11.4 6.5-16.8 2.6z"/></svg>',
				'keyword' => ['count down'],
			],
			'tp_dark_mode' => [
				'label' => esc_html__('Dark Mode','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/elementor-dark-mode/',
				'docUrl' => 'https://docs.posimyth.com/tpae/dark-mode-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/HY5KlYuWP5k',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 40c119.945 0 216 97.337 216 216 0 119.945-97.337 216-216 216-119.945 0-216-97.337-216-216 0-119.945 97.337-216 216-216m0-32C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm-32 124.01v247.98c-53.855-13.8-96-63.001-96-123.99 0-60.99 42.145-110.19 96-123.99M256 96c-88.366 0-160 71.634-160 160s71.634 160 160 160V96z"/></svg>',
				'keyword' => ['dark mode'],
			],
			'tp_design_tool' => [
				'label' => esc_html__('Design Tool','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/design-tool/',
				'docUrl' => 'https://docs.posimyth.com/tpae/grid-design-tool-tutorial/',
				'videoUrl' => 'https://www.youtube.com/embed/HL36KplDhVo',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M439 48H7a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8V56a8 8 0 0 0-8-8zm0 384H7a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm0-128H7a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm0-128H7a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8z"/></svg>',
				'keyword' => ['grid ','design tool','bootstrap grid'],
			],
			'tp_draw_svg' => [
				'label' => esc_html__('Draw SVG','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/draw-svg/',
				'docUrl' => 'https://docs.posimyth.com/tpae/draw-svg/',
				'videoUrl' => 'https://www.youtube.com/embed/mUSu64Y0YoI',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M120.81 248c-25.96 0-44.8 16.8-44.8 39.95 0 23.15 18.84 39.95 44.8 39.95l10.14.1c39.21 0 45.06-20.1 45.06-32.08-.01-24.68-31.1-47.92-55.2-47.92zm10.14 56c-3.51 0-7.02-.1-10.14-.1-12.48 0-20.8-6.38-20.8-15.95s8.32-15.95 20.8-15.95 31.2 14.36 31.2 23.93c0 7.17-10.54 8.07-21.06 8.07zm260.24-56c-24.1 0-55.19 23.24-55.19 47.93 0 11.98 5.85 32.08 45.06 32.08l10.14-.1c25.96 0 44.8-16.8 44.8-39.95-.01-23.16-18.85-39.96-44.81-39.96zm0 55.9c-3.12 0-6.63.1-10.14.1-10.53 0-21.06-.9-21.06-8.07 0-9.57 18.72-23.93 31.2-23.93s20.8 6.38 20.8 15.95-8.32 15.95-20.8 15.95zm114.8-140.94c-7.34-11.88-20.06-18.97-34.03-18.97H422.3l-8.07-24.76C403.5 86.29 372.8 64 338.17 64H173.83c-34.64 0-65.33 22.29-76.06 55.22l-8.07 24.76H40.04c-13.97 0-26.69 7.09-34.03 18.97s-8 26.42-1.75 38.91l5.78 11.61c3.96 7.88 9.92 14.09 17 18.55-6.91 11.74-11.03 25.32-11.03 39.97V400c0 26.47 21.53 48 48 48h16c26.47 0 48-21.53 48-48v-16H384v16c0 26.47 21.53 48 48 48h16c26.47 0 48-21.53 48-48V271.99c0-14.66-4.12-28.23-11.03-39.98 7.09-4.46 13.04-10.68 17-18.57l5.78-11.56c6.24-12.5 5.58-27.05-1.76-38.92zM128.2 129.14C134.66 109.32 153 96 173.84 96h164.33c20.84 0 39.18 13.32 45.64 33.13l20.47 62.85H107.73l20.47-62.84zm-89.53 70.02l-5.78-11.59c-1.81-3.59-.34-6.64.34-7.78.87-1.42 2.94-3.8 6.81-3.8h39.24l-6.45 19.82a80.69 80.69 0 0 0-23.01 11.29c-4.71-1-8.94-3.52-11.15-7.94zM96.01 400c0 8.83-7.19 16-16 16h-16c-8.81 0-16-7.17-16-16v-16h48v16zm367.98 0c0 8.83-7.19 16-16 16h-16c-8.81 0-16-7.17-16-16v-16h48v16zm0-80.01v32H48.01v-80c0-26.47 21.53-48 48-48h319.98c26.47 0 48 21.53 48 48v48zm15.12-132.41l-5.78 11.55c-2.21 4.44-6.44 6.97-11.15 7.97-6.94-4.9-14.69-8.76-23.01-11.29l-6.45-19.82h39.24c3.87 0 5.94 2.38 6.81 3.8.69 1.14 2.16 4.18.34 7.79z"/></svg>',
				'keyword' => ['draw svg','SVG'],
			],			
			'tp_dynamic_categories' => [
				'label' => esc_html__('Dynamic Categories','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/dynamic-category/',
				'docUrl' => 'https://docs.posimyth.com/tpae/dynamic-category-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/Atp_gVyWko8',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 224c-79.41 0-192 122.76-192 200.25 0 34.9 26.81 55.75 71.74 55.75 48.84 0 81.09-25.08 120.26-25.08 39.51 0 71.85 25.08 120.26 25.08 44.93 0 71.74-20.85 71.74-55.75C448 346.76 335.41 224 256 224zm120.26 224c-20.3 0-37.81-5.77-56.35-11.88-19.68-6.49-40.02-13.19-63.91-13.19-23.65 0-43.85 6.67-63.39 13.12-18.64 6.15-36.25 11.96-56.87 11.96C96 448 96 430.12 96 424.25 96 361.35 196.19 256 256 256s160 105.35 160 168.25c0 5.87 0 23.75-39.74 23.75zm98.57-286.73c-3.57-.86-7.2-1.27-10.81-1.27-25.85 0-51.62 21-60.74 51.39-10.4 34.65 4.77 68.38 33.89 75.34 3.58.86 7.2 1.27 10.81 1.27 25.85 0 51.62-21 60.74-51.39 10.4-34.65-4.77-68.38-33.89-75.34zm3.24 66.14C472.7 245.3 458.55 256 447.98 256c-1.16 0-2.29-.13-3.37-.39-3.7-.88-6.72-3.32-8.98-7.25-4.13-7.18-4.76-17.55-1.7-27.76 5.37-17.9 19.52-28.6 30.1-28.6 1.16 0 2.29.13 3.37.39 3.7.88 6.72 3.33 8.98 7.25 4.12 7.18 4.76 17.55 1.69 27.77zm-159.51-36.8c3.55.93 7.15 1.38 10.76 1.38 27.84 0 56.22-26.82 66.7-65.25 11.84-43.42-3.64-85.21-34.58-93.36a41.92 41.92 0 0 0-10.76-1.39c-27.84 0-56.22 26.82-66.7 65.26-11.84 43.42 3.64 85.22 34.58 93.36zm-3.71-84.93C322.27 78.48 340.43 64 350.68 64c.91 0 1.77.11 2.61.33 4.13 1.09 7.12 5 8.9 8.09 5.08 8.8 8.52 25.48 2.95 45.91-7.42 27.19-25.57 41.67-35.83 41.67-.91 0-1.77-.11-2.62-.33-4.12-1.08-7.12-4.99-8.9-8.08-5.07-8.81-8.51-25.48-2.94-45.91zM182.68 192c3.61 0 7.21-.45 10.76-1.38 30.94-8.14 46.42-49.94 34.58-93.36C217.54 58.82 189.16 32 161.32 32c-3.61 0-7.21.45-10.76 1.39-30.94 8.14-46.42 49.94-34.58 93.36 10.48 38.43 38.87 65.25 66.7 65.25zM149.8 72.42c1.78-3.09 4.78-7 8.9-8.09.85-.22 1.7-.33 2.61-.33 10.26 0 28.41 14.48 35.83 41.68 5.57 20.43 2.13 37.11-2.95 45.91-1.78 3.09-4.77 7-8.9 8.08-.85.22-1.7.33-2.61.33-10.26 0-28.41-14.48-35.83-41.68-5.57-20.42-2.13-37.1 2.95-45.9zM74.84 286.73c29.12-6.96 44.29-40.69 33.88-75.34C99.6 181 73.83 160 47.98 160c-3.62 0-7.24.41-10.81 1.27-29.12 6.96-44.29 40.69-33.89 75.34C12.4 267 38.18 288 64.02 288c3.62 0 7.24-.41 10.82-1.27zM33.93 227.4c-3.06-10.21-2.43-20.59 1.7-27.76 2.26-3.93 5.28-6.37 8.98-7.25 1.08-.26 2.21-.39 3.37-.39 10.57 0 24.72 10.7 30.09 28.59 3.06 10.21 2.43 20.59-1.7 27.77-2.26 3.93-5.28 6.37-8.98 7.25-1.1.26-2.2.39-3.37.39-10.57 0-24.72-10.7-30.09-28.6z"/></svg>',
				'keyword' => ['dynamic categories','categories','listing'],
			],
			'tp_dynamic_device' => [
				'label' => esc_html__('Dynamic Device','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/device-dynamic/',
				'docUrl' => 'https://docs.posimyth.com/tpae/dynamic-devices/',
				'videoUrl' => 'https://www.youtube.com/embed/SxLbJhA40WM',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M624 368h-48V96c0-35.3-28.72-64-64-64H128c-35.28 0-64 28.7-64 64v272H16c-8.84 0-16 7.16-16 16v48c0 44.11 35.88 80 80 80h480c44.12 0 80-35.89 80-80v-48c0-8.84-7.16-16-16-16zM96 96c0-17.67 14.33-32 32-32h384c17.67 0 32 14.33 32 32v272H391.13c-4.06 0-7.02 3.13-7.92 7.09C379.98 389.35 367.23 400 352 400h-64c-15.23 0-27.98-10.65-31.21-24.91-.9-3.96-3.86-7.09-7.92-7.09H96V96zm512 336c0 26.47-21.53 48-48 48H80c-26.47 0-48-21.53-48-48v-32h194.75c6.59 18.62 24.38 32 45.25 32h96c20.88 0 38.66-13.38 45.25-32H608v32z"/></svg>',
				'keyword' => ['dynamic device'],
			],
			'tp_dynamic_listing' => [
				'label' => esc_html__('Dynamic Listing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/dynamic-listing/',
				'docUrl' => 'https://docs.posimyth.com/tpae/dynamic-listing-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/72eMzrHj6P4',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 64c8.823 0 16 7.178 16 16v352c0 8.822-7.177 16-16 16H48c-8.823 0-16-7.178-16-16V80c0-8.822 7.177-16 16-16h416m0-32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm-336 96c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm0 96c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm0 96c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm288-148v-24a6 6 0 0 0-6-6H198a6 6 0 0 0-6 6v24a6 6 0 0 0 6 6h212a6 6 0 0 0 6-6zm0 96v-24a6 6 0 0 0-6-6H198a6 6 0 0 0-6 6v24a6 6 0 0 0 6 6h212a6 6 0 0 0 6-6zm0 96v-24a6 6 0 0 0-6-6H198a6 6 0 0 0-6 6v24a6 6 0 0 0 6 6h212a6 6 0 0 0 6-6z"/></svg>',
				'keyword' => ['dynamic listing','post','custom post','listing'],
			],
			'tp_dynamic_smart_showcase' => [
				'label' => esc_html__('Dynamic Smart Showcase','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#plus-magazine-post-styles',
				'docUrl' => 'https://docs.posimyth.com/tpae/magazine-post-styles/',
				'videoUrl' => 'https://www.youtube.com/embed/lGgVQpbmuWg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M187.7 153.7c-34 0-61.7 25.7-61.7 57.7 0 31.7 27.7 57.7 61.7 57.7s61.7-26 61.7-57.7c0-32-27.7-57.7-61.7-57.7zm143.4 0c-34 0-61.7 25.7-61.7 57.7 0 31.7 27.7 57.7 61.7 57.7 34.3 0 61.7-26 61.7-57.7.1-32-27.4-57.7-61.7-57.7zm156.6 90l-6 4.3V49.7c0-27.4-20.6-49.7-46-49.7H76.6c-25.4 0-46 22.3-46 49.7V248c-2-1.4-4.3-2.9-6.3-4.3-15.1-10.6-25.1 4-16 17.7 18.3 22.6 53.1 50.3 106.3 72C58.3 525.1 252 555.7 248.9 457.5c0-.7.3-56.6.3-96.6 5.1 1.1 9.4 2.3 13.7 3.1 0 39.7.3 92.8.3 93.5-3.1 98.3 190.6 67.7 134.3-124 53.1-21.7 88-49.4 106.3-72 9.1-13.8-.9-28.3-16.1-17.8zm-30.5 19.2c-68.9 37.4-128.3 31.1-160.6 29.7-23.7-.9-32.6 9.1-33.7 24.9-10.3-7.7-18.6-15.5-20.3-17.1-5.1-5.4-13.7-8-27.1-7.7-31.7 1.1-89.7 7.4-157.4-28V72.3c0-34.9 8.9-45.7 40.6-45.7h317.7c30.3 0 40.9 12.9 40.9 45.7v190.6z"></path></svg>',
				'keyword' => ['dynamic magazine filter', 'dynamic magazine slider', 'dynamic post ticker', 'post ticker', 'ticker', 'dynamic ticker', 'post magazine', 'magazine slider','magazine filter', 'blog slider', 'dynamic slider', 'dynamic filter', 'magazine', 'blog'],
			],
			'tp_everest_form' => [
				'label' => esc_html__('Everest Form','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/everest-forms/',
				'docUrl' => 'https://docs.posimyth.com/tpae/everest-forms-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/NIWTuStFVt8',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M349.32 52.26C328.278 35.495 292.938 0 256 0c-36.665 0-71.446 34.769-93.31 52.26-34.586 27.455-109.525 87.898-145.097 117.015A47.99 47.99 0 0 0 0 206.416V464c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V206.413a47.989 47.989 0 0 0-17.597-37.144C458.832 140.157 383.906 79.715 349.32 52.26zM464 480H48c-8.837 0-16-7.163-16-16V206.161c0-4.806 2.155-9.353 5.878-12.392C64.16 172.315 159.658 95.526 182.59 77.32 200.211 63.27 232.317 32 256 32c23.686 0 55.789 31.27 73.41 45.32 22.932 18.207 118.436 95.008 144.714 116.468a15.99 15.99 0 0 1 5.876 12.39V464c0 8.837-7.163 16-16 16zm-8.753-216.312c4.189 5.156 3.393 12.732-1.776 16.905-22.827 18.426-55.135 44.236-104.156 83.148-21.045 16.8-56.871 52.518-93.318 52.258-36.58.264-72.826-35.908-93.318-52.263-49.015-38.908-81.321-64.716-104.149-83.143-5.169-4.173-5.966-11.749-1.776-16.905l5.047-6.212c4.169-5.131 11.704-5.925 16.848-1.772 22.763 18.376 55.014 44.143 103.938 82.978 16.85 13.437 50.201 45.69 73.413 45.315 23.219.371 56.562-31.877 73.413-45.315 48.929-38.839 81.178-64.605 103.938-82.978 5.145-4.153 12.679-3.359 16.848 1.772l5.048 6.212z"/></svg>',
				'keyword' => ['everest form','form'],
			],
			'tp_flip_box' => [
				'label' => esc_html__('Flip Box','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/flipbox/',
				'docUrl' => 'https://docs.posimyth.com/tpae/flipbox/',
				'videoUrl' => 'https://www.youtube.com/embed/rbasfNo7K_E',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 464c-118.663 0-216-96.055-216-216 0-118.663 96.055-216 216-216 118.663 0 216 96.055 216 216 0 118.663-96.055 216-216 216zm0-296c-44.183 0-80 35.817-80 80s35.817 80 80 80 80-35.817 80-80-35.817-80-80-80zm0 128c-26.467 0-48-21.533-48-48s21.533-48 48-48 48 21.533 48 48-21.533 48-48 48z"/></svg>',
				'keyword' => ['flip box'],
			],
			'tp_gallery_listout' => [
				'label' => esc_html__('Gallery Listing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#plus-gallery',
				'docUrl' => 'https://docs.posimyth.com/tpae/image-gallery-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/tw7aIjUKbIk',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M301.1 212c4.4 4.4 4.4 11.9 0 16.3l-9.7 9.7c-4.4 4.7-11.9 4.7-16.6 0l-10.5-10.5c-4.4-4.7-4.4-11.9 0-16.6l9.7-9.7c4.4-4.4 11.9-4.4 16.6 0l10.5 10.8zm-30.2-19.7c3-3 3-7.8 0-10.5-2.8-3-7.5-3-10.5 0-2.8 2.8-2.8 7.5 0 10.5 3.1 2.8 7.8 2.8 10.5 0zm-26 5.3c-3 2.8-3 7.5 0 10.2 2.8 3 7.5 3 10.5 0 2.8-2.8 2.8-7.5 0-10.2-3-3-7.7-3-10.5 0zm72.5-13.3c-19.9-14.4-33.8-43.2-11.9-68.1 21.6-24.9 40.7-17.2 59.8.8 11.9 11.3 29.3 24.9 17.2 48.2-12.5 23.5-45.1 33.2-65.1 19.1zm47.7-44.5c-8.9-10-23.3 6.9-15.5 16.1 7.4 9 32.1 2.4 15.5-16.1zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-66.2 42.6c2.5-16.1-20.2-16.6-25.2-25.7-13.6-24.1-27.7-36.8-54.5-30.4 11.6-8 23.5-6.1 23.5-6.1.3-6.4 0-13-9.4-24.9 3.9-12.5.3-22.4.3-22.4 15.5-8.6 26.8-24.4 29.1-43.2 3.6-31-18.8-59.2-49.8-62.8-22.1-2.5-43.7 7.7-54.3 25.7-23.2 40.1 1.4 70.9 22.4 81.4-14.4-1.4-34.3-11.9-40.1-34.3-6.6-25.7 2.8-49.8 8.9-61.4 0 0-4.4-5.8-8-8.9 0 0-13.8 0-24.6 5.3 11.9-15.2 25.2-14.4 25.2-14.4 0-6.4-.6-14.9-3.6-21.6-5.4-11-23.8-12.9-31.7 2.8.1-.2.3-.4.4-.5-5 11.9-1.1 55.9 16.9 87.2-2.5 1.4-9.1 6.1-13 10-21.6 9.7-56.2 60.3-56.2 60.3-28.2 10.8-77.2 50.9-70.6 79.7.3 3 1.4 5.5 3 7.5-2.8 2.2-5.5 5-8.3 8.3-11.9 13.8-5.3 35.2 17.7 24.4 15.8-7.2 29.6-20.2 36.3-30.4 0 0-5.5-5-16.3-4.4 27.7-6.6 34.3-9.4 46.2-9.1 8 3.9 8-34.3 8-34.3 0-14.7-2.2-31-11.1-41.5 12.5 12.2 29.1 32.7 28 60.6-.8 18.3-15.2 23-15.2 23-9.1 16.6-43.2 65.9-30.4 106 0 0-9.7-14.9-10.2-22.1-17.4 19.4-46.5 52.3-24.6 64.5 26.6 14.7 108.8-88.6 126.2-142.3 34.6-20.8 55.4-47.3 63.9-65 22 43.5 95.3 94.5 101.1 59z"></path></svg>',
				'keyword' => ['gallery listing'],
			],
			'tp_google_map' => [
				'label' => esc_html__('Google Map','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/google-maps/',
				'docUrl' => 'https://docs.posimyth.com/tpae/google-maps/',
				'videoUrl' => 'https://www.youtube.com/embed/NwY-Pt8q-6g',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M560.02 32c-1.96 0-3.98.37-5.96 1.16L384.01 96H384L212 35.28A64.252 64.252 0 0 0 191.76 32c-6.69 0-13.37 1.05-19.81 3.14L20.12 87.95A32.006 32.006 0 0 0 0 117.66v346.32C0 473.17 7.53 480 15.99 480c1.96 0 3.97-.37 5.96-1.16L192 416l172 60.71a63.98 63.98 0 0 0 40.05.15l151.83-52.81A31.996 31.996 0 0 0 576 394.34V48.02c0-9.19-7.53-16.02-15.98-16.02zM30.63 118.18L176 67.61V387.8L31.91 441.05l-1.28-322.87zM208 387.71V67.8l160 56.48v319.91l-160-56.48zm192 56.68V124.2l144.09-53.26 1.28 322.87L400 444.39z"/></svg>',
				'keyword' => ['google map','map'],
			],
			'tp_gravity_form' => [
				'label' => esc_html__('Gravity Form','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/gravity-forms/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/GwKuP3zfiDw',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M349.32 52.26C328.278 35.495 292.938 0 256 0c-36.665 0-71.446 34.769-93.31 52.26-34.586 27.455-109.525 87.898-145.097 117.015A47.99 47.99 0 0 0 0 206.416V464c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V206.413a47.989 47.989 0 0 0-17.597-37.144C458.832 140.157 383.906 79.715 349.32 52.26zM464 480H48c-8.837 0-16-7.163-16-16V206.161c0-4.806 2.155-9.353 5.878-12.392C64.16 172.315 159.658 95.526 182.59 77.32 200.211 63.27 232.317 32 256 32c23.686 0 55.789 31.27 73.41 45.32 22.932 18.207 118.436 95.008 144.714 116.468a15.99 15.99 0 0 1 5.876 12.39V464c0 8.837-7.163 16-16 16zm-8.753-216.312c4.189 5.156 3.393 12.732-1.776 16.905-22.827 18.426-55.135 44.236-104.156 83.148-21.045 16.8-56.871 52.518-93.318 52.258-36.58.264-72.826-35.908-93.318-52.263-49.015-38.908-81.321-64.716-104.149-83.143-5.169-4.173-5.966-11.749-1.776-16.905l5.047-6.212c4.169-5.131 11.704-5.925 16.848-1.772 22.763 18.376 55.014 44.143 103.938 82.978 16.85 13.437 50.201 45.69 73.413 45.315 23.219.371 56.562-31.877 73.413-45.315 48.929-38.839 81.178-64.605 103.938-82.978 5.145-4.153 12.679-3.359 16.848 1.772l5.048 6.212z"/></svg>',
				'keyword' => ['gravity form','form'],
			],
			'tp_heading_animation' => [
				'label' => esc_html__('Heading Animation','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/heading-animation/',
				'docUrl' => 'https://docs.posimyth.com/tpae/animated-text/',
				'videoUrl' => 'https://www.youtube.com/embed/LTgDD_v8ioA',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 192 512"><path d="M96 38.223C75.091 13.528 39.824 1.336 6.191.005 2.805-.129 0 2.617 0 6.006v20.013c0 3.191 2.498 5.847 5.686 5.989C46.519 33.825 80 55.127 80 80v160H38a6 6 0 0 0-6 6v20a6 6 0 0 0 6 6h42v160c0 24.873-33.481 46.175-74.314 47.992-3.188.141-5.686 2.797-5.686 5.989v20.013c0 3.389 2.806 6.135 6.192 6.002C40.03 510.658 75.193 498.351 96 473.777c20.909 24.695 56.176 36.887 89.809 38.218 3.386.134 6.191-2.612 6.191-6.001v-20.013c0-3.191-2.498-5.847-5.686-5.989C145.481 478.175 112 456.873 112 432V272h42a6 6 0 0 0 6-6v-20a6 6 0 0 0-6-6h-42V80c0-24.873 33.481-46.175 74.314-47.992 3.188-.142 5.686-2.798 5.686-5.989V6.006c0-3.389-2.806-6.135-6.192-6.002C151.97 1.342 116.807 13.648 96 38.223z"/></svg>',
				'keyword' => ['heading animation'],
			],
			'tp_header_extras' => [
				'label' => esc_html__('Header Extras','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/elementor-header-navigation-builder/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/96Wh1AEKNtU',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 256 512"><path d="M208 368.667V208c0-15.495-7.38-29.299-18.811-38.081C210.442 152.296 224 125.701 224 96c0-52.935-43.065-96-96-96S32 43.065 32 96c0 24.564 9.274 47.004 24.504 64H56c-26.467 0-48 21.533-48 48v48c0 23.742 17.327 43.514 40 47.333v65.333C25.327 372.486 8 392.258 8 416v48c0 26.467 21.533 48 48 48h144c26.467 0 48-21.533 48-48v-48c0-23.742-17.327-43.514-40-47.333zM128 32c35.346 0 64 28.654 64 64s-28.654 64-64 64-64-28.654-64-64 28.654-64 64-64zm88 432c0 8.837-7.163 16-16 16H56c-8.837 0-16-7.163-16-16v-48c0-8.837 7.163-16 16-16h24V272H56c-8.837 0-16-7.163-16-16v-48c0-8.837 7.163-16 16-16h104c8.837 0 16 7.163 16 16v192h24c8.837 0 16 7.163 16 16v48z"/></svg>',
				'keyword' => ['header search', 'search bar', 'search icon', 'cart menu', 'mini cart','woo cart', 'music', 'music header', 'music bar', 'header extra content', 'header meta content', 'header extras', 'header extra info', 'language switcher', 'header call to action'],
			],
			'tp_heading_title' => [
				'label' => esc_html__('Heading Title','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/heading-titles/',
				'docUrl' => 'https://docs.posimyth.com/tpae/heading-title/',
				'videoUrl' => 'https://www.youtube.com/embed/OcJUA6gL_0Q',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M448 96v320h32a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16H320a16 16 0 0 1-16-16v-32a16 16 0 0 1 16-16h32V288H160v128h32a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16H32a16 16 0 0 1-16-16v-32a16 16 0 0 1 16-16h32V96H32a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16h160a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16h-32v128h192V96h-32a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16h160a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16z"></path></svg>',
				'keyword' => ['heading title','heading','title'],
			],
			'tp_hotspot' => [
				'label' => esc_html__('Hotspot','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/hotspot-pin-point/',
				'docUrl' => 'https://docs.posimyth.com/tpae/hotspot-pinpoint/',
				'videoUrl' => 'https://www.youtube.com/embed/Cmp7vk_RKKE',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M300.8 203.9L290.7 128H328c13.2 0 24-10.8 24-24V24c0-13.2-10.8-24-24-24H56C42.8 0 32 10.8 32 24v80c0 13.2 10.8 24 24 24h37.3l-10.1 75.9C34.9 231.5 0 278.4 0 335.2c0 8.8 7.2 16 16 16h160V472c0 .7.1 1.3.2 1.9l8 32c2 8 13.5 8.1 15.5 0l8-32c.2-.6.2-1.3.2-1.9V351.2h160c8.8 0 16-7.2 16-16 .1-56.8-34.8-103.7-83.1-131.3zM33.3 319.2c6.8-42.9 39.6-76.4 79.5-94.5L128 96H64V32h256v64h-64l15.3 128.8c40 18.2 72.7 51.8 79.5 94.5H33.3z"/></svg>',
				'keyword' => ['hotspot','pin'],
			],
			'tp_hovercard' => [
				'label' => esc_html__('Hover Card','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/advanced-hover-card-animations/',
				'docUrl' => 'https://docs.posimyth.com/tpae/hover-card-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/BksYXVaiGk8',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48z"></path></svg>',
				'keyword' => ['hover card','html'],
			],
			'tp_image_factory' => [
				'label' => esc_html__('Creative Image','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/creative-images/',
				'docUrl' => 'https://docs.posimyth.com/tpae/creative-images/',
				'videoUrl' => 'https://www.youtube.com/embed/NAxYbZgGwmU',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M159 336l-39.5-39.5c-4.7-4.7-12.3-4.7-17 0l-39 39L63 448h256V304l-55.5-55.5c-4.7-4.7-12.3-4.7-17 0L159 336zm96-50.7l32 32V416H95.1l.3-67.2 15.6-15.6 48 48c20.3-20.3 77.7-77.6 96-95.9zM127 256c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm0-96c17.6 0 32 14.4 32 32s-14.4 32-32 32-32-14.4-32-32 14.4-32 32-32zm242.9-62.1L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM256 32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5zM352 464c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304z"/></svg>',
				'keyword' => ['creative image'],
			],
			'tp_info_box' => [
				'label' => esc_html__('Info Box','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/infobox/',
				'docUrl' => 'https://docs.posimyth.com/tpae/infobox/',
				'videoUrl' => 'https://www.youtube.com/embed/wcnlT5JE0vM',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-36 344h12V232h-12c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h48c6.627 0 12 5.373 12 12v140h12c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12h-72c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12zm36-240c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32z"/></svg>',
				'keyword' => ['info box'],
			],
			'tp_instagram' => [
				'label' => esc_html__('Instagram','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/instagram/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/759q2McMid0',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>',
				'keyword' => ['instagram','insta feed'],
			],
			'tp_wp_bodymovin' => [
				'label' => esc_html__('LottieFiles Animation','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/lottiefiles-animations-elementor/',
				'docUrl' => 'https://docs.posimyth.com/tpae/lottiefiles-animation/',
				'videoUrl' => 'https://www.youtube.com/embed/_lnXp8DnNxs',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 480h72.5c4.615 0 9.232-.528 13.722-1.569l123.25-28.57c13.133-3.044 24.995-10.478 33.4-20.933 8.466-10.531 13.128-23.746 13.128-37.21V177.445c0-21.438-11.684-41.333-30.492-51.92l-101.5-57.139c-36.681-20.651-64.548-.478-88.228 28.683l-156.211-60.46c-34.639-13.405-73.672 3.411-87.35 37.709-13.696 34.345 3.326 73.326 38.212 86.829L176 192l-108.5-2.843c-37.22 0-67.5 29.991-67.5 66.855s30.28 66.854 67.5 66.854h102.327c-9.558 28.393 3.681 59.705 31.297 72.775C183.12 434.864 212.126 480 256 480zM364.311 96.271l101.5 57.14c8.753 4.927 14.189 14.137 14.189 24.035v214.272c0 12.91-8.945 24.001-21.754 26.97l-123.25 28.57a28.843 28.843 0 0 1-6.496.742H256c-37.41 0-37.35-55.424 0-55.424a8 8 0 0 0 8-8v-7.143a8 8 0 0 0-8-8h-29c-37.41 0-37.351-55.425 0-55.425h29a8 8 0 0 0 8-8v-7.143a8 8 0 0 0-8-8H67.5c-47.021 0-46.929-69.709 0-69.709H256a8 8 0 0 0 8-8V201.04a8 8 0 0 0-5.112-7.461L97.981 131.305c-43.579-16.867-17.902-81.857 26.037-64.852l172.497 66.761a8.002 8.002 0 0 0 9.098-2.418l22.54-27.757c8.76-10.785 23.966-13.632 36.158-6.768z"/></svg>',
				'keyword' => ['bodymoving', 'animations', 'lottiefiles', 'bodylines'],
			],
			'tp_mailchimp' => [
				'label' => esc_html__('Mailchimp','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/mailchimp/',
				'docUrl' => 'https://docs.posimyth.com/tpae/mailchimp-subscription-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/I7BLgbK6nBA',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z"/></svg>',
				'keyword' => ['mailchimp'],
			],
			'tp_meeting_scheduler' => [
				'label' => esc_html__('Meeting Scheduler','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/meeting-schedular-apps-integration-elementor/',
				'docUrl' => 'https://docs.posimyth.com/tpae/meeting-scheduler-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/9-8Ftlb79tI',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M400 64h-48V12c0-6.627-5.373-12-12-12h-8c-6.627 0-12 5.373-12 12v52H128V12c0-6.627-5.373-12-12-12h-8c-6.627 0-12 5.373-12 12v52H48C21.49 64 0 85.49 0 112v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zM48 96h352c8.822 0 16 7.178 16 16v48H32v-48c0-8.822 7.178-16 16-16zm352 384H48c-8.822 0-16-7.178-16-16V192h384v272c0 8.822-7.178 16-16 16z"/></svg>',
				'keyword' => ['meeting scheduler','calendly','freebusy','free busy','meetingbird','meeting bird','vyte','xai','x ai'],
			],
			'tp_messagebox' => [
				'label' => esc_html__('Message Box','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/message-box/',
				'docUrl' => 'https://docs.posimyth.com/tpae/message-box/',
				'videoUrl' => 'https://youtu.be/yEdMsJiC7Js',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M400 64h-48V12c0-6.627-5.373-12-12-12h-8c-6.627 0-12 5.373-12 12v52H128V12c0-6.627-5.373-12-12-12h-8c-6.627 0-12 5.373-12 12v52H48C21.49 64 0 85.49 0 112v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zM48 96h352c8.822 0 16 7.178 16 16v48H32v-48c0-8.822 7.178-16 16-16zm352 384H48c-8.822 0-16-7.178-16-16V192h384v272c0 8.822-7.178 16-16 16z"/></svg>',
				'keyword' => ['message box'],
			],
			'tp_mobile_menu' => [
				'label' => esc_html__('Mobile Menu','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/mobile-menu/',
				'docUrl' => 'https://docs.posimyth.com/tpae/mobile-menu/',
				'videoUrl' => 'https://www.youtube.com/embed/PDXbtRsYwGE',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 320 512"><path d="M192 416c0 17.7-14.3 32-32 32s-32-14.3-32-32 14.3-32 32-32 32 14.3 32 32zM320 48v416c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h224c26.5 0 48 21.5 48 48zm-32 0c0-8.8-7.2-16-16-16H48c-8.8 0-16 7.2-16 16v416c0 8.8 7.2 16 16 16h224c8.8 0 16-7.2 16-16V48z"/></svg>',
				'keyword' => ['accordion','faq'],
			],
			'tp_morphing_layouts' => [
				'label' => esc_html__('Morphing Layouts','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/morphing-sections/',
				'docUrl' => 'https://docs.posimyth.com/tpae/morphing-sections/',
				'videoUrl' => 'https://www.youtube.com/embed/VDBINvedP2k',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M634.4 279.09L525.35 103.12C522.18 98.38 517.09 96 512 96s-10.18 2.38-13.35 7.12L389.6 279.09c-3.87 5.78-6.09 12.72-5.51 19.64C389.56 364.4 444.74 416 512 416s122.44-51.6 127.91-117.27c.58-6.92-1.64-13.86-5.51-19.64zM512 384c-41.58 0-77.55-27.13-90.78-64h181.2C589 357.23 553.28 384 512 384zm-90.27-96l90.31-145.76L602.98 288H421.73zM536 480H336V125.74c27.56-7.14 48-31.95 48-61.74h152c4.42 0 8-3.58 8-8V40c0-4.42-3.58-8-8-8H374.89c-.15-.26-4.37-11.11-19.11-21.07C345.57 4.03 333.25 0 320 0s-25.57 4.03-35.78 10.93c-14.74 9.96-18.96 20.81-19.11 21.07H104c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h152c0 29.79 20.44 54.6 48 61.74V480H104c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h432c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zM288 64c0-17.67 14.33-32 32-32s32 14.33 32 32-14.33 32-32 32-32-14.33-32-32zm-32.09 234.73c.58-6.92-1.64-13.86-5.51-19.64L141.35 103.12C138.18 98.38 133.09 96 128 96s-10.18 2.38-13.35 7.12L5.6 279.09c-3.87 5.78-6.09 12.72-5.51 19.64C5.56 364.4 60.74 416 128 416s122.44-51.6 127.91-117.27zM128.04 142.24L218.98 288H37.73l90.31-145.76zM37.22 320h181.2C205 357.23 169.28 384 128 384c-41.58 0-77.55-27.13-90.78-64z"/></svg>',
				'keyword' => ['morphing', 'morphing sections', 'blob section', 'blob builder', 'SVG Sections'],
			],
			'tp_mouse_cursor' => [
				'label' => esc_html__('Mouse Cursor','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/mouse-cursor-icon-widget/',
				'docUrl' => 'https://docs.posimyth.com/tpae/mouse-cursor/',
				'videoUrl' => 'https://youtu.be/ggEhdsdjxxw',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 320 512"><path d="M154.149 488.438l-41.915-101.865-46.788 52.8C42.432 465.345 0 448.788 0 413.5V38.561c0-34.714 41.401-51.675 64.794-26.59L309.547 274.41c22.697 24.335 6.074 65.09-27.195 65.09h-65.71l42.809 104.037c8.149 19.807-1.035 42.511-20.474 50.61l-36 15.001c-19.036 7.928-40.808-1.217-48.828-20.71zm-31.84-161.482l61.435 149.307c1.182 2.877 4.117 4.518 6.926 3.347l35.999-15c3.114-1.298 4.604-5.455 3.188-8.896L168.872 307.5h113.479c5.009 0 7.62-7.16 3.793-11.266L41.392 33.795C37.785 29.932 32 32.879 32 38.561V413.5c0 5.775 5.935 8.67 9.497 4.65l80.812-91.194z"/></svg>',
				'keyword' => ['mouse cursor'],
			],
			'tp_navigation_menu_lite' => [
				'label' => esc_html__('TP Navigation Menu Lite','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/elementor-header-navigation-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/navigation-menu/',
				'videoUrl' => 'https://www.youtube.com/embed/ozRGPdEu9qQ',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M442 114H6a6 6 0 0 1-6-6V84a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6z"/></svg>',
				'keyword' => ['navigation menu', 'mega menu', 'header builder', 'sticky menu', 'navigation bar', 'header menu', 'menu', 'navigation builder'],
			],
			'tp_navigation_menu' => [
				'label' => esc_html__('TP Navigation Menu','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/navigation-menu/',
				'docUrl' => 'https://docs.posimyth.com/tpae/navigation-builder-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/ozRGPdEu9qQ',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M442 114H6a6 6 0 0 1-6-6V84a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6z"/></svg>',
				'keyword' => ['navigation menu', 'mega menu', 'header builder', 'sticky menu', 'navigation bar', 'header menu', 'menu', 'navigation builder'],
			],
			'tp_ninja_form' => [
				'label' => esc_html__('Ninja Form','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/ninja-forms/',
				'docUrl' => 'https://docs.posimyth.com/tpae/ninja-forms-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/fVxGZW8SZgE',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M349.32 52.26C328.278 35.495 292.938 0 256 0c-36.665 0-71.446 34.769-93.31 52.26-34.586 27.455-109.525 87.898-145.097 117.015A47.99 47.99 0 0 0 0 206.416V464c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V206.413a47.989 47.989 0 0 0-17.597-37.144C458.832 140.157 383.906 79.715 349.32 52.26zM464 480H48c-8.837 0-16-7.163-16-16V206.161c0-4.806 2.155-9.353 5.878-12.392C64.16 172.315 159.658 95.526 182.59 77.32 200.211 63.27 232.317 32 256 32c23.686 0 55.789 31.27 73.41 45.32 22.932 18.207 118.436 95.008 144.714 116.468a15.99 15.99 0 0 1 5.876 12.39V464c0 8.837-7.163 16-16 16zm-8.753-216.312c4.189 5.156 3.393 12.732-1.776 16.905-22.827 18.426-55.135 44.236-104.156 83.148-21.045 16.8-56.871 52.518-93.318 52.258-36.58.264-72.826-35.908-93.318-52.263-49.015-38.908-81.321-64.716-104.149-83.143-5.169-4.173-5.966-11.749-1.776-16.905l5.047-6.212c4.169-5.131 11.704-5.925 16.848-1.772 22.763 18.376 55.014 44.143 103.938 82.978 16.85 13.437 50.201 45.69 73.413 45.315 23.219.371 56.562-31.877 73.413-45.315 48.929-38.839 81.178-64.605 103.938-82.978 5.145-4.153 12.679-3.359 16.848 1.772l5.048 6.212z"/></svg>',
				'keyword' => ['ninja form','form'],
			],
			'tp_number_counter' => [
				'label' => esc_html__('Number Counter','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/number-counter/',
				'docUrl' => 'https://docs.posimyth.com/tpae/number-counter-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/QdlEv0BTkRc',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M446.381 182.109l1.429-8c1.313-7.355-4.342-14.109-11.813-14.109h-98.601l20.338-113.891C359.047 38.754 353.392 32 345.92 32h-8.127a12 12 0 0 0-11.813 9.891L304.89 160H177.396l20.338-113.891C199.047 38.754 193.392 32 185.92 32h-8.127a12 12 0 0 0-11.813 9.891L144.89 160H42.003a12 12 0 0 0-11.813 9.891l-1.429 8C27.448 185.246 33.103 192 40.575 192h98.6l-22.857 128H13.432a12 12 0 0 0-11.813 9.891l-1.429 8C-1.123 345.246 4.532 352 12.003 352h98.601L90.266 465.891C88.953 473.246 94.608 480 102.08 480h8.127a12 12 0 0 0 11.813-9.891L143.11 352h127.494l-20.338 113.891C248.953 473.246 254.608 480 262.08 480h8.127a12 12 0 0 0 11.813-9.891L303.11 352h102.886a12 12 0 0 0 11.813-9.891l1.429-8c1.313-7.355-4.342-14.109-11.813-14.109h-98.601l22.857-128h102.886a12 12 0 0 0 11.814-9.891zM276.318 320H148.825l22.857-128h127.494l-22.858 128z"/></svg>',
				'keyword' => ['number counter','counter'],
			],
			'tp_post_title' => [
				'label' => esc_html__('Post Title','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-title/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path fill="currentColor" d="M32 64h32v160c0 88.22 71.78 160 160 160s160-71.78 160-160V64h32a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16H272a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32v160a80 80 0 0 1-160 0V64h32a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16H32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm400 384H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path></svg>',
				'keyword' => ['post title'],
			],
			'tp_post_content' => [
				'label' => esc_html__('Post Content','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-content/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path fill="currentColor" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm64 236c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-64c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12v8zm0-72v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm96-114.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"></path></svg>',
				'keyword' => ['post content'],
			],
			'tp_post_featured_image' => [
				'label' => esc_html__('Post Featured Image','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-featured-image/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm32-48h224V288l-23.5-23.5c-4.7-4.7-12.3-4.7-17 0L176 352l-39.5-39.5c-4.7-4.7-12.3-4.7-17 0L80 352v64zm48-240c-26.5 0-48 21.5-48 48s21.5 48 48 48 48-21.5 48-48-21.5-48-48-48z"></path></svg>',
				'keyword' => ['post featured image'],
			],
			'tp_post_meta' => [
				'label' => esc_html__('Post Meta','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-meta/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>',
				'keyword' => ['post meta'],
			],
			'tp_post_author' => [
				'label' => esc_html__('Post Author','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-author/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>',
				'keyword' => ['post author'],
			],
			'tp_post_comment' => [
				'label' => esc_html__('Post Comment','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-comment/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32zM128 272c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm128 0c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm128 0c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z"></path></svg>',
				'keyword' => ['post comment'],
			],
			'tp_post_navigation' => [
				'label' => esc_html__('Post Prev/Next','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/blog-builder/#blog-single',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-navigation/',
				'videoUrl' => 'https://youtu.be/sU-gLRCZnLs',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M0 168v-16c0-13.255 10.745-24 24-24h360V80c0-21.367 25.899-32.042 40.971-16.971l80 80c9.372 9.373 9.372 24.569 0 33.941l-80 80C409.956 271.982 384 261.456 384 240v-48H24c-13.255 0-24-10.745-24-24zm488 152H128v-48c0-21.314-25.862-32.08-40.971-16.971l-80 80c-9.372 9.373-9.372 24.569 0 33.941l80 80C102.057 463.997 128 453.437 128 432v-48h360c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24z"></path></svg>',
				'keyword' => ['post previous next'],
			],
			'tp_off_canvas' => [
				'label' => esc_html__('Popup Builder','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/popup-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/popup-builder/',
				'videoUrl' => 'https://youtu.be/74bj6WcEhiY',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M442 114H6a6 6 0 0 1-6-6V84a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6z"/></svg>',
				'keyword' => ['offcanvas', 'popup', 'modal box', 'modal popup'],
			],
			'tp_page_scroll' => [
				'label' => esc_html__('Page Scroll','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/#plus-scroll',
				'docUrl' => 'https://docs.posimyth.com/tpae/page-scroll-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/8An5WSz3TUo',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M505.07337,19.34375C503.85462,13.73438,498.32338,8.20312,492.72964,7c-32.62885-7-58.162-7-83.57017-7C305.39988,0,242.95858,55.09375,196.236,128H94.82015c-16.34567.01562-35.53314,11.875-42.87883,26.48438L2.53125,253.29688A28.125,28.125,0,0,0,0,264a24.00659,24.00659,0,0,0,24.00191,24h92.63266l-10.59373,21.42188c-9.33592,18.91015,4.27733,34.77539,6.15624,36.625l53.75381,53.71874c1.85352,1.86329,17.789,15.47852,36.62885,6.14063l21.37692-10.57813V488a24.14815,24.14815,0,0,0,24.00191,24,28.02956,28.02956,0,0,0,10.625-2.53125l98.72835-49.39063c14.625-7.3125,26.50191-26.5,26.50191-42.85937V315.70312C456.6008,268.9375,511.98156,206.25,511.98156,103,512.07531,77.46875,512.07531,52,505.07337,19.34375ZM36.94134,256l43.59759-87.20312c2.46874-4.82813,8.84373-8.78126,14.28122-8.79688h85.19517c-13.93943,28.0625-31.72065,64-47.56632,96ZM351.84316,417.1875c-.03125,5.4375-4.002,11.84375-8.87694,14.26562L255.95855,475V379.48438c32.00386-15.82813,67.81825-33.59376,95.88461-47.54688Zm14.625-128.28125c-39.50383,19.78125-135.88649,67.4375-177.92157,88.23437l-53.81632-53.54687c20.87692-42.23437,68.537-138.59375,88.22642-178.1875C273.17923,67,330.65374,32,409.15947,32c21.53317,0,42.00384,0,66.63075,4.29688,4.34374,24.85937,4.25,45.20312,4.18749,66.6875C479.97771,181.0625,444.97582,238.45312,366.46813,288.90625ZM367.98962,88.0293a55.99512,55.99512,0,1,0,55.99209,55.99414A56.01691,56.01691,0,0,0,367.98962,88.0293Zm0,79.99218a23.998,23.998,0,1,1,23.99605-23.998A24.02247,24.02247,0,0,1,367.98962,168.02148Z"/></svg>',
				'keyword' => ['one page scroll', 'full page js', 'page piling', 'page pilling', 'multi scroll', 'page scroll', 'scroll'],
			],
			'tp_pre_loader' => [
				'label' => esc_html__('Pre Loader','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/pre-loader/',
				'docUrl' => 'https://docs.posimyth.com/tpae/pre-loader/',
				'videoUrl' => 'https://youtu.be/pi5i45p8sxc',
				'tag' => 'pro',
				'labelIcon' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="spinner" class="svg-inline--fa fa-spinner fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>',
				'keyword' => ['loader', 'preloader', 'pre loader'],
			],
			'tp_pricing_list' => [
				'label' => esc_html__('Pricing List','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/pricing-list/',
				'docUrl' => 'https://docs.posimyth.com/tpae/pricing-list/',
				'videoUrl' => 'https://www.youtube.com/embed/0zSX-ovDcwM',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zm-22.6 22.7c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9zM336 480H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304c0 8.8-7.2 16-16 16zm-48-244v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12z"/></svg>',
				'keyword' => ['pricing list','food menu','catalogue'],
			],
			'tp_pricing_table' => [
				'label' => esc_html__('Pricing Table','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/pricing-table/',
				'docUrl' => 'https://docs.posimyth.com/tpae/pricing-tables-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/9V0E9mFmaro',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M608 64H32C14.3 64 0 78.3 0 96v320c0 17.7 14.3 32 32 32h576c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32zM32 96h64c0 35.3-28.7 64-64 64zm0 320v-64c35.3 0 64 28.7 64 64zm576 0h-64c0-35.3 28.7-64 64-64zm0-96c-52.9 0-96 43.1-96 96H128c0-52.9-43.1-96-96-96V192c52.9 0 96-43.1 96-96h384c0 52.9 43.1 96 96 96zm0-160c-35.3 0-64-28.7-64-64h64zm-288-32c-61.9 0-112 57.3-112 128s50.1 128 112 128c61.8 0 112-57.3 112-128s-50.1-128-112-128zm0 224c-44.1 0-80-43.1-80-96s35.9-96 80-96 80 43.1 80 96-35.9 96-80 96zm32-63.9h-16v-88c0-4.4-3.6-8-8-8h-13.7c-4.7 0-9.4 1.4-13.3 4l-15.3 10.2c-3.7 2.5-4.6 7.4-2.2 11.1l8.9 13.3c2.5 3.7 7.4 4.6 11.1 2.2l.5-.3V288h-16c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h64c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-7.9z"/></svg>',
				'keyword' => ['accordion','faq'],
			],
			'tp_product_listout' => [
				'label' => esc_html__('Product Listing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#woo-products',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-product-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/UqJ9VNTeqA8',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M326.3 218.8c0 20.5-16.7 37.2-37.2 37.2h-70.3v-74.4h70.3c20.5 0 37.2 16.7 37.2 37.2zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-128.1-37.2c0-47.9-38.9-86.8-86.8-86.8H169.2v248h49.6v-74.4h70.3c47.9 0 86.8-38.9 86.8-86.8z"></path></svg>',
				'keyword' => ['product listing','listing','woocommerce'],
			],
			'tp_protected_content' => [
				'label' => esc_html__('Protected Content','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/protected-content/',
				'docUrl' => 'https://docs.posimyth.com/tpae/protected-content/',
				'videoUrl' => 'https://www.youtube.com/embed/Nrw2nK8PvQs',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M400 224h-16v-62.5C384 73.1 312.9.3 224.5 0 136-.3 64 71.6 64 160v64H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zM96 160c0-70.6 57.4-128 128-128s128 57.4 128 128v64H96v-64zm304 320H48c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h352c8.8 0 16 7.2 16 16v192c0 8.8-7.2 16-16 16z"/></svg>',
				'keyword' => ['protected content'],
			],
			'tp_post_search' => [
				'label' => esc_html__('Post Search','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/search-bar',
				'docUrl' => 'https://docs.posimyth.com/tpae/post-search-bar/',
				'videoUrl' => 'https://www.youtube.com/embed/3k8sPvQkQvA',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z"/></svg>',
				'keyword' => ['post search','search'],
			],
			'tp_progress_bar' => [
				'label' => esc_html__('Progress Bar','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/progress-bar/',
				'docUrl' => 'https://docs.posimyth.com/tpae/progress-bars/',
				'videoUrl' => 'https://www.youtube.com/embed/01purtRY770',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 544 512"><path d="M527.79 288H290.5l158.03 158.03a16.51 16.51 0 0 0 11.62 4.81c3.82 0 7.62-1.35 10.57-4.13 38.7-36.46 65.32-85.61 73.13-140.86 1.34-9.46-6.51-17.85-16.06-17.85zm-67.91 124.12L367.76 320h140.88c-8.12 34.16-24.96 66-48.76 92.12zM224 288V50.71c0-8.83-7.18-16.21-15.74-16.21-.69 0-1.4.05-2.11.15C86.99 51.49-4.1 155.6.14 280.37 4.47 407.53 113.18 512 240.13 512c.98 0 1.93-.01 2.91-.02 50.4-.63 96.97-16.87 135.26-44.03 7.9-5.6 8.42-17.23 1.57-24.08L224 288zm18.63 191.98l-2.51.02c-109.04 0-204.3-91.92-208-200.72C28.72 179.15 96.33 92.25 192 69.83v231.42l9.37 9.37 141.84 141.84c-30.56 17.62-64.96 27.08-100.58 27.52zM511.96 223.2C503.72 103.74 408.26 8.28 288.8.04c-.35-.03-.7-.04-1.04-.04C279.1 0 272 7.45 272 16.23V240h223.77c9.14 0 16.82-7.68 16.19-16.8zM304 208V33.9c89.25 13.81 160.28 84.85 174.1 174.1H304z"/></svg>',
				'keyword' => ['pie chart', 'progress bar', 'chart'],
			],
			'tp_process_steps' => [
				'label' => esc_html__('Process Steps','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/process-steps/',
				'docUrl' => 'https://docs.posimyth.com/tpae/process-steps/',
				'videoUrl' => 'https://www.youtube.com/embed/3ude_wxrqVo',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 320 512"><path d="M192 256c0 17.7-14.3 32-32 32s-32-14.3-32-32 14.3-32 32-32 32 14.3 32 32zm88-32c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm-240 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32z"/></svg>',
				'keyword' => ['process', 'steps', 'sequence','process bar'],
			],
			'tp_row_background' => [
				'label' => esc_html__('Row Background','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/#plus-sections',
				'docUrl' => 'https://docs.posimyth.com/tpae/row-background-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/2uIMQCIfjlM',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M455.59 0c-15.81 0-30.62 6.99-41.93 17.15C195.73 211.82 169.77 216.5 179.98 281.99c-41.52 4.96-78.59 24.05-100.32 81.32-2.68 7.08-9.12 11.38-16.64 11.38-12.67 0-51.85-31.56-63.02-39.19C0 429.45 43.26 512 146 512c117.18 0 152.72-87.75 145.06-145.89 56.9-7.01 97.15-62.51 206.45-266.49C505.2 84.65 512 68.48 512 51.66 512 21.52 484.89 0 455.59 0zM236.52 445.55C216.47 468.41 186.02 480 146 480c-63.78 0-92.29-38.83-104.75-78.69 8.02 3.65 14.98 5.39 21.77 5.39 20.92 0 39.2-12.58 46.56-32.03 6.65-17.52 16.05-53.95 83.76-62.04l65.08 50.62c4.03 30.68-1.25 58.75-21.9 82.3zM469.31 84.5c-118.4 220.96-143.69 245.11-194.08 251.31l-62-48.22c-8.8-56.43-14.8-35.28 221.82-246.64 6.33-5.69 13.81-8.95 20.54-8.95C467.38 32 480 39.9 480 51.66c0 10.58-5.54 22.79-10.69 32.84z"/></svg>',
				'keyword' => ['row background', 'section background', 'canvas', 'particles js', 'segmentation', 'gallery background', 'slideshow background', 'video background', 'youtube background', 'vimeo background', 'mobile video background', 'parallax background, segment', 'animated gradient background', 'on scroll background color change', 'on scroll morphing shape background', 'background fixed SVG morphing', 'on Scroll background Image change', 'kenburn gallery', 'kenburn background'],
			],
			'tp_scroll_navigation' => [
				'label' => esc_html__('Scroll Navigation','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/one-page-scroll-navigation/',
				'docUrl' => 'https://docs.posimyth.com/tpae/scroll-navigation/',
				'videoUrl' => 'https://www.youtube.com/embed/vAg6GNktZTQ',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 320 512"><path d="M288 288H32c-28.4 0-42.8 34.5-22.6 54.6l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c20-20.1 5.7-54.6-22.7-54.6zM160 448L32 320h256L160 448zM32 224h256c28.4 0 42.8-34.5 22.6-54.6l-128-128c-12.5-12.5-32.8-12.5-45.3 0l-128 128C-10.7 189.5 3.6 224 32 224zM160 64l128 128H32L160 64z"/></svg>',
				'keyword' => ['scroll navigation'],
			],
			'tp_site_logo' => [
				'label' => esc_html__('Site Logo','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/elementor-header-navigation-builder/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/96Wh1AEKNtU',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M216 24.01c0-23.8-31.16-33.11-44.15-13.04C76.55 158.25 200 238.73 200 288c0 22.06-17.94 40-40 40s-40-17.94-40-40V182.13c0-19.39-21.85-30.76-37.73-19.68C30.75 198.38 0 257.28 0 320c0 105.87 86.13 192 192 192s192-86.13 192-192c0-170.29-168-192.85-168-295.99zM192 480c-88.22 0-160-71.78-160-160 0-46.94 20.68-97.75 56-128v96c0 39.7 32.3 72 72 72s72-32.3 72-72c0-65.11-112-128-45.41-248C208 160 352 175.3 352 320c0 88.22-71.78 160-160 160z"/></svg>',
				'keyword' => ['site logo','logo'],
			],
			'tp_smooth_scroll' => [
				'label' => esc_html__('Smooth Scroll','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/smooth-scroll/',
				'docUrl' => 'https://docs.posimyth.com/tpae/smooth-scroll/',
				'videoUrl' => 'https://www.youtube.com/embed/H_RjZfhf9os',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M368 32h4c6.627 0 12-5.373 12-12v-8c0-6.627-5.373-12-12-12H12C5.373 0 0 5.373 0 12v8c0 6.627 5.373 12 12 12h4c0 91.821 44.108 193.657 129.646 224C59.832 286.441 16 388.477 16 480h-4c-6.627 0-12 5.373-12 12v8c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12v-8c0-6.627-5.373-12-12-12h-4c0-91.821-44.108-193.657-129.646-224C324.168 225.559 368 123.523 368 32zM48 32h288c0 110.457-64.471 200-144 200S48 142.457 48 32zm288 448H48c0-110.457 64.471-200 144-200s144 89.543 144 200zM285.621 96H98.379a12.01 12.01 0 0 1-11.602-8.903 199.464 199.464 0 0 1-2.059-8.43C83.054 71.145 88.718 64 96.422 64h191.157c7.704 0 13.368 7.145 11.704 14.667a199.464 199.464 0 0 1-2.059 8.43A12.013 12.013 0 0 1 285.621 96zm-15.961 50.912a141.625 141.625 0 0 1-6.774 8.739c-2.301 2.738-5.671 4.348-9.248 4.348H130.362c-3.576 0-6.947-1.61-9.248-4.348a142.319 142.319 0 0 1-6.774-8.739c-5.657-7.91.088-18.912 9.813-18.912h135.694c9.725 0 15.469 11.003 9.813 18.912z"/></svg>',
				'keyword' => ['smooth scroll'],
			],
			'tp_social_embed' => [
				'label' => esc_html__('Social Embed','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/social-embed/',
				'docUrl' => 'https://docs.posimyth.com/tpae/social-embed/',
				'videoUrl' => 'https://youtu.be/MbopAQ85pdg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M278.9 511.5l-61-17.7c-6.4-1.8-10-8.5-8.2-14.9L346.2 8.7c1.8-6.4 8.5-10 14.9-8.2l61 17.7c6.4 1.8 10 8.5 8.2 14.9L293.8 503.3c-1.9 6.4-8.5 10.1-14.9 8.2zm-114-112.2l43.5-46.4c4.6-4.9 4.3-12.7-.8-17.2L117 256l90.6-79.7c5.1-4.5 5.5-12.3.8-17.2l-43.5-46.4c-4.5-4.8-12.1-5.1-17-.5L3.8 247.2c-5.1 4.7-5.1 12.8 0 17.5l144.1 135.1c4.9 4.6 12.5 4.4 17-.5zm327.2.6l144.1-135.1c5.1-4.7 5.1-12.8 0-17.5L492.1 112.1c-4.8-4.5-12.4-4.3-17 .5L431.6 159c-4.6 4.9-4.3 12.7.8 17.2L523 256l-90.6 79.7c-5.1 4.5-5.5 12.3-.8 17.2l43.5 46.4c4.5 4.9 12.1 5.1 17 .6z"></path></svg>',
				'keyword' => ['social embed'],
			],
			'tp_social_feed' => [
				'label' => esc_html__('Social Feed','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/social-feed',
				'docUrl' => 'https://docs.posimyth.com/tpae/social-feed/',
				'videoUrl' => '#',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path  d="M128.081 415.959c0 35.369-28.672 64.041-64.041 64.041S0 451.328 0 415.959s28.672-64.041 64.041-64.041 64.04 28.673 64.04 64.041zm175.66 47.25c-8.354-154.6-132.185-278.587-286.95-286.95C7.656 175.765 0 183.105 0 192.253v48.069c0 8.415 6.49 15.472 14.887 16.018 111.832 7.284 201.473 96.702 208.772 208.772.547 8.397 7.604 14.887 16.018 14.887h48.069c9.149.001 16.489-7.655 15.995-16.79zm144.249.288C439.596 229.677 251.465 40.445 16.503 32.01 7.473 31.686 0 38.981 0 48.016v48.068c0 8.625 6.835 15.645 15.453 15.999 191.179 7.839 344.627 161.316 352.465 352.465.353 8.618 7.373 15.453 15.999 15.453h48.068c9.034-.001 16.329-7.474 16.005-16.504z"></path></svg>',
				'keyword' => ['social feed'],
			],
			'tp_social_icon' => [
				'label' => esc_html__('Social Icon','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/social-icon/',
				'docUrl' => 'https://docs.posimyth.com/tpae/social-icon/',
				'videoUrl' => 'https://www.youtube.com/embed/exz4Ahc-KeA',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M566.633 169.37L406.63 9.392C386.626-10.612 352 3.395 352 32.022v72.538C210.132 108.474 88 143.455 88 286.3c0 84.74 49.78 133.742 79.45 155.462 24.196 17.695 58.033-4.917 49.7-34.51C188.286 304.843 225.497 284.074 352 280.54V352c0 28.655 34.654 42.606 54.63 22.63l160.003-160c12.489-12.5 12.489-32.76 0-45.26zM384 352V248.04c-141.718.777-240.762 15.03-197.65 167.96C154.91 393 120 351.28 120 286.3c0-134.037 131.645-149.387 264-150.26V32l160 160-160 160zm37.095 52.186c2.216-1.582 4.298-3.323 6.735-5.584 7.68-7.128 20.17-1.692 20.17 8.787V464c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48V112c0-26.51 21.49-48 48-48h172.146c6.612 0 11.954 5.412 11.852 12.04-.084 5.446-4.045 10.087-9.331 11.396-9.462 2.343-18.465 4.974-27.074 7.914-1.25.427-2.555.65-3.876.65H48c-8.837 0-16 7.163-16 16v352c0 8.837 7.163 16 16 16h352c8.837 0 16-7.163 16-16v-50.002c0-3.905 1.916-7.543 5.095-9.812z"/></svg>',
				'keyword' => ['social icon'],
			],
			'tp_social_reviews' => [
				'label' => esc_html__('Social Reviews','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/social-reviews/',
				'docUrl' => 'https://docs.posimyth.com/tpae/social-review/',
				'videoUrl' => 'https://youtu.be/9HiV2h_z_oM',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path  d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path></svg>',
				'keyword' => ['social reviews'],
			],
			'tp_social_sharing' => [
				'label' => esc_html__('Social Sharing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/social-sharing/',
				'docUrl' => 'https://docs.posimyth.com/tpae/social-sharing/',
				'videoUrl' => 'https://youtu.be/PIfGW6Kxs2M',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path fill="currentColor" d="M568.482 177.448L424.479 313.433C409.3 327.768 384 317.14 384 295.985v-71.963c-144.575.97-205.566 35.113-164.775 171.353 4.483 14.973-12.846 26.567-25.006 17.33C155.252 383.105 120 326.488 120 269.339c0-143.937 117.599-172.5 264-173.312V24.012c0-21.174 25.317-31.768 40.479-17.448l144.003 135.988c10.02 9.463 10.028 25.425 0 34.896zM384 379.128V448H64V128h50.916a11.99 11.99 0 0 0 8.648-3.693c14.953-15.568 32.237-27.89 51.014-37.676C185.708 80.83 181.584 64 169.033 64H48C21.49 64 0 85.49 0 112v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48v-88.806c0-8.288-8.197-14.066-16.011-11.302a71.83 71.83 0 0 1-34.189 3.377c-7.27-1.046-13.8 4.514-13.8 11.859z"></path></svg>',
				'keyword' => ['social sharing'],
			],
			'tp_style_list' => [
				'label' => esc_html__('Style List','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/stylish-list/',
				'docUrl' => 'https://docs.posimyth.com/tpae/stylish-list-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/mQuR6xN097w',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 64c8.823 0 16 7.178 16 16v352c0 8.822-7.177 16-16 16H48c-8.823 0-16-7.178-16-16V80c0-8.822 7.177-16 16-16h416m0-32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm-336 96c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm0 96c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm0 96c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm288-148v-24a6 6 0 0 0-6-6H198a6 6 0 0 0-6 6v24a6 6 0 0 0 6 6h212a6 6 0 0 0 6-6zm0 96v-24a6 6 0 0 0-6-6H198a6 6 0 0 0-6 6v24a6 6 0 0 0 6 6h212a6 6 0 0 0 6-6zm0 96v-24a6 6 0 0 0-6-6H198a6 6 0 0 0-6 6v24a6 6 0 0 0 6 6h212a6 6 0 0 0 6-6z"/></svg>',
				'keyword' => ['style list'],
			],
			'tp_switcher' => [
				'label' => esc_html__('Switcher','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/switcher/',
				'docUrl' => 'https://docs.posimyth.com/tpae/switcher/',
				'videoUrl' => 'https://www.youtube.com/embed/nYhVnMnD_UA',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M384 96c88.426 0 160 71.561 160 160 0 88.426-71.561 160-160 160H192c-88.426 0-160-71.561-160-160 0-88.425 71.561-160 160-160h192m0-32H192C85.961 64 0 149.961 0 256s85.961 192 192 192h192c106.039 0 192-85.961 192-192S490.039 64 384 64zm0 304c61.856 0 112-50.144 112-112s-50.144-112-112-112-112 50.144-112 112c0 28.404 10.574 54.339 27.999 74.082C320.522 353.335 350.548 368 384 368z"/></svg>',
				'keyword' => ['switcher'],
			],
			'tp_table' => [
				'label' => esc_html__('Table','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/table/',
				'docUrl' => 'https://docs.posimyth.com/tpae/table/',
				'videoUrl' => 'https://www.youtube.com/embed/CrY7rg_ir8k',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM160 448H48c-8.837 0-16-7.163-16-16v-80h128v96zm0-128H32v-96h128v96zm0-128H32V96h128v96zm160 256H192v-96h128v96zm0-128H192v-96h128v96zm0-128H192V96h128v96zm160 160v80c0 8.837-7.163 16-16 16H352v-96h128zm0-32H352v-96h128v96zm0-128H352V96h128v96z"/></svg>',
				'keyword' => ['table'],
			],
			'tp_table_content' => [
				'label' => esc_html__('Table Of Content','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/table-of-contents/',
				'docUrl' => 'https://docs.posimyth.com/tpae/table-of-content/',
				'videoUrl' => 'https://youtu.be/NWhr5lOm_3Y',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM160 448H48c-8.837 0-16-7.163-16-16v-80h128v96zm0-128H32v-96h128v96zm0-128H32V96h128v96zm160 256H192v-96h128v96zm0-128H192v-96h128v96zm0-128H192V96h128v96zm160 160v80c0 8.837-7.163 16-16 16H352v-96h128zm0-32H352v-96h128v96zm0-128H352V96h128v96z"/></svg>',
				'keyword' => ['table of content'],
			],
			'tp_tabs_tours' => [
				'label' => esc_html__('Tabs/Tours','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/tabs-tours/',
				'docUrl' => 'https://docs.posimyth.com/tpae/tabs-tours/',
				'videoUrl' => 'https://www.youtube.com/embed/6clEoNvxtLY',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48H48C21.49 32 0 53.49 0 80zm480 0v90.667H192V64h272c8.837 0 16 7.163 16 16zm0 229.333H192V202.667h288v106.666zM32 202.667h128v106.667H32V202.667zM160 64v106.667H32V80c0-8.837 7.163-16 16-16h112zM32 432v-90.667h128V448H48c-8.837 0-16-7.163-16-16zm160 16V341.333h288V432c0 8.837-7.163 16-16 16H192z"/></svg>',
				'keyword' => ['tabs/tours','tabs'],
			],
			'tp_team_member_listout' => [
				'label' => esc_html__('Team Member Listing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#Team%20member',
				'docUrl' => 'https://docs.posimyth.com/tpae/team-member-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/cf2Ia1vyKZQ',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M544 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zM320 256c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm244 192h-40c-15.2 0-29.3 4.8-41.1 12.9 9.4 6.4 17.9 13.9 25.4 22.4 4.9-2.1 10.2-3.3 15.7-3.3h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zM96 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zm304.1 180c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9-12.4 18.4-19.6 40.5-19.6 64.3V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM480 432c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zM157.1 268.9c-11.9-8.1-26-12.9-41.1-12.9H76c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c5.5 0 10.8 1.2 15.7 3.3 7.5-8.5 16.1-16 25.4-22.4z"/></svg>',
				'keyword' => ['team member','listing'],
			],
			'tp_testimonial_listout' => [
				'label' => esc_html__('Testimonial','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/pluslisting/#plus-testimonial',
				'docUrl' => 'https://docs.posimyth.com/tpae/testimonials-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/a41vZMh1_oA',
				'tag' => 'freemium',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M544 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zM320 256c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm244 192h-40c-15.2 0-29.3 4.8-41.1 12.9 9.4 6.4 17.9 13.9 25.4 22.4 4.9-2.1 10.2-3.3 15.7-3.3h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zM96 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zm304.1 180c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9-12.4 18.4-19.6 40.5-19.6 64.3V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM480 432c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zM157.1 268.9c-11.9-8.1-26-12.9-41.1-12.9H76c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c5.5 0 10.8 1.2 15.7 3.3 7.5-8.5 16.1-16 25.4-22.4z"/></svg>',
				'keyword' => ['testimonial','listing'],
			],
			'tp_timeline' => [
				'label' => esc_html__('Timeline','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/timeline/',
				'docUrl' => 'https://docs.posimyth.com/tpae/timeline/',
				'videoUrl' => 'https://www.youtube.com/embed/9AVvXE-e-IY',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 64 512"><path d="M32 224c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zM0 136c0 17.7 14.3 32 32 32s32-14.3 32-32-14.3-32-32-32-32 14.3-32 32zm0 240c0 17.7 14.3 32 32 32s32-14.3 32-32-14.3-32-32-32-32 14.3-32 32z"/></svg>',
				'keyword' => ['timeline'],
			],
			'tp_video_player' => [
				'label' => esc_html__('Video Player','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/videos/',
				'docUrl' => 'https://docs.posimyth.com/tpae/video-player/',
				'videoUrl' => 'https://www.youtube.com/embed/i3IeWaz0N-k',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M543.9 96c-6.2 0-12.5 1.8-18.2 5.7L416 171.6v-59.8c0-26.4-23.2-47.8-51.8-47.8H51.8C23.2 64 0 85.4 0 111.8v288.4C0 426.6 23.2 448 51.8 448h312.4c28.6 0 51.8-21.4 51.8-47.8v-59.8l109.6 69.9c5.7 4 12.1 5.7 18.2 5.7 16.6 0 32.1-13 32.1-31.5v-257c.1-18.5-15.4-31.5-32-31.5zM384 400.2c0 8.6-9.1 15.8-19.8 15.8H51.8c-10.7 0-19.8-7.2-19.8-15.8V111.8c0-8.6 9.1-15.8 19.8-15.8h312.4c10.7 0 19.8 7.2 19.8 15.8v288.4zm160-15.7l-1.2-1.3L416 302.4v-92.9L544 128v256.5z"/></svg>',
				'keyword' => ['video','video player','player'],
			],
			'tp_unfold' => [
				'label' => esc_html__('Unfold','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/unfold-expand-toggle/',
				'docUrl' => 'https://docs.posimyth.com/tpae/unfold/',
				'videoUrl' => 'https://www.youtube.com/embed/EXPgcTuanPA',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M527.95 224H480v-48c0-26.51-21.49-48-48-48H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h385.057c28.068 0 54.135-14.733 68.599-38.84l67.453-112.464C588.24 264.812 565.285 224 527.95 224zM48 96h146.745l64 64H432c8.837 0 16 7.163 16 16v48H171.177c-28.068 0-54.135 14.733-68.599 38.84L32 380.47V112c0-8.837 7.163-16 16-16zm493.695 184.232l-67.479 112.464A47.997 47.997 0 0 1 433.057 416H44.823l82.017-136.696A48 48 0 0 1 168 256h359.975c12.437 0 20.119 13.568 13.72 24.232z"/></svg>',
				'keyword' => ['unfold'],
			],
			'tp_wp_forms' => [
				'label' => esc_html__('WP Forms','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/wpforms/',
				'docUrl' => 'https://docs.posimyth.com/tpae/wp-forms-widget/',
				'videoUrl' => 'https://www.youtube.com/embed/fp-R1TNr4RA',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M349.32 52.26C328.278 35.495 292.938 0 256 0c-36.665 0-71.446 34.769-93.31 52.26-34.586 27.455-109.525 87.898-145.097 117.015A47.99 47.99 0 0 0 0 206.416V464c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V206.413a47.989 47.989 0 0 0-17.597-37.144C458.832 140.157 383.906 79.715 349.32 52.26zM464 480H48c-8.837 0-16-7.163-16-16V206.161c0-4.806 2.155-9.353 5.878-12.392C64.16 172.315 159.658 95.526 182.59 77.32 200.211 63.27 232.317 32 256 32c23.686 0 55.789 31.27 73.41 45.32 22.932 18.207 118.436 95.008 144.714 116.468a15.99 15.99 0 0 1 5.876 12.39V464c0 8.837-7.163 16-16 16zm-8.753-216.312c4.189 5.156 3.393 12.732-1.776 16.905-22.827 18.426-55.135 44.236-104.156 83.148-21.045 16.8-56.871 52.518-93.318 52.258-36.58.264-72.826-35.908-93.318-52.263-49.015-38.908-81.321-64.716-104.149-83.143-5.169-4.173-5.966-11.749-1.776-16.905l5.047-6.212c4.169-5.131 11.704-5.925 16.848-1.772 22.763 18.376 55.014 44.143 103.938 82.978 16.85 13.437 50.201 45.69 73.413 45.315 23.219.371 56.562-31.877 73.413-45.315 48.929-38.839 81.178-64.605 103.938-82.978 5.145-4.153 12.679-3.359 16.848 1.772l5.048 6.212z"/></svg>',
				'keyword' => ['wp forms','form'],
			],
			'tp_woo_cart' => [
				'label' => esc_html__('Woo Cart','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/#cart',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-cart/',
				'videoUrl' => 'https://youtu.be/zLBnX4lMhWU',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path  d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path></svg>',
				'keyword' => ['woocommerce','cart','woo cart'],
			],
			'tp_woo_checkout' => [
				'label' => esc_html__('Woo Checkout','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/#checkout',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-checkout/',
				'videoUrl' => 'https://youtu.be/ChCaCmuoPKE',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"></path></svg>',
				'keyword' => ['woocommerce','checkout','woo checkout'],
			],
			'tp_woo_myaccount' => [
				'label' => esc_html__('Woo My Account','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/#my-account',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-my-account/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M336 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm0 464H48V48h288v416zM144 112h96c8.8 0 16-7.2 16-16s-7.2-16-16-16h-96c-8.8 0-16 7.2-16 16s7.2 16 16 16zm48 176c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm-89.6 128h179.2c12.4 0 22.4-8.6 22.4-19.2v-19.2c0-31.8-30.1-57.6-67.2-57.6-10.8 0-18.7 8-44.8 8-26.9 0-33.4-8-44.8-8-37.1 0-67.2 25.8-67.2 57.6v19.2c0 10.6 10 19.2 22.4 19.2z"></path></svg>',
				'keyword' => ['woocommerce','myaccount','woo myaccount'],
			],
			'tp_woo_order_track' => [
				'label' => esc_html__('Woo Order Track','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/#order-track',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-order-track/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h16c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"></path></svg>',
				'keyword' => ['woocommerce','order track','woo order track'],
			],
			'tp_woo_single_basic' => [
				'label' => esc_html__('Woo Single Basic','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-single-basic/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>',
				'keyword' => ['woocommerce','single basic'],
			],
			'tp_woo_single_image' => [
				'label' => esc_html__('Woo Product Images','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-product-images/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm32-48h224V288l-23.5-23.5c-4.7-4.7-12.3-4.7-17 0L176 352l-39.5-39.5c-4.7-4.7-12.3-4.7-17 0L80 352v64zm48-240c-26.5 0-48 21.5-48 48s21.5 48 48 48 48-21.5 48-48-21.5-48-48-48z"></path></svg>',
				'keyword' => ['woocommerce','single image'],
			],
			'tp_woo_single_pricing' => [
				'label' => esc_html__('Woo Single Pricing','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-single-pricing/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path fill="currentColor" d="M320 144c-53.02 0-96 50.14-96 112 0 61.85 42.98 112 96 112 53 0 96-50.13 96-112 0-61.86-42.98-112-96-112zm40 168c0 4.42-3.58 8-8 8h-64c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h16v-55.44l-.47.31a7.992 7.992 0 0 1-11.09-2.22l-8.88-13.31a7.992 7.992 0 0 1 2.22-11.09l15.33-10.22a23.99 23.99 0 0 1 13.31-4.03H328c4.42 0 8 3.58 8 8v88h16c4.42 0 8 3.58 8 8v16zM608 64H32C14.33 64 0 78.33 0 96v320c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V96c0-17.67-14.33-32-32-32zm-16 272c-35.35 0-64 28.65-64 64H112c0-35.35-28.65-64-64-64V176c35.35 0 64-28.65 64-64h416c0 35.35 28.65 64 64 64v160z"></path></svg>',
				'keyword' => ['woocommerce','single pricing'],
			],
			'tp_woo_single_tabs' => [
				'label' => esc_html__('Woo Single Tabs','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-single-tabs/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path fill="currentColor" d="M384 64H192C85.961 64 0 149.961 0 256s85.961 192 192 192h192c106.039 0 192-85.961 192-192S490.039 64 384 64zM64 256c0-70.741 57.249-128 128-128 70.741 0 128 57.249 128 128 0 70.741-57.249 128-128 128-70.741 0-128-57.249-128-128zm320 128h-48.905c65.217-72.858 65.236-183.12 0-256H384c70.741 0 128 57.249 128 128 0 70.74-57.249 128-128 128z"></path></svg>',
				'keyword' => ['woocommerce','single tabs'],
			],
			'tp_woo_thank_you' => [
				'label' => esc_html__('Woo Thank You','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/woo-builder/',
				'docUrl' => 'https://docs.posimyth.com/tpae/woo-thank-you/',
				'videoUrl' => '',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40 40s-17.9 40-40 40z"></path></svg>',
				'keyword' => ['woocommerce','thank you','woo thank you'],
			],
			'tp_wp_login_register' => [
				'label' => esc_html__('WP Login & Register','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/widgets/login-signup-password/',
				'docUrl' => 'https://docs.posimyth.com/tpae/login-signup/',
				'videoUrl' => 'https://www.youtube.com/embed/J635oOpFJDU',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm128 421.6c-35.9 26.5-80.1 42.4-128 42.4s-92.1-15.9-128-42.4V416c0-35.3 28.7-64 64-64 11.1 0 27.5 11.4 64 11.4 36.6 0 52.8-11.4 64-11.4 35.3 0 64 28.7 64 64v13.6zm30.6-27.5c-6.8-46.4-46.3-82.1-94.6-82.1-20.5 0-30.4 11.4-64 11.4S204.6 320 184 320c-48.3 0-87.8 35.7-94.6 82.1C53.9 363.6 32 312.4 32 256c0-119.1 96.9-216 216-216s216 96.9 216 216c0 56.4-21.9 107.6-57.4 146.1zM248 120c-48.6 0-88 39.4-88 88s39.4 88 88 88 88-39.4 88-88-39.4-88-88-88zm0 144c-30.9 0-56-25.1-56-56s25.1-56 56-56 56 25.1 56 56-25.1 56-56 56z"/></svg>',
				'keyword' => ['login', 'signup', 'password', 'login header bar', 'signup header bar', 'login signup panel', 'login panel', 'signup panel' ,'forgot' , 'reset' ,'register'],
			]
		];
	}
    
	public function plus_extra_listout(){
		$this->plus_extra_lists = [
			'section_scroll_animation' => [
				'label' => esc_html__('Section Scroll Animation','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/on-scroll-animations-elementor-any-widgets/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/rwbYhQhuSLI',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M616 352h-72v-73.38L521.38 256 544 233.38v-82.75L521.38 128l22.25-22.28-.97-7.77C535.59 42.11 488.03 0 432 0H80C35.88 0 0 35.89 0 80v88c0 13.23 10.78 24 24 24h104v41.38L150.62 256 128 278.62v132.81c0 51.28 37.84 95.23 86.16 100.08 1.5.15 3 .14 4.5.23v.26h312C590.94 512 640 462.95 640 402.67V376c0-13.23-10.78-24-24-24zM128 160H32V80c0-26.47 21.53-48 48-48s48 21.53 48 48v80zm32 251.44V291.88L195.88 256 160 220.12V80c0-18-5.97-34.62-16.03-48H432c37.41 0 69.56 26.39 77.59 62.5L476.12 128 512 163.88v56.25L476.12 256 512 291.88V352h-73.38L416 374.62 393.38 352H320c-17.66 0-32 14.36-32 32v32c0 18.05-7.69 35.34-21.06 47.47-13.59 12.3-31.12 18.09-49.59 16.2-32.16-3.22-57.35-33.19-57.35-68.23zm448-8.77c0 42.64-34.69 77.33-77.34 77.33H294.83c15.82-17.55 25.17-40.18 25.17-64v-32h60.12L416 419.88 451.88 384H608v18.67z"/></svg>',
				'keyword' => ['section scroll animation'],
			],
			'section_custom_css' => [
				'label' => esc_html__('Section Custom CSS','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/elementor-column-improvements-upgrades-responsive/#custom-css',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/9a4Akh7EFvg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M480 32l-64 368-223.3 80L0 400l19.6-94.8h82l-8 40.6L210 390.2l134.1-44.4 18.8-97.1H29.5l16-82h333.7l10.5-52.7H56.3l16.3-82H480z"/></svg>',
				'keyword' => ['section custom cSS'],
			],
			'column_sticky' => [
				'label' => esc_html__('Sticky Column','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/elementor-column-improvements-upgrades-responsive/#sticky-column',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/9a4Akh7EFvg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 448 512"><path d="M448 348.106V80c0-26.51-21.49-48-48-48H48C21.49 32 0 53.49 0 80v351.988c0 26.51 21.49 48 48 48h268.118a48 48 0 0 0 33.941-14.059l83.882-83.882A48 48 0 0 0 448 348.106zm-120.569 95.196a15.89 15.89 0 0 1-7.431 4.195v-95.509h95.509a15.88 15.88 0 0 1-4.195 7.431l-83.883 83.883zM416 80v239.988H312c-13.255 0-24 10.745-24 24v104H48c-8.837 0-16-7.163-16-16V80c0-8.837 7.163-16 16-16h352c8.837 0 16 7.163 16 16z"/></svg>',
				'keyword' => ['sticky column'],
			],
			'custom_width_column' => [
				'label' => esc_html__('Custom/Media Width Column','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/elementor-column-improvements-upgrades-responsive/#column-width',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/9a4Akh7EFvg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M496,416H480V32A32,32,0,0,0,448,0H64A32,32,0,0,0,32,32V416H16A16,16,0,0,0,0,432v64a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V432A16,16,0,0,0,496,416ZM272,32H448V208H272Zm0,208H448V416H272ZM64,32H240V208H64Zm0,208H240V416H64ZM480,480H32V448H480Z"/></svg>',
				'keyword' => ['custom media width column'],
			],
			'order_sort_column' => [
				'label' => esc_html__('Order AND Width Column','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/elementor-column-improvements-upgrades-responsive/#column-order',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/9a4Akh7EFvg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464,160H208a48,48,0,0,0-48,48V464a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V208A48,48,0,0,0,464,160Zm16,304a16,16,0,0,1-16,16H208a16,16,0,0,1-16-16V208a16,16,0,0,1,16-16H464a16,16,0,0,1,16,16ZM32,304V48A16,16,0,0,1,48,32H304a16,16,0,0,1,16,16v80h32V48A48,48,0,0,0,304,0H48A48,48,0,0,0,0,48V304a48,48,0,0,0,48,48h80V320H48A16,16,0,0,1,32,304Zm400-80H240a16,16,0,0,0-16,16V432a16,16,0,0,0,16,16H432a16,16,0,0,0,16-16V240A16,16,0,0,0,432,224ZM416,416H256V256H416Z"/></svg>',
				'keyword' => ['order and width column'],
			],
			'column_custom_css' => [
				'label' => esc_html__('Column Custom CSS','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/elementor-column-improvements-upgrades-responsive/#custom-css',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/9a4Akh7EFvg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 384 512"><path d="M0 32l34.9 395.8L192 480l157.1-52.2L384 32H0zm313.1 80l-4.8 47.3L193 208.6l-.3.1h111.5l-12.8 146.6-98.2 28.7-98.8-29.2-6.4-73.9h48.9l3.2 38.3 52.6 13.3 54.7-15.4 3.7-61.6-166.3-.5v-.1l-.2.1-3.6-46.3L193.1 162l6.5-2.7H76.7L70.9 112h242.2z"/></svg>',
				'keyword' => ['column custom css'],
			],
			'column_mouse_cursor' => [
				'label' => esc_html__('Column Mouse Cursor','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/mouse-cursor-icon-change/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/glP290dAkOM',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 320 512"><path d="M154.149 488.438l-41.915-101.865-46.788 52.8C42.432 465.345 0 448.788 0 413.5V38.561c0-34.714 41.401-51.675 64.794-26.59L309.547 274.41c22.697 24.335 6.074 65.09-27.195 65.09h-65.71l42.809 104.037c8.149 19.807-1.035 42.511-20.474 50.61l-36 15.001c-19.036 7.928-40.808-1.217-48.828-20.71zm-31.84-161.482l61.435 149.307c1.182 2.877 4.117 4.518 6.926 3.347l35.999-15c3.114-1.298 4.604-5.455 3.188-8.896L168.872 307.5h113.479c5.009 0 7.62-7.16 3.793-11.266L41.392 33.795C37.785 29.932 32 32.879 32 38.561V413.5c0 5.775 5.935 8.67 9.497 4.65l80.812-91.194z"/></svg>',
				'keyword' => ['column mouse cursor'],
			],
			'plus_display_rules' => [
				'label' => esc_html__('Display Rules','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/display-rules/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/xn9vPYHbogI',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><path d="M536 480H104a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zM608 0H32A32 32 0 0 0 0 32v352a32 32 0 0 0 32 32h576a32 32 0 0 0 32-32V32a32 32 0 0 0-32-32zm0 384H32V32h576z"/></svg>',
				'keyword' => ['display rules'],
			],
			'plus_event_tracker' => [
				'label' => esc_html__('Event Tracker','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/conversion-event-tracker-in-elementor/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/9a4Akh7EFvg',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 576 512"><path d="M80 352H16c-8.84 0-16 7.16-16 16v128c0 8.84 7.16 16 16 16h64c8.84 0 16-7.16 16-16V368c0-8.84-7.16-16-16-16zM64 480H32v-96h32v96zm496-288h-64c-8.84 0-16 7.16-16 16v288c0 8.84 7.16 16 16 16h64c8.84 0 16-7.16 16-16V208c0-8.84-7.16-16-16-16zm-16 288h-32V224h32v256zM502.77 88.68C510.12 93.24 518.71 96 528 96c26.51 0 48-21.49 48-48S554.51 0 528 0s-48 21.49-48 48c0 5.51 1.12 10.71 2.83 15.64l-89.6 71.68c-7.35-4.57-15.94-7.33-25.23-7.33s-17.88 2.76-25.23 7.33l-89.6-71.68C254.88 58.72 256 53.51 256 48c0-26.51-21.49-48-48-48s-48 21.49-48 48c0 7.4 1.81 14.32 4.8 20.58L68.58 164.8C62.32 161.81 55.4 160 48 160c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-7.4-1.81-14.32-4.8-20.58l96.22-96.22C193.68 94.19 200.6 96 208 96c9.29 0 17.88-2.76 25.23-7.33l89.6 71.68c-1.71 4.93-2.83 10.14-2.83 15.65 0 26.51 21.49 48 48 48s48-21.49 48-48c0-5.51-1.12-10.72-2.83-15.65l89.6-71.67zM528 32c8.82 0 16 7.18 16 16s-7.18 16-16 16-16-7.18-16-16 7.18-16 16-16zM48 224c-8.82 0-16-7.18-16-16s7.18-16 16-16 16 7.18 16 16-7.18 16-16 16zM208 64c-8.82 0-16-7.18-16-16s7.18-16 16-16 16 7.18 16 16-7.18 16-16 16zm160 128c-8.82 0-16-7.18-16-16s7.18-16 16-16 16 7.18 16 16-7.18 16-16 16zm-128 0h-64c-8.84 0-16 7.16-16 16v288c0 8.84 7.16 16 16 16h64c8.84 0 16-7.16 16-16V208c0-8.84-7.16-16-16-16zm-16 288h-32V224h32v256zm176-160h-64c-8.84 0-16 7.16-16 16v160c0 8.84 7.16 16 16 16h64c8.84 0 16-7.16 16-16V336c0-8.84-7.16-16-16-16zm-16 160h-32V352h32v128z"/></svg>',
				'keyword' => ['event tracker'],
			],
			'plus_section_column_link' => [
				'label' => esc_html__('Wrapper Link','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/wrapper-link/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/KMpzq3D4oT8',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M44.45 252.59l37.11-37.1c9.84-9.84 26.78-3.3 27.29 10.6a184.45 184.45 0 0 0 9.69 52.72 16.08 16.08 0 0 1-3.78 16.61l-13.09 13.09c-28 28-28.9 73.66-1.15 102a72.07 72.07 0 0 0 102.32.51L270 343.79A72 72 0 0 0 270 242a75.64 75.64 0 0 0-10.34-8.57 16 16 0 0 1-6.95-12.6A39.86 39.86 0 0 1 264.45 191l21.06-21a16.06 16.06 0 0 1 20.58-1.74A152.05 152.05 0 0 1 327 400l-.36.37-67.2 67.2c-59.27 59.27-155.7 59.26-215 0s-59.26-155.72.01-214.98z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M410.33 203.49c28-28 28.9-73.66 1.15-102a72.07 72.07 0 0 0-102.32-.49L242 168.21A72 72 0 0 0 242 270a75.64 75.64 0 0 0 10.34 8.57 16 16 0 0 1 6.94 12.6A39.81 39.81 0 0 1 247.55 321l-21.06 21.05a16.07 16.07 0 0 1-20.58 1.74A152.05 152.05 0 0 1 185 112l.36-.37 67.2-67.2c59.27-59.27 155.7-59.26 215 0s59.27 155.7 0 215l-37.11 37.1c-9.84 9.84-26.78 3.3-27.29-10.6a184.45 184.45 0 0 0-9.69-52.72 16.08 16.08 0 0 1 3.78-16.61z"></path></g></svg>',
				'keyword' => ['wrapper link'],
			],
			'plus_equal_height' => [
				'label' => esc_html__('Equal Height','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/equal-height/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/Bwp3GBOlkaw',
				'tag' => 'free',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M626.29 224H269.71c-7.57 0-13.71 7.16-13.71 16v32c0 8.84 6.14 16 13.71 16h356.58c7.57 0 13.71-7.16 13.71-16v-32c0-8.84-6.14-16-13.71-16zm0 160H269.71c-7.57 0-13.71 7.16-13.71 16v32c0 8.84 6.14 16 13.71 16h356.58c7.57 0 13.71-7.16 13.71-16v-32c0-8.84-6.14-16-13.71-16zm0-320H269.71C262.14 64 256 71.16 256 80v32c0 8.84 6.14 16 13.71 16h356.58c7.57 0 13.71-7.16 13.71-16V80c0-8.84-6.14-16-13.71-16z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M176 144c14.31 0 21.33-17.31 11.31-27.31l-80-80a16 16 0 0 0-22.62 0l-80 80C-4.64 126 .36 144 16 144h48v224H16c-14.29 0-21.31 17.31-11.29 27.31l80 80a16 16 0 0 0 22.62 0l80-80C196.64 386 191.64 368 176 368h-48V144z"></path></g></svg>',
				'keyword' => ['equal height'],
			],
			'plus_cross_cp' => [
				'label' => esc_html__('Cross Domain Copy Paste','tpebl'),
				'demoUrl' => 'https://theplusaddons.com/plus-extras/cross-domain-copy-paste-and-live-copy-elementor/',
				'docUrl' => '#doc',
				'videoUrl' => 'https://www.youtube.com/embed/qNvQdIzrJd8',
				'tag' => 'pro',
				'labelIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16.867" height="23" viewBox="0 0 512 512"><path d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zm-80 464c0 8.82-7.18 16-16 16H48c-8.82 0-16-7.18-16-16V144c0-8.82 7.18-16 16-16h48v240c0 26.51 21.49 48 48 48h240v48zm96-96c0 8.82-7.18 16-16 16H144c-8.82 0-16-7.18-16-16V48c0-8.82 7.18-16 16-16h320c8.82 0 16 7.18 16 16v320z"/></svg>',
				'keyword' => ['Cross Domain Copy Paste'],
			]
		];
	}
		
		
	/* Get widget Filter Search Ajax
	 * @since v1.0.0 
	 */
	public function theplus_widget_search(){
		check_ajax_referer('theplus-addons', 'security');
		if(isset($_POST['filter']) && !empty($_POST['filter'])){
			$this->widget_listout();
			$filter_widget =[];
			if(!empty($this->widget_lists)){
				
				foreach($this->widget_lists as $key => $block){
					$label = strtolower($block['label']);
					$filter_widget[$key] = $block;
					$filter_widget[$key]['filter'] = 'no';
					if(!empty($block['keyword'])){
						foreach($block['keyword'] as $keyword){
							$key_word= strtolower($keyword);
							if(strpos($key_word, $_POST['filter']) !== false){
								$filter_widget[$key]['filter'] = 'yes';
							}
						}
					}
					if(strpos($label, $_POST['filter']) !== false){
						$filter_widget[$key]['filter'] = 'yes';
					}
				}
			}
			$this->widget_lists = $filter_widget;
			
		}else{
			$this->widget_listout();
		}
		$output = $this->theplus_widget_list_rendered();
		echo $output;
		exit();
	}
	
	private function theplus_widget_list_rendered(){
		$widget_list = $this->widget_lists;
		$output ='';
		$get_widgets_save = get_option( 'theplus_options' );
		$save_widget ='';
		
		if(!empty($get_widgets_save['check_elements'])){
			$save_widget = $get_widgets_save['check_elements'];
		}
		
		if(!empty($widget_list)){
			foreach ($widget_list as $key => $widget){
				$filter_class = '';
				if(!empty($widget['filter'])){
					$filter_class = 'filter-widget-'.$widget['filter'];
				}				
				$output .='<div class="theplus-panel-col theplus-panel-col-25 widget-'.esc_attr($widget['tag']).' '.$filter_class.'">';
					$output .='<div class="plus-widget-list-wrap">';
						$output .='<div class="widget-pin-free-pro">'.esc_html($widget['tag']).'</div>';
						$output .='<div class="plus-widget-list-inner">';
							$output .='<span class="widget-icon">'.$widget['labelIcon'].'</span>';
							$output .='<span>'.esc_html($widget['label']).'</span>';
							$output .='<span class="widget-group-info">';
								$output .='<span class="widget-hover-info">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="3.75" height="10.8" viewBox="0 0 4.449 11.917">
										  <g id="information-logotype-in-a-circle" transform="translate(-11.039 -5.355)">
											<path id="Path_348" data-name="Path 348" d="M14.643,11.143H12.06v0H11.1v1.5h.962v5.364H11.039v1.435H12.06v.01h2.583v-.01h.845V18.013h-.845Z" transform="translate(0 -2.186)" />
											<path id="Path_349" data-name="Path 349" d="M13.912,7.937a1.294,1.294,0,1,0,.035-2.582,1.293,1.293,0,1,0-.035,2.582Z" transform="translate(-0.579)" />
										  </g>
										</svg>';
							$output .='</span>';
							$output .='<a href="'.esc_url($widget['demoUrl']).'" target="_blank" rel="noopener noreferrer" class="widget-hover-details widget-info-demo">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="9" height="8" viewBox="0 0 10 9.009">
									  <path d="M9.755,36.8a.787.787,0,0,0-.589-.255H.833a.788.788,0,0,0-.589.255A.851.851,0,0,0,0,37.409V43.3a.851.851,0,0,0,.245.612.788.788,0,0,0,.589.254H3.667a1.171,1.171,0,0,1-.083.422,3.905,3.905,0,0,1-.167.379.614.614,0,0,0-.083.238.339.339,0,0,0,.1.244.314.314,0,0,0,.234.1H6.333a.314.314,0,0,0,.234-.1.339.339,0,0,0,.1-.244.635.635,0,0,0-.083-.235,4.052,4.052,0,0,1-.167-.384,1.18,1.18,0,0,1-.083-.42H9.167a.787.787,0,0,0,.588-.254A.851.851,0,0,0,10,43.3v-5.89A.851.851,0,0,0,9.755,36.8Zm-.422,5.116a.17.17,0,0,1-.049.122.158.158,0,0,1-.117.051H.833a.157.157,0,0,1-.117-.051.17.17,0,0,1-.049-.122v-4.5a.17.17,0,0,1,.049-.122.158.158,0,0,1,.117-.051H9.167a.157.157,0,0,1,.117.051.17.17,0,0,1,.049.122v4.5Z" transform="translate(0 -36.543)" />
									</svg>';
							$output .='</a>';
							$output .='<a href="'.esc_url($widget['docUrl']).'" target="_blank" rel="noopener noreferrer" class="widget-hover-details widget-info-doc">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="8.053" height="10.166" viewBox="0 0 8.053 10.166">
									<g transform="translate(-41.796)">
										<g transform="translate(42.06 1.188)">
										  <path d="M226.884,303.02l-2.231,2.218v-1.69a.528.528,0,0,1,.528-.528Z" transform="translate(-220.296 -296.551)"/>
										</g>
										<g transform="translate(41.796)">
										  <path d="M46.39,45.813h-3.8a.792.792,0,0,1-.792-.792V37.363a.792.792,0,0,1,.792-.792h5.545a.792.792,0,0,1,.792.792v5.928a.264.264,0,0,1-.079.185h-.013L46.575,45.72A.264.264,0,0,1,46.39,45.813Zm-3.8-8.713a.264.264,0,0,0-.264.264V45.02a.264.264,0,0,0,.264.264h3.7l2.112-2.1V37.363a.264.264,0,0,0-.264-.264Z" transform="translate(-41.796 -35.647)"/>
										  <path d="M214.468,295.344a.264.264,0,0,1-.264-.264v-1.716a.792.792,0,0,1,.792-.792h1.716a.264.264,0,1,1,0,.528H215a.264.264,0,0,0-.264.264v1.716A.264.264,0,0,1,214.468,295.344Z" transform="translate(-209.847 -285.179)"/>
										  <path d="M137.2,206.9h-3.656a.269.269,0,1,1,0-.528H137.2a.269.269,0,1,1,0,.528Z" transform="translate(-131.798 -201.152)" />
										  <path d="M137.2,154.65h-3.656a.269.269,0,1,1,0-.528H137.2a.269.269,0,1,1,0,.528Z" transform="translate(-131.798 -150.227)" />
										  <path d="M137.2,102.406h-3.656a.269.269,0,1,1,0-.528H137.2a.269.269,0,1,1,0,.528Z" transform="translate(-131.798 -99.304)" />
										  <path d="M85.232,7.512a.264.264,0,0,1-.264-.264V1.056A.528.528,0,0,0,84.44.528H78.631a.264.264,0,1,1,0-.528H84.44A1.056,1.056,0,0,1,85.5,1.056V7.248A.264.264,0,0,1,85.232,7.512Z" transform="translate(-77.443)" />
										</g>
									</g>
									</svg>';
							$output .='</a>';
							$output .='<a href="'.esc_url($widget['videoUrl']).'" target="_blank" rel="noopener noreferrer" class="widget-hover-details widget-info-video">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 7.801 10.037">
									  <path d="M47.444,44.945a.4.4,0,0,1-.4-.4V35.308a.4.4,0,0,1,.62-.334l7,4.618a.4.4,0,0,1,.181.334.4.4,0,0,1-.181.334l-7,4.619a.4.4,0,0,1-.22.066Zm.4-8.894V43.8l5.874-3.876Z" transform="translate(-47.044 -34.909)" />
									</svg>';
							$output .='</a>';
							$output .='</span>';
						$output .='</div>';
						$pro_disable = '';
						if($widget['tag']=='pro' && !defined('THEPLUS_VERSION')){
							$pro_disable = 'disabled="disabled"';
						}
						$checked = '';
						if(!empty($save_widget) && in_array($key, $save_widget)){
							$checked = 'checked="checked"';
						}
						
						$output .='<div class="widget-check-wrap"><input type="checkbox" class="widget-list-checkbox" name="check_elements[]" id="'.esc_attr($key).'" value="'.esc_attr($key).'" '.$checked.' '.$pro_disable.'> <label for="'.esc_attr($key).'"></label></div>';
					$output .='</div>';
				$output .='</div>';
			}
		}
		return $output;
	}
	private function theplus_extra_list_rendered(){
		$extra_list = $this->plus_extra_lists;
		$output ='';
		$get_extras_save = get_option( 'theplus_options' );
		$save_extra ='';
		
		if(!empty($get_extras_save['extras_elements'])){
			$save_extra = $get_extras_save['extras_elements'];
		}
		
		if(!empty($extra_list)){
			foreach ($extra_list as $key => $widget){
				$filter_class = '';
				if(!empty($widget['filter'])){
					$filter_class = 'filter-widget-'.$widget['filter'];
				}
				$output .='<div class="theplus-panel-col theplus-panel-col-25 widget-'.esc_attr($widget['tag']).' '.$filter_class.'">';
					$output .='<div class="plus-widget-list-wrap">';
						$output .='<div class="widget-pin-free-pro">'.esc_html($widget['tag']).'</div>';
						$output .='<div class="plus-widget-list-inner">';
							$output .='<span class="widget-icon">'.$widget['labelIcon'].'</span>';
							$output .='<span>'.esc_html($widget['label']).'</span>';
							$output .='<span class="widget-group-info">';
								$output .='<span class="widget-hover-info">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="3.75" height="10.8" viewBox="0 0 4.449 11.917">
										  <g id="information-logotype-in-a-circle" transform="translate(-11.039 -5.355)">
											<path id="Path_348" data-name="Path 348" d="M14.643,11.143H12.06v0H11.1v1.5h.962v5.364H11.039v1.435H12.06v.01h2.583v-.01h.845V18.013h-.845Z" transform="translate(0 -2.186)" />
											<path id="Path_349" data-name="Path 349" d="M13.912,7.937a1.294,1.294,0,1,0,.035-2.582,1.293,1.293,0,1,0-.035,2.582Z" transform="translate(-0.579)" />
										  </g>
										</svg>';
							$output .='</span>';
							$output .='<a href="'.esc_url($widget['demoUrl']).'" target="_blank" rel="noopener noreferrer" class="widget-hover-details widget-info-demo">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="9" height="8" viewBox="0 0 10 9.009">
									  <path d="M9.755,36.8a.787.787,0,0,0-.589-.255H.833a.788.788,0,0,0-.589.255A.851.851,0,0,0,0,37.409V43.3a.851.851,0,0,0,.245.612.788.788,0,0,0,.589.254H3.667a1.171,1.171,0,0,1-.083.422,3.905,3.905,0,0,1-.167.379.614.614,0,0,0-.083.238.339.339,0,0,0,.1.244.314.314,0,0,0,.234.1H6.333a.314.314,0,0,0,.234-.1.339.339,0,0,0,.1-.244.635.635,0,0,0-.083-.235,4.052,4.052,0,0,1-.167-.384,1.18,1.18,0,0,1-.083-.42H9.167a.787.787,0,0,0,.588-.254A.851.851,0,0,0,10,43.3v-5.89A.851.851,0,0,0,9.755,36.8Zm-.422,5.116a.17.17,0,0,1-.049.122.158.158,0,0,1-.117.051H.833a.157.157,0,0,1-.117-.051.17.17,0,0,1-.049-.122v-4.5a.17.17,0,0,1,.049-.122.158.158,0,0,1,.117-.051H9.167a.157.157,0,0,1,.117.051.17.17,0,0,1,.049.122v4.5Z" transform="translate(0 -36.543)" />
									</svg>';
							$output .='</a>';
							$output .='<a href="'.esc_url($widget['docUrl']).'" target="_blank" rel="noopener noreferrer" class="widget-hover-details widget-info-doc">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="8.053" height="10.166" viewBox="0 0 8.053 10.166">
									<g transform="translate(-41.796)">
										<g transform="translate(42.06 1.188)">
										  <path d="M226.884,303.02l-2.231,2.218v-1.69a.528.528,0,0,1,.528-.528Z" transform="translate(-220.296 -296.551)"/>
										</g>
										<g transform="translate(41.796)">
										  <path d="M46.39,45.813h-3.8a.792.792,0,0,1-.792-.792V37.363a.792.792,0,0,1,.792-.792h5.545a.792.792,0,0,1,.792.792v5.928a.264.264,0,0,1-.079.185h-.013L46.575,45.72A.264.264,0,0,1,46.39,45.813Zm-3.8-8.713a.264.264,0,0,0-.264.264V45.02a.264.264,0,0,0,.264.264h3.7l2.112-2.1V37.363a.264.264,0,0,0-.264-.264Z" transform="translate(-41.796 -35.647)"/>
										  <path d="M214.468,295.344a.264.264,0,0,1-.264-.264v-1.716a.792.792,0,0,1,.792-.792h1.716a.264.264,0,1,1,0,.528H215a.264.264,0,0,0-.264.264v1.716A.264.264,0,0,1,214.468,295.344Z" transform="translate(-209.847 -285.179)"/>
										  <path d="M137.2,206.9h-3.656a.269.269,0,1,1,0-.528H137.2a.269.269,0,1,1,0,.528Z" transform="translate(-131.798 -201.152)" />
										  <path d="M137.2,154.65h-3.656a.269.269,0,1,1,0-.528H137.2a.269.269,0,1,1,0,.528Z" transform="translate(-131.798 -150.227)" />
										  <path d="M137.2,102.406h-3.656a.269.269,0,1,1,0-.528H137.2a.269.269,0,1,1,0,.528Z" transform="translate(-131.798 -99.304)" />
										  <path d="M85.232,7.512a.264.264,0,0,1-.264-.264V1.056A.528.528,0,0,0,84.44.528H78.631a.264.264,0,1,1,0-.528H84.44A1.056,1.056,0,0,1,85.5,1.056V7.248A.264.264,0,0,1,85.232,7.512Z" transform="translate(-77.443)" />
										</g>
									</g>
									</svg>';
							$output .='</a>';
							$output .='<a href="'.esc_url($widget['videoUrl']).'" target="_blank" rel="noopener noreferrer" class="widget-hover-details widget-info-video">';
								$output .='<svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 7.801 10.037">
									  <path d="M47.444,44.945a.4.4,0,0,1-.4-.4V35.308a.4.4,0,0,1,.62-.334l7,4.618a.4.4,0,0,1,.181.334.4.4,0,0,1-.181.334l-7,4.619a.4.4,0,0,1-.22.066Zm.4-8.894V43.8l5.874-3.876Z" transform="translate(-47.044 -34.909)" />
									</svg>';
							$output .='</a>';
							$output .='</span>';
						$output .='</div>';
						$pro_disable = '';
						if($widget['tag']=='pro' && !defined('THEPLUS_VERSION')){
							$pro_disable = 'disabled="disabled"';
						}
						$checked = '';
						if(!empty($save_extra) && in_array($key, $save_extra)){
							$checked = 'checked="checked"';
						}
						
						$output .='<div class="widget-check-wrap"><input type="checkbox" class="widget-list-checkbox" name="extras_elements[]" id="'.esc_attr($key).'" value="'.esc_attr($key).'" '.$checked.' '.$pro_disable.'> <label for="'.esc_attr($key).'"></label></div>';
					$output .='</div>';
				$output .='</div>';
			}
		}
		return $output;
	}
    /**
     * Add menu options page
     * @since 1.0.0
     */
    public function add_options_page()
    {		
        $option_tabs = self::option_fields();		
		
         foreach ($option_tabs as $index => $option_tab) {
            if ($index == 0) {
                $this->options_pages[] = add_menu_page($this->title, $this->title, 'manage_options', $option_tab['id'], array(
                    $this,
                    'admin_page_display'
                ),'dashicons-plus-settings'); 
                add_submenu_page($option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array(
                    $this,
                    'admin_page_display'
                ));
            } else {
				if(isset($option_tabs) && $option_tab['id'] != "theplus_white_label" && $option_tab['id'] != "theplus_purchase_code"){
					$this->options_pages[] = add_submenu_page($option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array(
						$this,
						'admin_page_display'
					));
				}else{
					$label_options=get_option( 'theplus_white_label' );	
					if( ((empty($label_options['tp_hidden_label']) || $label_options['tp_hidden_label']!='on') && ($option_tab['id'] == "theplus_white_label" || $option_tab['id'] == "theplus_purchase_code")) || !defined('THEPLUS_VERSION')){
						$this->options_pages[] = add_submenu_page($option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array(
							$this,
							'admin_page_display'
						));
					}
				}
				
            }
        }
    }
    
    /**
     * 
     * @since  1.0.0
     */
    public function admin_page_display()
    {
        $option_tabs = self::option_fields();	
        $tab_forms   = array();


		$output ='';
		
		$output .='<div class="'.$this->key.'">';
		$output .='<div id="theplus-setting-header-wrapper">';
				$output .='<div class="theplus-head-inner">';
				$options = get_option( 'theplus_white_label' );
				if(defined('THEPLUS_VERSION') && (!empty($options['tp_plus_logo']))){
					$output .='<img src="'.$options['tp_plus_logo'].'" style="max-width:150px;"/>';
				}else{
					$output .='<svg xmlns="http://www.w3.org/2000/svg" width="250" height="100" viewBox="0 0 976.33 265.397">
						  <g id="Group_4391" data-name="Group 4391" transform="translate(-310.19 -926.417)">
							<g id="Group_4387" data-name="Group 4387">
							  <g id="ICON">
								<path id="Path_7876" data-name="Path 7876" d="M449.33,1034.564H436.469v18.122H418.336v12.86h18.133v18.133H449.33v-18.133h18.11v-12.86H449.33v-18.122" fill="rgba(255,255,255,0.15)"/>
								<path id="Path_7877" data-name="Path 7877" d="M442.887,926.417H394.368v126.269H355.214v12.86h39.154v18.122h12.861V939.279h35.658a35.726,35.726,0,0,1,35.66,35.46v24.855h12.86V974.725a48.563,48.563,0,0,0-48.52-48.308" fill="rgba(255,255,255,0.15)"/>
								<path id="Path_7878" data-name="Path 7878" d="M449.318,971.442H436.457V1010.6H418.336v12.861H562.725v35.659a35.726,35.726,0,0,1-35.459,35.659H502.421v12.861h24.873a48.537,48.537,0,0,0,48.292-48.52V1010.6H449.318V971.442" fill="rgba(255,255,255,0.15)"/>
								<path id="Path_7879" data-name="Path 7879" d="M491.419,1034.564H478.558v144.39H442.9a35.728,35.728,0,0,1-35.66-35.46v-24.845H394.38v24.871a48.533,48.533,0,0,0,48.52,48.294h48.519V1065.546h39.154v-12.86H491.419v-18.122" fill="rgba(255,255,255,0.15)"/>
								<path id="Path_7880" data-name="Path 7880" d="M383.366,1010.608H358.5a48.562,48.562,0,0,0-48.306,48.519v48.52H436.457V1146.8h12.861v-39.155H467.44v-12.86H323.05v-35.66a35.717,35.717,0,0,1,35.472-35.659h24.844v-12.86" fill="rgba(255,255,255,0.15)"/>
							  </g>
							  <g id="E">
								<rect id="Rectangle_1305" data-name="Rectangle 1305" width="73.033" height="12.86" transform="translate(418.348 1052.686)" fill="#fff"/>
								<rect id="Rectangle_1306" data-name="Rectangle 1306" width="12.863" height="97.081" transform="translate(394.366 1010.565)" fill="#fff"/>
								<rect id="Rectangle_1307" data-name="Rectangle 1307" width="73.028" height="12.861" transform="translate(418.364 1010.596)" fill="#fff"/>
								<rect id="Rectangle_1308" data-name="Rectangle 1308" width="72.997" height="12.858" transform="translate(418.277 1094.787)" fill="#fff"/>
							  </g>
							</g>
							<g id="Group_4390" data-name="Group 4390">
							  <g id="Group_4388" data-name="Group 4388">
								<path id="Path_7881" data-name="Path 7881" d="M703.754,971.453H624.106v16.319h29.549v81.461H673.8V987.772h29.95V971.453" fill="#fff"/>
								<path id="Path_7882" data-name="Path 7882" d="M800.457,971.453H780.31v39.62H741.022v-39.62H720.876v97.78h20.147v-41.906H780.31v41.906h20.147v-97.78" fill="#fff"/>
								<path id="Path_7883" data-name="Path 7883" d="M889.1,971.453H823.689v97.78h65.547v-16.185h-45.4v-26.192H882.52v-15.783H843.839v-23.3H889.1V971.453" fill="#fff"/>
								<path id="Path_7884" data-name="Path 7884" d="M966.73,1018.462v-30.69H985.2q7.453.135,11.683,4.567t4.233,11.618q0,6.986-4.2,10.744t-12.191,3.761h-18m18-47.009H946.58v97.78h20.15v-34.452h17.661q17.391,0,27.231-8.294t9.838-22.664a31.939,31.939,0,0,0-4.5-16.89,29.723,29.723,0,0,0-12.859-11.451,44.132,44.132,0,0,0-19.376-4.029" fill="#fff"/>
								<path id="Path_7885" data-name="Path 7885" d="M1061.082,971.453h-20.146v97.78h62.925v-16.185h-42.779v-81.6" fill="#fff"/>
								<path id="Path_7886" data-name="Path 7886" d="M1193.445,971.453h-20.214v65.074q-.271,17.867-17.259,17.865-8.13,0-12.728-4.4t-4.6-14V971.453H1118.5V1036.6q.2,15.849,10.276,24.912t27.2,9.069q17.389,0,27.432-9.338t10.041-25.383v-64.4" fill="#fff"/>
								<path id="Path_7887" data-name="Path 7887" d="M1250.591,970.111a48.293,48.293,0,0,0-18.771,3.492,29.141,29.141,0,0,0-12.825,9.7,23.605,23.605,0,0,0-4.466,14.137q0,15.246,16.654,24.244a102.662,102.662,0,0,0,16.586,6.681q10.48,3.391,14.507,6.447a10.335,10.335,0,0,1,4.029,8.763,9.507,9.507,0,0,1-4.029,8.162q-4.028,2.921-11.213,2.919-19.343,0-19.341-16.185h-20.216a28.99,28.99,0,0,0,4.868,16.656,32.506,32.506,0,0,0,14.137,11.315,49.945,49.945,0,0,0,20.552,4.132q16.247,0,25.856-7.219t9.6-19.915a25.549,25.549,0,0,0-7.859-19.072q-7.857-7.654-25.05-12.825-9.333-2.82-14.135-6.043t-4.8-7.991a9.857,9.857,0,0,1,4.1-8.228q4.095-3.123,11.482-3.123,7.66,0,11.887,3.727t4.233,10.442h20.147a28.024,28.024,0,0,0-4.536-15.714,29.716,29.716,0,0,0-12.724-10.712,43.977,43.977,0,0,0-18.67-3.793" fill="#fff"/>
							  </g>
							  <g id="Group_4389" data-name="Group 4389">
								<path id="Path_7888" data-name="Path 7888" d="M664.615,1142.559a6.356,6.356,0,0,1-4.246-1.4,4.8,4.8,0,0,1-1.653-3.875q0-5.672,9.69-5.672h4.132v6.327a7.75,7.75,0,0,1-3.22,3.334,9.272,9.272,0,0,1-4.7,1.283m1.711-27.387a14.947,14.947,0,0,0-6.17,1.254,11.2,11.2,0,0,0-4.447,3.405,7.275,7.275,0,0,0-1.638,4.46h5.3a4.2,4.2,0,0,1,1.909-3.448,7.681,7.681,0,0,1,4.731-1.425,6.646,6.646,0,0,1,4.873,1.638,5.924,5.924,0,0,1,1.653,4.4v2.423h-5.13q-6.641,0-10.3,2.664a8.717,8.717,0,0,0-3.662,7.48,8.348,8.348,0,0,0,2.921,6.541,10.89,10.89,0,0,0,7.482,2.578,11.763,11.763,0,0,0,8.777-3.818,11.049,11.049,0,0,0,.74,3.249h5.529v-.456a17.33,17.33,0,0,1-1.083-6.754v-14.192a9.607,9.607,0,0,0-3.135-7.338q-3.02-2.664-8.349-2.665" fill="#fff"/>
								<path id="Path_7889" data-name="Path 7889" d="M702.3,1142.673a7,7,0,0,1-5.985-2.964q-2.166-2.965-2.165-8.208,0-5.871,2.165-8.863a7.035,7.035,0,0,1,6.042-2.992,7.748,7.748,0,0,1,7.266,4.361v14.163a7.687,7.687,0,0,1-7.323,4.5m12.6-39.869h-5.273v16.072a11.441,11.441,0,0,0-17.382.613q-3.365,4.317-3.364,11.414v.4q0,7.067,3.377,11.455a10.533,10.533,0,0,0,8.734,4.388,10.738,10.738,0,0,0,8.807-3.875l.256,3.306H714.9V1102.8" fill="#fff"/>
								<path id="Path_7890" data-name="Path 7890" d="M739.3,1142.673a7,7,0,0,1-5.985-2.964q-2.164-2.965-2.166-8.208,0-5.871,2.166-8.863a7.035,7.035,0,0,1,6.043-2.992,7.749,7.749,0,0,1,7.266,4.361v14.163a7.69,7.69,0,0,1-7.324,4.5m12.6-39.869h-5.273v16.072a11.443,11.443,0,0,0-17.384.613q-3.361,4.317-3.362,11.414v.4q0,7.067,3.377,11.455a10.531,10.531,0,0,0,8.734,4.388,10.734,10.734,0,0,0,8.806-3.875l.257,3.306H751.9V1102.8" fill="#fff"/>
								<path id="Path_7891" data-name="Path 7891" d="M776.814,1142.843a7.614,7.614,0,0,1-6.368-3.1,13.191,13.191,0,0,1-2.38-8.237q0-5.785,2.393-8.891a7.576,7.576,0,0,1,6.3-3.106,7.654,7.654,0,0,1,6.4,3.149,13.159,13.159,0,0,1,2.409,8.222q0,5.67-2.366,8.82a7.569,7.569,0,0,1-6.384,3.148m-.056-27.671a13.494,13.494,0,0,0-7.253,1.967,13.278,13.278,0,0,0-4.959,5.585,18.231,18.231,0,0,0-1.781,8.151v.37q0,7.182,3.891,11.542a12.972,12.972,0,0,0,10.158,4.359,13.658,13.658,0,0,0,7.367-1.994,13.1,13.1,0,0,0,4.931-5.571,18.359,18.359,0,0,0,1.724-8.08v-.37q0-7.241-3.89-11.6a13,13,0,0,0-10.188-4.361" fill="#fff"/>
								<path id="Path_7892" data-name="Path 7892" d="M815.923,1115.172a11.234,11.234,0,0,0-9.233,4.446l-.17-3.876h-4.988v30.835H806.8V1124.6a9.289,9.289,0,0,1,3.022-3.59,7.6,7.6,0,0,1,4.5-1.369,6.108,6.108,0,0,1,4.66,1.6,7.1,7.1,0,0,1,1.524,4.929v20.405h5.272V1126.2q-.086-11.031-9.861-11.03" fill="#fff"/>
								<path id="Path_7893" data-name="Path 7893" d="M848.992,1115.172a12.522,12.522,0,0,0-8.194,2.622,8,8,0,0,0-3.206,6.413,6.82,6.82,0,0,0,1.125,3.932,9.065,9.065,0,0,0,3.478,2.85,26.539,26.539,0,0,0,6.354,2.051,15.518,15.518,0,0,1,5.615,2.038,3.883,3.883,0,0,1,1.61,3.321,3.717,3.717,0,0,1-1.81,3.233,8.5,8.5,0,0,1-4.8,1.211,8.227,8.227,0,0,1-5.229-1.553,5.458,5.458,0,0,1-2.123-4.2h-5.273a8.822,8.822,0,0,0,1.612,5.086,10.634,10.634,0,0,0,4.459,3.661,15.509,15.509,0,0,0,6.554,1.311,13.874,13.874,0,0,0,8.579-2.492,7.894,7.894,0,0,0,3.3-6.627,7.255,7.255,0,0,0-1.182-4.2,9.312,9.312,0,0,0-3.633-2.949,28.41,28.41,0,0,0-6.4-2.109,18.541,18.541,0,0,1-5.457-1.853,3.2,3.2,0,0,1-1.511-2.878,3.941,3.941,0,0,1,1.625-3.276,7.2,7.2,0,0,1,4.5-1.255,6.888,6.888,0,0,1,4.63,1.567,4.759,4.759,0,0,1,1.838,3.734h5.3a8.6,8.6,0,0,0-3.263-6.925,12.881,12.881,0,0,0-8.506-2.708" fill="#fff"/>
								<path id="Path_7894" data-name="Path 7894" d="M903.271,1102.206q-4.845,0-7.494,2.706t-2.651,7.667v3.163h-4.873v4.076h4.873v26.759H898.4v-26.759h6.582v-4.076H898.4v-3.258a6.1,6.1,0,0,1,1.4-4.3,5.151,5.151,0,0,1,3.962-1.5,15.047,15.047,0,0,1,2.849.258l.285-4.25a13.948,13.948,0,0,0-3.619-.481" fill="#fff"/>
								<path id="Path_7895" data-name="Path 7895" d="M927.535,1142.843a7.62,7.62,0,0,1-6.371-3.1,13.2,13.2,0,0,1-2.378-8.237q0-5.785,2.393-8.891a7.575,7.575,0,0,1,6.3-3.106,7.655,7.655,0,0,1,6.4,3.149,13.165,13.165,0,0,1,2.408,8.222q0,5.67-2.365,8.82a7.569,7.569,0,0,1-6.383,3.148m-.058-27.671a13.5,13.5,0,0,0-7.252,1.967,13.278,13.278,0,0,0-4.959,5.585,18.217,18.217,0,0,0-1.781,8.151v.37q0,7.182,3.889,11.542a12.978,12.978,0,0,0,10.161,4.359,13.657,13.657,0,0,0,7.366-1.994,13.092,13.092,0,0,0,4.93-5.571,18.359,18.359,0,0,0,1.724-8.08v-.37q0-7.241-3.89-11.6a13,13,0,0,0-10.188-4.361" fill="#fff"/>
								<path id="Path_7896" data-name="Path 7896" d="M964.82,1115.172a8.207,8.207,0,0,0-7.352,4.132l-.086-3.562h-5.129v30.835h5.271v-21.886q1.852-4.419,7.04-4.418a15.9,15.9,0,0,1,2.593.2v-4.9a5.373,5.373,0,0,0-2.337-.4" fill="#fff"/>
								<path id="Path_7897" data-name="Path 7897" d="M1021.521,1105.084H995.446v41.493h26.361V1142.1h-20.888V1127.4H1018.9v-4.474h-17.982v-13.366h20.6v-4.474" fill="#fff"/>
								<path id="Path_7898" data-name="Path 7898" d="M1037.6,1102.8h-5.271v43.773h5.271V1102.8" fill="#fff"/>
								<path id="Path_7899" data-name="Path 7899" d="M1054.231,1128.339a11.293,11.293,0,0,1,2.678-6.512,7.031,7.031,0,0,1,5.358-2.323,6.621,6.621,0,0,1,5.244,2.209,10.039,10.039,0,0,1,2.165,6.226v.4h-15.445m8.036-13.167a12.329,12.329,0,0,0-6.826,2.038,13.671,13.671,0,0,0-4.9,5.643,18.493,18.493,0,0,0-1.752,8.192v.97q0,6.9,3.932,11.014a13.469,13.469,0,0,0,10.2,4.117q7.753,0,11.627-5.955l-3.22-2.508a11.872,11.872,0,0,1-3.392,3.02,9.176,9.176,0,0,1-4.729,1.14,8.375,8.375,0,0,1-6.484-2.806,10.965,10.965,0,0,1-2.665-7.367h20.89v-2.194q0-7.38-3.336-11.342t-9.346-3.962" fill="#fff"/>
								<path id="Path_7900" data-name="Path 7900" d="M1118.018,1115.172a11.483,11.483,0,0,0-9.832,4.959q-2.336-4.959-8.805-4.959a11.386,11.386,0,0,0-9.147,3.99l-.144-3.42H1085.1v30.835h5.273v-22.514q1.908-4.417,7.1-4.417,6.582,0,6.582,6.726v20.205h5.3v-20.461a7.112,7.112,0,0,1,2.251-4.717,6.993,6.993,0,0,1,4.873-1.753q3.564,0,5.073,1.639a7.075,7.075,0,0,1,1.511,4.945v20.347h5.272v-20.661q-.171-10.744-10.317-10.744" fill="#fff"/>
								<path id="Path_7901" data-name="Path 7901" d="M1144.475,1128.339a11.287,11.287,0,0,1,2.679-6.512,7.029,7.029,0,0,1,5.357-2.323,6.618,6.618,0,0,1,5.243,2.209,10.034,10.034,0,0,1,2.166,6.226v.4h-15.445m8.036-13.167a12.326,12.326,0,0,0-6.825,2.038,13.666,13.666,0,0,0-4.9,5.643,18.507,18.507,0,0,0-1.752,8.192v.97q0,6.9,3.932,11.014a13.472,13.472,0,0,0,10.2,4.117q7.753,0,11.628-5.955l-3.221-2.508a11.881,11.881,0,0,1-3.391,3.02,9.179,9.179,0,0,1-4.73,1.14,8.376,8.376,0,0,1-6.484-2.806,10.97,10.97,0,0,1-2.665-7.367h20.89v-2.194q0-7.38-3.334-11.342t-9.348-3.962" fill="#fff"/>
								<path id="Path_7902" data-name="Path 7902" d="M1189.767,1115.172a11.238,11.238,0,0,0-9.233,4.446l-.171-3.876h-4.986v30.835h5.271V1124.6a9.3,9.3,0,0,1,3.021-3.59,7.608,7.608,0,0,1,4.5-1.369,6.1,6.1,0,0,1,4.659,1.6,7.087,7.087,0,0,1,1.525,4.929v20.405h5.273V1126.2q-.087-11.031-9.862-11.03" fill="#fff"/>
								<path id="Path_7903" data-name="Path 7903" d="M1218.818,1108.276h-5.273v7.466h-5.614v4.076h5.614v19.122a9.18,9.18,0,0,0,1.795,6.069,6.567,6.567,0,0,0,5.329,2.137,15.325,15.325,0,0,0,4.048-.566v-4.249a12.78,12.78,0,0,1-2.509.342,3.236,3.236,0,0,1-2.622-.928,4.277,4.277,0,0,1-.768-2.781v-19.146h5.755v-4.076h-5.755v-7.466" fill="#fff"/>
								<path id="Path_7904" data-name="Path 7904" d="M1246.9,1142.843a7.614,7.614,0,0,1-6.369-3.1,13.2,13.2,0,0,1-2.38-8.237q0-5.785,2.394-8.891a7.573,7.573,0,0,1,6.3-3.106,7.655,7.655,0,0,1,6.4,3.149,13.171,13.171,0,0,1,2.408,8.222q0,5.67-2.366,8.82a7.568,7.568,0,0,1-6.383,3.148m-.056-27.671a13.5,13.5,0,0,0-7.254,1.967,13.282,13.282,0,0,0-4.958,5.585,18.2,18.2,0,0,0-1.782,8.151v.37q0,7.182,3.891,11.542a12.971,12.971,0,0,0,10.159,4.359,13.66,13.66,0,0,0,7.367-1.994,13.09,13.09,0,0,0,4.929-5.571,18.345,18.345,0,0,0,1.724-8.08v-.37q0-7.241-3.889-11.6a13,13,0,0,0-10.187-4.361" fill="#fff"/>
								<path id="Path_7905" data-name="Path 7905" d="M1284.185,1115.172a8.21,8.21,0,0,0-7.353,4.132l-.086-3.562h-5.129v30.835h5.272v-21.886q1.852-4.419,7.039-4.418a15.893,15.893,0,0,1,2.593.2v-4.9a5.362,5.362,0,0,0-2.336-.4" fill="#fff"/>
							  </g>
							</g>
						  </g>
						</svg>';
				}
						
					$output .='<div class="theplus-panel-head-inner">';						
						$output .='<h2 class="theplus-head-setting-panel">'.esc_html__('Setting Panel','tpebl').'</h2>';
						$ver = L_THEPLUS_VERSION;
						if(defined('THEPLUS_VERSION')){
							$ver = THEPLUS_VERSION;
						}
						$output .='<div class="theplus-current-version"> '.esc_html__('Version','tpebl').' '.$ver.'</div>';
					$output .='</div>';
				$output .='</div>';
			$output .='</div>';
		
		
				$output .='<div class="theplus-nav-tab-wrapper">';
					$output .='<div class="nav-tab-wrapper">';
						ob_start();
						foreach ($option_tabs as $option_tab):
							$tab_slug  = $option_tab['id'];
							$nav_class = 'nav-tab';
							if ($tab_slug == htmlspecialchars($_GET['page'])) {
								$nav_class .= ' nav-tab-active'; //add active class to current tab
								$tab_forms[] = $option_tab; //add current tab to forms to be rendered
							}
							$navicon = '';
							if($tab_slug == "theplus_welcome_page"){
								$navicon = '<svg class="tab-nav-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" preserveAspectRatio="none">
											<path d="M109.148 120h-36c-1.104 0-2-0.9-2-2v-34h-20v34c0 1.1-0.896 2-2 2h-36c-1.104 0-2-0.9-2-2v-62h-8.648c-0.832 0-1.576-0.512-1.868-1.288-0.296-0.776-0.080-1.652 0.54-2.204l57.324-51c0.736-0.656 1.836-0.676 2.596-0.056l14.060 11.54v-10.992c0-1.104 0.896-2 2-2h20c1.1 0 2 0.896 2 2v31.648l19.74 18.908c0.588 0.568 0.776 1.432 0.472 2.192-0.308 0.756-1.044 1.252-1.86 1.252h-6.356v62c0 1.1-0.896 2-2 2zM75.148 116h32v-62c0-1.104 0.896-2 2-2h3.376l-16.756-16.056c-0.396-0.376-0.612-0.9-0.612-1.444v-30.5h-16v13.22c0 0.772-0.44 1.48-1.144 1.808-0.7 0.328-1.528 0.232-2.124-0.26l-16-13.136-52.124 46.368h5.396c1.104 0 2 0.896 2 2v62h32v-34c0-1.1 0.896-2 2-2h24c1.104 0 2 0.9 2 2v34h-0.012z"></path>
										</svg>';
							}							
							if($tab_slug == "theplus_options"){
								$navicon = '<svg class="tab-nav-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" preserveAspectRatio="none">
									<path d="M118 110h-116c-1.104 0-2-0.9-2-2v-96c0-1.104 0.896-2 2-2h116c1.1 0 2 0.896 2 2v96c0 1.1-0.9 2-2 2zM4 106h112v-92h-112v92z"></path>
									<path d="M116 34h-112c-1.104 0-2-0.896-2-2s0.896-2 2-2h112c1.1 0 2 0.896 2 2s-0.9 2-2 2z"></path>
									<path d="M46.904 97.048c-0.412 0-0.824-0.132-1.172-0.384-0.704-0.508-1-1.416-0.732-2.236l4.932-15.304-12.896-9.516c-0.696-0.516-0.984-1.416-0.712-2.24s1.036-1.38 1.9-1.38h15.916l4.916-15.136c0.536-1.648 3.268-1.648 3.804 0l4.916 15.136h15.916c0.864 0 1.628 0.56 1.904 1.38 0.264 0.82-0.016 1.724-0.716 2.24l-12.896 9.516 4.928 15.236c0.264 0.824-0.032 1.728-0.732 2.236s-1.648 0.508-2.348 0l-12.876-9.32-12.88 9.384c-0.348 0.256-0.76 0.388-1.172 0.388zM44.3 70l9.164 6.756c0.692 0.508 0.98 1.408 0.716 2.228l-3.488 10.828 9.088-6.616c0.7-0.516 1.648-0.516 2.348-0.008l9.088 6.584-3.484-10.776c-0.264-0.82 0.024-1.712 0.712-2.224l9.164-6.76h-11.288c-0.868 0-1.636-0.564-1.908-1.388l-3.464-10.664-3.464 10.664c-0.268 0.824-1.036 1.388-1.904 1.388h-11.284v-0.012z"></path>
									<path d="M15.956 23c0 1.381-1.119 2.5-2.5 2.5s-2.5-1.119-2.5-2.5c0-1.381 1.119-2.5 2.5-2.5s2.5 1.119 2.5 2.5z"></path>
									<path d="M25.956 23c0 1.381-1.119 2.5-2.5 2.5s-2.5-1.119-2.5-2.5c0-1.381 1.119-2.5 2.5-2.5s2.5 1.119 2.5 2.5z"></path>
									<path d="M35.956 23c0 1.381-1.119 2.5-2.5 2.5s-2.5-1.119-2.5-2.5c0-1.381 1.119-2.5 2.5-2.5s2.5 1.119 2.5 2.5z"></path>
								</svg>';
							}
							if($tab_slug == "post_type_options"){
								$navicon = '<svg class="tab-nav-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"><path d="M29.5,30H.5a.493.493,0,0,1-.5-.483V.484A.492.492,0,0,1,.5,0h29a.493.493,0,0,1,.5.484V29.517A.494.494,0,0,1,29.5,30ZM1,29.032H29V.968H1Z" /><path d="M29,15.484H1a.484.484,0,1,1,0-.968H29a.484.484,0,1,1,0,.968Z" /><path d="M29,5.807H1a.484.484,0,1,1,0-.968H29a.484.484,0,1,1,0,.968Z" /><path d="M14.5,29.517a.493.493,0,0,1-.5-.484V.968a.5.5,0,0,1,1,0V29.032A.493.493,0,0,1,14.5,29.517Z" /><path d="M29,20.322H1a.484.484,0,1,1,0-.967H29a.484.484,0,1,1,0,.967Z" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(2.739 2.056)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(5.239 2.056)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(7.739 2.056)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(16.488 2.056)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(18.988 2.056)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(21.488 2.056)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(2.739 16.572)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(5.239 16.572)" /><ellipse cx="0.625" cy="0.605" rx="0.625" ry="0.605" transform="translate(7.739 16.572)" /></svg>';
							}
							
							if($tab_slug == "theplus_import_data"){
								$navicon = '<svg class="tab-nav-icon" xmlns="http://www.w3.org/2000/svg" width="36" height="30" viewBox="0 0 36 30"><g transform="translate(0 -2.5)"><path d="M35.4,32.5H.6a.6.6,0,0,1-.6-.6V3.1a.6.6,0,0,1,.6-.6H35.4a.6.6,0,0,1,.6.6V31.9A.6.6,0,0,1,35.4,32.5ZM1.2,31.3H34.8V3.7H1.2Z" /><path d="M34.7,8.7H1.1a.6.6,0,0,1,0-1.2H34.7a.6.6,0,0,1,0,1.2Z" transform="translate(0.1 1)" /><path d="M22.191,25.438a5.11,5.11,0,0,1-2.041-.386,2.632,2.632,0,0,1-1.661-2.473,2.765,2.765,0,0,1,.92-2.158c1.871-1.72,6.056-1.327,6.233-1.31L25.523,20.3c-1.058-.1-4.079-.125-5.3,1a1.585,1.585,0,0,0-.529,1.258,1.438,1.438,0,0,0,.949,1.391,5.4,5.4,0,0,0,4.727-.677l.792.9A6.483,6.483,0,0,1,22.191,25.438Z" transform="translate(3.698 3.312)" /><path d="M5.482,27.664a.612.612,0,0,1-.21-.038.6.6,0,0,1-.352-.774l5.641-15.06a.6.6,0,0,1,1.124.422L6.045,27.274A.6.6,0,0,1,5.482,27.664Z" transform="translate(0.976 1.781)" /><path d="M16.179,27.664a.6.6,0,0,1-.562-.39L9.975,12.214a.6.6,0,0,1,1.124-.422l5.642,15.06a.6.6,0,0,1-.35.774A.641.641,0,0,1,16.179,27.664Z" transform="translate(1.987 1.781)" /><rect width="6" height="1" transform="translate(10 20.5)" /><path d="M25.661,25.612a.6.6,0,0,1-.6-.6v-6.93a1.456,1.456,0,0,0-.864-.815c-1.382-.5-3.8.548-4.614,1A.6.6,0,0,1,19,17.212c.138-.077,3.418-1.864,5.6-1.074a2.652,2.652,0,0,1,1.615,1.606.594.594,0,0,1,.042.218v7.05A.6.6,0,0,1,25.661,25.612Z" transform="translate(3.739 2.688)" /><circle cx="0.75" cy="0.75" r="0.75" transform="translate(3.287 5.65)" /><circle cx="0.75" cy="0.75" r="0.75" transform="translate(6.287 5.65)" /><circle cx="0.75" cy="0.75" r="0.75" transform="translate(9.287 5.65)" /></g></svg>';
							}
							if($tab_slug == "theplus_performance"){
								$navicon = '<svg class="tab-nav-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" preserveAspectRatio="none">
									<path d="M69.532 99.592h-19.064c-21.288 0-21.532-56.236-21.532-58.624 0-16.388 16.056-32.804 30.464-37.284 0.392-0.12 0.8-0.12 1.192 0 12.768 3.972 30.464 18.988 30.464 36.848 0.004 2.408-0.24 59.060-21.524 59.060zM60 7.692c-11.5 3.892-27.064 18.132-27.064 33.272 0 21.12 4.756 54.624 17.532 54.624h19.064c13.252 0 17.532-37.096 17.532-55.064-0.004-15.448-15.792-29.024-27.064-32.832z"></path>
									<path d="M35.156 116.408c-0.152 0-0.3-0.016-0.448-0.056-0.632-0.148-1.16-0.592-1.404-1.196l-10.312-25.316c-0.316-0.768-0.116-1.656 0.496-2.224l11.016-10.188c0.808-0.752 2.072-0.704 2.828 0.108 0.752 0.812 0.7 2.080-0.112 2.828l-10 9.252 8.72 21.404 16.612-14.916c0.82-0.736 2.084-0.672 2.824 0.156 0.744 0.82 0.668 2.084-0.152 2.828l-18.732 16.812c-0.372 0.328-0.848 0.508-1.336 0.508z"></path>
									<path d="M84.844 116.408c-0.488 0-0.964-0.18-1.336-0.516l-18.728-16.812c-0.824-0.74-0.896-2-0.152-2.828 0.736-0.82 2-0.888 2.824-0.148l16.608 14.916 8.72-21.4-10-9.252c-0.812-0.752-0.864-2.016-0.112-2.828s2.016-0.86 2.828-0.112l11.016 10.196c0.612 0.568 0.808 1.448 0.496 2.22l-10.312 25.316c-0.244 0.604-0.764 1.052-1.404 1.196-0.148 0.036-0.3 0.052-0.448 0.052z"></path>
								</svg>';
							}
							if($tab_slug == "theplus_api_connection_data"){
								$navicon = '<svg class="tab-nav-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
									<g id="icomoon-ignore"><line stroke-width="1" stroke="#449FDB" opacity=""></line>
									</g>
									<path d="M66.968 91.64c-0.1 0-0.208-0.008-0.312-0.024-0.752-0.116-1.372-0.656-1.592-1.384l-8.488-27.32-27.32-8.488c-0.728-0.228-1.26-0.848-1.38-1.6s0.2-1.504 0.82-1.944l23.36-16.516-0.364-28.604c-0.008-0.76 0.416-1.464 1.088-1.808 0.68-0.344 1.496-0.276 2.104 0.18l22.924 17.104 27.084-9.18c0.72-0.244 1.516-0.060 2.056 0.48 0.54 0.536 0.728 1.332 0.48 2.056l-9.18 27.092 17.096 22.924c0.46 0.608 0.528 1.424 0.18 2.1-0.352 0.676-1.072 1.080-1.808 1.092l-28.608-0.368-16.516 23.352c-0.368 0.544-0.984 0.856-1.624 0.856zM34.312 51.808l24.452 7.6c0.628 0.196 1.12 0.688 1.316 1.316l7.596 24.448 14.784-20.908c0.38-0.536 1.016-0.828 1.656-0.844l25.608 0.328-15.308-20.52c-0.392-0.528-0.5-1.216-0.292-1.84l8.224-24.252-24.256 8.224c-0.624 0.212-1.312 0.1-1.836-0.292l-20.52-15.308 0.328 25.608c0.008 0.66-0.308 1.28-0.844 1.66l-20.908 14.78z"></path>
									<path d="M6.252 116.264c-0.512 0-1.024-0.196-1.416-0.584-0.78-0.776-0.78-2.048 0-2.828l41.356-41.352c0.78-0.78 2.048-0.78 2.828 0s0.78 2.048 0 2.828l-41.356 41.352c-0.392 0.392-0.904 0.584-1.412 0.584z"></path>
								</svg>';
							}
							
							if($tab_slug == "theplus_styling_data"){
								$navicon = '<svg class="tab-nav-icon" xmlns="http://www.w3.org/2000/svg" width="36" height="30" viewBox="0 0 36 30">
									  <g transform="translate(0 -2.5)">
										<path d="M35.4,32.5H.6a.6.6,0,0,1-.6-.6V3.1a.6.6,0,0,1,.6-.6H35.4a.6.6,0,0,1,.6.6V31.9A.6.6,0,0,1,35.4,32.5ZM1.2,31.3H34.8V3.7H1.2Z"/>
										<path d="M34.7,8.7H1.1a.6.6,0,0,1,0-1.2H34.7a.6.6,0,0,1,0,1.2Z" transform="translate(0.1 1)"/>
										<path d="M11.153,26.763a.6.6,0,0,1-.509-.281L6.08,19.233a.6.6,0,0,1,.025-.676l4.564-6.187a.6.6,0,0,1,.965.713l-4.32,5.858,4.345,6.9a.6.6,0,0,1-.506.917Z" transform="translate(1.198 1.925)"/>
										<path d="M20.338,26.764a.6.6,0,0,1-.509-.918l4.345-6.9-4.32-5.858a.6.6,0,1,1,.965-.713l4.564,6.187a.606.606,0,0,1,.025.676l-4.564,7.25A.6.6,0,0,1,20.338,26.764Z" transform="translate(3.947 1.925)"/>
										<path d="M12.838,25.151a.615.615,0,0,1-.293-.076.6.6,0,0,1-.23-.817l5.938-10.625a.6.6,0,1,1,1.048.584L13.362,24.844A.6.6,0,0,1,12.838,25.151Z" transform="translate(2.448 2.165)"/>
										<g transform="translate(3.287 5.65)">
										  <circle id="Ellipse_29" data-name="Ellipse 29" cx="0.75" cy="0.75" r="0.75"/>
										  <circle id="Ellipse_30" data-name="Ellipse 30" cx="0.75" cy="0.75" r="0.75" transform="translate(3)"/>
										  <circle id="Ellipse_31" data-name="Ellipse 31" cx="0.75" cy="0.75" r="0.75" transform="translate(6)"/>
										</g>
									  </g>
									</svg>';
							}
							if($tab_slug == "theplus_purchase_code"){
								$navicon = '<svg class="tab-nav-icon" xmlns="http://www.w3.org/2000/svg" width="15.204" height="28.507" viewBox="0 0 15.204 28.507"><g transform="translate(22.204) rotate(90)"><path d="M10.967,22.2H2.553A2.969,2.969,0,0,1,0,19.521V8.732C0,7.663.979,7,2.553,7h8.413C12.43,7,13.3,7.648,13.3,8.732v3.019H28.032a.476.476,0,0,1,.475.475v4.751a.477.477,0,0,1-.475.475H13.3V19.52A2.749,2.749,0,0,1,10.967,22.2ZM2.553,7.95c-.164,0-1.6.022-1.6.782V19.521a2.061,2.061,0,0,0,1.6,1.732h8.413c.67,0,1.386-1.016,1.386-1.731V16.977a.476.476,0,0,1,.475-.475H27.557V12.7H12.828a.475.475,0,0,1-.475-.475V8.733c0-.519-.467-.783-1.386-.783Z" /><path d="M18.826,14.95H15.975a.475.475,0,1,1,0-.95h2.851a.475.475,0,0,1,0,.95Z" transform="translate(-0.771 -0.348)" /><path d="M23.826,14.95H20.975a.475.475,0,0,1,0-.95h2.851a.475.475,0,0,1,0,.95Z" transform="translate(-1.02 -0.348)" /><path d="M27.876,14.95h-1.9a.475.475,0,1,1,0-.95h1.9a.475.475,0,0,1,0,.95Z" transform="translate(-1.269 -0.348)" /><path d="M5.376,18.552h-1.9A.476.476,0,0,1,3,18.077v-7.6A.475.475,0,0,1,3.475,10h1.9a.475.475,0,0,1,.475.475v7.6A.476.476,0,0,1,5.376,18.552ZM3.95,17.6H4.9V10.95H3.95Z" transform="translate(-0.149 -0.149)" /></g></svg>';
							}
							if($tab_slug == "theplus_white_label"){
								$navicon = '<svg class="tab-nav-icon" xmlns="http://www.w3.org/2000/svg" width="30.152" height="27.537" viewBox="0 0 30.152 27.537">
								  <g transform="matrix(-0.788, 0.616, -0.616, -0.788, 34.922, 16.639)">
									<path d="M27.478,20.962H4.894a.466.466,0,0,1-.335-.144L.947,17.023a3.593,3.593,0,0,1,.008-5.266L4.567,8.136A.456.456,0,0,1,4.9,8H27.462a.462.462,0,0,1,.367.744L23.416,14.48l4.348,5.651a.466.466,0,0,1-.286.83ZM5.092,20.036H26.52l-4.056-5.273a.46.46,0,0,1,0-.564L26.52,8.927H5.086L1.609,12.412a2.671,2.671,0,0,0,0,3.966Z" />
									<path d="M6.33,17.43a2.778,2.778,0,1,1,2.778-2.778A2.782,2.782,0,0,1,6.33,17.43Zm0-4.629a1.852,1.852,0,1,0,1.852,1.852A1.853,1.853,0,0,0,6.33,12.8Z" transform="translate(-0.278 -0.287)" />
									<path d="M18.581,13.926H13.026a.463.463,0,1,1,0-.926h5.555a.463.463,0,0,1,0,.926Z" transform="translate(-0.946 -0.371)"/>
									<path d="M18.581,16.926H13.026a.463.463,0,0,1,0-.926h5.555a.463.463,0,0,1,0,.926Z" transform="translate(-0.946 -0.593)"/>
								  </g>
								</svg>';
							}
							
							$label_options=get_option( 'theplus_white_label' );	
							if( (empty($label_options['tp_hidden_label']) || $label_options['tp_hidden_label']!='on') && ($tab_slug == "theplus_white_label" || $tab_slug == "theplus_purchase_code")){
							?>							
							<a class="<?php echo $nav_class; ?>" href="<?php menu_page_url($tab_slug); ?>">
								<span><?php echo $navicon; ?></span>
								<span><?php echo esc_html($option_tab['title']); ?></span>
							</a>
							
							<?php 
							}else if(($tab_slug != "theplus_white_label" && $tab_slug != "theplus_purchase_code") || !defined('THEPLUS_VERSION')){
							?>							
							<a class="<?php echo $nav_class; ?>" href="<?php menu_page_url($tab_slug); ?>">
								<span><?php echo $navicon; ?></span>
								<span><?php echo esc_html($option_tab['title']); ?></span>
							</a>	
							<?php  }
						endforeach;
						$out = ob_get_clean();
						$output .= $out;
					$output .='</div>';
				$output .='</div>';
			
				/*Content Options*/
				$output .='<div class="theplus-settings-form-wrapper form-'.$tab_forms[0]['id'].'">';
				
					if(!empty($tab_forms)){
						ob_start();
						foreach ($tab_forms as $tab_form):
						
							if($tab_form['id']=='theplus_options'){
								echo '<div class="theplus-panel-plus-widget-page">';
									
									/*block filter*/
									echo '<div class="theplus-panel-row theplus-mt-50">';
										echo '<div class="theplus-panel-col theplus-panel-col-100">';
											echo '<div class="panel-plus-widget-filter">';
												echo '<div class="theplus-widget-filters-check">';
													echo '<label class="panel-widget-head panel-widget-check-all"><span><svg xmlns="http://www.w3.org/2000/svg" width="23.532" height="20.533" viewBox="0 0 23.532 20.533">
														  <path d="M6.9,15.626,0,8.73,2.228,6.5,6.9,11.064,17.729,0,20,2.388Z" transform="translate(4.307) rotate(16)"/>
														</svg></span><input type="checkbox" id="widget_check_all" /> '.esc_html__('Enable All','tpebl').'</label>';
													echo '<div class="panel-widget-head panel-widget-filters">';
														echo '<select class="widgets-filter">';
															echo '<option value="all">'.esc_html__('All','tpebl').'</option>';
															echo '<option value="free">'.esc_html__('Free','tpebl').'</option>';
															echo '<option value="freemium">'.esc_html__('Freemium','tpebl').'</option>';
															echo '<option value="pro">'.esc_html__('Pro','tpebl').'</option>';
														echo '</select>';
													echo '</div>';
												echo '</div>';
												echo '<div class="theplus-widget-filters-search">';
												
													/*since 5.0.0*/
													echo '<div class="tp-widget-scan-area">
														<span class="tp-widget-scan-disable-text" style="position:absolute;top:-15px;color:#ff5A6E;padding:0;border:none;background:transparent;left:0;right:0;user-select:none;cursor:text;font-size:12px;justify-content:center;font-weight:500;"></span>
														<button class="tp-widget-scan-disable" data-page="tpewidpage">
															<span>'.esc_html__('Disable Unused Widgets', 'tpebl').'</span>
															<span class="tp-scan-spinner"></span>
														</button>';
													echo '<button class="tp-widget-scan" data-page="tpewidpage">
															<span>'.esc_html__('Scan Unused Widgets', 'tpebl').'</span>
															<span class="tp-scan-spinner"></span>
														</button>';
													echo '</div>';
													
													echo '<label class="theplus-filter-widget-search"><input type="text" class="widget-search" placeholder="'.esc_attr__("Search..","tpebl").'" /></label>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
									/*block filter*/
									
									/*block listing*/
									echo '<form class="cmb-form" action="'.esc_url( admin_url('admin-post.php') ).'" method="post" id="theplus_options" enctype="multipart/form-data" encoding="multipart/form-data">';
										wp_nonce_field( 'nonce_theplus_options_action', 'nonce_theplus_options' );
										$pro_tag='';
										if(!defined('THEPLUS_VERSION')){
											$pro_tag ='plus-widget-pro';
										}
										echo '<div class="theplus-panel-row theplus-mt-50 plus-widget-list '.$pro_tag.'">';
											echo $this->theplus_widget_list_rendered();
										echo '</div>';
										/*plus extras*/
										echo '<div class="plus-extras-feature-list">											
												<h3 class="plus-extras-feature-list-title">Plus Features</h3>
												<p class="plus-extras-feature-list-description">List of features added in The Plus Addons for Elementor. You can enable/disable them from below.</p>
											</div>';
										echo '<div class="theplus-panel-row theplus-mt-50 plus-widget-list '.$pro_tag.' plus_extra_listout">';
											echo $this->theplus_extra_list_rendered();
										echo '</div>';
										/*plus extras*/
										echo '<input type="hidden" name="action" value="theplus_widgets_opts_save">';
										echo '<input type="submit" name="submit-key" value="Save" class="button-primary theplus-submit-widget">';
									echo '</form>';
									/*block listing*/
								echo '</div>';
							}
							if($tab_form['id']=='post_type_options'){								
								echo '<div class="post_type_options_btn_link">	
									<ul class="post_type_options_btn_link_list">
										<li><a href="#client_p_t">'.esc_html__('Clients','tpebl').'</a><span class="theplus-sep-nav"></span></li>
										<li><a href="#testimonial_p_t" >'.esc_html__('Testimonial','tpebl').'</a><span class="theplus-sep-nav"></span></li>
										<li><a href="#team_member_p_t" >'.esc_html__('Team Member','tpebl').'</a></li>
									</ul>	
								</div>';				
							}
							/*Plus Design start*/
							if($tab_form['id']=='theplus_import_data'){
								do_action('theplus_free_pro_import_data');
							} 
							/*Plus Design end*/
							
							/*Activate start*/
							if($tab_form['id']=='theplus_purchase_code'){
								do_action('theplus_free_pro_purchase_code');
							} 
							/*Activate end*/
							
							/*White Label start*/
							if($tab_form['id']=='theplus_white_label'){
								do_action('theplus_free_pro_white_label');
							} 
							/*White Label end*/
							
							/*elementor widget start*/
							if($tab_form['id']=='theplus_elementor_widget'){
							echo '<div class="plus-ele-widget-list">											
								<h3 class="plus-ele-widget-list-title">Elementor Free & Pro Widgets Manager</h3>
								<p class="plus-ele-widget-list-description">This is beta feature. You may enable/disable any widgets as well as scan widgets to auto disable all at once. Below is a collection of widgets for Elementor Free and Elementor Pro version.</p>
							</div>';
							echo '<div class="theplus-panel-col theplus-panel-col-100"><div class="panel-plus-widget-filter">';	
							echo '<label class="panel-widget-head panel-widget-check-all"><span><svg xmlns="http://www.w3.org/2000/svg" width="23.532" height="20.533" viewBox="0 0 23.532 20.533">
							  <path d="M6.9,15.626,0,8.73,2.228,6.5,6.9,11.064,17.729,0,20,2.388Z" transform="translate(4.307) rotate(16)"/>
							</svg></span><input type="checkbox" id="widget_check_all" /> '.esc_html__('Enable All','tpebl').'</label>';	

							/*since 5.0.0*/
							echo '<div class="tp-widget-scan-area">
								<span class="tp-widget-scan-disable-text" style="position:absolute;top:-15px;color:#ff5A6E;padding:0;border:none;background:transparent;left:0;right:0;user-select:none;cursor:text;font-size:12px;justify-content:center;font-weight:500;"></span>
								<button class="tp-widget-scan-disable" data-page="elementorwidgetpage">
									<span>'.esc_html__('Disable Unused Widgets', 'tpebl').'</span>
									<span class="tp-scan-spinner"></span>
								</button>';
							echo '<button class="tp-widget-scan" data-page="elementorwidgetpage">
									<span>'.esc_html__('Scan Unused Widgets', 'tpebl').'</span>
									<span class="tp-scan-spinner"></span>
								</button>';
							echo '</div>';
							echo '</div>';
							echo '</div>';

													
	$elewid = $this->tp_ele_get_registered_widgets();
	echo '<form class="cmb-form" action="'.esc_url( admin_url('admin-post.php') ).'" method="post" id="elementor_widgets_options" enctype="multipart/form-data" encoding="multipart/form-data">';
		wp_nonce_field( 'nonce_ele_options_action', 'nonce_ele_options' );
		$ele_wid_options=get_option( 'theplus_elementor_widget' );
		$ele_wid_get = $ele_wid_options['elementor_check_elements'];
		
		foreach ($elewid as $key => $val) {	
			$checked = '';
			if(!empty($ele_wid_get) && in_array($key, $ele_wid_get)){
				$checked = 'checked="checked"';
			}			
			
			echo '<div class="theplus-ele-panel-col theplus-ele-panel-col-25">';
				echo '<div class="theplus-ele-panel-col-inner">';
					echo '<span class="widget-name-wrap">'.esc_html($val).'</span>';
					echo '<div class="widget-check-wrap">
							<input type="checkbox" class="ele-widget-list-checkbox" name="elementor_check_elements[]" id="'.esc_attr($key).'" value="'.esc_attr($key).'" '.$checked.' > <label for="'.esc_attr($key).'"></label>
						</div>';
				echo '</div>';
			echo '</div>';
		}
	echo '<input type="hidden" name="action" value="tp_ele_widgets_opts_save">';
		echo '<input type="submit" name="ele-submit-key" value="Save" class="button-primary theplus-submit-widget">';
	echo '</form>';
} 
/*elementor widget end*/
							
							if(defined('THEPLUS_VERSION') && $tab_form['id']=='theplus_white_label'){								
								cmb2_metabox_form($tab_form, $tab_form['id']);
								
							}else if($tab_form['id']!='theplus_welcome_page' && $tab_form['id']!='theplus_options' && $tab_form['id']!='theplus_import_data' && $tab_form['id']!='theplus_purchase_code' && $tab_form['id']!='theplus_white_label' && $tab_form['id']!='theplus_elementor_widget'){		
								cmb2_metabox_form($tab_form, $tab_form['id']);
							}else if($tab_form['id']=='theplus_welcome_page'){								
								include_once L_THEPLUS_INCLUDES_URL.'welcome-page.php';
							}
						endforeach;
						$out = ob_get_clean();
						$output .= $out;
					}
				$output .='</div>';
					
		$output .='</div>';		
		echo $output;
		
		if(defined('THEPLUS_VERSION')){
			$current_screen = get_current_screen();
			$hidden_label = theplus_white_label_option('tp_hidden_label');
			if( !empty($hidden_label) && $hidden_label=='on' ){
				if( is_admin() && !empty($current_screen) && ($current_screen->id === "theplus-settings_page_theplus_white_label" || $current_screen->id === "theplus-settings_page_theplus_purchase_code")) {
					wp_safe_redirect( admin_url( 'admin.php?page=theplus_options' ) );
					exit;
				}
				echo '<style>#theplus_white_label{display:none;}</style>';
			}
		}
		
    }
   
	
    /**
     * Defines the theme option metabox and field configuration
     * @since  1.0.0
     * @return array
     */
    public function option_fields($verify_api='')
    {
		
        // Only need to initiate the array once per page-load
        if (!empty($this->option_metabox)) {
            return $this->option_metabox;
        }
		
		$this->option_metabox[] = array(
            'id' => 'theplus_welcome_page',
            'title' => 'Welcome',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_welcome_page'
                )
            ),
            'show_names' => true,
            'fields' => ''
        );
		
        $this->option_metabox[] = array(
            'id' => 'theplus_options',
            'title' => 'Plus Widgets',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_options'
                )
            ),
            'show_names' => true,
            'fields' => '',
        );
        
        $this->option_metabox[] = array(
            'id' => 'post_type_options',
            'title' => 'Plus Listing',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'post_type_options'
                )
            ),
            'show_names' => true,
            'fields' => array(				
				/* client option start */
				array(
					'name' => esc_html__('Clients Post Type Settings', 'tpebl'),
					'desc' => esc_html__('Use below settings to configure your “Clients” custom post type.', 'tpebl'),
					'type' => 'title',
					'id' => 'client_post_title'
				),
				array(
						'name' => esc_html__('Select Post Type Type', 'tpebl'),
						'desc' => '',
						'id' => 'client_post_type',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'disable',
						'options' => array(
							'disable' => esc_html__('Disable', 'tpebl'),
							'plugin' => esc_html__('ThePlus Post Type', 'tpebl'),
							'themes' => esc_html__('Prebuilt Theme Based', 'tpebl'),
						)
				),
				array(
				'name' => esc_html__('Post Name : (Keep Blank if you want to keep default Name)', 'tpebl'),
				'desc' => esc_html__('Enter value for clients custom post type name. Default: "theplus_clients"', 'tpebl'),
				'default' => '',
				'id' => 'client_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Post Title : (Keep Blank if you want to keep default Title)', 'tpebl'),
				'desc' => esc_html__('Enter value for clients custom post title name. Default: "Tp Clients"', 'tpebl'),
				'default' => '',
				'id' => 'client_plugin_title',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Category Taxonomy Value : (Keep Blank if you want to keep default Name)', 'tpebl'),
				'desc' => esc_html__('Enter value for Category Taxonomy Value. Default : "theplus_clients_cat" ', 'tpebl'),
				'default' => '',
				'id' => 'client_category_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Post Name : (You can find that from here)', 'tpebl'),
				'desc' => sprintf( __('Enter the value of your current post type name which is prebuilt with your theme. E.g.: "theplus_clients" <a href="%s" class="thickbox" title="Get the Post Name of Custom Post type as per above Screenshot.">Check screenshot</a> for how to get that value from URL of your current post type.', 'tpebl'), L_THEPLUS_URL.'assets/images/post-type-screenshot.png' ),
				'default' => '',
				'id' => 'client_theme_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Category Taxonomy Value : (You can find that from here)', 'tpebl'),
				'desc' => sprintf( __('Enter the value of your current Category Taxonomy Value which is prebuilt with your theme.  E.g. : "theplus_clients_cat" <a href="%s" class="thickbox" title="Get the Category Taxonomy Value as per above screenshot.">Check screenshot</a> for how to get that value from URL of your current taxonomy.', 'tpebl'), L_THEPLUS_URL.'assets/images/taxonomy-screenshot.png'),
				'default' => '',
				'id' => 'client_category_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'client_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				/* client option start */
				/* testimonial option start */
				array(
					'name' => esc_html__('Testimonial Post Type Settings', 'tpebl'),
					'desc' => esc_html__('Use below settings to configure your “Testimonial” custom post type.', 'tpebl'),
					'type' => 'title',
					'id' => 'testimonial_post_title'
				),
				array(
						'name' => esc_html__('Select Post type Type', 'tpebl'),
						'desc' => '',
						'id' => 'testimonial_post_type',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'disable',
						'options' => array(
							'disable' => esc_html__('Disable', 'tpebl'),
							'plugin' => esc_html__('ThePlus Post Type', 'tpebl'),
							'themes' => esc_html__('Prebuilt Theme Based', 'tpebl'),
						)
				),
				array(
				'name' => esc_html__('Post Name : (Keep Blank if you want to keep default Name)', 'tpebl'),
				'desc' => esc_html__('Enter value for testimonial custom post type name. Default: "theplus_testimonial"', 'tpebl'),
				'default' => '',
				'id' => 'testimonial_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Post Title : (Keep Blank if you want to keep default Title)', 'tpebl'),
				'desc' => esc_html__('Enter value for testimonial custom post title name. Default: "TP Testimonials"', 'tpebl'),
				'default' => '',
				'id' => 'testimonial_plugin_title',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Category Taxonomy Value : (Keep Blank if you want to keep default Name)', 'tpebl'),
				'desc' => esc_html__('Enter value for Category Taxonomy Value. Default :"theplus_testimonial_cat"', 'tpebl'),
				'default' => '',
				'id' => 'testimonial_category_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Post Name : (You can find that from here)', 'tpebl'),
				'desc' => sprintf( __('Enter the value of your current post type name which is prebuilt with your theme. E.g.: "theplus_testimonial" <a href="%s" class="thickbox" title="Get the Post Name of Custom Post type as per above Screenshot.">Check screenshot</a> for how to get that value from URL of your current post type.', 'tpebl'), L_THEPLUS_URL.'assets/images/post-type-screenshot.png' ),
				'default' => '',
				'id' => 'testimonial_theme_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Category Taxonomy Value : (You can find that from here)', 'tpebl'),
				'desc' => sprintf( __('Enter the value of your current Category Taxonomy Value which is prebuilt with your theme.  E.g. : "theplus_testimonial_cat" <a href="%s" class="thickbox" title="Get the Category Taxonomy Value as per above screenshot.">Check screenshot</a> for how to get that value from URL of your current taxonomy.', 'tpebl'), L_THEPLUS_URL.'assets/images/taxonomy-screenshot.png' ),
				'default' => '',
				'id' => 'testimonial_category_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'testimonial_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				/* testimonial option start */
				/* Team Member option start */
				array(
					'name' => esc_html__('Team Member Post Type Settings','tpebl'),
					'desc' => esc_html__('Use below settings to configure your “Team Member” custom post type.', 'tpebl'),
					'type' => 'title',
					'id' => 'team_member_post_title'
				),
				array(
						'name' => esc_html__('Select Team Member Post Type', 'tpebl'),
						'desc' => '',
						'id' => 'team_member_post_type',
						'type' => 'select',
						'show_option_none' => true,
						'default' => 'disable',
						'options' => array(
							'disable' => esc_html__('Disable', 'tpebl'),
							'plugin' => esc_html__('ThePlus Post Type', 'tpebl'),
							'themes' => esc_html__('Prebuilt Theme Based', 'tpebl'),
						)
				),
				array(
				'name' => esc_html__('Post Name : (Keep Blank if you want to keep default Name)', 'tpebl'),
				'desc' => esc_html__('Enter value for team member custom post type name. Default: "theplus_team_member"', 'tpebl'),
				'default' => '',
				'id' => 'team_member_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Post Title : (Keep Blank if you want to keep default Title)', 'tpebl'),
				'desc' => esc_html__('Enter value for team member custom post type title. Default: "TP Team Members"', 'tpebl'),
				'default' => '',
				'id' => 'team_member_plugin_title',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Category Taxonomy Value (Keep Blank if you want to keep default Name)', 'tpebl'),
				'desc' => esc_html__('Enter value for Category Taxonomy Value. Default : "theplus_team_member_cat"', 'tpebl'),
				'default' => '',
				'id' => 'team_member_category_plugin_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'plugin',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Post Name : (You can find that from here)', 'tpebl'),
				'desc' => sprintf( __('Enter the value of your current post type name which is prebuilt with your theme. E.g.: "theplus_team_member" <a href="%s" class="thickbox" title="Get the Post Name of Custom Post type as per above Screenshot.">Check screenshot</a> for how to get that value from URL of your current post type.', 'tpebl'), L_THEPLUS_URL.'assets/images/post-type-screenshot.png' ),
				'default' => '',
				'id' => 'team_member_theme_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				array(
				'name' => esc_html__('Prebuilt Category Taxonomy Value (You can find that from here)', 'tpebl'),
				'desc' => sprintf( __('Enter the value of your current Category Taxonomy Value which is prebuilt with your theme.  E.g. : "theplus_team_member_cat" <a href="%s" class="thickbox" title="Get the Category Taxonomy Value as per above screenshot.">Check screenshot</a> for how to get that value from URL of your current taxonomy.', 'tpebl'), L_THEPLUS_URL.'assets/images/taxonomy-screenshot.png' ),
				'default' => '',
				'id' => 'team_member_category_name',
				'type' => 'text',
					'attributes' => array(
						'data-conditional-id'    => 'team_member_post_type',
						'data-conditional-value' => 'themes',
					),
				),
				/* Team Member option start */
            )
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_import_data',
            'title' => 'Plus Designs',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_import_data'
                )
            ),
            'show_names' => true,
        );
		$api_con_fields=[
			array(
					'name' => esc_html__('Lazy Load (Beta)', 'tpebl'),
					'desc' => esc_html__('We are adding Lazy Load Functionality in each of our widgets. It\'s in beta version at this moment but completely implemented very soon. It will help you drastically in Google Web Vitals. ', 'tpebl'),
					'id' => 'plus_lazyload_opt',
					'type' => 'select',
					'show_option_none' => false,
					'default' => 'disable',
					'options' => array(
						'disable' => esc_html__('Disable', 'tpebl'),
						'enable' => esc_html__('Enable', 'tpebl'),
					),
			),
			array(
					'name' => esc_html__('Lazy Load Type', 'tpebl'),
					'desc' => esc_html__('Choose Type of animation you want in Lazy Load using above options.', 'tpebl'),
					'id' => 'plus_lazyload_opt_anim',
					'type' => 'select',
					'show_option_none' => false,
					'default' => 'fade',
					'options' => array(
						'fade' => esc_html__('Fade In', 'tpebl'),
						'dbl-circle' => esc_html__('Double Circle', 'tpebl'),
						'circle' => esc_html__('Simple Circle', 'tpebl'),
						'blur-img' => esc_html__('Blur Image', 'tpebl'),
						'skeleton' => esc_html__('Skeleton', 'tpebl'),
					),
					'attributes' => array(
						'data-conditional-id'    => 'plus_lazyload_opt',
						'data-conditional-value' => 'enable',
					),
			),
		];
		if(has_filter('theplus_pro_api_con_field')) {
			$api_con_fields = apply_filters('theplus_pro_api_con_field', $api_con_fields);
		}
		$this->option_metabox[] = array(
            'id' => 'theplus_api_connection_data',
            'title' => 'Extra Options',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_api_connection_data'
                )
            ),
            'show_names' => true,
			 'fields' => $api_con_fields,
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_performance',
            'title' => 'Performance',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_performance'
                )
            ),
            'show_names' => true,
            'fields' => [
				array(
						'name' => esc_html__('Cache Manager', 'tpebl'),
						'desc' => '',
						'id' => 'plus_cache_option',
						'type' => 'select',
						'show_option_none' => false,
						'default' => 'external',
						'options' => array(
							'external' => esc_html__('Smart Optimised (Recommended)', 'tpebl'),
							'separate' => esc_html__('On Demand Assets', 'tpebl'),
						),
				),
			],
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_styling_data',
            'title' => 'Custom',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_styling_data'
                )
            ),
            'show_names' => true,
            'fields' => array(				
				array( 
					'name' => esc_html__( 'Custom CSS', 'tpebl' ),
					'desc' => esc_html__( 'Add Your Custom CSS Styles', 'tpebl' ),
					'id' => 'theplus_custom_css_editor',
					'type' => 'textarea_code',
					'default' => '',
				),
				array( 
					'name' => esc_html__( 'Custom JS', 'tpebl' ),
					'desc' => esc_html__( 'Add Your Custom JS Scripts', 'tpebl' ),
					'id' => 'theplus_custom_js_editor',
					'type' => 'textarea_code',
					'default' => '',
				),
				array(
					'id'   => 'tp_styling_hidden',
					'type' => 'hidden',
					'default' => 'hidden',
				),
			),
        );
		$this->option_metabox[] = array(
            'id' => 'theplus_purchase_code',
            'title' => 'Activate',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_purchase_code'
                )
            ),
            'show_names' => true,
			 'fields' => '',
        );
		
		$white_label_fields_ar=[];
		if(has_filter('theplus_pro_white_lab_fields')) {
			$white_label_fields_ar = apply_filters('theplus_pro_white_lab_fields', $white_label_fields_ar);
		}
		
		$this->option_metabox[] = array(
            'id' => 'theplus_white_label',
            'title' => 'White Label',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_white_label'
                )
            ),
            'show_names' => true,
			'fields' => $white_label_fields_ar,
        );
		
		$this->option_metabox[] = array(
            'id' => 'theplus_elementor_widget',
            'title' => 'Elementor Widget',
            'show_on' => array(
                'key' => 'options-page',
                'value' => array(
                    'theplus_elementor_widget'
                )
            ),
            'show_names' => true,
			'fields' => $white_label_fields_ar,
        );
		
        return $this->option_metabox;
    }
	
    public function get_option_key($field_id)
    {
        $option_tabs = $this->option_fields();
        foreach ($option_tabs as $option_tab) { //search all tabs
            foreach ($option_tab['fields'] as $field) { //search all fields
                if ($field['id'] == $field_id) {
                    return $option_tab['id'];
                }
            }
        }
        return $this->key; //return default key if field id not found
    }
    /**
     * Public getter method for retrieving protected/private variables
     * @since  1.0.0
     * @param  string  $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get($field)
    {
        
        // Allowed fields to retrieve
        if (in_array($field, array('key','fields','title','options_page'), true)) {
            return $this->{$field};
        }
        if ('option_metabox' === $field) {
            return $this->option_fields();
        }
        
        throw new Exception('Invalid property: ' . $field);
    }
    
}


// Get it started
$L_Theplus_Elementor_Plugin_Options = new L_Theplus_Elementor_Plugin_Options();
$L_Theplus_Elementor_Plugin_Options->hooks();

/**
 * Wrapper function around cmb_get_option
 * @since  1.0.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function l_theplus_ele_get_option($key = '')
{
    global $L_Theplus_Elementor_Plugin_Options;
    return cmb_get_option($L_Theplus_Elementor_Plugin_Options->key, $key);
}