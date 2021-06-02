<?php
/**
 * actapp-designer.php
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
 * Plugin Name: Action App Designer
 * Plugin URI: https://github.com/hookedupjoe/actapp-plugin
 * Description: The designer component used with blocks and standard Action App functionality with Semantic UI and jQuery * 
 * Author: Joseph Francis
 * Author URI: https://www.hookedup.com
 * Donate-Link: https://www.hookedup.com/
 * Text Domain: actapp
 * License: GPLv3
 * 
 * Version: 1.0.1
 */
define( 'ACTAPP_DESIGNER_VERSION', '1.0.1' );
 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ACTAPP_DESIGNER_FILE', __FILE__ );

if ( !defined( 'ACTAPP_DESIGNER_DIR' ) ) {
	define( 'ACTAPP_DESIGNER_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( !defined( 'ACTAPP_DESIGNER_URL' ) ) {
	define( 'ACTAPP_DESIGNER_URL', plugins_url( 'actapp-designer' ) );
}


require_once ACTAPP_DESIGNER_DIR . '/cls/ActAppDesigner.php';

