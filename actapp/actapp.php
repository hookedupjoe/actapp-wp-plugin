<?php
/**
 * actapp.php
 *
 * Copyright (c) 2020 Joseph Francis / hookedup, inc. www.hookedup.com
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
 * @since actapp 1.0.0
 *
 * Plugin Name: Action App Core
 * Plugin URI: https://github.com/hookedupjoe/actapp-plugin
 * Description: Used to provide full Action App functionality with Semantic UI and jQuery * 
 * Author: Joseph Francis
 * Author URI: https://www.hookedup.com
 * Donate-Link: https://www.hookedup.com/
 * Text Domain: actapp
 * License: GPLv3
 * 
 * Version: 1.0.21
 */
define( 'ACTAPP_CORE_VERSION', '1.0.21' );
 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ACTAPP_FILE', __FILE__ );
if ( !defined( 'ACTAPP_CORE_DIR' ) ) {
	define( 'ACTAPP_CORE_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( !defined( 'ACTAPP_CORE_URL' ) ) {
	define( 'ACTAPP_CORE_URL', plugins_url( 'actapp' ) );
}

if ( !defined( 'ACTAPP_CORE_LIB_URL' ) ) {
	define( 'ACTAPP_CORE_LIB_URL', ACTAPP_CORE_URL . '/core' );
}

if ( !defined( 'ACTAPP_CORE_LIB' ) ) {
	define( 'ACTAPP_CORE_LIB', ACTAPP_CORE_DIR . '/core' );
}

if ( !defined( 'ACTAPP_SLEEKDB_LIB' ) ) {
	define( 'ACTAPP_SLEEKDB_LIB', ACTAPP_CORE_DIR . '/SleekDB' );
}

if ( !defined( 'ACTAPP_WIDGETS_DIR' ) ) {
	define( 'ACTAPP_WIDGETS_DIR', ACTAPP_CORE_DIR . '/widgets' );
}
if ( !defined( 'ACTAPP_WIDGETS_URL' ) ) {
	define( 'ACTAPP_WIDGETS_URL', ACTAPP_CORE_URL . '/widgets' );
}



require_once ACTAPP_CORE_LIB . '/constants.php';
require_once ACTAPP_CORE_LIB . '/wp-init.php';
require_once ACTAPP_SLEEKDB_LIB . '/SleekDB.php';

// //ToDo: Move this
// add_action( 'wp_enqueue_scripts', 'actapp_remove_jquery', 100 );
// function actapp_remove_jquery()
// {
//     // wp_dequeue_script( 'jquery-core-js' );
//     // wp_deregister_script( 'jquery-core-js' );

//     // wp_dequeue_script( 'jquery-core-js' );
//     // wp_deregister_script( 'jjquery-migrate-js' );
//     // Now the parent script is completely removed
// }

function actapp_block_category( $categories, $post ) {
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

function actapp_init_blocks($theHook) {
	
		actapp_load_scripts($theHook);

		  wp_enqueue_script(
			'my-new-block2', 
			ACTAPP_WIDGETS_URL . '/blocks/core-blocks.js',
			array('wp-blocks','wp-editor','wp-element','wp-rich-text','wp-data','wp-server-side-render'),
			true
		  );

}

add_filter( 'block_categories', 'actapp_block_category', 10, 2);
add_action('enqueue_block_editor_assets', 'actapp_init_blocks',10,2);









 
function gutenberg_examples_dynamic_render_callback( $block_attributes, $content ) {
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
    // automatically load dependencies and version
 
    wp_register_script(
        'gutenberg-examples-dynamic',
        plugins_url( 'build/block.js', __FILE__ ),
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
        'render_callback' => 'gutenberg_examples_dynamic_render_callback',
    ) );
 
}
add_action( 'init', 'gutenberg_examples_dynamic' );

