<?php

//--- Multiple json endpoints created / served by a single class
class ActAppDesignerDataController extends WP_REST_Controller {
	private static $instance;
	public static function initInstance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppDesignerDataController();
			self::$instance->registerRoutes();
		}
		return self::$instance;
	}

	public function registerRoutes() {
	  $namespace = 'actappdesigner';

	  $path = 'config';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_config' ),
		'permission_callback' => array( $this, 'get_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'more';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_more' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     
	}

	public function get_permissions_check($request) {
		return true;
	}
	public function get_edit_permissions_check($request) {
		return true;
	}

	public function get_config($request) {
		$tmpRet = array('for'=>'designer');
		return new WP_REST_Response($tmpRet, 200);
	}
	public function get_more($request) {
		$tmpMsg = 'Version: ' . ActAppDesigner::getDataVersion();
		
		$tmpRet = '{
			"options": {
				"padding": false
			},
			"content": [
				{
					"ctl": "tabs",
					"name": "pagetabs",
					"tabs": [
						{
							"label": "Tab One",
							"name": "pagetabs-one",
							"ctl": "tab",
							"content": [
								{
									"ctl": "pagespot",
									"spotname": "tab-area-1"
								},
								{
									"ctl":"message",
									"text":"' . $tmpMsg . '"
								}
							]
						},
						{
							"label": "Tab Two",
							"name": "pagetabs-two",
							"ctl": "tab",
							"content": [
								{
									"ctl": "pagespot",
									"spotname": "tab-area-2"
								}
							]
						}
					]
				}
			]
		}';
		
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
		//return new WP_REST_Response($tmpRet, 200);
		// $args = array(
		// 	'post_type' => 'designer',
        //     'numberposts' => 0
		// );
		// $posts = get_posts($args);
		// if (empty($posts)) {
		// 	$posts = array();
		// }
		// return new WP_REST_Response($posts, 200);
	}


}

add_action('rest_api_init', array('ActAppDesignerDataController', 'initInstance'));
  

