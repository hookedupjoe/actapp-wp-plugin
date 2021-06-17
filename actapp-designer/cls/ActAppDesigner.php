<?php
/**
 * Server Side Designer Functionality: ActAppDesigner
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


class ActAppDesigner {
	private static $instance;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppDesigner();
		}
		return self::$instance;
	}

	public static function getDataVersion(){
		return 1.06;
	}

	public static function actapp_block_category( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug' => 'actappdesign',
					'title' => __( 'Designer Widgets'),
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
			ACTAPP_DESIGNER_URL . '/blocks/' . $tmpFN . '.js',
			$tmpDepDefaults,
			true
		);
		wp_enqueue_style ( 'act-app-designer_css' );
	}

	public static function activation_hook() {
		self::init();
		flush_rewrite_rules(); 
		self::plugin_initialize();
	}

	public static function override_tpl($template){
		$post_types = array( 'actappdesign' );
		$post = get_post();
		$pagename = $post->post_name;
		$current_user = wp_get_current_user();
		
		if ( is_singular( $post_types ) && $pagename != '' && file_exists( ACTAPP_DESIGNER_DIR . '/tpl/designer-'.$pagename.'.php' ) ){
			$template = ACTAPP_DESIGNER_DIR . '/tpl/designer-'.$pagename.'.php';
			return $template;
		}

		if ( is_singular( $post_types ) && file_exists( ACTAPP_DESIGNER_DIR . '/tpl/designer.php' ) ){
			$template = ACTAPP_DESIGNER_DIR . '/tpl/designer.php';
			return $template;
		}

		return $template;
	}
	

	public static function getRootPost(){
		$tmpMainID = self::getRootPostID();
		if( $tmpMainID ){
			$tmpMainPost = get_post($tmpMainID);
			if( $tmpMainPost ){
				return $tmpMainPost;
			}
		}
		return false;
	}
	public static function getRootPostID(){
		$post_type = 'actappdesign';
		$slug = 'welcome';
		$tmpMainID = ActAppCommon::post_exists_by_slug($slug, $post_type, $title, $content);
		if( $tmpMainID ){
			return $tmpMainID;
		}
		return false;
	}
	
	public static function getSUID(){
		$tmpRet = false;
		$tmpMainID = self::getRootPostID();
		if( $tmpMainID ){
			$tmpRet = get_post_meta( $tmpMainID, 'suid', true);
		}
		return $tmpRet;
	}
	public static function getPluginSetupVersion(){
		$tmpVersion = 0;
		$tmpMainID = self::getRootPostID();
		if( $tmpMainID ){
			$tmpVersion = get_post_meta( $tmpMainID, 'version', true);
		}
		return $tmpVersion;
	}

	public static function assure_plugin_initialized() {
		$tmpVersion = self::getPluginSetupVersion();
		if( $tmpVersion != self::getDataVersion() ){
			flush_rewrite_rules();
			return self::plugin_initialize();
		}
		return false;
	}

	public static function setOnLoad() {
		$slug = 'welcome';
		$tmpMainID = ActAppCommon::post_exists_by_slug($slug, 'actappdesign');
		//--- Use new var for assuring other docs to return false if not created
		update_post_meta( $tmpMainID, 'access', 'yes' );

	}


	public static function getOnLoad() {
		$slug = 'welcome';
		$tmpMainID = ActAppCommon::post_exists_by_slug($slug, 'actappdesign');
		//--- Use new var for assuring other docs to return false if not created
		return get_post_meta( $tmpMainID, 'access', true );

	}

	public static function plugin_initialize() {
		$post_type = 'actappdesign';

		$slug = 'welcome';
        $title = 'Designer Home Page';
        $content = 'Internal Use';
		$tmpMainID = ActAppCommon::assure_doc($slug, $post_type, $title, $content);
		
		$tmpMainID = ActAppCommon::post_exists_by_slug($slug, $post_type);
		if( !($tmpMainID)){
			throw new ErrorException("Could not create main entry point for designer, contact support");
		}
		$tmpSourceID = get_post_meta( $tmpMainID, 'suid', true );

		if( $tmpSourceID == ''){
			$tmpStoreID = uniqid('' . random_int(100, 999) . '_');
			update_post_meta( $tmpMainID, 'suid', $tmpStoreID);
			$tmpSourceID = get_post_meta( $tmpMainID, 'suid', true );
			if( $tmpSourceID == ''){
				throw new ErrorException("Could not save created store ID, contact support");
			}
		}
		$tmpVersion = get_post_meta( $tmpMainID, 'version', true ); 
		if( $tmpVersion != self::getDataVersion() ){
			//--- Use new var for assuring other docs to return false if not created
			update_post_meta( $tmpMainID, 'version', self::getDataVersion() );
		}

		$slug = 'dashboard';
        $title = 'Designer Dashboard';
        $content = 'Internal Use';
		$tmpNewDoc = ActAppCommon::assure_doc($slug, $post_type, $title, $content);

		$slug = 'resources';
        $title = 'Designer Resources';
        $content = 'Internal Use';
		$tmpNewDoc = ActAppCommon::assure_doc($slug, $post_type, $title, $content);

		return $tmpMainID;
	}

	

	public static function actapp_init_blocks_content($theHook) {
		$tmpConfig = array(
			'baseURL'=>self::baseURL(),
			'catalogURL'=>self::baseURL() . '/catalog'
		);
		$tmpJson = json_encode($tmpConfig);
		$tmpScript = 'window.ActionAppCore.DesignerConfig = ' . $tmpJson;
		ActAppCommon::setup_scripts($theHook);
		wp_add_inline_script( 'app-only-preinit', $tmpScript );

		//--- Load the action app core components and ActionAppCore.common.blocks add on
		wp_enqueue_script(
			'actapp-designer', 
			ACTAPP_DESIGNER_URL . '/js/DesignerDashboard.js',
			array(),
			true
		);
	}

	public static function actapp_init_admin_scripts(){
		// wp_register_style( 'aa-core-admin_css',   ACTAPP_DESIGNER_URL . '/css/wp-admin.css', false,  $my_css_ver );
		// wp_enqueue_style ( 'aa-core-admin_css' );
	}
	
	public static function actapp_init_blocks($theHook) {
		
	
		wp_register_style( 'act-app-designer_css',   ACTAPP_DESIGNER_URL . '/css/designer.css', false,  $my_css_ver );
		//--- Load the action app core components and ActionAppCore.common.blocks add on
		wp_enqueue_script(
			'actapp-core-blocks', 
			ACTAPP_DESIGNER_URL . '/js/DesignerDashboard.js',
			array('wp-blocks','wp-editor','wp-element'),
			true
		);
		if ( get_post_type( get_the_ID() ) == 'actappdesign' ) {
			//--- Load standardly created widgets;
			$tmpWidgetList = array('any');
			foreach ($tmpWidgetList as $aName) {
				self::loadStandardBlock($aName);
			}
			
		}

			
	}

	public static function init() {
		self::assure_plugin_initialized();
		self::setup_data();

		add_filter('block_categories',  array('ActAppDesigner','actapp_block_category'), 10, 2);

		add_action('wp_enqueue_scripts',  array('ActAppDesigner','actapp_init_blocks_content'),20,2);

		add_action('admin_enqueue_scripts',  array('ActAppDesigner','actapp_init_blocks_content'),20,2);
		add_action('admin_enqueue_scripts',  array('ActAppDesigner','actapp_init_admin_scripts'),20);

		add_action('enqueue_block_editor_assets',  array('ActAppDesigner','actapp_init_blocks_content'),11,2);
		add_action('enqueue_block_editor_assets',  array('ActAppDesigner','actapp_init_blocks'),11,2);

	}

	
	public static function setup_data() {
		self::custom_post_designer_access();
		self::custom_post_actapp_doc();
		self::custom_post_design_element();
	}

	

	private function custom_post_actapp_doc() {

		$labels = array(
		'name'               => __( 'ActApp Docs' ),
		'singular_name'      => __( 'ActApp Doc' ),
		'add_new'            => __( 'Add New ActApp Doc' ),
		'add_new_item'       => __( 'Add New ActApp Doc' ),
		'edit_item'          => __( 'Edit ActApp Doc' ),
		'new_item'           => __( 'New ActApp Doc' ),
		'all_items'          => __( 'All ActApp Docs' ),
		'view_item'          => __( 'View ActApp Doc' ),
		'search_items'       => __( 'Search ActApp Doc' )
		);

		$args = array(
		'labels'            => $labels,
		'description'       => 'Holds general data managed by the ActApp model',
		'public'            => true,
		'menu_position'     => 21,
		'show_in_rest' => true,
		'supports'          => array( 'title', 'editor', 'custom-fields' ),
		'has_archive'       => false,
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		);

		register_post_type( 'actappdoc', $args);

	}

	private function custom_post_design_element() {

		$labels = array(
		'name'               => __( 'Design Elements' ),
		'singular_name'      => __( 'Design Element' ),
		'add_new'            => __( 'Add New Design Element' ),
		'add_new_item'       => __( 'Add New Design Element' ),
		'edit_item'          => __( 'Edit Design Element' ),
		'new_item'           => __( 'New Design Element' ),
		'all_items'          => __( 'All Design Elements' ),
		'view_item'          => __( 'View Design Element' ),
		'search_items'       => __( 'Search Design Element' )
		);

		$args = array(
		'labels'            => $labels,
		'description'       => 'Holds general data managed by the ActApp model',
		'public'            => true,
		'menu_position'     => 22,
		'show_in_rest' => true,
		'supports'          => array( 'title', 'editor', 'custom-fields' ),
		'has_archive'       => false,
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		);

		register_post_type( 'actappelem', $args);

	}

	private function custom_post_designer_access() {

		$labels = array(
		'name'               => __( 'Designer Access Points' ),
		'singular_name'      => __( 'Designer Access Point' ),
		'add_new'            => __( 'Add New Designer Access Point' ),
		'add_new_item'       => __( 'Add New Designer Access Point' ),
		'edit_item'          => __( 'Edit Designer Access Point' ),
		'new_item'           => __( 'New Designer Access Point' ),
		'all_items'          => __( 'All Designer Access Points' ),
		'view_item'          => __( 'View Designer Access Point' ),
		'search_items'       => __( 'Search Designer Access Point' )
		);

		$args = array(
		'labels'            => $labels,
		'description'       => 'Used to provide access entrypoints into the designer',
		'public'            => true,
		'menu_position'     => 23,
		'show_in_rest' => true,
		'supports'          => array( 'title', 'editor', 'custom-fields' ),
		'has_archive'       => false,
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'query_var'         => true,
		);

		register_post_type( 'actappdesign', $args);

	}

	
	public static function baseDir() {
		return ACTAPP_DESIGNER_DIR;
	}
	public static function baseURL() {
		return ACTAPP_DESIGNER_URL;
	}
	

	//---- Admin Settings
	public static function showDesigner(){
		esc_html_e( 'showDesigner', 'textdomain' );
	}
	public static function registerMenus(){
		//remove_menu_page( 'edit.php?post_type=actappdesign' );
		//remove_menu_page( 'edit.php?post_type=actappdoc' );
		
		//--- Demo of how to add a page on the left panel.  		
		// add_menu_page( 
		// 	__( 'UI Designer'),
		// 	'UI Designer',
		// 	'manage_options',
		// 	'actappdesigner',
		// 	array( 'ActAppDesigner', 'showDesigner' ),
		// 	plugins_url( 'actapp-designer/images/icon.png' ),
		// 	81
		// ); 
	}



}

//--- Demo of a widget that uses server side rendering
//require_once ACTAPP_DESIGNER_WIDGETS_DIR . '/blocks/ActAppDynamicCard/Object.php';

//--- Create stub documents when plugin initialized
register_activation_hook( __FILE__, array( 'ActAppDesigner', 'activation_hook' ) );

add_action( 'init', array( 'ActAppDesigner', 'init' ) );

add_action( 'admin_menu', array( 'ActAppDesigner', 'registerMenus' ) );
 
add_filter(
	'template_include',
	array( 'ActAppDesigner', 'override_tpl')
);

