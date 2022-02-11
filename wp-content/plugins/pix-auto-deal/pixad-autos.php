<?php
/*
Plugin Name: PixAutoDeal
Description: Auto Deal Options for Autozone Theme
Version: 2.1
Author: Templines
Author URI: templines.com
Text Domain:pixad

*/

require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/theme/autozone/pix-auto-deal.json',
    __FILE__,
    'pixad-autos'
);  

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Pix_Autos' ) ) {
	class Pix_Autos {
		
		/**
		 * Refers to a single instance of this class.
		 * 
		 * @rewritten
		 * @since 1.0
		 */
		private static $instance = null;
		
		/**
		 * Plugin Version
		 *
		 * @rewritten
		 * @since 1.0
		 */
		static private $version = '1.0.2';
		
		/**
		 * Class Constructor
		 *
		 * @rewritten
		 * @since 1.0
		 */
		function __construct() {
			
			add_action( 'plugins_loaded', array( $this, 'localization' ) );
			$this->init();
			
		}
		
		/**
		 * Creates or returns an instance of this class.
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public static function get_instance() {
			
			if( null == self::$instance ) {
				self::$instance = new self;
			}
			
			return self::$instance;
		}
		
		/**
		 * Plugin Localization
		 *
		 * @rewritten
		 * @since 1.0
		 */
		function localization() {
			$path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			load_plugin_textdomain( 'pixad', false, $path );
		}
		
		/**
		 * Plugin Initialization
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public function init() {
			
			$this->defines();
			$this->includes();
			
		}
		
		/**
		 * Plugin Defines
		 *
		 * @rewritten
		 * @since 1.0
		 */
		private function defines() {
			if( ! defined( 'TEXTDOMAIN' ) )
				   define( 'TEXTDOMAIN', 'pixad' );
			 
			if( ! defined( 'PIXAD_AUTO_URI' ) )
				   define( 'PIXAD_AUTO_URI', plugin_dir_url( __FILE__ ) );
			
			if( ! defined( 'PIXAD_AUTO_DIR' ) ) 
				   define( 'PIXAD_AUTO_DIR', plugin_dir_path( __FILE__ ) );
			  
			if( ! defined( 'PIXAD_TEMPLATES_DIR' ) ) 
				   define( 'PIXAD_TEMPLATES_DIR', PIXAD_AUTO_DIR . 'templates/' );

		}
		
		/**
		 * Include Necessary Files
		 *
		 * @rewritten
		 * @since 1.0
		 */
		private function includes() {
			$files = array(
				PIXAD_AUTO_DIR . 'classes/class.pixad-custom.php',
				PIXAD_AUTO_DIR . 'includes/backend/post_taxonomy_type.php',
				PIXAD_AUTO_DIR . 'install.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-settings.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-country.php',
				PIXAD_AUTO_DIR . 'classes/class.pixad-autos.php',
				PIXAD_AUTO_DIR . 'includes/global/media_uploader.php',
				PIXAD_AUTO_DIR . 'includes/functions_global.php',
				PIXAD_AUTO_DIR . 'includes/functions_backend.php',
				PIXAD_AUTO_DIR . 'includes/widgets/widget_sidebar.php',
			);
			if( $files ) {
				foreach( $files as $file ) {
					require_once $file;
				}
			}
		}

		/**
		 * Load Shortcodes
		 *
		 * @rewritten
		 * @since 0.7
		 */
		private function shortcodes() {
			$files = glob( PIXAD_AUTO_DIR . 'shortcodes/*.php' );
			foreach( $files as $file ) {
				require_once $file;
			}
		}

		/**
		 * Get Plugin Version
		 *
		 * @rewritten
		 * @since 1.0
		 */
		public static function version() {
			return self::$version;
		}
	}
	Pix_Autos::get_instance();
}

register_activation_hook( __FILE__, 'pix_add_roles_on_plugin_activation' );
function pix_add_roles_on_plugin_activation() {
	add_role('autodealer', esc_attr('Autodealer', 'pixad'), array(
	 	'read'         => true,
		'edit_posts'   => true,
		'edit_post'   => true,
		'delete_posts' => true,
		'edit_published_posts' => true,
		'upload_files' => true,
	) );

	$role = get_role('autodealer');

     $role->add_cap('read');
     $role->add_cap('delete_posts');
     $role->add_cap('edit_posts');
     $role->add_cap('upload_files');
     $role->add_cap('edit_private_posts');
     $role->add_cap('edit_published_posts');
}
	
add_filter('upload_mimes', 'pix_autodealer_upload_mimes');
function pix_autodealer_upload_mimes($mime_types){
	if(!empty( wp_get_current_user()->caps['autodealer'])){
		foreach ($mime_types as $key => $value) {
			if(!(
				$key === 'gif' ||
				$key === 'jpg|jpeg|jpe' ||
				$key === 'png' 
				 )){
				unset($mime_types[$key]);
			}
		}
  		return $mime_types;
	}
	return $mime_types;
}

add_action( 'admin_menu', 'pix_autodealer_remove_menus', 999999 );
function pix_autodealer_remove_menus(){
	$user = wp_get_current_user();
	$user_roles = $user->roles;

	if ( in_array( 'autodealer', $user_roles, true ) && !current_user_can('publish_pages') ) {

		remove_all_actions( 'admin_notices' );
	   	remove_menu_page( 'index.php' );                  // Консоль
		remove_menu_page( 'edit.php' );                   // Записи
		remove_menu_page( 'upload.php' );                 // Медиафайлы
		remove_menu_page( 'edit.php?post_type=page' );    // Страницы
		remove_menu_page( 'edit-comments.php' );          // Комментарии
		remove_menu_page( 'themes.php' );                 // Внешний вид
		remove_menu_page( 'plugins.php' );                // Плагины
		remove_menu_page( 'users.php' );                  // Пользователи
		remove_menu_page( 'tools.php' );                  // Инструменты
		remove_menu_page( 'options-general.php' );        // Параметры
		remove_menu_page( 'edit.php?post_type=staticblocks' );
		remove_menu_page( 'edit.php?post_type=replica_section' );
		remove_menu_page( 'wpcf7' );
		remove_menu_page( 'profile.php' );
		remove_menu_page( 'vc-welcome' );
		remove_menu_page( 'yellow-pencil-changes' );
	}
}

add_filter( 'admin_body_class','pix_add_class_role' );
function pix_add_class_role( $classes ) {
    $user = wp_get_current_user();
    $user_role = $user->roles[0];
    return "$classes". ' user-role-'.$user_role;
}

add_filter( 'body_class','pix_add_class_role_front' );
function pix_add_class_role_front( $classes ) {

    $user = wp_get_current_user();
    if(!empty($user->roles[0])){
        $user_role = $user->roles[0];
        $classes[] = 'user-role-'.$user_role;
    } else {
        $classes[] = '';
    }


	return $classes;
}

add_action('admin_init', 'pix_autodealer_block_admin_pages_redirect3132123');
function pix_autodealer_block_admin_pages_redirect3132123() {
    global $pagenow;
    $user = wp_get_current_user();
	$user_roles = $user->roles;
    if( in_array( 'autodealer', $user_roles, true ) && !current_user_can('publish_pages')){
	    $pages_to_block = array(
	        'index.php',
	    );
	    if(in_array($pagenow, $pages_to_block)){
            wp_redirect( admin_url('/edit.php?post_type=pixad-autos&author='. $user->ID) );
	        exit;
	    }
	}
}

function pix_baseencode($data){
     return base64_decode($data);
}


add_theme_support( 'post-thumbnails', array( 'post', 'pixad-autos' ) );
