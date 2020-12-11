<?php
/**
 * class-actapp-sleekdb.php
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
 * @since actapp 1.0.9
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SleekDB functions.
 */
class ACTAPP_SleekDB {

	public static function loadfs(){
		include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
		if (!class_exists('WP_Filesystem_Direct')) {
			return false;
		}
		return true;
	}
	/**
	 * Prepares the data area for use by creating directory and limiting access for apache
	 * 
	 * @param string $dbname
	 * @return boolean if successfully created	
	 */
	public static function init( $basepath = "" ){
		$this->loadfs();
		$dbroot = ($basepath == "") ? (ABSPATH . 'actappdata') : $basepath;
		if( WP_Filesystem_Direct::exists($dbroot)){
			return true;
		}
		if ( !wp_mkdir_p( $dbroot ) ) {
			return false;
		}
		//$this->loadfs();
		//WP_Filesystem_Direct::copy(ACTAPP_SLEEKDB_LIB . '/.htaccess', $dbroot);
		return true;
	}

}
