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
	private $rootdir = "";

	public function getRoot(){
		return $this->$rootdir;
	}
	/**
	 * Prepares the data area for use by creating directory and limiting access for apache
	 * 
	 * @param string $dbname
	 * @return boolean if successfully created	
	 */
	public function init( $basepath = "" ){
		if( $this->$rootdir != ""){
			return;
		}
		$dbroot = ($basepath == "") ? (ABSPATH . 'actappdata') : $basepath;
		$this->$rootdir = $dbroot;
		if( file_exists($dbroot)){
			return true;
		}
		if ( !wp_mkdir_p( $dbroot ) ) {
			return false;
		}
		copy(ACTAPP_SLEEKDB_LIB . '/.htaccess', $dbroot. '/.htaccess');
		
		//define( 'ACTAPP_SLEEKDB_ROOT', $dbroot );
		return true;
	}

	public function getStore( $theName = "general"){
		if ( $this->$rootdir == "" ) {
			$actapp_sleekdb->init();
		}
		if ($this->$rootdir == "" ) {
			return false;
		}
		return \SleekDB\SleekDB::store($theName, $this->$rootdir);
	}


}

global $actapp_sleekdb;
$actapp_sleekdb = new ACTAPP_SleekDB();


