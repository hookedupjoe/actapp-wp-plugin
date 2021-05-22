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

	public static function actapp_init_blocks($theHook) {
		
			actapp_load_scripts($theHook);

			wp_enqueue_script(
				'actapp-core-blocks', 
				ACTAPP_WIDGETS_URL . '/blocks/core-blocks.js',
				array('wp-blocks','wp-editor','wp-element','wp-rich-text','wp-data','wp-server-side-render'),
				true
			);
	}

	public static function init() {
		add_filter( 'block_categories',  array('ActAppWidgetManager','actapp_block_category'), 10, 2);
		add_action('enqueue_block_editor_assets',  array('ActAppWidgetManager','actapp_init_blocks'),10,2);
		self::gutenberg_examples_dynamic();
	}

	
	public static function gutenberg_examples_dynamic_render_callback( $block_attributes, $content ) {
		$tmpCount = sizeof($block_attributes);
		if( $tmpCount == 0){
			return 'no attributes';
			}
			if( $block_attributes['debug'] ){
			return 'debug ' . $block_attributes['debug'];
		}

		if( $block_attributes['message'] ){
			return '<div class="ui card"><b>message</b>: ' . $block_attributes['message'] . "</div>";
		}
		return 'unknown params';
	}


	function gutenberg_examples_dynamic() {
	 
		wp_register_script(
			'gutenberg-examples-dynamic',
			plugins_url( 'build/block.js', ACTAPP_WIDGETS_DIR ),
			array('wp-blocks', 'wp-element', 'wp-server-side-render', 'wp-i18n', 'wp-polyfill')
		);
	 
		register_block_type( 'gutenberg-examples/example-dynamic', array(
			'api_version' => 2,
			'attributes' => array(
				'message' => array(
					'type' => 'string'
				),
				'debug' => array(
					'type' => 'string'
				),
				),
			'editor_script' => 'gutenberg-examples-dynamic',
			'render_callback' => array('ActAppWidgetManager','gutenberg_examples_dynamic_render_callback'),
		) );
	 
	}
	

	
	public static function baseDir() {
		return ACTAPP_WIDGETS_DIR;
	}
	public static function baseURL() {
		return ACTAPP_WIDGETS_URL;
	}
	
	
}


add_action( 'init', array( 'ActAppWidgetManager', 'init' ) );

