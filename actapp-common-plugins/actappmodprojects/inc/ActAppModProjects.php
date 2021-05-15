<?php
/*
Common access points for this plugin
*/

/* package: actappmodprojects */

class ActAppModProjects {
	private static $instance;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new ActAppModProjects();
		}
		return self::$instance;
	}

	public static function init() {
		//self::do_something_on_startup();
	}

	public static function pluginDir() {
		return ACTAPP_PROJECTS_PLUGIN_DIR;
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


	public static function getProjectCard($theDoc) {
		return self::getCardUI($theDoc);
	}

	public static function processArchivePosts() {
		$tmpRet = '';
		$tmpSummary = [];

		while ( have_posts() ) :
			the_post();
			
			//Get details for summary here
			//the_category();
			$tmpCat = get_the_category();
			
			foreach ($tmpCat as $aCat) {
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
				//$tmpSummary[$tmpCatSlug] = array("name"=>$tmpCatName, "slug"=>$tmpCatSlug);
			}
		endwhile;
		//var_dump($tmpSummary);
		$tmpShowMax = 3;
		$tmpCardsDiv = "three stackable";
		foreach($tmpSummary as $aKey => $tmpCurr) {
			//echo('key '.$aKey);
			$tmpURL = site_url( '/projects/?category_name='.$tmpCurr["slug"]);
			$tmpCards = array();
			$tmpPosts = $tmpCurr["posts"];
			$tmpCount = sizeof($tmpPosts);
			$tmpShowCount = $tmpCount;
			$tmpShowMore = false;
			if( $tmpShowCount > $tmpShowMax ){
				$tmpShowMore = true;
				$tmpShowCount = $tmpShowMax;
			}

			//echo('$tmpCount '.$tmpCount);
			//echo('$tmpShowCount '.$tmpShowCount);
			//echo('testing');
			echo ('<div class="ui header blue medium">Latest '.$tmpCurr["name"].'</div>');
			echo ('<div class="ui cards '.$tmpCardsDiv.'">');
			//echo("cnt ".$tmpShowCount);
			for( $i = 0 ; $i < $tmpShowCount ; $i++){
				echo self::getProjectCard($tmpPosts[$i]);
			}
			echo('</div>');
			if( $tmpShowMore == true ){
				echo('<a class="ui fluid basic blue circular small button" href="'.$tmpURL.'">See all '.$tmpCurr["name"].'</a>');
			}
			
			//var_dump($tmpCurr);
		}
		  
		
		return $tmpRet;

	}
	
}

add_action( 'init', array( 'ActAppModProjects', 'init' ) );
