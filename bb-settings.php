<?php
namespace BZ_BB;
use WP_THEME;

define('BZBB_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZBB_PRODUCT_ID',   'BZBB');
define('BZBB_VERSION',   	'1.0');
define('BZBB_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZ_BB_NS','BZ_BB');
define('BZBB_PLUGIN_FILE', 'rebrand-buddyboss/rebrand-buddyboss.php');   //Main base file

class BZRebrandBuddyBossSettings {
		
		public $pageslug 	   = 'bb-rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'theme_name'       	=> '',
				'theme_desc'       	=> '',
				'theme_author'     	=> '',
				'theme_uri'        	=> '',
				

			);
        
			
			
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			} 
if ( is_plugin_active( 'blitz-rebrand-buddyboss-pro/blitz-rebrand-buddyboss-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
		
			$this->bzbb_activation_hooks();	
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzbb_activation_hooks() {
					
			global $blog_id;
	
			add_filter( 'gettext', 					array($this, 'bzbb_update_label'), 20, 3 );
			add_filter( 'all_themes', 				array($this, 'bzbb_theme_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzbb_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzbb_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzbb_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzbb_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzbb_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzbb_hide_rebrand_from_menu'), 20, 2);
			}
		}
		
	
	
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzbb_hide_rebrand_from_menu($lmscurrent, $screen) {

			$rebranding = $this->bzbb_get_rebranding();

			$lmscurrent .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['theme_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';

			if($this->bzbb_getOption( 'rebrand_lms_screen_option','' )){
				
				$cartflows_screen_option = $this->bzbb_getOption( 'rebrand_lms_screen_option',''); 
				
				if($cartflows_screen_option=='show'){
					//$current .='It is showing now. ';
					$lmscurrent .= __('Hide the "','bzbb').$rebranding['theme_name'].__(' - Rebrand" menu item?','bzbb') .$hide;
					$lmscurrent .= '<style>#adminmenu .toplevel_page_buddyboss a[href="admin.php?page=bb-rebrand"]{display:block;}</style>';
				} else {
					//$current .='It is disabling now. ';
					$lmscurrent .= __('Show the "','bzbb').$rebranding['theme_name'].__(' - Rebrand" menu item?','bzbb') .$show;
					$lmscurrent .= '<style>#adminmenu .toplevel_page_buddyboss a[href="admin.php?page=bb-rebrand"]{display:none;}</style>';
				}		
				
			} else {
					//$current .='It is showing now. ';
					$lmscurrent .= __('Hide the "','bzbb').$rebranding['theme_name'].__(' - Rebrand" menu item?','bzbb') .$hide;
					$lmscurrent .= '<style>#adminmenu .toplevel_page_buddyboss a[href="admin.php?page=bb-rebrand"]{display:block;}</style>';
			}	

			$lmscurrent .=' <br/><br/> </fieldset>' ;
			
			return $lmscurrent;
		}
		
		
		
				
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzbb_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzbb_css', plugins_url('assets/css/bzbb-main.css', __FILE__) );
					wp_enqueue_style( 'bzbb_css' );
					
					wp_register_script( 'bzbb_js', plugins_url('assets/js/bzbb-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzbb_js' );

					
				}
			}
		}	
		
		
		
		
	   public function bzbb_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'buddyboss_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'buddyboss_rebrand');	
				}
			}

			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.1
		 * @return void
		 */
		public function bzbb_render_fields() {
			
			$branding = get_option( 'buddyboss_rebrand');
			include BZBB_BASE_DIR . 'admin/bzbb-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		
		
		public function bzbb_menu() {  
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzbb');
			$rebranding = $this->bzbb_get_rebranding();
			//if (empty ($rebranding) ) { return; } 
						
			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzbb_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'buddyboss-platform', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'buddyboss-platform', $title, $title, $cap, $slug, $func );
				}
			}	
			
			//~ echo '<pre/>';
			//~ print_r($menu);
			//~ die;
				
			foreach($menu as $custommenusK => $custommenusv ) {
				if( $custommenusK == '3' ) {
					if(!empty($rebranding)){
						$menu[$custommenusK][0] = $rebranding['theme_name']; //change menu Label		
					}
				}
			}
			return $menu;
		}
		
			
		
		/**
		 * Renders to fields
		*/
		public function bzbb_render() {
			$this->bzbb_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzbb_save_settings() {
			
			if ( ! isset( $_POST['buddyboss_wl_nonce'] ) || ! wp_verify_nonce( $_POST['buddyboss_wl_nonce'], 'buddyboss_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['buddyboss_submit'] ) ) {
				return;
			}
			$this->bzbb_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzbb_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzbb_get_rebranding();
			
			echo '<style id="buddyboss-wl-admin-style">';
			include BZBB_BASE_DIR . 'admin/bzbb-style.css.php';
			echo '</style>';
			
			echo '<script id="buddyboss-wl-admin-script">';
			include BZBB_BASE_DIR . 'admin/bzbb-script.js.php';
			echo '</script>';
			
		}	  
	
	

		/**
		 * Update branding
		*/
	    public function bzbb_update_branding() {
			
			if ( ! isset($_POST['buddyboss_wl_nonce']) ) {
				return;
			}
			
			//print_r($_POST);

			$data = array(
				'theme_name'       => isset( $_POST['buddyboss_wl_theme_name'] ) ? sanitize_text_field( $_POST['buddyboss_wl_theme_name'] ) : '',
				'theme_desc'       => isset( $_POST['buddyboss_wl_theme_desc'] ) ? sanitize_text_field( $_POST['buddyboss_wl_theme_desc'] ) : '',
				'theme_author'     => isset( $_POST['buddyboss_wl_theme_author'] ) ? sanitize_text_field( $_POST['buddyboss_wl_theme_author'] ) : '',
				'theme_uri'        => isset( $_POST['buddyboss_wl_theme_uri'] ) ? sanitize_text_field( $_POST['buddyboss_wl_theme_uri'] ) : '',
			);
			
			//print_r($data);	

			
			$all_themes = wp_get_themes();
			$destination = '';
			foreach($all_themes as $key => $_all_themes){
				if(($key == 'buddyboss-theme-child') || ($key == 'buddyboss-theme')){
					$screenshot = get_theme_root().'/'.$key.'/screenshot.png';
					if (file_exists($screenshot)) {
						unlink($screenshot);
					}
					if(!empty($_FILES)){
						if(isset($_FILES["buddyboss_wl_theme_preview_image"]["tmp_name"])){ //print_r($_FILES);
							$move = move_uploaded_file($_FILES["buddyboss_wl_theme_preview_image"]["tmp_name"],get_theme_root()."/".$key."/screenshot.png");
						}
					}
					// directory 
					if($destination != ''){
						copy($destination,$screenshot);
					}
					$destination = $screenshot;
				}
			}
			

			update_option( 'buddyboss_rebrand', $data );
		}
    
    
		
		/**
		 * change plugin meta
		*/  
        public function bzbb_plugin_branding( $all_plugins ) {
			
			//~ echo '<pre/>';
			//~ print_r($all_plugins);
			
		}
    
    
		
		/**
		 * change plugin meta
		*/  
        public function bzbb_theme_branding( $all_themes ) {
			
			if( class_exists('WP_THEME') ) {

				$my_theme = wp_get_theme( 'buddyboss-theme-child' );
				

				foreach($all_themes as $key => $_all_themes){
					if(($key == 'buddyboss-theme-child') || ($key == 'buddyboss-theme')){  //echo $my_theme->get('Description');
  						
						
						$cssfile = get_theme_root().'/'.$key.'/style.css';
						$rebranding = $this->bzbb_get_rebranding();
						
						$handle = fopen($cssfile, "r");
						
						$content1 = '';
						if ($handle) {
							while (($line = fgets($handle)) !== false) {
									$content1 .= $line;
							}
							fclose($handle);
						} else {
							// error opening the file.
						}
						
						if(get_option( $key.'_content' ) == ''){
							update_option( $key.'_content', $content1 );
						}						
						
						$handle = fopen($cssfile, "r");
						$content = '';
						if ($handle) {
							while (($line = fgets($handle)) !== false) {
								
								if(strpos($line,"heme Name:") > 0){
									$content .= 'Theme Name: '.$rebranding['theme_name'].''.PHP_EOL; 
								}elseif(strpos($line,"heme URI:") > 0){
									$content .= 'Theme URI: '.$rebranding['theme_uri'].''.PHP_EOL; 
								}elseif(strpos($line,"escription:") > 0){
									$content .= 'Description: '.$rebranding['theme_desc'].''.PHP_EOL; 
								}elseif(strpos($line,"uthor:") > 0){
									$content .= 'Author: '.$rebranding['theme_author'].''.PHP_EOL; 
								}else{
									$content .= $line;
								}
							}
							fclose($handle);
						} else {
							// error opening the file.
						}
						
						//echo $content;
						
						$file_handle = fopen($cssfile, 'w'); 
						fwrite($file_handle, $content);
						fclose($file_handle);

					}
				}
			
			}
			
			return $all_themes;
			
		}
	
    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzbb_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzbb_get_rebranding();
			
			$bzbb_new_text = $translated_text;
			$bzbb_name = isset( $rebranding['theme_name'] ) && ! empty( $rebranding['theme_name'] ) ? $rebranding['theme_name'] : '';
			$buddypanel_title = isset( $rebranding['buddypanel_title'] ) && ! empty( $rebranding['buddypanel_title'] ) ? $rebranding['buddypanel_title'] : '';
			
			if ( ! empty( $bzbb_name ) ) {
				$bzbb_new_text = str_replace( 'BuddyBoss', $bzbb_name, $bzbb_new_text );
			}
			
			if ( ! empty( $buddypanel_title ) ) {
				$bzbb_new_text = str_replace( 'BuddyPanel', $buddypanel_title, $bzbb_new_text );
			}
			
			return $bzbb_new_text;
		}
	

		
		/**
		 * update options
		*/
		public function bzbb_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		/**
		 * get options
		*/
		
		public function bzbb_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}
		
	
} //end Class
