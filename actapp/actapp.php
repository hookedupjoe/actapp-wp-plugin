<?php
/**
 * actapp.php
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
 * Version: 1.0.24
 */
define( 'ACTAPP_CORE_VERSION', '1.0.24' );
 
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

require_once ACTAPP_CORE_DIR . '/cls/ActAppCommon.php';
require_once ACTAPP_SLEEKDB_LIB . '/SleekDB.php';


//---- Blocks Module

define( 'ACTAPP_BLOCKS_VERSION', '1.0.3' );
define( 'ACTAPP_BLOCKS_FILE', __FILE__ );

if ( !defined( 'ACTAPP_BLOCKS_DIR' ) ) {
	define( 'ACTAPP_BLOCKS_DIR', ACTAPP_CORE_DIR );
}

if ( !defined( 'ACTAPP_BLOCKS_URL' ) ) {
	define( 'ACTAPP_BLOCKS_URL', ACTAPP_CORE_URL );
}

require_once ACTAPP_BLOCKS_DIR . '/cls/ActAppWidgetManager.php';
require_once ACTAPP_BLOCKS_DIR . '/cls/ActAppWidgetManangerDataController.php';


