<?php
/*
Common access points for this plugin
*/

/* package: actappmoddoc */

class ActAppModDocs {
	private static $instance;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppModDocs();
		}
		return self::$instance;
	}

	public static function init() {
		//self::do_something_on_startup();
	}
	
	public static function setup_blocks(){
		

		if( get_post_type() != 'docpost' ){
			return;
		}

		$tmpFN = 'myguten';
		wp_enqueue_script(
			'myguten-script',
			ACTAPP_DOCS_PLUGIN_URL . '/blocks/' . $tmpFN . '.js',
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-data', 'wp-core-data', 'wp-block-editor' )
		);
		
		//--- Load docpost related widgets
		$tmpWidgetList = array('docpostslist');
		
		foreach ($tmpWidgetList as $aName) {
			self::loadStandardBlock($aName);
		}
	}
	public static function actapp_docposts_block_category( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug' => 'actappdocposts',
					'title' => __( 'Docs Widgets'),
				),
			),
			$categories,
		);
	}

	public static function pluginDir() {
		return ACTAPP_DOCS_PLUGIN_DIR;
	}

	//Common function to be moved to common builder class later
	public static function getCardUI($theDoc) {
		$tmpURL = $theDoc["url"];
		$tmpRet = '<a class="card" href="'.$tmpURL.'">';
		$tmpFeaturedURL = $theDoc["thumbnail"];
		if( $tmpFeaturedURL != ""){
			$tmpRet .= '<div class="image">
			<img style="min-height:125px;max-height:125px;object-fit: cover;" src="'.$tmpFeaturedURL.'">
		</div>';
		}

		$tmpRet .= '<div class="content"><div class="header">'.$theDoc["title"].'</div>';
	  
		$tmpExcerpt = $theDoc["excerpt"];
		if( $tmpExcerpt != ""){
			$tmpRet .= '<div class="description">
			'.$tmpExcerpt.'
			</div>';
		}
		$tmpRet .= '</div>';

		
		$tmpRet .= '</a>';
		return $tmpRet;
	}

	public static function getDocCard($theDoc) {
		return self::getCardUI($theDoc);
	}
	
	public static function processSidebarForCategory() {
			$tmpTestField = get_post_meta( get_the_ID(), 'myguten_meta_block_field', true);
		echo('$tmpTestField ' . $tmpTestField);
		// $tmpCats = get_the_terms( get_the_ID(), 'docpost-category' );
		// foreach ($tmpCats as $aCat) {
		// 	echo self::getCategoryLink($aCat);
		// }
		// echo self::getFullListLink();
		return true;
	}
	
	public static function getCategoryLink($theCat){
		$tmpRet = '';
		$tmpURL = site_url( '/docposts/?docpost-category='.$theCat->slug);
		$tmpRet .= '<div class="ui list"><div class="item"><a href="'.$tmpURL.'" class="ui button fluid circular black rounded basic">'.$theCat->name.'</a></div></div>';
		return $tmpRet;
	}

	public static function getFullListLink(){
		$tmpRet = '';
		$tmpURL = site_url( '/docposts');
		$tmpRet .= '<div class="ui list"><div class="item"><a href="'.$tmpURL.'" class="ui button fluid circular black rounded basic">Table of Contents</a></div></div>';
		return $tmpRet;
	}
	
	public static function getNothingFound(){
		return ('<div class="ui message orange large">Nothing found</div>');
	}

	public static function processArchivePosts($theShowCount = 0) {
		$tmpRet = '';
		$tmpSummary = [];

		while ( have_posts() ) :
			the_post();
			
			//$tmpCat = get_the_category();
			$tmpCat = get_the_terms( get_the_ID(), 'docpost-category' );
			
			$aCat = $tmpCat[0];
			//foreach ($tmpCat as $aCat) {
				$tmpCatName = $aCat->name;
				$tmpCatSlug = $aCat->slug;
				$tmpCurr = $tmpSummary[$tmpCatSlug];

				$tmpRec = array(
					"id"=>get_the_ID(),
					"title"=>get_the_title(),
					"excerpt"=>get_the_excerpt(),
					"url"=>get_the_permalink(),
					"thumbnail"=>get_the_post_thumbnail_url(),
				);
				
				if( $tmpCurr == null){
					$tmpCurr = array(
						"name"=>$tmpCatName, 
						"slug"=>$tmpCatSlug
					);
					$tmpCurr["posts"] = array();
					
				}
				array_push($tmpCurr["posts"], $tmpRec);
				$tmpSummary[$tmpCatSlug] = $tmpCurr;
			//}
		endwhile;
		$tmpShowMax = 3;
		if( $theShowCount == 0){
			$tmpShowMax = 999;
		}
		$tmpCardsDiv = "three";
		foreach($tmpSummary as $aKey => $tmpCurr) {
			$tmpURL = site_url( '/docposts/?docpost-category='.$tmpCurr["slug"]);
			$tmpCards = array();
			$tmpPosts = $tmpCurr["posts"];
			$tmpCount = sizeof($tmpPosts);
			$tmpShowCount = $tmpCount;
			$tmpShowMore = false;
			if( $tmpShowCount > $tmpShowMax ){
				$tmpShowMore = true;
				$tmpShowCount = $tmpShowMax;
			}

			if( $theShowCount > 0){
				echo ('<div class="ui header blue medium">');
				echo $tmpPrefix = 'Latest '.$tmpCurr["name"];
				echo ('</div>');
			}

			echo ('<div class="ui cards stackable '.$tmpCardsDiv.'"><div></div>'); //--- Extra div to fix first child oddity on stackable cards

			for( $i = 0 ; $i < $tmpShowCount ; $i++){
				echo self::getDocCard($tmpPosts[$i]);
			}
			echo('</div>');
			if( $tmpShowMore == true ){
				echo('<a class="ui fluid basic blue circular small button" href="'.$tmpURL.'">See all '.$tmpCurr["name"].'</a>');
			}
		}
		return $tmpRet;
	}


	//Experimental ..
	public static function loadStandardBlock($theName, $theFileName = '', $theDependencies = null){
		$tmpDepDefaults = array('wp-blocks','wp-editor','wp-element');
		//$tmpDeps = array_combine($tmpDepDefaults, $theDependencies);
		$tmpFN = $theFileName;
		if( $tmpFN == ''){
			$tmpFN = $theName;
		}	
		
		wp_enqueue_script(
			$theName, 
			ACTAPP_DOCS_PLUGIN_URL . '/blocks/' . $tmpFN . '.js',
			$tmpDepDefaults,
			true
		);		
	}

	
}

add_action( 'init', array( 'ActAppModDocs', 'init' ) );


add_filter('block_categories',  array('ActAppModDocs','actapp_docposts_block_category'), 10, 2);
add_action('enqueue_block_editor_assets',  array('ActAppModDocs','setup_blocks'),10,2);

//--- DEMO EXAMPLE BELOW - HOW TO LOAD A CATEGORY AND BLOCKS SPECIFIC TO POST TYPE
//add_filter('block_categories',  array('ActAppModDocs','actapp_docposts_block_category'), 10, 2);
//add_action('enqueue_block_editor_assets',  array('ActAppModDocs','setup_blocks'),10,2);

//--- DEMO EXAMPLE BELOW - HOW TO LIMIT LOADED BLOCKS BASED ON POST TYPE
// add_filter('allowed_block_types', function($block_types, $post) {
// 	$allowed = [
// 		'core/paragraph'
// 	];
// 	if ($post->post_type == 'docpost') {
// 		return $allowed;
// 	}
// 	return $block_types;
// }, 10, 2);

