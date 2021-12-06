<?php
namespace TheplusAddons;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'L_Theplus_Widgets_Include' ) ) {

	/**
	 * Define L_Theplus_Widgets_Include class
	 */
	class L_Theplus_Widgets_Include {
		
		
		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;
		
		/**
		 * Check if processing elementor widget
		 *
		 * @var boolean
		 */
		 /**
		 * Localize data array
		 *
		 * @var array
		 */
		public $localize_data = array();
		
		/**
		 * ThePlus_Load constructor.
		 */
		private function __construct() {
			
			$this->required_fiels();
			l_theplus_generator()->init();
			l_theplus_library();
			if(!defined('THEPLUS_VERSION')){
				$this->init();
				l_theplus_wpml_translate();
			}
			if(defined('THEPLUS_VERSION')){
				add_filter( 'all_plugins',array($this,'tp_white_label_update_free') );
			}
		}
		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function init() {
			add_action( 'elementor/widgets/widgets_registered', array($this, 'add_widgets' ) );
			
		}
		
		/*
		 * White label
		 * @since 3.0
		 */
		public function tp_white_label_update_free( $all_plugins ){				
				$plugin_name =theplus_white_label_option('l_tp_plugin_name');
				$tp_plugin_desc =theplus_white_label_option('l_tp_plugin_desc');
				$tp_author_name =theplus_white_label_option('l_tp_author_name');
				$tp_author_uri =theplus_white_label_option('l_tp_author_uri');
			if(!empty($all_plugins[L_THEPLUS_PBNAME]) && is_array($all_plugins[L_THEPLUS_PBNAME])){
			$all_plugins[L_THEPLUS_PBNAME]['Name']           = ! empty( $plugin_name )     ? $plugin_name      : $all_plugins[L_THEPLUS_PBNAME]['Name'];
			$all_plugins[L_THEPLUS_PBNAME]['PluginURI']      = ! empty( $tp_author_uri )      ? $tp_author_uri       : $all_plugins[L_THEPLUS_PBNAME]['PluginURI'];
			$all_plugins[L_THEPLUS_PBNAME]['Description']    = ! empty( $tp_plugin_desc )     ? $tp_plugin_desc      : $all_plugins[L_THEPLUS_PBNAME]['Description'];
			$all_plugins[L_THEPLUS_PBNAME]['Author']         = ! empty( $tp_author_name )   ? $tp_author_name    : $all_plugins[L_THEPLUS_PBNAME]['Author'];
			$all_plugins[L_THEPLUS_PBNAME]['AuthorURI']      = ! empty( $tp_author_uri )      ? $tp_author_uri       : $all_plugins[L_THEPLUS_PBNAME]['AuthorURI'];
			$all_plugins[L_THEPLUS_PBNAME]['Title']          = ! empty( $plugin_name )     ? $plugin_name      : $all_plugins[L_THEPLUS_PBNAME]['Title'];
			$all_plugins[L_THEPLUS_PBNAME]['AuthorName']     = ! empty( $tp_author_name )   ? $tp_author_name    : $all_plugins[L_THEPLUS_PBNAME]['AuthorName'];

			return $all_plugins;
			}
		}
		/**
		* Widget Include required files
		*
		*/
		public function required_fiels()
		{	
			require_once L_THEPLUS_PATH.'modules/enqueue/plus-library.php';
			require_once L_THEPLUS_PATH.'modules/enqueue/plus-generator.php';
			if(!defined('THEPLUS_VERSION')){
				require_once L_THEPLUS_PATH.'modules/enqueue/plus-wpml.php';
			}
		}
		/**
		 * Add new controls.
		 *
		 * @param  object $widgets_manager Controls manager instance.
		 * @return void
		 */		
		public function add_widgets( $widgets_manager ) {

			$grouped = array(
				'theplus-widgets' => '\TheplusAddons\Widgets\L_Theplus_Elements_Widgets',
				'tp_smooth_scroll' => '\TheplusAddons\Widgets\L_ThePlus_Smooth_Scroll',
				'tp_accordion' => '\TheplusAddons\Widgets\L_ThePlus_Accordion',
				'tp_adv_text_block' => '\TheplusAddons\Widgets\L_ThePlus_Adv_Text_Block',
				'tp_age_gate' => '\TheplusAddons\Widgets\L_ThePlus_Age_Gate',
				'tp_blockquote' => '\TheplusAddons\Widgets\L_ThePlus_Block_Quote',
				'tp_blog_listout' => '\TheplusAddons\Widgets\L_ThePlus_Blog_ListOut',
				'tp_button' => '\TheplusAddons\Widgets\L_ThePlus_Button',
				'tp_caldera_forms' => '\TheplusAddons\Widgets\L_ThePlus_Caldera_Forms',
				'tp_clients_listout' => '\TheplusAddons\Widgets\L_ThePlus_Clients_ListOut',
				'tp_contact_form_7' => '\TheplusAddons\Widgets\L_ThePlus_Contact_Form_7',
				'tp_countdown' => '\TheplusAddons\Widgets\L_ThePlus_Countdown',	
				'tp_everest_form' => '\TheplusAddons\Widgets\L_ThePlus_Everest_form',
				'tp_flip_box' => '\TheplusAddons\Widgets\L_ThePlus_Flip_Box',
				'tp_gallery_listout' => '\TheplusAddons\Widgets\L_ThePlus_Gallery_ListOut',
				'tp_gravity_form' => '\TheplusAddons\Widgets\L_ThePlus_Gravity_Form',
				'tp_heading_animation' => '\TheplusAddons\Widgets\L_ThePlus_Heading_Animation',
				'tp_header_extras' => '\TheplusAddons\Widgets\L_ThePlus_Header_Extras',
				'tp_heading_title' => '\TheplusAddons\Widgets\L_Theplus_Ele_Heading_Title',
				'tp_hovercard' => '\TheplusAddons\Widgets\L_ThePlus_Hovercard',
				'tp_info_box' => '\TheplusAddons\Widgets\L_ThePlus_Info_Box',
				'tp_meeting_scheduler' => '\TheplusAddons\Widgets\L_ThePlus_Meeting_Scheduler',
				'tp_messagebox' => '\TheplusAddons\Widgets\L_ThePlus_MessageBox',
				'tp_navigation_menu_lite' => '\TheplusAddons\Widgets\L_ThePlus_Navigation_Menu_Lite',
				'tp_ninja_form' => '\TheplusAddons\Widgets\L_ThePlus_Ninja_form',
				'tp_number_counter' => '\TheplusAddons\Widgets\L_ThePlus_Number_Counter',
				'tp_post_title' => '\TheplusAddons\Widgets\L_ThePlus_Post_Title',				
				'tp_post_content' => '\TheplusAddons\Widgets\L_ThePlus_Post_Content',
				'tp_post_featured_image' => '\TheplusAddons\Widgets\L_ThePlus_Featured_Image',
				'tp_post_meta' => '\TheplusAddons\Widgets\L_ThePlus_Post_Meta',
				'tp_post_author' => '\TheplusAddons\Widgets\L_ThePlus_Post_Author',
				'tp_post_comment' => '\TheplusAddons\Widgets\L_ThePlus_Post_Comment',
				'tp_page_scroll' => '\TheplusAddons\Widgets\L_ThePlus_Page_Scroll',
				'tp_pricing_table' => '\TheplusAddons\Widgets\L_ThePlus_Pricing_Table',
				'tp_post_search' => '\TheplusAddons\Widgets\L_ThePlus_Post_Search',
				'tp_progress_bar' => '\TheplusAddons\Widgets\L_ThePlus_Progress_Bar',
				'tp_scroll_navigation' => '\TheplusAddons\Widgets\L_ThePlus_Scroll_Navigation',
				'tp_social_icon' => '\TheplusAddons\Widgets\L_ThePlus_Social_Icon',
				'tp_tabs_tours' => '\TheplusAddons\Widgets\L_ThePlus_Tabs_Tours',
				'tp_team_member_listout' => '\TheplusAddons\Widgets\L_ThePlus_Team_Member_ListOut',
				'tp_testimonial_listout' => '\TheplusAddons\Widgets\L_ThePlus_Testimonial_ListOut',
				'tp_video_player' => '\TheplusAddons\Widgets\L_ThePlus_Video_Player',				
				'tp_wp_forms' => '\TheplusAddons\Widgets\L_ThePlus_Wp_Forms',
			);
			
			$get_option=l_theplus_get_option('general','check_elements');
			if(!empty($get_option)){
				array_push($get_option, "theplus-widgets");				
				foreach ( $grouped as $widget_id => $class_name ) {
					if(in_array($widget_id,$get_option)){
						if ( $this->include_widget( $widget_id, true ) ) {
							$widgets_manager->register_widget_type( new $class_name() );
						}
					}
				}
			}
		}
		
		
		/**
		 * Include control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 * @return [type]             [description]
		 */
		public function include_widget( $widget_id, $grouped = false ) {

			$filename = sprintf('modules/widgets/'.$widget_id.'.php');

			if ( ! file_exists( L_THEPLUS_PATH.$filename ) ) {
				return false;
			}

			require L_THEPLUS_PATH.$filename;

			return true;
		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of L_Theplus_Widgets_Include
 *
 * @return object
 */
function l_theplus_widgets_include() {
	return L_Theplus_Widgets_Include::get_instance();
}