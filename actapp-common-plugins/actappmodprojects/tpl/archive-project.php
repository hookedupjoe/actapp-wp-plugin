<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package SLAHomePage
 */

get_header();

$tmpQuery = $wp_query->query;
$tmpPostType = $tmpQuery['post_type'];
$tmpQO = get_queried_object();
$tmpPostType = get_post_type_object( $tmpPostType );
$tmpPostArchiveList = $tmpPostType->has_archive;
$tmpTax = $tmpQO->taxonomy;
$tmpArchiveLabel = "";
$tmpIsFullList = false;

if( $tmpTax == "category" ){
	$tmpArchiveLabel = $tmpPostType->label;
} else {
	$tmpIsFullList = true;
}


?>


<div class="row">
	<div class="col-sm-12 col-md-9 pad3">  
		<div class="ui segment black">
	
		<main id="primary" class="site-main">

<?php if ( have_posts() ) : ?>
	
	<header class="page-header">
		<?php
		the_archive_title( '<h1 class="ui header black large">', '</h1>' );
		?>
	</header><!-- .page-header -->
	
	<?php
	if( $tmpIsFullList ){
		$tmpSummary = [];
			/* Start the Loop */
	
	echo (ActAppModProjects::processArchivePosts());

	} else {
		echo('<div class="ui cards">');
	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		/*
		 * Include the Post-Type-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		 */
		
		include(ACTAPP_PROJECTS_PLUGIN_DIR . "/tpl/list-project.php");
		
	endwhile;
	
	echo('</div>');

	}
	
	

else :

	//get_template_part( 'template-parts/content', 'none' );
	echo('<div class="ui message orange large">Nothing found</div>');

endif;
?>

</main><!-- #main -->
	
		</div>
	</div>  <?php // End Content ?>
	<div class="col-sm-12 col-md-3 pad3">
		
		<div class="ui segment black">
			<?php 
			if($tmpTax == "category" && $tmpPostArchiveList != ""){
				$tmpURL = '';
				if( $tmpPostArchiveList != ""){
					$tmpURL = '../'.$tmpPostArchiveList;
				}
				echo('<div class="pad5" /><a class="ui button basic blue circular fluid" href="'.$tmpURL.'">Show all '.$tmpArchiveLabel.'</a>');
			}
			get_sidebar();
			
			 ?>
		</div>
			
	</div>


</div>
</div>

<?php

get_footer();
