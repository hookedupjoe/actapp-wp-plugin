<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package SLAHomePage
 */

 
?>

<a class="card" href="<?php the_permalink(); ?>">
<?php
$tmpFeaturedURL = get_the_post_thumbnail_url();
if( $tmpFeaturedURL != ""){
	echo('<div class="image">
	<img style="min-height:125px;max-height:125px;object-fit: cover;" src="'.$tmpFeaturedURL.'">
  </div>');
}
?>
    
    <div class="content">
      <div class="header"><?php the_title(); ?></div>
	  <?php
$tmpExcerpt = get_the_excerpt();
if( $tmpExcerpt != ""){
	echo('<div class="description">
	'.$tmpExcerpt.'
  </div>');
}
?>
    </div>

  </a>







