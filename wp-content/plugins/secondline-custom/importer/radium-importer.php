<?php

/**
 * Class Radium_Theme_Importer
 *
 * This class provides the capability to import demo content as well as import widgets and WordPress menus
 *
 * @since 0.0.2
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 *
 */

 // Exit if accessed directly
 if ( !defined( 'ABSPATH' ) ) exit;

 // Don't duplicate me!
 if ( !class_exists( 'Radium_Theme_Importer' ) ) {
	 
	 	global $wp_customize;

	class Radium_Theme_Importer {

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $widgets;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $content_demo;
		
		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $slider;		

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $flag_as_imported = array( 'content' => false, 'menus' => false, 'widgets' => false, 'slider' => false);

		/**
		 * imported sections to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $imported_demos = array();

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var bool
		 */
		public $add_admin_menu = true;

	    /**
	     * Holds a copy of the object for easy reference.
	     *
	     * @since 0.0.2
	     *
	     * @var object
	     */
	    private static $instance;

	    /**
	     * Constructor. Hooks all interactions to initialize the class.
	     *
	     * @since 0.0.2
	     */
		 
		 
	    public function __construct() {

	       self::$instance = $this;

	       $this->demo_files_path = apply_filters('radium_theme_importer_demo_files_path', $this->demo_files_path);
		   			
		   $this->theme_name1 = apply_filters('radium_theme_importer_theme_names', $this->theme_name1);
		   			
		   $this->theme_namess = apply_filters('radium_theme_importer_theme_names', $this->theme_namess);
			
	       $this->widgets = apply_filters('radium_theme_importer_widgets_file', $this->widgets_file_name);			

	       $this->content_demo = apply_filters('radium_theme_importer_content_demo_file', $this->content_demo_file_name);

		   $this->imported_demos = get_option( 'radium_imported_demo' );

	        if( $this->add_admin_menu ) add_action( 'admin_menu', array($this, 'add_admin') );

			// add_filter( 'add_post_metadata', array( $this, 'check_previous_meta' ), 10, 5 );

      		add_action( 'radium_import_end', array( $this, 'after_wp_importer' ) );
			
			

	    }
		

		/**
		 * Add Panel Page
		 *
		 * @since 0.0.2
		 */
	    public function add_admin() {

	        add_submenu_page('themes.php', "Import Demo Data", "Import Demo Data", 'switch_themes', 'radium_demo_installer', array($this, 'demo_installer'));
			
			
	    }

	    /**
         * Avoids adding duplicate meta causing arrays in arrays from WP_importer
         *
         * @param null    $continue
         * @param unknown $post_id
         * @param unknown $meta_key
         * @param unknown $meta_value
         * @param unknown $unique
         *
         * @since 0.0.2
         *
         * @return
         */
        public function check_previous_meta( $continue, $post_id, $meta_key, $meta_value, $unique ) {
			

			$old_value = get_metadata( 'post', $post_id, $meta_key );
			/* Breaks Metabox with multiple values
			if ( count( $old_value ) == 1 ) {

				if ( $old_value[0] === $meta_value ) {

					return false;

				} elseif ( $old_value[0] !== $meta_value ) {

					update_post_meta( $post_id, $meta_key, $meta_value );
					return false;

				}

			}
			 */

    	}

    	/**
    	 * Add Panel Page
    	 *
    	 * @since 0.0.2
    	 */
    	public function after_wp_importer() {

			do_action( 'radium_importer_after_content_import');

			update_option( 'radium_imported_demo', $this->flag_as_imported );

		}
		
    	public function intro_html() {
			if(isset($_POST['theme_name_hid']))
			{
				echo "<h1 class='impor_msg'>The Demo import has started please Wait!";
				echo '<img src="'. $plugin_url=plugin_dir_url(__FILE__) .'loading.gif" width="32px" height="32px" style="vertical-align: text-top;margin-left: 20px;" />';			
				echo "</h1>";	
			}
			?>

			
				<!--<h1 class='impor_msg'>The Demo is Importing please Wait!</h1>-->
			 <?php

			 if( !empty($this->imported_demos) ) { ?>

			  	<div style="background-color: #FAFFFB; margin:10px 0;padding: 5px 10px;color: #8AB38A;border: 2px solid #a1d3a2; clear:both; width:90%; line-height:18px;">
			  		<p><?php _e('Demo already imported', 'secondline-custom'); ?></p>
			  	</div>
				
				<?php
			   	//return;

			  }
    	}

	    /**
	     * demo_installer Output
	     *
	     * @since 0.0.2
	     *
	     * @return null
	     */
	    public function demo_installer() {

			
			$action = isset($_POST['action']) ? $_POST['action'] : '';				
			$theme_name_hid = isset($_POST['theme_name_hid']) ? $_POST['theme_name_hid'] : '';
			$widgetsoption = isset($_POST['widgetsoption']) ? $_POST['widgetsoption'] : '';
			$democontent = isset($_POST['democontent']) ? $_POST['democontent'] : '';
			$themeoption = isset($_POST['themeoption']) ? $_POST['themeoption'] : '';
			
			

			if( !empty($this->imported_demos ) ) {

				$button_text = esc_html__('Import Again', 'secondline-custom');

			} else {

				$button_text = esc_html__('Import Demo Data', 'secondline-custom');

			}

	        ?>
            <div id="icon-tools" class="icon32"><br></div>
	        <h2><?php echo esc_html__('Import Demo Data', 'secondline-custom'); ?></h2>
			  
		  
   			<div style="background-color: #F5FAFD; margin:10px 0;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;">
   			    <p class="tie_message_hint"><?php echo esc_html__('Tips', 'secondline-custom'); ?></p>

   			      <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
 						 <li><?php echo esc_html__('The importer will not delete any pages, posts, or content.  It will only add content and adjust theme options.', 'secondline-custom'); ?></li>
   						 <li><?php echo esc_html__('If the import times out or does not finish, please run the importer again.', 'secondline-custom'); ?> </li>		
 						 <li><?php echo esc_html__('Running the importer mulitple times may duplicate your menu items. If you run the importer again, make sure to delete any navigation menus under Navigation > Menus.  You will not have delete any pages as those will not duplicate.', 'secondline-custom'); ?></li>
   			      </ul>
   			 </div>
			  

	       	<div class="radium-importer-wrap" data-demo-id="1"  data-nonce="<?php echo wp_create_nonce('radium-demo-code'); ?>">
				<?php $this->intro_html(); ?>
                
                
                <div class="demos_import" style=" display:none;">
				<?php 	
					$name_of_thmems= $this->theme_namess;				
					$plugin_url= get_template_directory_uri() . '/screenshot.png';					
				?>
                    <form name="import_form_<?php echo wp_get_theme(); ?>" method="post">
                        <div class="importoptions" style="border: 1px solid #ccc;padding: 1%;width: 24%; float:left; margin:1%;">
                        
                        	<?php 
							@$urls=getimagesize($plugin_url);
							
							 if(is_array($urls)){ ?>   
                            	<img src="<?php echo $plugin_url; ?>" width="100%" height="auto" />
                            <?php } else { ?>
                   				<img src="<?php echo $plugin_url=plugin_dir_url(__FILE__).'gray.png'; ?>" width="100%" height="aut" />
                            <?php } ?>
                            
                           <h1 style="text-align:center;"><?php echo wp_get_theme();?></h1>
                           <span style=" color: #666;display: block;font-weight: bold;  margin-bottom: 10px;">Select your import:</span>
                           <div class="importer-checkbox-input">
                           
                               <input type="hidden" name="demononce" value="<?php echo wp_create_nonce('radium-demo-code'); ?>" />				  <input type="checkbox" name="democontent" value="democontent" value="democontent" id="democontent">Demo Content</input>
                           </div>
                           <div class="importer-checkbox-input">
                           
                               <input type="checkbox" name="widgetsoption" value="widgetsoption" id="widgetsoption">Widgets</input>
                           </div>
                           <div class="importer-checkbox-input">
                               <input type="checkbox" name="themeoption" value="themeoption" id="themeoption">Theme Options</input>
                               
                           </div>
                           
                           <div class="importer-checkbox-input-button">			
                           <input name="reset" class="panel-save button-primary radium-import-start" type="submit" value="<?php echo $button_text ; ?>" />
                           <input type="hidden" name="theme_name_hid" value="<?php echo wp_get_theme();?>" />
                           <input type="hidden" name="action" value="demo-import" id="impor_demo_id" />

                           </div>
                            
                            <div class="radium-importer-message clear">
                            <?php 
                                if( $action == 'demo-import' && check_admin_referer('radium-demo-code' , 'demononce')){
                                    $path11 = $this->demo_files_path;     									
                                    $return_value=$this->process_imports($democontent,$widgetsoption,$themeoption,$path11);
                                }
                            ?>
                            </div>
                        </div>
					</form>
                    
                <?php //}?>
	 	        
				</div>
 	        </div>
			  
			 
  	        <br />
  	        <br />

	        <br />
	        <br /><?php

	    }

	    /**
	     * Process all imports
	     *
	     * @params $content
	     * @params $widgets
	     *
	     * @since 0.0.3
	     *
	     * @return null
	     */
	    public function process_imports($democontent,$widgetsoption,$themeoption,$path11) {
	
			
			if($democontent != ''){
			
				$democontentpath=$path11.$this->content_demo;
				if (!empty( $democontentpath ) && is_file($democontentpath ) ) {
					 $this->set_demo_data( $path11.$this->content_demo );
				}
				
				$this->set_demo_menus();
				
					$homepage = get_page_by_title ('Home');

					if ( isset( $homepage->ID ) ) {
						update_option( 'page_on_front', $homepage->ID );
						update_option( 'show_on_front', 'page' );

					}  
					
					$blogpage = get_page_by_title ('Episode Archives');
					if ( isset( $blogpage->ID ) ) {
						update_option( 'page_for_posts', $blogpage->ID );
					} 
			}	
			if($widgetsoption != ''){  
				
				 $widgetsoptionpath = get_template_directory() . '/demo-files/' . "widgets.json";
				if (  ! empty( $widgetsoptionpath ) && is_file( $widgetsoptionpath ) ) {
					$reswidget=$this->process_widget_import_file( $widgetsoptionpath );
					if(!empty($reswidget)){
						
					echo "<h3>Widgets have been imported<h3>";
					
					}else
					{
						echo "<h3>Error in widgets Import Please check<h3>";
					}
			
				}else{
					
					echo "<h3 style='color:RED'>Widgets Import File Does Not Exist <h3>";
					}
			}
			if($themeoption != ''){  	
				$themeoptionpath = get_template_directory() . '/demo-files/' . "theme_option.dat";
				global $wp_customize;
				 $result11=self::_import( $wp_customize,$themeoptionpath );   
					echo $result11;
					
					$this->set_demo_menus();
			}
		}
		
	
		
		static private function _import( $wp_customize,$themeoptionpath ) 
		{
			
		// Load the export/import option class.
		require_once dirname( __FILE__ ).'/classes/class-cei-option.php';     
		
		// Setup global vars.
		global $wp_customize;
		global $cei_error;
		
		// Setup internal vars.
		$cei_error	 = false;
		$template	 = get_template();
		$overrides   = array( 'test_form' => FALSE, 'mimes' => array('dat' => 'text/dat') );
		 $dir = $themeoptionpath;
		 $file = $dir;
		
		if ( ! file_exists( $dir ) ) {
			$cei_error = esc_html__( 'Error importing settings! Please try again.', 'secondline-custom' );
			return;
		}
		
		// Get the upload data.
		$raw  = file_get_contents( $file );
		$data = @unserialize( $raw );
	
		
		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			
			$cei_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'secondline-custom' );
			return;
		}
		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			
			$cei_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'secondline-custom' );
			return;
		}
		if ( $data['template'] != $template ) {

		}
		
		// Import images.

			
			$data['mods'] = self::_import_images( $data['mods'] );
		
		// Import custom options.
		if ( isset( $data['options'] ) ) {
			
			
			
			foreach ( $data['options'] as $option_key => $option_value ) {
				
				$option = new CEI_Option( $wp_customize, $option_key, array(
					'default'		=> '',
					'type'			=> 'option',
					'capability'	=> 'edit_theme_options'
				) );
				
				$option->import( $option_value );
			}
		}
		
		// Call the customize_save action.
		do_action( 'customize_save', $wp_customize );
		
		// Loop through the mods.
		foreach ( $data['mods'] as $key => $val ) {
			
			// Call the customize_save_ dynamic action.
			do_action( 'customize_save_' . $key, $wp_customize );
			
			// Save the mod.
			set_theme_mod( $key, $val );
		}
		
		if ( file_exists( $dir ) ) {
			return "<h3>Theme Options have been imported</h3>";
		}
		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );
		
	}
		static public function _import_images( $mods ) 
			{
				foreach ( $mods as $key => $val ) {
					
					if ( self::_is_image_url( $val ) ) {
						
						$data = self::_sideload_image( $val );
						
						if ( ! is_wp_error( $data ) ) {
							
							$mods[ $key ] = $data->url;
							
							// Handle header image controls.
							if ( isset( $mods[ $key . '_data' ] ) ) {
								$mods[ $key . '_data' ] = $data;
								update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
							}
						}
					}
				}
				
				return $mods;
			}
			
	static  public function _sideload_image( $file ) 
		{
			$data = new stdClass();
			
			if ( ! function_exists( 'media_handle_sideload' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
			}
			
			if ( ! empty( $file ) ) {
				
				// Set variables for storage, fix file filename for query strings.
				preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
				$file_array = array();
				$file_array['name'] = basename( $matches[0] );
		
				// Download file to temp location.
				$file_array['tmp_name'] = download_url( $file );
		
				// If error storing temporarily, return the error.
				if ( is_wp_error( $file_array['tmp_name'] ) ) {
					return $file_array['tmp_name'];
				}
		
				// Do the validation and storage stuff.
				$id = media_handle_sideload( $file_array, 0 );
		
				// If error storing permanently, unlink.
				if ( is_wp_error( $id ) ) {
					@unlink( $file_array['tmp_name'] );
					return $id;
				}
				
				// Build the object to return.
				$meta					= wp_get_attachment_metadata( $id );
				$data->attachment_id	= $id;
				$data->url				= wp_get_attachment_url( $id );
				$data->thumbnail_url	= wp_get_attachment_thumb_url( $id );
				$data->height			= $meta['height'];
				$data->width			= $meta['width'];
			}
		
			return $data;
		}
	static public function _is_image_url( $string = '' ) 
		{
			if ( is_string( $string ) ) {
				
				if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
					return true;
				}
			}
			
			return false;
		}	

	    /**
	     * add_widget_to_sidebar Import sidebars
	     * @param  string $sidebar_slug    Sidebar slug to add widget
	     * @param  string $widget_slug     Widget slug
	     * @param  string $count_mod       position in sidebar
	     * @param  array  $widget_settings widget settings
	     *
	     * @since 0.0.2
	     *
	     * @return null
	     */
	    public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()){

	        $sidebars_widgets = get_option('sidebars_widgets');

	        if(!isset($sidebars_widgets[$sidebar_slug]))
	           $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

	        $newWidget = get_option('widget_'.$widget_slug);

	        if(!is_array($newWidget))
	            $newWidget = array();

	        $count = count($newWidget)+1+$count_mod;
	        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

	        $newWidget[$count] = $widget_settings;

	        update_option('sidebars_widgets', $sidebars_widgets);
	        update_option('widget_'.$widget_slug, $newWidget);

	    }
		

	    public function set_demo_data( $file ) {
			

		    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

	        require_once ABSPATH . 'wp-admin/includes/import.php';

	        $importer_error = false;

	        if ( !class_exists( 'WP_Importer' ) ) {

	            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

	            if ( file_exists( $class_wp_importer ) ){

	                require_once($class_wp_importer);

	            } else {

	                $importer_error = true;

	            }

	        }

	        if ( !class_exists( 'WP_Import' ) ) {

	            $class_wp_import = dirname( __FILE__ ) .'/wordpress-importer.php';

	            if ( file_exists( $class_wp_import ) )
	                require_once($class_wp_import);
	            else
	                $importer_error = true;

	        }

	        if($importer_error){

	            die("Error on import");

	        } else {   

	            if(!is_file( $file )){

	                echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";

	            } else {

	               	$wp_import = new WP_Import();
	               	$wp_import->fetch_attachments = true;
	               	$wp_import->import( $file );
					$this->flag_as_imported['content'] = true;

	         	}

	    	}

	    	do_action( 'radium_importer_after_theme_content_import');


	    }

	    public function set_demo_menus() {
			
			// Menus to Import and assign - you can remove or add as many as you want
			$main_menu   = get_term_by('name', 'Main Navigation', 'nav_menu');
			
			if ( isset( $main_menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'secondline-themes-primary' => $main_menu->term_id,
					)
				);
			}
			
				

			$this->flag_as_imported['menus'] = true;	
			
		}

	    /**
	     * Available widgets
	     *
	     * Gather site's widgets into array with ID base, name, etc.
	     * Used by export and import functions.
	     *
	     * @since 0.0.2
	     *
	     * @global array $wp_registered_widget_updates
	     * @return array Widget information
	     */
	    function available_widgets() {

	    	global $wp_registered_widget_controls;

	    	$widget_controls = $wp_registered_widget_controls;

	    	$available_widgets = array();

	    	foreach ( $widget_controls as $widget ) {

	    		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

	    			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
	    			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

	    		}

	    	}

	    	return apply_filters( 'radium_theme_import_widget_available_widgets', $available_widgets );

	    }


	    /**
	     * Process import file
	     *
	     * This parses a file and triggers importation of its widgets.
	     *
	     * @since 0.0.2
	     *
	     * @param string $file Path to .wie file uploaded
	     * @global string $widget_import_results
	     */
	    function process_widget_import_file( $file ) {

	    	// File exists?
	    	if ( ! file_exists( $file ) ) {
	    		wp_die(
	    			esc_html__( 'Widget Import file could not be found. Please try again.', 'secondline-custom' ),
	    			'',
	    			array( 'back_link' => true )
	    		);
	    	}

	    	// Get file contents and decode
	    	$data = file_get_contents( $file );
	    	$data = json_decode( $data );

	    	// Import the widget data
	    	// Make results available for display on import/export page
	    	$this->widget_import_results = $this->import_widgets( $data );
			return true;

	    }


	    /**
	     * Import widget JSON data
	     *
	     * @since 0.0.2
	     * @global array $wp_registered_sidebars
	     * @param object $data JSON widget data from .json file
	     * @return array Results array
	     */
	    public function import_widgets( $data ) {

	    	global $wp_registered_sidebars;

	    	// Have valid data?
	    	// If no data or could not decode
	    	if ( empty( $data ) || ! is_object( $data ) ) {
	    		return;
	    	}

	    	// Hook before import
	    	$data = apply_filters( 'radium_theme_import_widget_data', $data );

	    	// Get all available widgets site supports
	    	$available_widgets = $this->available_widgets();

	    	// Get all existing widget instances
	    	$widget_instances = array();
	    	foreach ( $available_widgets as $widget_data ) {
	    		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	    	}

	    	// Begin results
	    	$results = array();

	    	// Loop import data's sidebars
	    	foreach ( $data as $sidebar_id => $widgets ) {

	    		// Skip inactive widgets
	    		// (should not be in export file)
	    		if ( 'wp_inactive_widgets' == $sidebar_id ) {
	    			continue;
	    		}

	    		// Check if sidebar is available on this site
	    		// Otherwise add widgets to inactive, and say so
	    		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
	    			$sidebar_available = true;
	    			$use_sidebar_id = $sidebar_id;
	    			$sidebar_message_type = 'success';
	    			$sidebar_message = '';
	    		} else {
	    			$sidebar_available = false;
	    			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
	    			$sidebar_message_type = 'error';
	    			$sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'secondline-custom' );
	    		}

	    		// Result for sidebar
	    		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
	    		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
	    		$results[$sidebar_id]['message'] = $sidebar_message;
	    		$results[$sidebar_id]['widgets'] = array();

	    		// Loop widgets
	    		foreach ( $widgets as $widget_instance_id => $widget ) {

	    			$fail = false;

	    			// Get id_base (remove -# from end) and instance ID number
	    			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
	    			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

	    			// Does site support this widget?
	    			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
	    				$fail = true;
	    				$widget_message_type = 'error';
	    				$widget_message = esc_html__( 'Site does not support widget', 'secondline-custom' ); // explain why widget not imported
	    			}

	    			// Filter to modify settings before import
	    			// Do before identical check because changes may make it identical to end result (such as URL replacements)
	    			$widget = apply_filters( 'radium_theme_import_widget_settings', $widget );

	    			// Does widget with identical settings already exist in same sidebar?
	    			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

	    				// Get existing widgets in this sidebar
	    				$sidebars_widgets = get_option( 'sidebars_widgets' );
	    				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

	    				// Loop widgets with ID base
	    				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
	    				foreach ( $single_widget_instances as $check_id => $check_widget ) {

	    					// Is widget in same sidebar and has identical settings?
	    					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

	    						$fail = true;
	    						$widget_message_type = 'warning';
	    						$widget_message = esc_html__( 'Widget already exists', 'secondline-custom' ); // explain why widget not imported

	    						break;

	    					}

	    				}

	    			}

	    			// No failure
	    			if ( ! $fail ) {

	    				// Add widget instance
	    				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
	    				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
	    				$single_widget_instances[] = (array) $widget; // add it

    					// Get the key it was given
    					end( $single_widget_instances );
    					$new_instance_id_number = key( $single_widget_instances );

    					// If key is 0, make it 1
    					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
    					if ( '0' === strval( $new_instance_id_number ) ) {
    						$new_instance_id_number = 1;
    						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
    						unset( $single_widget_instances[0] );
    					}

    					// Move _multiwidget to end of array for uniformity
    					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
    						$multiwidget = $single_widget_instances['_multiwidget'];
    						unset( $single_widget_instances['_multiwidget'] );
    						$single_widget_instances['_multiwidget'] = $multiwidget;
    					}

    					// Update option with new widget
    					update_option( 'widget_' . $id_base, $single_widget_instances );

	    				// Assign widget instance to sidebar
	    				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
	    				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
	    				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
	    				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

	    				// Success message
	    				if ( $sidebar_available ) {
	    					$widget_message_type = 'success';
	    					$widget_message = esc_html__( 'Imported', 'secondline-custom' );
	    				} else {
	    					$widget_message_type = 'warning';
	    					$widget_message = esc_html__( 'Imported to Inactive', 'secondline-custom' );
	    				}

	    			}

	    			// Result for widget instance
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : esc_html__( 'No Title', 'secondline-custom' ); // show "No Title" if widget instance is untitled
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

	    		}

	    	}

			$this->flag_as_imported['widgets'] = true;

	    	// Hook after import
	    	do_action( 'radium_theme_import_widget_after_import' );

	    	// Return results
	    	return
			 apply_filters( 'radium_theme_import_widget_results', $results );

	    }

	    /**
	     * Helper function to return option tree decoded strings
	     *
	     * @return    string
	     *
	     * @access    public
	     * @since     0.0.3
	     */
	    public function optiontree_decode( $value ) {

			$func = 'base64' . '_decode';
			return $func( $value );

	    }

	}//class

}//function_exists
?>