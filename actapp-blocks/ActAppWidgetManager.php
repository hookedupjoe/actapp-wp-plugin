<?php
/**
 * Server Side Widget Manager: ActAppWidgetManager
 * 
 * Copyright (c) 2021 Joseph Francis / hookedup, inc. 
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Joseph Francis
 * @package actappblocks
 * @since actappblocks 1.0.1
 */


class ActAppWidgetManager {
	private static $instance;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppWidgetManager();
		}
		return self::$instance;
	}


	public static function actapp_block_category( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug' => 'actappui',
					'title' => __( 'UI Widgets'),
				),
			),
			$categories,
		);
	}

	
	public static function loadStandardBlock($theName, $theFileName = '', $theDependencies = null){
		$tmpDepDefaults = array('wp-blocks','wp-editor','wp-element');
		//$tmpDeps = array_combine($tmpDepDefaults, $theDependencies);
		$tmpFN = $theFileName;
		if( $tmpFN == ''){
			$tmpFN = $theName;
		}
		wp_enqueue_script(
			$theName, 
			ACTAPP_BLOCKS_DESIGN_URL . '/blocks/' . $tmpFN . '.js',
			$tmpDepDefaults,
			true
		);
		wp_enqueue_style ( 'aa-core-blocks_css' );
	}

	public static function actapp_init_blocks_content($theHook) {
		$tmpConfig = array(
			'baseURL'=> ACTAPP_BLOCKS_URL,
			'catalogURL'=> ACTAPP_BLOCKS_URL . '/catalog'
		);


		$tmpJson = json_encode($tmpConfig);
		$tmpScript = 'window.ActionAppCore.BlockManagerConfig = ' . $tmpJson;
		ActAppCommon::setup_scripts($theHook);
		wp_add_inline_script( 'app-only-preinit', $tmpScript );

		//--- Load the action app core components and ActionAppCore.common.blocks add on
		wp_enqueue_script(
			'actapp-blocks-controller', 
			ACTAPP_BLOCKS_DESIGN_URL . '/BlocksController.js',
			array(),
			true
		);
	}

	public static function actapp_init_admin_scripts(){
		wp_register_style( 'aa-core-admin_css',   ACTAPP_BLOCKS_URL . '/css/wp-admin.css', false,  $my_css_ver );
		wp_enqueue_style ( 'aa-core-admin_css' );
	}
	
	public static function actapp_init_blocks($theHook) {
		
	
		wp_register_style( 'aa-core-blocks_css',   ACTAPP_BLOCKS_URL . '/css/wp-blocks.css', false,  $my_css_ver );
		//--- Load the action app core components and ActionAppCore.common.blocks add on
		wp_enqueue_script(
			'actapp-blocks-editor', 
			ACTAPP_BLOCKS_DESIGN_URL . '/BlockEditor.js',
			array('wp-blocks','wp-editor','wp-element'),
			true
		);
		//--- Load standardly created widgets;
		$tmpWidgetList = array('segment','header','card', 'cards', 'message', 'button');
		//ToAdd _. , 'buttons'
		foreach ($tmpWidgetList as $aName) {
			self::loadStandardBlock($aName);
		}

			
	}

	public static function init() {
		add_filter('block_categories',  array('ActAppWidgetManager','actapp_block_category'), 10, 2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks_content'),10,2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks'),10,2);
		self::setup_data();
	}

	// //Custom acf endpoint;
	// public static function dev_endpoint( $request_data ) {
	// 	return array('version'=>'V1.1.1');
	// }

	
	public static function setup_data() {
		
// // register the endpoint;
// add_action( 'rest_api_init', function () {
// 	register_rest_route( 'aawm/v1', 'blocksdev/', array(
// 		'methods' => 'GET',
// 		'callback' => array('ActAppWidgetManager', 'dev_endpoint'),
// 		)
// 	);
// });
	}

	
	public static function baseDir() {
		return ACTAPP_BLOCKS_DESIGN_DIR;
	}
	public static function baseURL() {
		return ACTAPP_BLOCKS_DESIGN_URL;
	}
	

	//---- Admin Settings
	public static function showAdminPageWidgetsSettings(){
		//include ACTAPP_BLOCKS_DESIGN_DIR . '/tpl/widgets-settings.php';
		//get_template_part( 'tpl/widgets-settings' );
		//echo 'hi';
		include(ACTAPP_BLOCKS_DIR . '/tpl/widgets-settings.php');
		
	}

	public static function getTest(){
		return 'testing 123';
	}
	public static function registerAdminPageWidgetsSettings(){
		add_menu_page( 
			__( 'UI Widget Settings'),
			'UI Widgets',
			'manage_options',
			'actappwidgetsettings',
			array( 'ActAppWidgetManager', 'showAdminPageWidgetsSettings' ),
			plugins_url( 'actapp-blocks/images/icon.png' ),
			81
		); 
	}



}

//--- Demo of a widget that uses server side rendering
//require_once ACTAPP_BLOCKS_DESIGN_DIR . '/blocks/ActAppDynamicCard/Object.php';

add_action( 'init', array( 'ActAppWidgetManager', 'init' ) );












//--- Demo of json endpoint
class Latest_Posts_Controller extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'actappwm';
	  $path = 'projects';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_items' ),
		'permission_callback' => array( $this, 'get_items_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     
	}

	public function get_items_permissions_check($request) {
		return true;
	}

	public function get_items($request) {
		$args = array(
			'posttype' => $request['posttype'] || 'projects'
		);
		$posts = get_posts($args);
		if (empty($posts)) {
			return new WP_Error( 'empty_category', 'there is no post of this type', array( 'status' => 404 ) );
		}
		return new WP_REST_Response($posts, 200);
	}


  }
  add_action('rest_api_init', function () {           
	$tmpController = new Latest_Posts_Controller();
	$tmpController->register_routes();
  });



add_action( 'admin_menu', array( 'ActAppWidgetManager', 'registerAdminPageWidgetsSettings' ) );
 

