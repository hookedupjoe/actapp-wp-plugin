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

	  
	  $path = 'datapost';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'datapost' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'formpost';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'formpost' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'jsonpost';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'jsonpost' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'config';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_config' ),
		'permission_callback' => array( $this, 'get_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'json_from_csv';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_json_from_csv' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'more';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_more' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'people';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_people' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'dataview';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_dataview' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     


	  $path = 'users';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_users' ),
		'permission_callback' => array( $this, 'get_users_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     



	  $path = 'saveuser';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'save_user' ),
		'permission_callback' => array( $this, 'get_users_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'savedoc';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'save_doc' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'savedesign';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'save_design' ),
		'permission_callback' => array( $this, 'get_design_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'recycle';
	  $routeInfo = array(
		'methods'             => 'POST',
		'callback'            => array( $this, 'recycle_docs' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  $path = 'get-ws-outline.json';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_ws_outline' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     

	  

	  $path = 'page';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_page' ),
		'permission_callback' => array( $this, 'get_edit_permissions_check' )
	  );
	  register_rest_route( $namespace, '/' . $path, [$routeInfo]);     


	  $path = 'pagecode';
	  $routeInfo = array(
		'methods'             => 'GET',
		'callback'            => array( $this, 'get_page_code' ),
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
	public function get_users_permissions_check($request) {
		if( current_user_can('actappdesign')){
			return true;
		}
		return false;
	}
	

	public function get_design_permissions_check($request) {
		if( current_user_can('actappdesign')){
			return true;
		}
		return false;
	}


	//--- *** EDUCATIONAL USE ONLY: DO NOT USE THE fieldVal FUNCTION IN PRODUCTION
	public static function fieldVal($theName,$theContainer,$theIsArray = ''){
		if( is_string($theName) ){
			if( $theIsArray === true || is_array($theContainer) ){
				return $theContainer[$theName];
			}
			return $theContainer->{$theName};
		}
		if( is_array($theName) ){
			$tmpRet = [];
			foreach ($theName as $iFieldName) {
				$tmpRet[$iFieldName] = self::fieldVal($iFieldName,$theContainer,$theIsArray);
			}
			return $tmpRet;
		}
		return false;
	}
	//--- *** EDUCATIONAL USE ONLY: DO NOT USE THE datapost FUNCTION IN PRODUCTION
	//--- Example of an endpoint that takes form submit or json data that is one level deep
	public function datapost($request) {
		//---> Return an error using this technique
		// if( !current_user_can('pingback') ){
		// 	return new WP_Error('actapp_data_error', 'Not autorized', array('status' => 403));
		// }


		$parameters = $request->get_params();
		//---> Check for a form submit (formSubmit = true)
		$body = $request->get_body_params();
		if( $body == null || count($body) == 0){
			//---> No form passed, use the body as json
			$json = $request->get_body();
			$body = json_decode($json);	
		}
		//--> Determine if this is an array field and pass optional param
		//..... if the third param is not set, it checks the type in the fieldVal function
		//..... so for performance reasons, we check it once if we need more than one field in a loop
		$tmpIsArray = is_array($body);
		$tmpActionName = self::fieldVal('action',$body,$tmpIsArray);
		$tmpFieldVals = self::fieldVal(['action','more','test'],$body,$tmpIsArray);
		//or just $tmpActionName = self::fieldVal('action',$body);

		//--- Make return as array and encode it
		$tmpRet = wp_json_encode(array(
			'request' => 'datapost',
			'vals' => $tmpFieldVals,
			'params' => $parameters,
			'action' => $tmpActionName,
			'body' => $body,
		));

		//--- Standard JSON reply
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();

	}

//**** This is the preferred method for sending data to a service
	//--- A JSON Post can convert to any data type based on JSON passed
	public function jsonpost($request) {
		//---> If using formSubmit = false or no formSubmit used,
		// .... then get field values like this
		$json = $request->get_body();
		$body = json_decode($json);
		$tmpActionName = $body->action; //or $body->{'action'};

		//--- Make return as array and encode it
		$tmpRet = wp_json_encode(array(
			'request' => 'jsonpost',
			'action' => $tmpActionName,
			'body' => $body,
		));

		//--- Standard JSON reply
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();

	}

	//--- A Form Post of json data ends up being all strings
	public function formpost($request) {
		//---> If using formSubmit = true then get field values like this
		$body = $request->get_body_params();
		$tmpActionName = $body['action'];

		//--- Make return as array and encode it
		$tmpRet = wp_json_encode(array(
			'request' => 'formpost',
			'action' => $tmpActionName,
			'body' => $body,
		));

		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}	


	public function get_config($request) {
		$tmpRet = array('for'=>'designer');
		return new WP_REST_Response($tmpRet, 200);
	}

	

	public function get_page_code($request) {
		$tmpRoot = ACTAPP_DESIGNER_DIR . '/apps/DevDesigner/app/catalog/designer/panels';
		$tmpRet = '{"status":true,"loc":"'.$tmpRoot.'","index":{"thisPageSpecs":"2","layoutOptions":"6","layoutConfig":"10","required":"14","_onPreInit":"18","_onInit":"22","_onFirstActivate":"26","_onFirstLoad":"30","_onActivate":"34","_onResizeLayout":"38","YourPageCode":"42"},"parts":["(function (ActionAppCore, $) {\r\n\r\n    var SiteMod = ActionAppCore.module(\"site\");\r\n\r\n    ","thisPageSpecs","\r\n\r\nvar thisPageSpecs = {\n\t\"pageName\": \"TestNew1\",\n\t\"pageTitle\": \"TestNew1\",\n\t\"navOptions\": {\n\t\t\"topLink\": true,\n\t\t\"sideLink\": true\n\t}\n}\r\n\r\n","thisPageSpecs~","\r\n\r\n    var pageBaseURL = \n"app/pages/\n" + thisPageSpecs.pageName + \n"/\n";\r\n\r\n    ","layoutOptions","\r\n    thisPageSpecs.layoutOptions = {\r\n        baseURL: pageBaseURL,\r\n        north: false,\r\n        east: { html: \n"east\n" },\r\n        west: false,\r\n        center: { html: \"center\" },\r\n        south: false\r\n    }\r\n    ","layoutOptions~","\r\n\r\n    ","layoutConfig","\r\n    thisPageSpecs.layoutConfig = {\r\n        west__size: \"500\"\r\n        , east__size: \"250\"\r\n    }\r\n\r\n    ","layoutConfig~","\r\n    ","required","\r\n    thisPageSpecs.required = {\r\n\r\n    }\r\n    ","required~","\r\n\r\n    var ThisPage = new SiteMod.SitePage(thisPageSpecs);\r\n\r\n    var actions = ThisPage.pageActions;\r\n\r\n    ThisPage._onPreInit = function (theApp) {\r\n        ","_onPreInit","\r\n\r\n        ","_onPreInit~","\r\n    }\r\n\r\n    ThisPage._onInit = function () {\r\n        ","_onInit","\r\n\r\n        ","_onInit~","\r\n    }\r\n\r\n\r\n    ThisPage._onFirstActivate = function (theApp) {\r\n        ","_onFirstActivate","\r\n\r\n        ","_onFirstActivate~","\r\n        ThisPage.initOnFirstLoad().then(\r\n            function () {\r\n                ","_onFirstLoad","\r\n\r\n                ","_onFirstLoad~","\r\n                ThisPage._onActivate();\r\n            }\r\n        );\r\n    }\r\n\r\n\r\n    ThisPage._onActivate = function () {\r\n        ","_onActivate","\r\n\r\n        ","_onActivate~","\r\n    }\r\n\r\n    ThisPage._onResizeLayout = function (thePane, theElement, theState, theOptions, theName) {\r\n        ","_onResizeLayout","\r\n\r\n        ","_onResizeLayout~","\r\n    }\r\n\r\n    //------- --------  --------  --------  --------  --------  --------  -------- \r\n    ","YourPageCode","\r\n\r\n\r\n    actions.loadASpot = loadASpot;\r\n    function loadASpot() {\r\n        ThisPage.loadSpot(\"funspot\", \"We are having fun now\")\r\n    };\r\n\r\n    actions.loadASpot = loadASpot;\r\n    function loadASpot() {\r\n        var tmpHTML = [];\r\n        tmpHTML.push(\n"<div class=\"ui-layout-center\">Center\n")\r\n        tmpHTML.push(\n"</div>\n")\r\n        tmpHTML.push(\n"<div class=\"ui-layout-north\">North</div>\n")\r\n        tmpHTML.push(\n"<div class=\"ui-layout-south\">South</div>\n")\r\n        tmpHTML.push(\n"<div class=\"ui-layout-east\">East</div>\n")\r\n        tmpHTML.push(\n"<div class=\"ui-layout-west\">West</div>\n")\r\n        tmpHTML = tmpHTML.join(\n"\n");\r\n\r\n        ThisPage.loadSpot(\"body\", tmpHTML);\r\n        var tmpBodySpot = ThisPage.getSpot(\"body\");\r\n        var tmpLayout = tmpBodySpot.layout();\r\n        console.log(\n"tmpLayout\n", tmpLayout);\r\n        if (typeof (ThisApp.refreshLayouts) == \n"function\n") {\r\n            ThisApp.refreshLayouts();\r\n        }\r\n        console.log(\n"tmpBodySpot\n", tmpBodySpot);\r\n\r\n\r\n    };\r\n    ","YourPageCode~","\r\n\r\n})(ActionAppCore, $);\r\n"]}';
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}

	public function get_page($request) {
		$tmpRet = '{"options":{"padding":false},"content":[{"ctl":"tbl-ol-node","type":"pages","name":"pages","item":"","details":".../pages","meta":"&#160;","classes":"ws-outline","level":3,"icon":"columns","color":"black","group":"workspace-outline","content":[{"ctl":"tbl-ol-node","type":"page","item":"ActionAppParts-Home","attr":{"appname":"ActionAppParts","pagename":"Home","source":"app"},"details":"Home","meta":"&#160;","level":2,"icon":"columns","color":"green","group":"workspace-outline","content":[{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-PanelWIthControls.json","details":"PanelWIthControls","meta":"&#160;","level":1,"icon":"newspaper outline","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"PanelWIthControls.json","restype":"Panels","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-PanelWithLayout.json","details":"PanelWithLayout","meta":"&#160;","level":1,"icon":"newspaper outline","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"PanelWithLayout.json","restype":"Panels","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-frmContactInfo.json","details":"frmContactInfo","meta":"&#160;","level":1,"icon":"newspaper outline","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"frmContactInfo.json","restype":"Panels","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-Demo Media Text.html","details":"Demo Media Text","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"Demo Media Text.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-buttons - animated demo.html","details":"buttons - animated demo","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"buttons - animated demo.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-buttons container testing.html","details":"buttons container testing","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"buttons container testing.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-cards demo.html","details":"cards demo","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"cards demo.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-center.html","details":"center","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"center.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-demo sae detroit home.html","details":"demo sae detroit home","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"demo sae detroit home.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-demo single event.html","details":"demo single event","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"demo single event.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-east.html","details":"east","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"east.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-events page demo.html","details":"events page demo","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"events page demo.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-file-upload-formatted.html","details":"file-upload-formatted","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"file-upload-formatted.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-grid-16 four column example.html","details":"grid-16 four column example","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"grid-16 four column example.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-members.html","details":"members","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"members.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-relaxed list demo.html","details":"relaxed list demo","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"relaxed list demo.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-sidebar-cards.html","details":"sidebar-cards","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"sidebar-cards.html","restype":"HTML","source":"app"},"group":"workspace-outline"},{"ctl":"tbl-ol-node","type":"resource","item":"ActionAppParts-Home-tabs-demo.html","details":"tabs-demo","meta":"&#160;","level":1,"icon":"code","color":"purple","attr":{"appname":"ActionAppParts","pagename":"Home","resname":"tabs-demo.html","restype":"HTML","source":"app"},"group":"workspace-outline"}]}]}]}';
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}
	
	public function recycle_docs($request) {
		$json = $request->get_body();
		$body = json_decode($json);
		$ids = $body->ids;
		foreach( $ids as $id){
			//set_post_type( $id, get_post_type($id)."_recycled" );
			wp_trash_post( $id );
		}
		//--- Make return as array and encode it
		$tmpRet = wp_json_encode(array(
			'action' => 'recycle',
			'ids' => $ids,
		));

		//--- Standard JSON reply
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}	

	public static function getDataFromQuery($query){
		$tmpRet = array();
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$tmpID = get_the_ID();
				$tmpData = get_post_meta($tmpID);
				
				foreach($tmpData as $iField => $iVal) {
					if( count($iVal) == 1){
						$tmpVal = $iVal[0];
						$tmpData[$iField] = maybe_unserialize($tmpVal);
					}
				}
				
				if( $tmpAdded ){
					$tmpRet .= ',';			
				} else {
					$tmpAdded = true;
				}
				array_push($tmpRet, $tmpData);			
			}
		}
		return $tmpRet;
	}
	public static function get_design_doc($theName,$theType){
		//--- Get data view document by slug
		//-- populate this from the details
		$tmpDocType = $theType; 
		$tmpPostType = 'actappdesigndoc'; 

		//--- Start with blank query
		$tmpQuery = array();

		//--- If getting a doc type then add to the query
		if( $tmpDocType != ''){
			array_push($tmpQuery, array(
				'key'     => '__doctype',
				'value'   => $tmpDocType,
				'compare' => '=',
				)
			);
		}
		if( $theName != ''){
			array_push($tmpQuery,array(
				'key'     => 'name',
				'value'   => $theName,
				'compare' => '=',
			));
		}

		$args = array(
			'post_type' => $tmpPostType,
			'posts_per_page' => 1,
			'meta_query' => $tmpQuery
		);

		$query = new WP_Query( $args );

		$tmpRet = self::getDataFromQuery($query);
		/* Restore original Post Data */
		wp_reset_postdata();
		return $tmpRet[0];
		
	}

	
	public function save_user($request) {
		//ToDo: Use wp user update / add caps instead
		if( !current_user_can('actappdesign') ){
			return new WP_Error('actapp_data_error', 'Not autorized', array('status' => 403));
		}
		$json = $request->get_body();
		$body = json_decode($json);

		$tmpDocID = '';
		$tmpPostID = false;
		if ($body->id != null && $body->id != ""){
			$tmpPostID = $body->id;
			$tmpDocID = $body->id;
		} else {
			if($body->id != null){
				unset($body["id"]);
			}			
			$tmpDocID = (ActAppDesigner::getSUID() . '_' . uniqid('' . random_int(1000, 9999)));
			$body->__uid = $tmpDocID;
			$body->__doctype = $doctype;
			$body->__title = $doctitle;
		}
		
		$jsonDoc = json_encode($body);
		
		$author_id = get_current_user_id();;
		$newid = 0;

		$newuser = array(
			'user_login'    =>   $body->user_login,
			'user_email'       =>   $body->user_email,
			'first_name'         =>   $body->first_name,
			'last_name'        =>   $body->last_name,
			'description'      =>   $body->description,
			'show_admin_bar_front' => in_array('adminbar',$body->admin_options),
			'use_ssl' => in_array('ssl',$body->admin_options),
			'role'       =>   $body->role,
		);
		if( $tmpPostID ){
			$newuser['ID'] = $tmpPostID;
		}
		
		
		$tmpResultCode = '';
		if( !$tmpPostID ){
			$tmpResultCode = 'new user';
			if( $body->user_pass != null && $body->user_pass != ''){
				$newuser['user_pass'] = $body->user_pass;			
			}

			$newid = wp_insert_user(
				$newuser
			);
			$body->id = $newid;
			$newWPUser = get_user_by('id', $newid);
			if( is_array($body->capabilities) ){
				foreach ($body->capabilities as $iCap) {
					$newWPUser->add_cap($iCap);
				}	
			}
		} else {
			$tmpResultCode = 'updated user ';
			if( $body->user_pass != null && $body->user_pass != ''){
				wp_set_password( $body->user_pass, $tmpPostID );			
			}
			
			$tmpAddReply = wp_insert_user(
				$newuser
			);
			$newWPUser = get_user_by('id', $tmpPostID);
			//--- ToDo: Review for removal from capacity when not passed on update
			if( is_array($body->capabilities) ){
				foreach ($body->capabilities as $iCap) {
					$newWPUser->add_cap($iCap);
				}	
			}
		}

		//--- Make return as array and encode it
		$tmpRet = wp_json_encode(array(
			'action' => 'saveuser',
			'add_reply' => $tmpAddReply,
			'post_id' => $newid ? $newid : $tmpPostID,
			'full_id' => $body->id,
			'new_id' => $newid,
			'update_id' => $tmpPostID,
			'doctype' => $doctype,
			'newuser' => $newuser,
			'result' => $tmpResultCode,
			'body' => $body
		));

		//--- Standard JSON reply
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}

	public function save_design($request) {
		return self::save_doc($request,true);
	}	
	
	public function save_doc($request, $theIsDesign = false) {
		$tmpPostType = 'actappdoc';
		if( $theIsDesign === true){
			$tmpPostType = 'actappdesigndoc';
			if( !current_user_can('actappdesign') ){
				return new WP_Error('actapp_data_error', 'Not autorized', array('status' => 403));
			}
		} else {
			if( !current_user_can('actappapps') ){
				return new WP_Error('actapp_data_error', 'Not autorized', array('status' => 403));
			}
		}
		$json = $request->get_body();
		$body = json_decode($json);

		$doctype = $body->__doctype;
		if( !$doctype ){
			$doctype = $_GET['doctype'];
		}

		$doctitle = $body->__doctitle;
		if( !$doctitle ){
			$doctitle = $_GET['doctitle'];
		}

		$tmpDocID = '';
		$tmpPostID = false;
		if ($body->id != null && $body->id != ""){
			$tmpPostID = $body->id;
			$tmpDocID = $body->id;
		} else {
			if($body->id != null){
				unset($body["id"]);
			}			
			$tmpDocID = (ActAppDesigner::getSUID() . '_' . uniqid('' . random_int(1000, 9999)));
			if( $doctitle == ''){
				$doctitle = $tmpDocID;
			}
			$body->__uid = $tmpDocID;
			$body->__doctype = $doctype;
			$body->__title = $doctitle;
		}
		
		$jsonDoc = json_encode($body);
		
		$author_id = get_current_user_id();;
		$newid = 0;

		$newpost = array(
			'comment_status'    =>   'closed',
			'ping_status'       =>   'closed',
			'post_author'       =>   $author_id,
			'post_name'         =>   $tmpDocID,
			'post_title'        =>   $doctitle,
			'post_content'      =>   '',
			'json' => $jsonDoc,
			'body_topic' => $body->topic,
			'post_status'       =>   'publish',
			'post_type'         =>   $tmpPostType
		);
		if( $tmpPostID ){
			$newpost['id'] = $tmpPostID;
		}

		
		$tmpResultCode = '';
		if( !$tmpPostID ){
			$tmpResultCode = 'new doc';
			$newid = wp_insert_post(
				$newpost
			);
			$body->id = $newid;

			wp_update_post(array(
				'ID'        => $newid,
				'meta_input'=> $body,	
			));
		} else {
			$tmpResultCode = 'updated json';
			
			wp_update_post(array(
				'ID'        => $tmpPostID,
				'meta_input'=> $body,
			));
		}

		//--- Make return as array and encode it
		$tmpRet = wp_json_encode(array(
			'action' => 'savedoc',
			'post_id' => $newid ? $newid : $tmpPostID,
			'full_id' => $body->id,
			'new_id' => $newid,
			'update_id' => $tmpPostID,
			'doctype' => $doctype,
			'newpost' => $newpost,
			'result' => $tmpResultCode,
			'body' => $body,
			'storeid' => ActAppDesigner::getSUID(),
			'data_version' => ActAppDesigner::getPluginSetupVersion(),
			'base_url' => ActAppCommon::getRootPath(),
		));

		//--- Standard JSON reply
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}


	public function get_json_from_csv($request) {
		$file="C:\\aa\\mock-data.csv";
		$csv= file_get_contents($file);
		$array = array_map("str_getcsv", explode("\n", $csv));
		$tmpDocCount = count($array);

		$tmpID = 'na';
		$pos = $_GET['pos'];
		$tmpStart = 1;
		$tmpEnd = $tmpDocCount;		
		if( $pos != ''){
			if( $pos == 'auto'){
				$current_user = wp_get_current_user();
				$tmpID = $current_user->ID;
				$tmpLastPos = get_user_meta( $tmpID, 'mock_data_pos', true ); 
				if( $tmpLastPos == ''){
					$pos = 1;
				} else {
					$pos = intval(''.$tmpLastPos) + 1;
					if( $pos >= $tmpDocCount-1){
						$pos = 1;
					}
				}
				update_user_meta( $tmpID, 'mock_data_pos', $pos ); 
			}
			$tmpStart = intval($pos);
			$tmpEnd = $tmpStart + 1;
		}
		$tmpFieldNames = $array[0];
		$tmpFNCount = count($tmpFieldNames);
		$tmpData = [];
		for ($iPos = $tmpStart; $iPos < $tmpEnd; $iPos++) {
			$tmpDoc = $array[$iPos];
			$tmpDocEntry = [];
			if(count($tmpDoc) == $tmpFNCount){
				for ($iFieldPos = 0; $iFieldPos < $tmpFNCount; $iFieldPos++) {
					$tmpFN = $tmpFieldNames[$iFieldPos];
					$tmpDocEntry[$tmpFN] = $tmpDoc[$iFieldPos];
				}
				$tmpDocEntry['posid'] = ''.$iPos;
				array_push($tmpData, $tmpDocEntry);
			}
		}
		$tmpRet = array('data' => $tmpData,'id' => $tmpID, 'pos' => $pos);
		$json = json_encode($tmpRet);
		header('Content-Type: application/json');
		echo $json;
		exit();
	}

	// public static function get_mock_data($thePos) {
	// 	$file="C:\\aa\\mock-data.csv";
	// 	$csv= file_get_contents($file);
	// 	$array = array_map("str_getcsv", explode("\n", $csv));
	// 	$tmpDocCount = count($array);

	// 	$pos = $thePos;
	// 	$tmpStart = 1;
	// 	$tmpEnd = $tmpDocCount;
		
	// 	if( $pos != ''){
	// 		$tmpStart = intval($pos);
	// 		$tmpEnd = $tmpStart + 1;
	// 	}
	// 	$tmpFieldNames = $array[0];
	// 	$tmpFNCount = count($tmpFieldNames);
	// 	$tmpData = [];
	// 	for ($iPos = $tmpStart; $iPos < $tmpEnd; $iPos++) {
	// 		$tmpDoc = $array[$iPos];
	// 		$tmpDocEntry = [];
	// 		if(count($tmpDoc) == $tmpFNCount){
	// 			for ($iFieldPos = 0; $iFieldPos < $tmpFNCount; $iFieldPos++) {
	// 				$tmpFN = $tmpFieldNames[$iFieldPos];
	// 				$tmpDocEntry[$tmpFN] = $tmpDoc[$iFieldPos];
	// 			}
	// 			array_push($tmpData, $tmpDocEntry);
	// 		}
	// 	}
	// 	$tmpRet = array('data' => $tmpData);
	// 	return $tmpRet;
	// }


	public function get_more($request) {
		$tmpRet = wp_json_encode(array(
			'storeid' => ActAppDesigner::getSUID(),
			'data_version' => ActAppDesigner::getPluginSetupVersion(),
			'base_url' => ActAppCommon::getRootPath(),
		));
		header('Content-Type: application/json');
		echo $tmpRet;
		exit();
	}

	public function get_dataview($request) {

		$tmpName = $_GET['name'];
		$qs = $_GET['qs'];


		//--- Get design doc for data view
		$tmpDesignDoc = self::get_design_doc($tmpName,'dataview');

		//-- populate this from the details
		$tmpDocType = $tmpDesignDoc["doctype"]; 
		$tmpPostType = $tmpDesignDoc["posttype"];

		//--- Start with blank query
		$tmpQuery = array();

		//--- If getting a doc type then add to the query
		if( $tmpDocType != ''){
			array_push($tmpQuery, array(
				'key'     => '__doctype',
				'value'   => $tmpDocType,
				'compare' => '=',
				)
			);
		}

		//--- Get and use query string values from the setup doc
		if( $qs != '' ){
			array_push($tmpQuery,array(
				'key'     => 'topic',
				'value'   => '"'.$qs.'"',
				'compare' => 'Like',
			));
		}

		$args = array(
			'post_type' => $tmpPostType,
			'posts_per_page' => -1,
			'meta_query' => $tmpQuery
		);
		$query = new WP_Query( $args );
		//$tmpQuery["design"] = $tmpDesignDoc;
		$tmpRet = '{"q":' . json_encode($tmpQuery);
		$tmpRet .= ',"design":' . json_encode($tmpDesignDoc);
		$tmpRet .= ',"data":[';
		$tmpAdded = false;
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$tmpID = get_the_ID();
				$tmpJson = get_post_meta($tmpID);
				
				foreach($tmpJson as $iField => $iVal) {
					if( count($iVal) == 1){
						$tmpVal = $iVal[0];
						$tmpJson[$iField] = maybe_unserialize($tmpVal);
					}
				}
				$tmpJson = json_encode($tmpJson);
				if( $tmpAdded ){
					$tmpRet .= ',';			
				} else {
					$tmpAdded = true;
				}
				$tmpRet .= $tmpJson;			
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		
		$tmpRet .= ']}';
		header('Content-Type: application/json');
		echo $tmpRet;
		
		exit();
	}
	

	public function get_users($request) {
		$blogusers = get_users( array( 'role__in' => array( 'administrator', 'author', 'editor' ) ) );
		$tmpData = [];
		foreach ( $blogusers as $user ) {
			$tmpID = $user->ID;
			if( $tmpID != 1){
				//$tmpAdminOptions = [];
				foreach ( $user->roles as $iRole ) {
					$tmpRole = $iRole;
				}
				
				$tmpUserData = $user->data;
				$tmpCaps = [];
				$tmpAdminOptions = [];
				$tmpAdminBar = get_user_meta($tmpID,'show_admin_bar_front',true);
				$tmpSSL = get_user_meta($tmpID,'use_ssl',true);

				if( $tmpAdminBar == '1' ){
					array_push($tmpAdminOptions,'adminbar');
				}
				if( $tmpSSL == '1' ){
					array_push($tmpAdminOptions,'ssl');
				}

				foreach ( $user->caps as $iCapName => $iCapVal ) {
					if( $iCapName != $tmpRole){
						if( $iCapVal === true){
							array_push($tmpCaps,$iCapName);
						}
					}
				}

				$tmpNew = [
					'admin_options' => $tmpAdminOptions,
					'capabilities' => $tmpCaps,
					'description' => get_user_meta($tmpID,'description',true),
					'first_name' => get_user_meta($tmpID,'first_name',true),
					'last_name' => get_user_meta($tmpID,'last_name',true),
					'role' => $tmpRole,
					'user_email' => $user->data->user_email,
					'user_login' => $user->data->user_login,
				];
				if( $tmpNew['description'] === null ){
					$tmpNew['description'] = '';
				}
				$tmpNew['id'] = $tmpID;
				array_push($tmpData,$tmpNew);
			}
		}
		$tmpRet = ['data' => $tmpData];
		header('Content-Type: application/json');
		echo json_encode($tmpRet);
		exit();
	}

	public function get_users_raw($request) {
		$blogusers = get_users( array( 'role__in' => array( 'administrator', 'author', 'editor' ) ) );
		$tmpRet = ['data' => $blogusers];
		header('Content-Type: application/json');
		echo json_encode($tmpRet);
		exit();
	}

	public function get_people($request) {

		$qs = $_GET['qs'];
		$tmpQuery = array(
			array(
				'key'     => '__doctype',
				'value'   => 'person',
				'compare' => '=',
			),
		);
		if( $qs != ''){
			array_push($tmpQuery,array(
				'key'     => 'topic',
				'value'   => '"'.$qs.'"',
				'compare' => 'Like',
			));
		}

		$args = array(
			'post_type' => 'actappdoc',
			'posts_per_page' => -1,
			'meta_query' => $tmpQuery
		);
		$query = new WP_Query( $args );

		$tmpRet = '{"q":' . json_encode($tmpQuery) .',"data":[';
		$tmpAdded = false;
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$tmpID = get_the_ID();
				//$tmpJson = get_post_meta($tmpID,'actappdocdata',true);
				$tmpJson = get_post_meta($tmpID);
				
				foreach($tmpJson as $iField => $iVal) {
					if( count($iVal) == 1){
						$tmpVal = $iVal[0];
						$tmpJson[$iField] = maybe_unserialize($tmpVal);
						// if( substr( $tmpVal, 0, 3 ) == 'j;;'){
						// 	$tmpVal = substr( $tmpVal,3);
						// 	$tmpJson[$iField] = json_decode($tmpVal);
						// } else {
						// 	$tmpJson[$iField] = $tmpVal;
						// }
						
					}
					//$tmpJson[$iField] = get_post_meta($tmpID,$iField,true);
				}
				$tmpJson = json_encode($tmpJson);
				if( $tmpAdded ){
					$tmpRet .= ',';			
				} else {
					$tmpAdded = true;
				}
				$tmpRet .= $tmpJson;			
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		
		$tmpRet .= ']}';
		header('Content-Type: application/json');
		echo $tmpRet;
		
		exit();
	}

	public function get_ws_outline($request) {
		$tmpMsg = 'Version: ' . ActAppDesigner::getDataVersion();
		
		$tmpRet = '{
			"options": {
				"padding": false,
				"css": [
					".ws-outline table.outline > tbody > tr[oluse=\"select\"] {",
					"  cursor: pointer;",
					"}",
					".ws-outline table.outline > tbody > tr[oluse=\"collapsable\"] {",
					"  cursor: pointer;",
					"}",
					".ws-outline table.outline > tbody > tr > td.tbl-label {",
					"  width:20px;",
					"  color:black;",
					"  background-color: #eeeeee;",
					"}",
					".ws-outline table.outline > tbody > tr.active > td.tbl-label {",
					"  background-color: #777777;",
					"  color: white;",
					"}",
					".ws-outline table.outline > tbody > tr > td.tbl-icon {",
					"  width:40px;",
					"}",
					".ws-outline table.outline > tbody > tr > td.tbl-icon2 {",
					"  width:80px;",
					"}",
					".ws-outline table.outline > tbody > tr > td.tbl-details {",
					"  font-weight:bolder;",
					"  overflow:auto;",
					"  width:auto;",
					"}",
					".ws-outline table.outline > tbody > tr.active[type=\"page\"] > td.tbl-label {",
					"  background-color: #21ba45;",
					"}",
					".ws-outline table.outline > tbody > tr.active[type=\"app\"] > td.tbl-label {",
					"  background-color: #2185d0;",
					"}",
					".ws-outline table.outline > tbody > tr.active[type=\"resource\"] > td.tbl-label {",
					"  background-color: #a333c8;",
					"}"
				],
				"extra": {
					"previewPort": 33461
				}
			},
			"content": [
				{
					"ctl": "tbl-ol-node",
					"type": "workspace",
					"name": "workspace",
					"item": "",
					"details": "Workspace",
					"meta": "&#160;",
					"classes": "ws-outline",
					"level": 3,
					"icon": "hdd outline",
					"color": "black",
					"group": "workspace-outline",
					"content": [
						{
							"ctl": "tbl-ol-node",
							"type": "apps",
							"details": "Applications",
							"meta": "&#160;",
							"classes": "ws-editor-outline",
							"level": 2,
							"icon": "globe",
							"color": "black",
							"group": "workspace-outline",
							"content": [
								{
									"ctl": "tbl-ol-node",
									"type": "app",
									"item": "ActAppTutorial",
									"attr": {
										"appname": "ActAppTutorial",
										"apptitle": "Action App Tutorial",
										"source": "workspace"
									},
									"details": "[ActAppTutorial] Action App Tutorial",
									"meta": "&#160;",
									"level": 1,
									"icon": "globe",
									"color": "blue",
									"group": "workspace-outline"
								},
								{
									"ctl": "tbl-ol-node",
									"type": "app",
									"item": "ActionAppMobile",
									"attr": {
										"appname": "ActionAppMobile",
										"apptitle": "Action App Mobile",
										"source": "workspace"
									},
									"details": "[ActionAppMobile] Action App Mobile",
									"meta": "&#160;",
									"level": 1,
									"icon": "globe",
									"color": "blue",
									"group": "workspace-outline"
								}
							]
						},
						{
							"ctl": "tbl-ol-node",
							"type": "catalogs",
							"details": "Catalogs",
							"meta": "&#160;",
							"classes": "ws-editor-outline",
							"level": 2,
							"icon": "archive",
							"color": "black",
							"group": "workspace-outline",
							"content": [
								{
									"ctl": "tbl-ol-node",
									"type": "catalog",
									"item": "Catalog One",
									"attr": {
										"catname": "cat1",
										"cattitle": "Catalog One",
										"source": "catalog"
									},
									"details": "[cat1] Catalog One",
									"meta": "&#160;",
									"level": 1,
									"icon": "archive",
									"color": "teal",
									"group": "workspace-outline"
								},
								{
									"ctl": "tbl-ol-node",
									"type": "catalog",
									"item": "Catalog Two",
									"attr": {
										"catname": "cat2",
										"cattitle": "Catalog Two",
										"source": "catalog"
									},
									"details": "[cat2] Catalog Two",
									"meta": "&#160;",
									"level": 1,
									"icon": "archive",
									"color": "teal",
									"group": "workspace-outline"
								},
								{
									"ctl": "tbl-ol-node",
									"type": "catalog",
									"item": "Catalog Three",
									"attr": {
										"catname": "cat3",
										"cattitle": "Catalog Three",
										"source": "catalog"
									},
									"details": "[cat3] Catalog Three",
									"meta": "&#160;",
									"level": 1,
									"icon": "archive",
									"color": "teal",
									"group": "workspace-outline"
								},
								{
									"ctl": "tbl-ol-node",
									"type": "catalog",
									"item": "Catalog Four",
									"attr": {
										"catname": "cat4",
										"cattitle": "Catalog Four",
										"source": "catalog"
									},
									"details": "[cat4] Catalog Four",
									"meta": "&#160;",
									"level": 1,
									"icon": "archive",
									"color": "teal",
									"group": "workspace-outline"
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
  

