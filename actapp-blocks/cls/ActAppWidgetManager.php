<?php
/**
 * Server Side Blocks / Widget Manager: ActAppWidgetManager
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
			ACTAPP_BLOCKS_URL . '/blocks/' . $tmpFN . '.js',
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
			ACTAPP_BLOCKS_URL . '/js/BlocksController.js',
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
			ACTAPP_BLOCKS_URL . '/js/BlockEditor.js',
			array('wp-blocks','wp-editor','wp-element'),
			true
		);
		//--- Load standardly created widgets;
		$tmpWidgetList = array('segment','header','card', 'cards', 'message', 'button', 'any', 'cardsection');
		//ToAdd _. , 'buttons'
		foreach ($tmpWidgetList as $aName) {
			self::loadStandardBlock($aName);
		}

			
	}

	public static function init() {
//		add_action( 'admin_menu', array( 'ActAppWidgetManager', 'registerAdminPageWidgetsSettings' ) );

		add_filter('block_categories',  array('ActAppWidgetManager','actapp_block_category'), 10, 2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks_content'),10,2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks'),10,2);
		
		add_action('wp_enqueue_scripts', array('ActAppCommon','setup_scripts'),20);
		add_action('wp_enqueue_scripts',  array('ActAppWidgetManager','actapp_init_blocks_content'),20,2);

		add_action('admin_enqueue_scripts', array('ActAppCommon','setup_scripts'),20);
		add_action('admin_enqueue_scripts',  array('ActAppWidgetManager','actapp_init_blocks_content'),20,2);
		add_action('admin_enqueue_scripts',  array('ActAppWidgetManager','actapp_init_admin_scripts'),20);


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
		return ACTAPP_BLOCKS_DIR;
	}
	public static function baseURL() {
		return ACTAPP_BLOCKS_URL;
	}
	

	//---- Admin Settings
	public static function showAdminPageWidgetsSettings(){
		//include ACTAPP_BLOCKS_DIR . '/tpl/widgets-settings.php';
		//get_template_part( 'tpl/widgets-settings' );
		//echo 'hi';
		include(ACTAPP_BLOCKS_DIR . '/tpl/widgets-settings.php');
		
	}

	
	public static function getWidgetUI(){
		return 'List UI Widget options here';
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
//require_once ACTAPP_BLOCKS_DIR . '/blocks/ActAppDynamicCard/Object.php';

add_action( 'init', array( 'ActAppWidgetManager', 'init' ) );




//--- Multiple json endpoints created / served by a single class
class ActAppWidgetManangerDataController extends WP_REST_Controller {
	private static $instance;
	public static function initInstance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppWidgetManangerDataController();
			self::$instance->registerRoutes();
		}
		return self::$instance;
	}

	public function registerRoutes() {
	  $namespace = 'actappwm';

	  $path = 'config';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_config' ),
		'permission_callback' => array( $this, 'get_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'more';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_more' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     
	}

	public function get_permissions_check($request) {
		return true;
	}
	public function get_edit_permissions_check($request) {
		return true;
	}

	public function get_config($request) {
		$tmpRet = array('testing'=>'initial');
		return new WP_REST_Response($tmpRet, 200);
	}
	public function get_more($request) {
		$args = array(
			'posttype' => 'projects'
		);
		$posts = get_posts($args);
		if (empty($posts)) {
			$posts = array();
		}
		return new WP_REST_Response($posts, 200);
	}


}

add_action('rest_api_init', array('ActAppWidgetManangerDataController', 'initInstance'));
  

