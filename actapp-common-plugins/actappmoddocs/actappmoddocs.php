<?php
/*
Plugin Name: Docs Module
Plugin URI: http://actionapp.hookedup.com
Version: 1.0.2
Author: Hookedup, inc.
Author URI: http://tech.hookedup.com
*/

/* package: actappmoddocs */

class ActAppDocsModule {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	//--- Update this if the forms update and need cache busting
	public static function form_version(){
		return "0608210736";
	}


	public static function echo_relative() {
		echo (ACTAPP_DOCS_PREFIX_URL);
		return ACTAPP_DOCS_PREFIX_URL;
	}

	public static function admin_menu() {
		// if( !current_user_can( 'administrator' ) ){
		// 	remove_menu_page( 'edit.php?post_type=docpost' );
		// }
	}

	/**
	 * Returns an instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppDocsModule();
		}
		return self::$instance;
	}

	public static function plugin_initialize() {
		
	}

	public static function add_field_groups(){
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_docpost',
				'title' => 'Document Details',
				'fields' => array(
					array(
						'key' => 'field_docpost_book',
						'label' => 'Book',
						'name' => 'book',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'docpost',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));
			
			endif;

	}
	/**
	 * Runs when plugin is activated
	 */
	public static function activation_hook() {
		self::init();
		flush_rewrite_rules(); 
		self::plugin_initialize();
	}
	/**
	 * Init it
	 */
	public static function init() {
		self::add_field_groups();			
		register_taxonomy(
			'docpost-category',
			'docpost',
			array(
				'label' => __( 'Category' ),
				'rewrite' => array( 'slug' => 'docpost-category' ),
				'hierarchical' => true,
				'show_in_rest' => true,
			)
		);


		

register_post_meta(
	'docpost',
	'_my_data',
	[
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
		'auth_callback' => function() {
			return current_user_can( 'edit_posts' );
		}
	]
);

//-- end testing
		self::custom_post_docpost();
        
	

        /**
         * Class with commonly used static functions
         * 
         * Usage: ActAppModDocs::doSomething()
         */
        require ACTAPP_DOCS_PLUGIN_DIR . '/inc/ActAppModDocs.php';
       
        add_filter( 'template_include', 'docpost_list_template' );
        function docpost_list_template( $template ) {

            $tmpType = 'docpost';
            $tmpPluginDir = ACTAPP_DOCS_PLUGIN_DIR;

            $tmpFN = '';
			
            if ( is_post_type_archive( $tmpType )  ) {
				
                $tmpFN = '/tpl/archive-'.$tmpType.'.php';
                if ( is_singular( $tmpType )  ) {
                    $tmpFN = '/tpl/list-'.$tmpType.'.php';
                }
            } else if ( is_singular( $tmpType )  ) {
                $tmpFN = '/tpl/single-'.$tmpType.'.php';
            }
            if( $tmpFN != ''){
			    if ( file_exists( $tmpPluginDir . $tmpFN ) ) {
                    return $tmpPluginDir . $tmpFN;
                }
            }

            return $template;
        }


        // add_filter( 'single-docpost_template', function( $template ) {
        //     if ( ! $template ) {
        //         $template = dirname( __FILE__ ) . '/tpl/default-docpost-single.php';
        //     }
            
        //     return $template;
        // });

	}


	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {
		//PLACEHOLDER

	}

	
	

	private function custom_post_docpost() {
	/**
	 * Post Type: Docs.
	 */

	$labels = [
		"name" => "Docs",
		"singular_name" => "Doc",
	];

	$args = [
		"label" => "Docs",
		"labels" => $labels,
		"description" => "Documentation Post",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => "docposts",
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "docpost", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "custom-fields", "thumbnail", "excerpt", "comments" ],
		"taxonomies" => [ "docpost-category" ],
		"show_in_graphql" => false,
	];

	register_post_type( "docpost", $args );

	}

    


}

	
if ( !defined( 'ACTAPP_DOCS_PLUGIN_DIR' ) ) {
	define( 'ACTAPP_DOCS_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( !defined( 'ACTAPP_DOCS_PLUGIN_URL' ) ) {
	define( 'ACTAPP_DOCS_PLUGIN_URL', plugins_url( 'actappmoddocs' ));
}

if ( !defined( 'ACTAPP_DOCS_PREFIX_URL' ) ) {
	define( 'ACTAPP_DOCS_PREFIX_URL',  wp_make_link_relative(get_site_url()) . '/donate' );
}

if ( !defined( 'ACTAPP_DOCS_ASSETS_DIR' ) ) {
	define( 'ACTAPP_DOCS_ASSETS_DIR', ACTAPP_DOCS_PLUGIN_DIR . '/assets');
}


register_activation_hook( __FILE__, array( 'ActAppDocsModule', 'activation_hook' ) );

add_action( 'plugins_loaded', array( 'ActAppDocsModule', 'get_instance' ) );
add_action( 'init', array( 'ActAppDocsModule', 'init' ) );
add_action( 'admin_menu', array( 'ActAppDocsModule', 'admin_menu' ));

 
// register custom meta tag field
function myguten_register_post_meta() {
    register_post_meta( 'docpost', 'myguten_meta_block_field', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ) );
}
add_action( 'init', 'myguten_register_post_meta' );



// Add field:
add_action( 'add_meta_boxes', function() {
	add_meta_box(
		'my_meta_box',
		'My Meta Box',
		function( $post ) {
			wp_nonce_field( __FILE__, '_my_data_nonce' );
			?>
			<p><input type="text" class="large-text" name="my_data" value="<?php echo esc_attr( get_post_meta( $post->ID, '_my_data', true ) ); ?>"></p>
			<?php
		},
		'docpost',
		'side'
	);
} );
// Save field.
add_action( 'save_post', function( $post_id ) {
	if ( isset( $_POST['my_data'], $_POST['_my_data_nonce'] ) && wp_verify_nonce( $_POST['_my_data_nonce'], __FILE__ ) ) {
		update_post_meta( $post_id, '_my_data', sanitize_text_field( $_POST['my_data'] ) );
	}
} );



add_action( 'enqueue_block_editor_assets', function() {
	wp_enqueue_script(
		'my-data',
		trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/my-data.min.js',
		[ 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ],
		'0.1.0',
		true
	);
} );
