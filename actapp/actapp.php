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
 * Description: Used to provide full Action App functionality for complex development / sites.
 * Version: 1.0.5
 * Author: Joseph Francis
 * Author URI: https://www.hookedup.com
 * Donate-Link: https://www.hookedup.com/
 * Text Domain: actapp
 * License: GPLv3
 */
 
 
 if ( !defined( 'ABSPATH' ) ) {
	exit;
}
define( 'ACTAPP_CORE_VERSION', '1.0.0' );
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

require_once ACTAPP_CORE_LIB . '/constants.php';
require_once ACTAPP_CORE_LIB . '/wp-init.php';
