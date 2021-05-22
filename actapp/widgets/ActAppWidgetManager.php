<?php
/*
Common access point and launcher for ActApp related widgets / blocks
*/

/* package: actapp */


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
		//$tmpDeps = array_combine($tmpDepDefaults, $theDependencies || []);
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
	}

	public static function actapp_init_blocks($theHook) {
		
			//--- Load the action app library when blocks initializes
			actapp_load_scripts($theHook);

			//--- Load the action app core components and ActionAppCore.blocks add on
			wp_enqueue_script(
				'actapp-core-blocks', 
				ACTAPP_WIDGETS_URL . '/blocks/core-blocks.js',
				array('wp-blocks','wp-editor','wp-element','wp-rich-text','wp-data','wp-server-side-render'),
				true
			);
			//--- Load standardly created widgets;
			$tmpWidgetList = array('message','segment','cards');
			foreach ($tmpWidgetList as $aName) {
				self::loadStandardBlock($aName);
			}

			//self::loadStandardBlock('message');
			//self::loadStandardBlock('segment');
			
	}

	public static function init() {
		add_filter( 'block_categories',  array('ActAppWidgetManager','actapp_block_category'), 10, 2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks'),10,2);
	}


	
	public static function baseDir() {
		return ACTAPP_WIDGETS_DIR;
	}
	public static function baseURL() {
		return ACTAPP_WIDGETS_URL;
	}
	
}

require_once ACTAPP_WIDGETS_DIR . '/blocks/ActAppDynamicCard/Object.php';

add_action( 'init', array( 'ActAppWidgetManager', 'init' ) );

