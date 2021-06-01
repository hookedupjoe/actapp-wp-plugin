<?php
/**
 * wp-init.php
 *
 * Copyright (c) Joseph Francis www.hookedup.com
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
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// startup
global $actapp_version, $actapp_admin_messages;

if ( !isset( $actapp_admin_messages ) ) {
	$actapp_admin_messages = array();
}

if ( !isset( $actapp_version ) ) {
	$actapp_version = ACTAPP_CORE_VERSION;
}

/**
 * Load core :
 */

//--- utility
require_once ACTAPP_CORE_LIB . '/class-actapp-utility.php';

//--- sleekdb
require_once ACTAPP_CORE_LIB . '/class-actapp-sleekdb.php';


/*

// options
require_once ACTAPP_CORE_LIB . '/class-actapp-options.php';

// plugin control: activation, deactivation, ...
require_once ACTAPP_CORE_LIB . '/class-actapp-controller.php';


// help
if ( is_admin() ) {
	require_once ACTAPP_CORE_LIB . '/class-actapp-help.php';
}

require_once ACTAPP_CORE_LIB . '/class-actapp-capability.php';
*/



function actapp_setup_scripts($hook) {
 
	$tmplibloc = ACTAPP_CORE_LIB_URL . '/';
 	//--- To use local designer files
	//---> $tmplibloc = '//localhost:33460/';
	//--- To use CDN repo
	//---> $tmplibloc = 'http://actionapp.hookedup.com/';
	
    // create my own version codes
			$my_js_ver  = ACTAPP_CORE_VERSION;
			$my_css_ver = ACTAPP_CORE_VERSION;

			wp_register_style( 'support_libs_css',    $tmplibloc . 'built-lib/support-libs.css', false,   $my_css_ver );
			wp_enqueue_style ( 'support_libs_css' );

			wp_register_style( 'semantic_css',    $tmplibloc . 'lib/semantic/dist/semantic.min.css', false,   $my_css_ver );
			wp_enqueue_style ( 'semantic_css' );

			wp_register_style( 'aa-appframe',    $tmplibloc . 'lib/css/appframe.css', false,   $my_css_ver );
			wp_enqueue_style ( 'aa-appframe' );

			wp_register_style( 'aa-resp-grid',    $tmplibloc . 'lib/css/resp-grid.css', false,   $my_css_ver );
			wp_enqueue_style ( 'aa-resp-grid' );

			wp_register_style( 'tabulator_css',    $tmplibloc . 'lib/tabulator/css/tabulator.min.css', false,   $my_css_ver );
			wp_enqueue_style ( 'tabulator_css' );

			wp_enqueue_script( 'support_libs', $tmplibloc . 'built-lib/support-libs.js', array(), $my_js_ver );
			wp_enqueue_script( 'semantic_js', $tmplibloc . 'lib/semantic/dist/semantic.min.js', array(), $my_js_ver );
			wp_enqueue_script( 'actionapp', $tmplibloc . 'lib/actionapp/actionapp.js', array(), $my_js_ver );
			wp_enqueue_script( 'data-mgr-plugin', $tmplibloc . 'lib/actionapp/nosql-data-manager.js', array(), $my_js_ver );
			wp_enqueue_script( 'obj-mgr-plugin', $tmplibloc . 'lib/actionapp/object-manager-plugin.js', array(), $my_js_ver );
			wp_enqueue_script( 'app-module', $tmplibloc . 'lib/actionapp/app-module.js', array(), $my_js_ver );
			wp_enqueue_script( 'tabulator', $tmplibloc . 'lib/tabulator/js/tabulator.min.js', array(), $my_js_ver );
			wp_enqueue_script( 'tabulator_xlsx', $tmplibloc . 'lib/tabulator/addons/xlsx.full.min.js', array(), $my_js_ver );

			
			wp_enqueue_script( 'app-only-preinit', $tmplibloc . 'lib/actionapp/app-only-preinit.js', array(), $my_js_ver );
			wp_enqueue_script( 'app-only-init', $tmplibloc . 'lib/actionapp/app-only-init.js', array(), $my_js_ver,true );
			
 
}
