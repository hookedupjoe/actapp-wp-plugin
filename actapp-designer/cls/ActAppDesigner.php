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
		// //--- Load standardly created widgets;
		// $tmpWidgetList = array();
		// //ToAdd _. , 'buttons'
		// foreach ($tmpWidgetList as $aName) {
		// 	self::loadStandardBlock($aName);
		// }

			
	}

	public static function init() {
		self::setup_data();

		add_filter('block_categories',  array('ActAppDesigner','actapp_block_category'), 10, 2);

		
		add_action('wp_enqueue_scripts',  array('ActAppDesigner','actapp_init_blocks_content'),20,2);


		add_action('admin_enqueue_scripts',  array('ActAppDesigner','actapp_init_blocks_content'),20,2);
		add_action('admin_enqueue_scripts',  array('ActAppDesigner','actapp_init_admin_scripts'),20);

		add_action('enqueue_block_editor_assets',  array('ActAppDesigner','actapp_init_blocks_content'),10,2);
		add_action('enqueue_block_editor_assets',  array('ActAppDesigner','actapp_init_blocks'),10,2);

	}

	
	public static function setup_data() {
	
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
		add_menu_page( 
			__( 'UI Designer'),
			'UI Designer',
			'manage_options',
			'actappdesigner',
			array( 'ActAppDesigner', 'showDesigner' ),
			plugins_url( 'actapp-designer/images/icon.png' ),
			81
		); 
	}



}

//--- Demo of a widget that uses server side rendering
//require_once ACTAPP_DESIGNER_WIDGETS_DIR . '/blocks/ActAppDynamicCard/Object.php';

add_action( 'init', array( 'ActAppDesigner', 'init' ) );

add_action( 'admin_menu', array( 'ActAppDesigner', 'registerMenus' ) );
 

