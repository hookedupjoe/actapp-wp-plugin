<?php
/**
 * Server Side Widget Manager: ActAppCommon
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
 */


class ActAppCommon {
	private static $instance;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppCommon();
		}
		return self::$instance;
	}

    
public static function setup_scripts($hook) {
 
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


    protected static function assure_doc($slug, $post_type, $title, $content){
		$author_id = 1;
		if( !self::post_exists_by_slug( $slug, $post_type ) ) {
            // Set the post ID
            wp_insert_post(
                array(
                    'comment_status'    =>   'closed',
                    'ping_status'       =>   'closed',
                    'post_author'       =>   $author_id,
                    'post_name'         =>   $slug,
                    'post_title'        =>   $title,
                    'post_content'      =>  $content,
                    'post_status'       =>   'publish',
                    'post_type'         =>   $post_type
                )
			);
		}
	}
	
	public static function init() {
        
	}




}
add_action( 'init', array( 'ActAppCommon', 'init' ) );
