<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ActAppDocs
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

if( $tmpTax == "docpost-category" ){
	$tmpArchiveLabel = $tmpPostType->label;
} else {
	$tmpIsFullList = true;
}


?>


<div class="row">
	<div class="col-sm-12 col-md-9 pad3">  
		<div class="ui segment black">
	
		<main>

<?php if ( have_posts() ) : ?>
	
	<header class="page-header">
		<?php
		the_archive_title( '<div class="ui header green large">', '</div>' );
		?>
	</header><!-- .page-header -->
	
	<?php
	if( $tmpIsFullList ){
		$tmpSummary = [];
		echo (ActAppModDocs::processArchivePosts(3));
	} else {
		echo (ActAppModDocs::processArchivePosts());

	}
	
	

else :

	//get_template_part( 'template-parts/content', 'none' );
	echo ActAppModDocs::getNothingFound();
	

endif;
?>

</main><!-- #main -->
	
		</div>
	</div>  <?php // End Content ?>
	<div class="col-sm-12 col-md-3 pad3">
		

		<div class="ui segment black">
			<?php 
			if( !$tmpIsFullList ){
				echo ActAppModDocs::getFullListLink();
				//echo ('</div><div class="ui segment black">');
			}

			//get_sidebar();
			
			 ?>
		</div>
			
	</div>


	</div>

<?php

get_footer();
