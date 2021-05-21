<?php
/*
Common access points for ActApp related widgets
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

	public static function init() {
		//self::do_something_on_startup();
		self::sidebar_plugin_register();

		
	}

	

	public static function sidebar_plugin_register() {
		wp_register_script(
			'plugin-sidebar-js',
			plugins_url( 'plugin-sidebar.js', __FILE__ ),
			array( 'wp-plugins', 'wp-edit-post', 'wp-element' )
		);
	}
	public static function sidebar_plugin_script_enqueue() {
		wp_enqueue_script( 'plugin-sidebar-js' );
	}
	
	public static function baseDir() {
		return ACTAPP_WIDGETS_DIR;
	}
	public static function baseURL() {
		return ACTAPP_WIDGETS_URL;
	}
	
}

add_action( 'enqueue_block_editor_assets', array('ActAppWidgetManager','sidebar_plugin_script_enqueue' );
add_action( 'init', array( 'ActAppWidgetManager', 'init' ) );

