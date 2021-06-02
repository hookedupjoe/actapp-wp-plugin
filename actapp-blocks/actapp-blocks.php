<?php
/**
 * actapp-blocks.php
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
 *
 * Plugin Name: Action App Core Blocks
 * Plugin URI: https://github.com/hookedupjoe/actapp-plugin
 * Description: Used to blocks with Action App functionality with Semantic UI and jQuery * 
 * Author: Joseph Francis
 * Author URI: https://www.hookedup.com
 * Donate-Link: https://www.hookedup.com/
 * Text Domain: actapp
 * License: GPLv3
 * 
 * Version: 1.0.1
 */
define( 'ACTAPP_BLOCKS_VERSION', '1.0.1' );
 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ACTAPP_BLOCKS_FILE', __FILE__ );

if ( !defined( 'ACTAPP_BLOCKS_DIR' ) ) {
	define( 'ACTAPP_BLOCKS_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( !defined( 'ACTAPP_BLOCKS_URL' ) ) {
	define( 'ACTAPP_BLOCKS_URL', plugins_url( 'actapp-blocks' ) );
}

if ( !defined( 'ACTAPP_BLOCKS_DESIGN_DIR' ) ) {
	define( 'ACTAPP_BLOCKS_DESIGN_DIR', ACTAPP_BLOCKS_DIR . '/design' );
}

if ( !defined( 'ACTAPP_BLOCKS_DESIGN_URL' ) ) {
	define( 'ACTAPP_BLOCKS_DESIGN_URL', ACTAPP_BLOCKS_URL . '/design' );
}

require_once ACTAPP_BLOCKS_DIR . '/ActAppWidgetManager.php';

add_action('wp_enqueue_scripts', array('ActAppCommon','setup_scripts'),20);
add_action('wp_enqueue_scripts',  array('ActAppWidgetManager','actapp_init_blocks_content'),20,2);


add_action('admin_enqueue_scripts', array('ActAppCommon','setup_scripts'),20);
add_action('admin_enqueue_scripts',  array('ActAppWidgetManager','actapp_init_blocks_content'),20,2);
add_action('admin_enqueue_scripts',  array('ActAppWidgetManager','actapp_init_admin_scripts'),20);

