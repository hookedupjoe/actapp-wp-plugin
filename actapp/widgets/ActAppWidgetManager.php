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
 * @package actapp
 * @since actapp 1.0.22
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
			ACTAPP_WIDGETS_URL . '/blocks/' . $tmpFN . '.js',
			$tmpDepDefaults,
			true
		);
		wp_enqueue_style ( 'aa-core-blocks_css' );
	}

	public static function actapp_init_blocks_content($theHook) {
		$tmpConfig = array(
			'baseURL'=>self::baseURL(),
			'catalogURL'=>self::baseURL() . '/catalog'
		);

		$tmpJson = json_encode($tmpConfig);
		$tmpScript = 'window.ActionAppCore.BlockManagerConfig = ' . $tmpJson;
		actapp_setup_scripts($theHook);
		wp_add_inline_script( 'app-only-preinit', $tmpScript );
		
		
		//wp_register_style( 'aa-core-blocks-content_css',   ACTAPP_WIDGETS_URL . '/css/wp-blocks-content.css', false,  $my_css_ver );
		//--- Load the action app core components and ActionAppCore.common.blocks add on
		wp_enqueue_script(
			'actapp-core-blocks-content', 
			ACTAPP_WIDGETS_URL . '/blocks/core-blocks-content.js',
			array(),
			true
		);
	}

	public static function actapp_init_blocks($theHook) {
		
	
		wp_register_style( 'aa-core-blocks_css',   ACTAPP_WIDGETS_URL . '/css/wp-blocks.css', false,  $my_css_ver );
		//--- Load the action app core components and ActionAppCore.common.blocks add on
		wp_enqueue_script(
			'actapp-core-blocks', 
			ACTAPP_WIDGETS_URL . '/blocks/core-blocks.js',
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
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks'),10,2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks_content'),10,2);
	}


	
	public static function baseDir() {
		return ACTAPP_WIDGETS_DIR;
	}
	public static function baseURL() {
		return ACTAPP_WIDGETS_URL;
	}
	
}

//require_once ACTAPP_WIDGETS_DIR . '/blocks/ActAppDynamicCard/Object.php';

add_action( 'init', array( 'ActAppWidgetManager', 'init' ) );

